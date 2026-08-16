<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Destination;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    /**
     * Display a listing of destinations (Tourism Portal).
     */
    public function index()
    {
        $destinations = Destination::where('availability_status', 'Available')->get();
        return view('destinations.index', compact('destinations'));
    }

    /**
     * Show a specific destination detail with pre-rendered availability data.
     */
    public function show(Destination $destination)
    {
        $currentMonth = date('Y-m');
        $nextMonth    = date('Y-m', strtotime('+1 month'));

        $initialAvailability = [
            $currentMonth => $this->getMonthlyAvailabilityData($destination, $currentMonth),
            $nextMonth    => $this->getMonthlyAvailabilityData($destination, $nextMonth),
        ];

        return view('destinations.show', compact('destination', 'initialAvailability'));
    }

    /**
     * Show form to create a new destination (Admin Only).
     */
    public function create()
    {
        return view('destinations.create');
    }

    /**
     * Store a new destination (Admin Only).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:10|unique:destinations',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:4096',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('destination_photos', 'public');
        }

        Destination::create([
            'name' => $request->name,
            'initials' => strtoupper($request->initials),
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'photos' => $photoPath,
            'availability_status' => $request->capacity > 0 ? 'Available' : 'Unavailable',
        ]);

        return redirect()->route('dashboard')->with('success', 'Destination registered successfully!');
    }

    /**
     * Show form to edit a destination (Admin / Assigned Staff Only).
     */
    public function edit(Destination $destination)
    {
        // Staff check
        if (auth()->user()->isStaff() && auth()->user()->assigned_destination_id !== $destination->id) {
            $assignedSpot = optional(auth()->user()->assignedDestination)->name ?? 'your assigned spot';
            return redirect()->route('spots.dashboard', auth()->user()->assigned_destination_id)
                ->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Editing {$destination->name} is unauthorized under the 1-Staff-1-Spot policy.")
                ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        return view('destinations.edit', compact('destination'));
    }

    /**
     * Update destination profile (Admin / Assigned Staff Only).
     */
    public function update(Request $request, Destination $destination)
    {
        if (auth()->user()->isStaff() && auth()->user()->assigned_destination_id !== $destination->id) {
            $assignedSpot = optional(auth()->user()->assignedDestination)->name ?? 'your assigned spot';
            return redirect()->route('spots.dashboard', auth()->user()->assigned_destination_id)
                ->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Modifying {$destination->name} is unauthorized under the 1-Staff-1-Spot policy.")
                ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:4096',
            'availability_status' => 'required|string|in:Available,Unavailable',
        ]);

        $photoPath = $destination->photos;
        if ($request->hasFile('photo')) {
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('destination_photos', 'public');
        }

        $destination->update([
            'name' => $request->name,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'photos' => $photoPath,
            'availability_status' => ($request->capacity == 0) ? 'Unavailable' : $request->availability_status,
        ]);

        return redirect()->route('dashboard')->with('success', 'Destination updated successfully!');
    }

    /**
     * Delete a destination (Admin Only).
     */
    public function destroy(Destination $destination)
    {
        if ($destination->photos) {
            Storage::disk('public')->delete($destination->photos);
        }
        $destination->delete();
        return redirect()->route('destinations.index')->with('success', 'Destination removed.');
    }

    /**
     * Check availability of a destination on a specific date.
     */
    public function checkAvailability(Request $request, Destination $destination)
    {
        $request->validate([
            'date' => 'required|date|after:today',
        ]);

        $dateStr  = $request->date;
        $cacheKey = "dest_avail_{$destination->id}_{$dateStr}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 10, function () use ($destination, $dateStr) {
            $capacity = $destination->capacity;

            // Count confirmed/completed bookings on that date
            $confirmedCount = $destination->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->where('visit_date', $dateStr)
                ->count();

            $slots = max(0, $capacity - $confirmedCount);
            $pct   = $capacity > 0 ? round(($confirmedCount / $capacity) * 100) : 100;

            $status = 'open';
            if ($slots === 0) {
                $status = 'full';
            } elseif ($pct >= 75) {
                $status = 'limited';
            }

            $alternateDates = [];
            if ($status === 'full') {
                // Bulk query next 14 days in 1 single SQL query!
                $currentDate     = new \DateTime($dateStr);
                $next14DaysStart = (clone $currentDate)->modify('+1 day')->format('Y-m-d');
                $next14DaysEnd   = (clone $currentDate)->modify('+14 day')->format('Y-m-d');

                $futureCounts = $destination->bookings()
                    ->whereIn('status', ['confirmed', 'completed'])
                    ->whereBetween('visit_date', [$next14DaysStart, $next14DaysEnd])
                    ->selectRaw('visit_date, count(*) as total')
                    ->groupBy('visit_date')
                    ->pluck('total', 'visit_date');

                for ($i = 1; count($alternateDates) < 3 && $i <= 14; $i++) {
                    $checkDateStr   = (clone $currentDate)->modify("+$i day")->format('Y-m-d');
                    $checkConfirmed = (int) $futureCounts->get($checkDateStr, 0);

                    if ($checkConfirmed < $capacity) {
                        $alternateDates[] = $checkDateStr;
                    }
                }
            }

            return response()->json([
                'slots'           => $slots,
                'booked'          => $confirmedCount,
                'pct'             => $pct,
                'status'          => $status,
                'capacity'        => $capacity,
                'alternate_dates' => $alternateDates,
            ]);
        });
    }

    /**
     * Check availability for a range of consecutive days (for multi-day tour duration).
     * Returns per-day breakdown + overall range status (bottleneck = min slots).
     */
    public function checkRangeAvailability(Request $request, Destination $destination)
    {
        $request->validate([
            'start' => 'required|date|after:today',
            'days'  => 'required|integer|min:1|max:14',
        ]);

        $startStr = $request->start;
        $days     = (int) $request->days;
        $cacheKey = "dest_range_avail_{$destination->id}_{$startStr}_{$days}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 10, function () use ($destination, $startStr, $days) {
            $capacity  = $destination->capacity;
            $startDate = new \DateTime($startStr);
            $endDateStr = (clone $startDate)->modify('+' . ($days - 1) . ' day')->format('Y-m-d');
            $results   = [];
            $minSlots  = $capacity; // track bottleneck

            // Bulk query all booking counts across the date range in 1 single SQL query!
            $rangeCounts = $destination->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->whereBetween('visit_date', [$startStr, $endDateStr])
                ->selectRaw('visit_date, count(*) as total')
                ->groupBy('visit_date')
                ->pluck('total', 'visit_date');

            for ($i = 0; $i < $days; $i++) {
                $dateObj = (clone $startDate)->modify("+$i day");
                $dateStr = $dateObj->format('Y-m-d');

                $confirmed = (int) $rangeCounts->get($dateStr, 0);
                $slots     = max(0, $capacity - $confirmed);
                $pct       = $capacity > 0 ? round(($confirmed / $capacity) * 100) : 100;

                $dayStatus = 'open';
                if ($slots === 0) {
                    $dayStatus = 'full';
                } elseif ($pct >= 75) {
                    $dayStatus = 'limited';
                }

                $results[] = [
                    'date'   => $dateStr,
                    'slots'  => $slots,
                    'booked' => $confirmed,
                    'pct'    => $pct,
                    'status' => $dayStatus,
                ];

                if ($slots < $minSlots) {
                    $minSlots = $slots;
                }
            }

            // Overall range status is determined by the bottleneck day
            $rangeStatus = 'open';
            if ($minSlots === 0) {
                $rangeStatus = 'full';
            } elseif ($capacity > 0 && ($capacity - $minSlots) / $capacity >= 0.75) {
                $rangeStatus = 'limited';
            }

            return response()->json([
                'capacity'     => $capacity,
                'days'         => $days,
                'start'        => $startStr,
                'min_slots'    => $minSlots,
                'range_status' => $rangeStatus,
                'breakdown'    => $results,
            ]);
        });
    }

    /**
     * Check availability of a destination for an entire month in a single API call.
     */
    public function checkMonthAvailability(Request $request, Destination $destination)
    {
        $request->validate([
            'month' => 'required|date_format:Y-m',
        ]);

        $data = $this->getMonthlyAvailabilityData($destination, $request->month);
        return response()->json($data);
    }

    /**
     * Helper method to compute monthly availability data.
     */
    public function getMonthlyAvailabilityData(Destination $destination, string $monthStr): array
    {
        $cacheKey = "dest_month_avail_{$destination->id}_{$monthStr}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 10, function () use ($destination, $monthStr) {
            $capacity  = $destination->capacity;
            $startDate = "{$monthStr}-01";
            $endDate   = date('Y-m-t', strtotime($startDate));

            // Single aggregated DB query for the entire month!
            $monthCounts = $destination->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->whereBetween('visit_date', [$startDate, $endDate])
                ->selectRaw('visit_date, count(*) as total')
                ->groupBy('visit_date')
                ->pluck('total', 'visit_date');

            $daysInMonth = (int) date('t', strtotime($startDate));
            $dayData     = [];

            for ($d = 1; $d <= $daysInMonth; $d++) {
                $ds        = sprintf('%s-%02d', $monthStr, $d);
                $confirmed = (int) $monthCounts->get($ds, 0);
                $slots     = max(0, $capacity - $confirmed);
                $pct       = $capacity > 0 ? round(($confirmed / $capacity) * 100) : 100;

                $status = 'open';
                if ($slots === 0) {
                    $status = 'full';
                } elseif ($pct >= 75) {
                    $status = 'limited';
                }

                $dayData[$ds] = [
                    'slots'  => $slots,
                    'booked' => $confirmed,
                    'pct'    => $pct,
                    'status' => $status,
                ];
            }

            return $dayData;
        });
    }
}
