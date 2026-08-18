<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\User;
use App\Models\WalkIn;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isStaff()) {
            return $this->staffDashboard();
        } else {
            return $this->touristDashboard();
        }
    }

    private function adminDashboard()
    {
        return view('dashboard');
    }

    private function staffDashboard()
    {
        $user = auth()->user();
        $today = now()->toDateString();
        $destinationId = $user->assigned_destination_id;
        
        $todaysBookingsCount = Booking::where('destination_id', $destinationId)
            ->where('visit_date', $today)->count();
        $pendingBookingsCount = Booking::where('destination_id', $destinationId)
            ->where('status', 'pending')->count();
        $confirmedBookingsCount = Booking::where('destination_id', $destinationId)
            ->where('status', 'confirmed')->count();
        
        $todaysCheckinsCount = CheckIn::whereHas('booking', function ($q) use ($destinationId) {
            $q->where('destination_id', $destinationId);
        })->whereBetween('arrival_time', [now()->startOfDay(), now()->endOfDay()])->count();

        // Count walk-ins currently on-site: registered <= today AND (registered_date + duration_days - 1) >= today
        // i.e., they checked in on day X and are staying X + duration_days - 1 days total
        $today = Carbon::today();
        $onSiteWalkinsCount = WalkIn::where('destination_id', $destinationId)
            ->whereDate('created_at', '<=', $today)
            ->whereRaw('DATE(DATE_ADD(DATE(created_at), INTERVAL (duration_days - 1) DAY)) >= ?', [$today->toDateString()])
            ->count();

        // Total live visitors today = checked-in pre-bookings + on-site walk-ins
        $currentVisitorsCount = $todaysCheckinsCount + $onSiteWalkinsCount;
        
        $destination = Destination::find($destinationId);
        $totalCapacity = $destination ? $destination->capacity : 0;
        $availableCapacityPct = $totalCapacity > 0 
            ? max(0, round((($totalCapacity - $currentVisitorsCount) / $totalCapacity) * 100)) 
            : 0;

        $stats = [
            'todays_bookings' => $todaysBookingsCount,
            'pending_bookings' => $pendingBookingsCount,
            'confirmed_bookings' => $confirmedBookingsCount,
            'todays_checkins' => $currentVisitorsCount, // Include walkins in total arrivals display
            'current_visitors' => $currentVisitorsCount,
            'available_capacity_pct' => $availableCapacityPct,
        ];

        // Latest 5 pending bookings
        $recentPendingBookings = Booking::query()
            ->select(['id', 'tourist_id', 'destination_id', 'visit_date', 'status', 'payment_status', 'created_at'])
            ->with(['tourist:id,name,email', 'destination:id,name,location'])
            ->where('status', 'pending')
            ->latest()
            ->limit(5)
            ->get();

        // Latest 5 check-ins
        $recentCheckIns = CheckIn::query()
            ->select(['id', 'booking_id', 'arrival_time'])
            ->with(['booking' => function ($query) {
                $query->select(['id', 'tourist_id', 'destination_id', 'visit_date', 'status'])
                    ->with(['tourist:id,name', 'destination:id,name,location']);
            }])
            ->whereDate('arrival_time', $today)
            ->latest()
            ->limit(5)
            ->get();

        // Latest 5 walk-ins (for dashboard quick view)
        $recentWalkins = WalkIn::where('destination_id', $destinationId)
            ->latest()
            ->limit(5)
            ->get();

        // Spot occupancy overview
        $spots = Destination::withCount(['bookings as current_visitors' => function($q) use ($today) {
            $q->where('status', 'completed')
              ->where('visit_date', $today);
        }])->get()->map(function($spot) {
            $pct = $spot->capacity > 0 ? min(100, round(($spot->current_visitors / $spot->capacity) * 100)) : 100;
            $spot->occupancy_pct = $pct;
            $spot->status_badge = $pct >= 100 ? 'Full' : 'Open';
            return $spot;
        });

        $notifications = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)->latest()->limit(5)->get();

        return view('dashboard.staff', compact('stats', 'recentPendingBookings', 'recentCheckIns', 'recentWalkins', 'spots', 'notifications', 'destination'));
    }


    private function touristDashboard()
    {
        $myBookings = Booking::query()
            ->select(['id', 'tourist_id', 'destination_id', 'visit_date', 'status', 'payment_status', 'gcash_reference_number', 'payment_submitted_at', 'checked_in_at', 'qr_token', 'created_at'])
<<<<<<< Updated upstream
            ->with(['destination:id,name,location', 'ticket:id,booking_id,qr_code'])
            ->where('tourist_id', auth()->id())
=======
            ->with(['destination:id,name,location,photos', 'ticket:id,booking_id,qr_code', 'tourist:id,name,classification'])
            ->where('tourist_id', $userId)
            ->latest()
            ->limit(4)
            ->get();

        $stats = [
            'total' => Booking::where('tourist_id', $userId)->count(),
            'confirmed' => Booking::where('tourist_id', $userId)->where('status', 'confirmed')->count(),
            'pending' => Booking::where('tourist_id', $userId)->where('status', 'pending')->count(),
            'unpaid' => Booking::where('tourist_id', $userId)
                ->whereNotIn('status', ['cancelled', 'declined'])
                ->where(function ($q) {
                    $q->where('payment_status', 'unpaid')
                      ->orWhereNull('payment_status');
                })->count(),
            'completed' => Booking::where('tourist_id', $userId)->where('status', 'completed')->count(),
        ];

        $activePass = Booking::with(['destination:id,name,location', 'ticket:id,booking_id,qr_code'])
            ->where('tourist_id', $userId)
            ->where('status', 'confirmed')
            ->whereDate('visit_date', '>=', now()->toDateString())
            ->orderBy('visit_date', 'asc')
            ->first();

        $notifications = Notification::where('recipient_id', $userId)
            ->where('is_read', false)
            ->where('type', '!=', 'broadcast_alert')
>>>>>>> Stashed changes
            ->latest()
            ->limit(5)
            ->get();

        $notifications = Notification::where('recipient_id', auth()->id())
            ->where('is_read', false)->latest()->limit(5)->get();

        $destinations = Destination::limit(6)->get();

        return view('dashboard.tourist', compact('myBookings', 'notifications', 'destinations'));
    }
}
