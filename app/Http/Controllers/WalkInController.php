<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\WalkIn;
use App\Models\CheckIn;
use Illuminate\Http\Request;

class WalkInController extends Controller
{
    public function create()
    {
        $user = auth()->user();
        if (!$user->isStaff()) {
            abort(403, 'Unauthorized action.');
        }

        $destination = Destination::find($user->assigned_destination_id);
        if (!$destination) {
            return redirect()->route('dashboard')->with('error', 'You must be assigned to a tourist spot to register walk-ins.');
        }

        // Live capacity stats (combining today's check-ins + today's walk-ins)
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();

        $todayCheckins = CheckIn::whereHas('booking', function ($q) use ($destination) {
            $q->where('destination_id', $destination->id);
        })->whereBetween('arrival_time', [$todayStart, $todayEnd])->count();

        $todayWalkins = WalkIn::where('destination_id', $destination->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])->count();

        $currentVisitors = $todayCheckins + $todayWalkins;
        
        $totalWalkinsMonth = WalkIn::where('destination_id', $destination->id)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

        return view('staff.walkins.create', compact('destination', 'currentVisitors', 'todayWalkins', 'totalWalkinsMonth'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->isStaff()) {
            abort(403, 'Unauthorized action.');
        }

        $destination = Destination::find($user->assigned_destination_id);
        if (!$destination) {
            abort(400, 'Destination not assigned.');
        }

        $request->validate([
            'visitors' => 'required|array|min:1',
            'visitors.*.name' => 'required|string|max:255',
            'visitors.*.age' => 'required|integer|min:1|max:150',
            'visitors.*.contact_number' => 'nullable|string|max:50',
            'visitors.*.email' => 'nullable|email|max:255',
            'visitors.*.classification' => 'required|string|in:Local,Domestic Tourist,International Tourist',
            'visitors.*.duration_days' => 'required|integer|min:1|max:30',
        ]);

        $visitorCount = count($request->visitors);

        // Fetch current active count
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        $todayCheckins = CheckIn::whereHas('booking', function ($q) use ($destination) {
            $q->where('destination_id', $destination->id);
        })->whereBetween('arrival_time', [$todayStart, $todayEnd])->count();

        $todayWalkins = WalkIn::where('destination_id', $destination->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])->count();

        $currentVisitors = $todayCheckins + $todayWalkins;

        if (($currentVisitors + $visitorCount) > $destination->capacity) {
            return back()->withInput()->with('error', 'Registration denied: This would push the destination over its maximum capacity of ' . $destination->capacity . '.');
        }

        foreach ($request->visitors as $v) {
            WalkIn::create([
                'destination_id' => $destination->id,
                'name' => $v['name'],
                'age' => $v['age'],
                'contact_number' => $v['contact_number'],
                'email' => $v['email'],
                'classification' => $v['classification'],
                'duration_days' => $v['duration_days'],
                'registered_by_staff_id' => $user->id,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Walk-in visitors registered successfully.');
    }
}
