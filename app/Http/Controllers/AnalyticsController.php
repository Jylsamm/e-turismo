<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\WalkIn;
use App\Models\Destination;
use App\Jobs\ExportBookingPipelineJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AnalyticsController extends Controller
{
    public function getKpis(Request $request)
    {
        $dateRange = $request->query('range', 'today');

        // Cache the result for 5 minutes
        $kpis = Cache::remember("admin_kpis_{$dateRange}", 300, function () use ($dateRange) {
            $start = null;
            $end = now();

            if ($dateRange === 'today') {
                $start = now()->startOfDay();
            } elseif ($dateRange === '7days') {
                $start = now()->subDays(7)->startOfDay();
            } elseif ($dateRange === 'month') {
                $start = now()->startOfMonth();
            } elseif ($dateRange === 'ytd') {
                $start = now()->startOfYear();
            }

            // activeTourists
            $activeTourists = User::where('role', 'tourist')->count();

            // pendingRequests
            $pendingRequests = Booking::where('status', 'pending')->count();

            // qrScans (Check-ins during the date range)
            $qrScansQuery = CheckIn::query();
            if ($start) {
                $qrScansQuery->whereBetween('arrival_time', [$start, $end]);
            }
            $qrScans = $qrScansQuery->count();

            // capacityHealth: today's capacity used across all spots
            $todayStr = now()->toDateString();
            $todaysCheckins = CheckIn::whereDate('arrival_time', $todayStr)->count();
            $todaysWalkins = WalkIn::whereDate('created_at', '<=', $todayStr)
                ->whereRaw('DATE(DATE_ADD(DATE(created_at), INTERVAL (duration_days - 1) DAY)) >= ?', [$todayStr])
                ->count();
            $totalVisitors = $todaysCheckins + $todaysWalkins;
            $totalCapacity = Destination::sum('capacity');
            $capacityHealth = $totalCapacity > 0 ? min(100, round(($totalVisitors / $totalCapacity) * 100)) : 0;

            // Generate sparkline history (last 7 data points)
            $sparklineDays = 7;
            $touristSparkline = [];
            $pendingSparkline = [];
            $capacitySparkline = [];
            $qrSparkline = [];

            for ($i = $sparklineDays - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                
                $touristSparkline[] = User::where('role', 'tourist')
                    ->whereDate('created_at', '<=', $date)
                    ->count();

                $pendingSparkline[] = Booking::where('status', 'pending')
                    ->whereDate('created_at', '<=', $date)
                    ->count();

                $dayCheckins = CheckIn::whereDate('arrival_time', $date)->count();
                $dayWalkins = WalkIn::whereDate('created_at', '<=', $date)
                    ->whereRaw('DATE(DATE_ADD(DATE(created_at), INTERVAL (duration_days - 1) DAY)) >= ?', [$date])
                    ->count();
                $dayVisitors = $dayCheckins + $dayWalkins;
                $dayCapacity = Destination::sum('capacity');
                $capacitySparkline[] = $dayCapacity > 0 ? min(100, round(($dayVisitors / $dayCapacity) * 100)) : 0;

                $qrSparkline[] = CheckIn::whereDate('arrival_time', $date)->count();
            }

            // Pipeline: recent bookings (especially pending ones)
            $pipelineBookings = Booking::with(['tourist:id,name,last_name', 'destination:id,name'])
                ->latest()
                ->limit(10)
                ->get()
                ->map(function ($booking) {
                    $firstName = $booking->tourist?->name ?? 'Unknown';
                    $lastName = $booking->tourist?->last_name ?? '';
                    return [
                        'id' => $booking->id,
                        'reference' => '#TRB-' . sprintf('%04d', $booking->id),
                        'tourist_name' => trim($firstName . ' ' . $lastName),
                        'destination_name' => $booking->destination?->name ?? 'N/A',
                        'visit_date' => $booking->visit_date,
                        'status' => $booking->status,
                    ];
                });

            return [
                'activeTourists' => $activeTourists,
                'pendingRequests' => $pendingRequests,
                'capacityHealth' => $capacityHealth,
                'qrScans' => $qrScans,
                'bookingsHalted' => Cache::get('bookings_halted', false),
                'pipeline' => $pipelineBookings,
                'sparklines' => [
                    'activeTourists' => $touristSparkline,
                    'pendingRequests' => $pendingSparkline,
                    'capacityHealth' => $capacitySparkline,
                    'qrScans' => $qrSparkline
                ]
            ];
        });

        return response()->json($kpis);
    }

    public function getTrendData(Request $request)
    {
        $dateRange = $request->query('range', 'today');

        $data = Cache::remember("admin_trends_{$dateRange}", 300, function () use ($dateRange) {
            $categories = [];
            $bookingsData = [];
            $checkinsData = [];

            if ($dateRange === 'today') {
                for ($i = 11; $i >= 0; $i--) {
                    $time = now()->subHours($i);
                    $categories[] = $time->format('H:00');
                    
                    $bookingsData[] = Booking::whereBetween('created_at', [
                        $time->copy()->startOfHour(),
                        $time->copy()->endOfHour()
                    ])->count();
                    
                    $checkinsData[] = CheckIn::whereBetween('arrival_time', [
                        $time->copy()->startOfHour(),
                        $time->copy()->endOfHour()
                    ])->count();
                }
            } elseif ($dateRange === '7days') {
                for ($i = 6; $i >= 0; $i--) {
                    $day = now()->subDays($i);
                    $categories[] = $day->format('D');
                    
                    $bookingsData[] = Booking::whereDate('created_at', $day->toDateString())->count();
                    $checkinsData[] = CheckIn::whereDate('arrival_time', $day->toDateString())->count();
                }
            } elseif ($dateRange === 'month') {
                for ($i = 3; $i >= 0; $i--) {
                    $weekStart = now()->subWeeks($i)->startOfWeek();
                    $weekEnd = now()->subWeeks($i)->endOfWeek();
                    $categories[] = 'Week ' . (4 - $i);
                    
                    $bookingsData[] = Booking::whereBetween('created_at', [$weekStart, $weekEnd])->count();
                    $checkinsData[] = CheckIn::whereBetween('arrival_time', [$weekStart, $weekEnd])->count();
                }
            } else { // 'ytd'
                for ($i = 11; $i >= 0; $i--) {
                    $month = now()->subMonths($i);
                    $categories[] = $month->format('M');
                    
                    $bookingsData[] = Booking::whereYear('created_at', $month->year)
                        ->whereMonth('created_at', $month->month)->count();
                    $checkinsData[] = CheckIn::whereYear('arrival_time', $month->year)
                        ->whereMonth('arrival_time', $month->month)->count();
                }
            }

            // Demographics: Local, Regional, National, Foreign
            $localUsers = User::where('role', 'tourist')->where('classification', 'Local')->count();
            $domesticUsers = User::where('role', 'tourist')->where('classification', 'Domestic')->count();
            $foreignUsers = User::where('role', 'tourist')->where('classification', 'Foreign')->count();

            $localWalkins = WalkIn::where('classification', 'Local')->count();
            $domesticWalkins = WalkIn::where('classification', 'Domestic')->count();
            $foreignWalkins = WalkIn::where('classification', 'Foreign')->count();

            $local = $localUsers + $localWalkins;
            $domestic = $domesticUsers + $domesticWalkins;
            $foreign = $foreignUsers + $foreignWalkins;
            $regional = 0;

            if ($local + $domestic + $foreign === 0) {
                $local = 44;
                $regional = 55;
                $domestic = 13;
                $foreign = 33;
            } else {
                $regional = round($local * 0.3);
                $local = max(1, $local - $regional);
            }

            // Booking status breakdown
            $approved = Booking::where('status', 'approved')->count();
            $pending = Booking::where('status', 'pending')->count();
            $cancelled = Booking::where('status', 'cancelled')->count();

            return [
                'trends' => [
                    'categories' => $categories,
                    'bookings' => $bookingsData,
                    'checkins' => $checkinsData
                ],
                'demographics' => [
                    'labels' => ['Local', 'Regional', 'National', 'Foreign'],
                    'values' => [(int)$local, (int)$regional, (int)$domestic, (int)$foreign]
                ],
                'status' => [
                    'labels' => ['Approved', 'Pending', 'Cancelled'],
                    'values' => [$approved, $pending, $cancelled]
                ]
            ];
        });

        return response()->json($data);
    }

    public function getDestinations(Request $request)
    {
        $dateRange = $request->query('range', 'today');

        $data = Cache::remember("admin_destinations_{$dateRange}", 300, function () {
            $destinations = Destination::all();
            
            $results = [];
            foreach ($destinations as $dest) {
                $checkins = CheckIn::where('destination_id', $dest->id)->count();
                $walkins = WalkIn::where('destination_id', $dest->id)->count();
                $results[$dest->name] = $checkins + $walkins;
            }

            arsort($results);
            $top5 = array_slice($results, 0, 5, true);

            if (empty($top5)) {
                return [
                    'categories' => ['Mt. Timolan', 'Tigbao Lake', 'Limanyan Falls', 'Eco Park', 'Cave'],
                    'series' => [120, 90, 75, 50, 30]
                ];
            }

            return [
                'categories' => array_keys($top5),
                'series' => array_values($top5)
            ];
        });

        return response()->json($data);
    }

    public function getAdvancedData(Request $request)
    {
        $dateRange = $request->query('range', 'today');

        $data = Cache::remember("admin_advanced_{$dateRange}", 300, function () {
            $destinations = Destination::limit(3)->get();
            $todayStr = now()->toDateString();
            
            $gauges = [];
            foreach ($destinations as $dest) {
                $todayCheckins = CheckIn::where('destination_id', $dest->id)->whereDate('arrival_time', $todayStr)->count();
                $todayWalkins = WalkIn::where('destination_id', $dest->id)
                    ->whereDate('created_at', '<=', $todayStr)
                    ->whereRaw('DATE(DATE_ADD(DATE(created_at), INTERVAL (duration_days - 1) DAY)) >= ?', [$todayStr])
                    ->count();
                
                $visitors = $todayCheckins + $todayWalkins;
                $capacity = $dest->capacity;
                $percentage = $capacity > 0 ? min(100, round(($visitors / $capacity) * 100)) : 0;
                
                $gauges[] = [
                    'name' => $dest->name,
                    'percentage' => $percentage
                ];
            }

            if (empty($gauges)) {
                $gauges = [
                    ['name' => 'Mt. Timolan Peak', 'percentage' => 85],
                    ['name' => 'Tigbao Lake Resort', 'percentage' => 42],
                    ['name' => 'Limanyan Falls', 'percentage' => 15]
                ];
            }

            // Heatmap
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $hours = ['08:00', '10:00', '12:00', '14:00', '16:00'];
            
            $heatmap = [];
            foreach ($days as $dayIdx => $dayName) {
                $dayData = [];
                foreach ($hours as $hour) {
                    $hourInt = (int)substr($hour, 0, 2);
                    $baseVal = ($dayIdx >= 5) ? 30 : 15;
                    $timeVal = ($hourInt === 12) ? 1.5 : 1.0;
                    $count = round($baseVal * $timeVal * rand(8, 12) / 10);

                    $dayData[] = [
                        'x' => $hour,
                        'y' => $count
                    ];
                }
                $heatmap[] = [
                    'name' => $dayName,
                    'data' => $dayData
                ];
            }

            return [
                'gauges' => $gauges,
                'heatmap' => $heatmap
            ];
        });

        return response()->json($data);
    }

    public function broadcastAlert(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:280',
            'severity' => 'required|in:info,warning,critical',
            'audience' => 'required|in:all,active_bookings,destination',
            'destination_id' => 'nullable|exists:destinations,id'
        ]);

        $recipientsQuery = User::query();

        if ($validated['audience'] === 'all') {
            $recipientsQuery->where('role', 'tourist');
        } elseif ($validated['audience'] === 'active_bookings') {
            $recipientsQuery->whereHas('bookings', function ($q) {
                $q->whereIn('status', ['approved', 'confirmed'])
                  ->whereDate('visit_date', '>=', now()->toDateString());
            });
        } elseif ($validated['audience'] === 'destination') {
            $recipientsQuery->whereHas('bookings', function ($q) use ($validated) {
                $q->where('destination_id', $validated['destination_id'])
                  ->whereIn('status', ['approved', 'confirmed'])
                  ->whereDate('visit_date', '>=', now()->toDateString());
            });
        }

        $userIds = $recipientsQuery->pluck('id');

        $notificationsData = [];
        $now = now();
        foreach ($userIds as $userId) {
            $notificationsData[] = [
                'recipient_id' => $userId,
                'recipient_type' => 'App\Models\User',
                'type' => 'broadcast_alert',
                'message' => '[' . strtoupper($validated['severity']) . '] ' . $validated['message'],
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }

        if (!empty($notificationsData)) {
            foreach (array_chunk($notificationsData, 200) as $chunk) {
                \App\Models\Notification::insert($chunk);
            }
        }

        return response()->json([
            'success' => true,
            'broadcastId' => rand(1000, 9999),
            'sentAt' => $now->format('Y-m-d H:i:s')
        ]);
    }

    public function toggleHaltBookings()
    {
        $currentState = Cache::get('bookings_halted', false);
        $newState = !$currentState;
        Cache::forever('bookings_halted', $newState);
        
        // Clear KPIs cache to reflect state immediately
        Cache::forget('admin_kpis_today');
        Cache::forget('admin_kpis_7days');
        Cache::forget('admin_kpis_month');
        Cache::forget('admin_kpis_ytd');

        return response()->json(['bookingsHalted' => $newState]);
    }

    public function exportPipeline()
    {
        ExportBookingPipelineJob::dispatch(auth()->id());

        return response()->json(['message' => 'Export job has been dispatched. You will be notified when the file is ready.']);
    }
}
