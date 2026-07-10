<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display the specified ticket with its QR code.
     */
    public function show(Ticket $ticket)
    {
        $user = auth()->user();
        $booking = $ticket->booking;

        // Check if the user is authorized to view this ticket
        if ($user->isTourist() && $booking->tourist_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        return view('tickets.show', compact('ticket', 'booking'));
    }
}
