<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Booking;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the specified ticket with its QR code.
     */
    public function show($id)
    {
        $user = auth()->user();
        
        $ticket = Ticket::find($id);
        if (!$ticket) {
            $booking = Booking::find($id);
            if ($booking && $booking->qr_token) {
                $ticket = Ticket::firstOrCreate(
                    ['booking_id' => $booking->id],
                    ['qr_code' => $booking->qr_token, 'issued_at' => now()]
                );
            }
        } else {
            $booking = $ticket->booking;
        }

        // Strict Check: Prevent display of QR ticket for declined or rejected bookings
        if (!$ticket || !$booking || $booking->status === 'declined' || $booking->payment_status === 'rejected') {
            abort(403, 'This booking has been declined or QR code ticket is unavailable.');
        }

        // Check if the user is authorized to view this ticket
        if ($user->isTourist() && $booking->tourist_id !== $user->id) {
            return redirect()->route('bookings.index')
                ->with('warning', 'Access Restricted: You are only authorized to view tickets for your own bookings.')
                ->with('warning_title', 'Access Restricted');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $bookingSpot = optional($booking->destination)->name ?? 'this destination';
            return redirect()->route('dashboard')
                ->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Viewing tickets for {$bookingSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        return view('tickets.show', compact('ticket', 'booking'));
    }
}
