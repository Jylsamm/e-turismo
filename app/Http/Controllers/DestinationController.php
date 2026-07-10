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
     * Show a specific destination detail.
     */
    public function show(Destination $destination)
    {
        return view('destinations.show', compact('destination'));
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
            abort(403, 'Unauthorized action.');
        }

        return view('destinations.edit', compact('destination'));
    }

    /**
     * Update destination profile (Admin / Assigned Staff Only).
     */
    public function update(Request $request, Destination $destination)
    {
        if (auth()->user()->isStaff() && auth()->user()->assigned_destination_id !== $destination->id) {
            abort(403, 'Unauthorized action.');
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

        $dateStr = $request->date;
        $capacity = $destination->capacity;

        // Count confirmed/completed bookings on that date
        $confirmedCount = $destination->bookings()
            ->whereIn('status', ['confirmed', 'completed'])
            ->where('visit_date', $dateStr)
            ->count();

        $slots = max(0, $capacity - $confirmedCount);
        $pct = $capacity > 0 ? round(($confirmedCount / $capacity) * 100) : 100;

        $status = 'open';
        if ($slots === 0) {
            $status = 'full';
        } elseif ($pct >= 75) {
            $status = 'limited';
        }

        $alternateDates = [];
        if ($status === 'full') {
            // Find next 3 available days
            $currentDate = new \DateTime($dateStr);
            for ($i = 1; count($alternateDates) < 3 && $i <= 14; $i++) {
                $checkDateObj = (clone $currentDate)->modify("+$i day");
                $checkDateStr = $checkDateObj->format('Y-m-d');

                $checkConfirmed = $destination->bookings()
                    ->whereIn('status', ['confirmed', 'completed'])
                    ->where('visit_date', $checkDateStr)
                    ->count();

                if ($checkConfirmed < $capacity) {
                    $alternateDates[] = $checkDateStr;
                }
            }
        }

        return response()->json([
            'slots' => $slots,
            'booked' => $confirmedCount,
            'pct' => $pct,
            'status' => $status,
            'capacity' => $capacity,
            'alternate_dates' => $alternateDates,
        ]);
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

        $startStr  = $request->start;
        $days      = (int) $request->days;
        $capacity  = $destination->capacity;
        $startDate = new \DateTime($startStr);
        $results   = [];
        $minSlots  = $capacity; // track bottleneck

        for ($i = 0; $i < $days; $i++) {
            $dateObj = (clone $startDate)->modify("+$i day");
            $dateStr = $dateObj->format('Y-m-d');

            $confirmed = $destination->bookings()
                ->whereIn('status', ['confirmed', 'completed'])
                ->where('visit_date', $dateStr)
                ->count();

            $slots = max(0, $capacity - $confirmed);
            $pct   = $capacity > 0 ? round(($confirmed / $capacity) * 100) : 100;

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
    }
}
