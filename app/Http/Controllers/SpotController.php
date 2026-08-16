<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\DestinationImage;
use App\Models\Booking;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SpotController extends Controller
{
    /**
     * Nav entry point — resolve the correct spot and redirect to its dashboard.
     * Staff   → their assigned spot
     * Admin   → first destination (can switch via dropdown)
     * No spot → select view
     */
    public function redirect()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $first = Destination::first();
            if (!$first) {
                return view('spots.no-spots');
            }
            return redirect()->route('spots.dashboard', $first);
        }

        // Staff
        $assigned = $user->assigned_destination_id
            ? Destination::find($user->assigned_destination_id)
            : null;

        if (!$assigned) {
            // Staff not assigned to any spot — show a selector
            $allSpots = Destination::orderBy('name')->get();
            return view('spots.select', compact('allSpots'));
        }

        return redirect()->route('spots.dashboard', $assigned);
    }

    /**
     * Ensure the authenticated user has permission to manage this destination.
     * Non-admins assigned to a specific spot are safely redirected to their assigned spot
     * with an alert message instead of hitting a raw 403 HTTP error screen.
     */
    private function ensureAuthorizedSpot(Destination $destination)
    {
        $user = auth()->user();
        if ($user && !$user->isAdmin() && $user->assigned_destination_id !== $destination->id) {
            $assigned = $user->assigned_destination_id
                ? Destination::find($user->assigned_destination_id)
                : null;

            if ($assigned) {
                return redirect()->route('spots.dashboard', $assigned)
                    ->with('warning', 'Access Restricted: You are assigned to ' . $assigned->name . '. Managing ' . $destination->name . ' is unauthorized under the 1-Staff-1-Spot policy.')
                    ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
            }

            abort(403, 'Unauthorized action. You are not assigned to this spot.');
        }

        return null;
    }

    /**
     * Full spot detail/management page.
     */
    public function dashboard(Destination $destination)
    {
        if ($redirect = $this->ensureAuthorizedSpot($destination)) {
            return $redirect;
        }

        $user = auth()->user();

        // ── Today date range ──────────────────────────────────────────────
        $todayStart = now()->startOfDay();
        $todayEnd   = now()->endOfDay();

        // ── Current occupancy (today's check-ins) ─────────────────────────
        $currentVisitors = CheckIn::whereHas(
            'booking',
            fn ($q) => $q->where('destination_id', $destination->id)
        )->whereBetween('arrival_time', [$todayStart, $todayEnd])->count();

        $maxCapacity  = $destination->capacity ?: 1; // avoid div-by-zero
        $occupancyPct = min(100, round(($currentVisitors / $maxCapacity) * 100));
        $isFull       = $occupancyPct >= 100;

        // ── Today's statistics ────────────────────────────────────────────
        $totalVisitorsToday = $currentVisitors;

        // Peak hour — group check-ins by hour in database, pick the busiest
        $peakHourRecord = CheckIn::whereHas(
            'booking',
            fn ($q) => $q->where('destination_id', $destination->id)
        )->whereBetween('arrival_time', [$todayStart, $todayEnd])
         ->selectRaw('HOUR(arrival_time) as hour, COUNT(*) as count')
         ->groupBy('hour')
         ->orderByDesc('count')
         ->first();

        $peakHour = null;
        if ($peakHourRecord) {
            $peakH    = $peakHourRecord->hour;
            $peakHour = date('g:00 A', mktime($peakH, 0, 0)) . ' – ' . date('g:00 A', mktime($peakH + 1, 0, 0));
        }

        // Booking conversion rate — (confirmed today) / (all bookings today) × 100
        $totalBookingsToday     = Booking::where('destination_id', $destination->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])->count();
        $confirmedBookingsToday = Booking::where('destination_id', $destination->id)
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$todayStart, $todayEnd])->count();
        $conversionRate = $totalBookingsToday > 0
            ? round(($confirmedBookingsToday / $totalBookingsToday) * 100)
            : 0;

        // ── Booking history — today's bookings, sorted by visit_date ──────
        $sortDir      = request('sort', 'desc') === 'asc' ? 'asc' : 'desc';
        $bookingHistory = Booking::with('tourist')
            ->where('destination_id', $destination->id)
            ->whereDate('visit_date', today())
            ->orderBy('created_at', $sortDir)
            ->get();

        // ── All spots for the selector dropdown ───────────────────────────
        $allSpots = Cache::remember('all_destinations_names', 86400, function () {
            return Destination::orderBy('name')->get(['id', 'name']);
        });
        if (!$user->isAdmin()) {
            $allSpots = $allSpots->where('id', $destination->id)->values();
        }

        // ── Load gallery images ───────────────────────────────────────────
        $destination->load('images');

        return view('spots.dashboard', compact(
            'destination',
            'currentVisitors',
            'maxCapacity',
            'occupancyPct',
            'isFull',
            'totalVisitorsToday',
            'peakHour',
            'conversionRate',
            'bookingHistory',
            'sortDir',
            'allSpots',
        ));
    }

    /**
     * Show the "Edit Details" tab.
     */
    public function edit(Destination $destination)
    {
        if ($redirect = $this->ensureAuthorizedSpot($destination)) {
            return $redirect;
        }

        $destination->load('images');
        $spot = $destination;
        return view('spots.edit', compact('spot'));
    }

    /**
     * Show the "Spot Status" tab (alias to dashboard).
     */
    public function status(Destination $destination)
    {
        return $this->dashboard($destination);
    }

    /**
     * Show the "Image Gallery" tab.
     */
    public function gallery(Destination $destination)
    {
        if ($redirect = $this->ensureAuthorizedSpot($destination)) {
            return $redirect;
        }

        $destination->load('images');
        $spot = $destination;
        return view('spots.gallery', compact('spot'));
    }

    /**
     * Save spot details (including check-in coordinates).
     *
     * Supports both:
     *  - Standard form POST  → redirect back with flash
     *  - AJAX / fetch (Accept: application/json) → JSON response
     *    The edit-details Blade form uses fetch + FormData + _method=PUT.
     */
    public function update(Request $request, Destination $destination)
    {
        $user = auth()->user();
        if (!$user->isAdmin() && $user->assigned_destination_id !== $destination->id) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action. You can only modify your assigned spot (' . optional(Destination::find($user->assigned_destination_id))->name . ').'
                ], 403);
            }
            if ($redirect = $this->ensureAuthorizedSpot($destination)) {
                return $redirect;
            }
        }

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'location'            => 'required|string|max:255',
            'capacity'            => 'required|integer|min:1', // spot daily capacity must be >= 1
            'description'         => 'nullable|string',
            'availability_status' => 'required|string|in:available,limited,closed',
            'checkin_latitude'    => 'nullable|numeric|between:-90,90',
            'checkin_longitude'   => 'nullable|numeric|between:-180,180',
            'checkin_radius'      => 'nullable|integer|min:5|max:5000',
        ]);

        $dbStatus = 'Available';
        if ($validated['capacity'] == 0 || $validated['availability_status'] === 'closed') {
            $dbStatus = 'Unavailable';
        }

        $destination->update([
            'name'                => $validated['name'],
            'location'            => $validated['location'],
            'capacity'            => $validated['capacity'],
            'description'         => $validated['description'] ?? null,
            'availability_status' => $dbStatus,
            'checkin_latitude'    => $validated['checkin_latitude'] ?? null,
            'checkin_longitude'   => $validated['checkin_longitude'] ?? null,
            'checkin_radius'      => $validated['checkin_radius'] ?? 100,
            'last_updated_by'     => $user->name,
        ]);

        // AJAX response (Blade form submits via fetch with Accept: application/json)
        if ($request->expectsJson()) {
            return response()->json([
                'message'           => 'Spot details updated successfully!',
                'checkin_latitude'  => $destination->checkin_latitude,
                'checkin_longitude' => $destination->checkin_longitude,
                'checkin_radius'    => $destination->checkin_radius,
                'last_updated_by'   => $destination->last_updated_by,
                'updated_at'        => $destination->updated_at->toIso8601String(),
            ]);
        }

        return back()->with('success', 'Spot details updated successfully!');
    }

    /**
     * Lightweight public endpoint that returns only the current check-in
     * coordinates for a spot.  The visitor-facing map polls this every 30 s
     * so it stays in sync without WebSockets.
     *
     * Route: GET /spots/{destination}/checkin-coords   (no auth required)
     */
    public function checkinCoords(Destination $destination)
    {
        return response()->json([
            'checkin_latitude'  => $destination->checkin_latitude,
            'checkin_longitude' => $destination->checkin_longitude,
            'checkin_radius'    => $destination->checkin_radius,
            'last_updated_by'   => $destination->last_updated_by,
            'updated_at'        => $destination->updated_at?->toIso8601String(),
        ])->header('Cache-Control', 'no-store');
    }

    public function uploadImage(Request $request, Destination $destination)
    {
        if ($redirect = $this->ensureAuthorizedSpot($destination)) {
            return $redirect;
        }

        $request->validate(['image' => 'required|image|max:4096']);

        $path    = $request->file('image')->store('destination_photos', 'public');
        $isFirst = !$destination->images()->exists();

        $destination->images()->create([
            'path'       => $path,
            'is_primary' => $isFirst,
        ]);

        if ($isFirst) {
            $destination->update(['photos' => $path]);
        }

        return back()->with('success', 'Image uploaded successfully!');
    }

    public function deleteImage(DestinationImage $image)
    {
        if ($redirect = $this->ensureAuthorizedSpot($image->destination)) {
            return $redirect;
        }

        Storage::disk('public')->delete($image->path);

        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $nextPrimary = $destination->images()->first();
            if ($nextPrimary) {
                $nextPrimary->update(['is_primary' => true]);
                $destination->update(['photos' => $nextPrimary->path]);
            } else {
                $destination->update(['photos' => null]);
            }
        }

        return back()->with('success', 'Image removed successfully!');
    }

    public function setPrimary(DestinationImage $image)
    {
        if ($redirect = $this->ensureAuthorizedSpot($image->destination)) {
            return $redirect;
        }

        $destination->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);
        $destination->update(['photos' => $image->path]);

        return back()->with('success', 'Primary image updated successfully!');
    }
}
