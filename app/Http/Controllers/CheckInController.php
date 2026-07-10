<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckIn;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    /**
     * Show QR scan / manual check-in form.
     */
    public function create()
    {
        return view('checkins.create');
    }

    /**
     * Process check-in by QR code (Staff action).
     */
    public function store(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $user = auth()->user();

        // Admin is not permitted to perform check-ins (blocked at route level; this is defense-in-depth)
        if ($user->isAdmin()) {
            abort(403, 'Admins cannot perform check-ins.');
        }

        $ticket = Ticket::where('qr_code', $request->qr_code)->first();

        if (!$ticket) {
            return back()->with('error', 'Invalid QR code. Ticket not found.');
        }

        $booking = $ticket->booking;

        // Staff can only check in tourists at their assigned destination
        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'You can only check in tourists at your assigned destination.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'This booking is not confirmed. Check-in denied.');
        }

        // Date validation
        if ($booking->visit_date !== now()->toDateString()) {
            return back()->with('error', 'QR code is valid but today is not the scheduled visit date (' . $booking->visit_date . ').');
        }

        // Prevent duplicate check-in
        if ($booking->checkIn) {
            return back()->with('error', 'This ticket has already been checked in at ' . $booking->checkIn->arrival_time . '.');
        }

        // Log the check-in
        CheckIn::create([
            'booking_id' => $booking->id,
            'arrival_time' => now(),
            'verified_by_staff_id' => auth()->id(),
            'occupancy_updated' => true,
        ]);

        // Mark ticket as scanned
        $ticket->update(['scanned_at' => now()]);

        // Mark booking as completed
        $booking->update(['status' => 'completed']);

        $destination = $booking->destination;

        // Notify admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'recipient_id' => $admin->id,
                'recipient_type' => 'admin',
                'type' => 'info',
                'message' => $booking->tourist->name . " has arrived at " . $destination->name . " (checked in at " . now()->format('h:i A') . ").",
                'related_booking_id' => $booking->id,
            ]);
        }

        // Check capacity threshold (notify staff if at 80%+)
        $todayVisitors = CheckIn::whereHas('booking', function ($q) use ($destination) {
            $q->where('destination_id', $destination->id)
              ->where('visit_date', now()->toDateString());
        })->count();

        if ($todayVisitors >= ($destination->capacity * 0.8)) {
            foreach ($destination->staff as $staff) {
                Notification::create([
                    'recipient_id' => $staff->id,
                    'recipient_type' => 'staff',
                    'type' => 'capacity_alert',
                    'message' => "Capacity alert: " . $destination->name . " is at {$todayVisitors}/{$destination->capacity} visitors today.",
                    'related_booking_id' => $booking->id,
                ]);
            }
        }

        return back()->with('success', "Check-in successful! Welcome, {$booking->tourist->name}.");
    }
}
