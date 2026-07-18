<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\Ticket;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Show booking form for a specific destination.
     */
    public function create(Destination $destination)
    {
        return view('bookings.create', compact('destination'));
    }

    /**
     * Store a new booking (Tourist submits).
     */
    public function store(Request $request, Destination $destination)
    {
        $request->validate([
            'visit_date' => 'required|date|after:today',
        ]);

        // Check if destination has capacity
        $confirmedBookingsOnDate = Booking::where('destination_id', $destination->id)
            ->where('visit_date', $request->visit_date)
            ->where('status', 'confirmed')
            ->count();

        if ($confirmedBookingsOnDate >= $destination->capacity) {
            return back()->with('error', 'This destination is fully booked on the selected date. Please choose another date.');
        }

        $booking = Booking::create([
            'tourist_id' => auth()->id(),
            'destination_id' => $destination->id,
            'visit_date' => $request->visit_date,
            'status' => 'pending',
        ]);

        // Notify all staff assigned to this destination
        $staffUsers = $destination->staff;
        foreach ($staffUsers as $staff) {
            Notification::create([
                'recipient_id' => $staff->id,
                'recipient_type' => 'staff',
                'type' => 'booking_alert',
                'message' => "New booking request from " . auth()->user()->name . " for " . $destination->name . " on " . $request->visit_date . ".",
                'related_booking_id' => $booking->id,
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking submitted! You will be notified once it is reviewed.');
    }

    /**
     * List all bookings for the logged-in user (tourist) or assigned destination (staff).
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->isTourist()) {
            $bookings = Booking::with(['destination', 'ticket'])
                ->where('tourist_id', $user->id)
                ->latest()
                ->get();
        } elseif ($user->isStaff()) {
            $bookings = Booking::with(['tourist', 'destination', 'ticket'])
                ->where('destination_id', $user->assigned_destination_id)
                ->latest()
                ->get();
        } else {
            // Admin is not allowed here (blocked at the route level via 'cannot:admin-only')
            abort(403, 'Admins do not have access to booking management.');
        }


        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show booking details (Tourist or Staff action).
     */
    public function show(Booking $booking)
    {
        $user = auth()->user();
        if ($user->isTourist() && $booking->tourist_id !== $user->id) {
            abort(403, 'Unauthorized.');
        }
        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        $booking->load(['tourist', 'destination', 'ticket']);

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'id' => $booking->id,
                'tourist' => [
                    'name' => $booking->tourist?->name ?? 'Unknown',
                    'email' => $booking->tourist?->email ?? 'N/A',
                    'phone' => $booking->tourist?->phone ?? 'N/A',
                ],
                'spot' => $booking->destination?->name ?? 'Unknown',
                'location' => $booking->destination?->location ?? 'Unknown',
                'visit_date' => \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y'),
                'payment_status' => $booking->payment_status ?? 'unpaid',
                'payment_receipt' => $booking->payment_screenshot_path ? \Illuminate\Support\Facades\Storage::url($booking->payment_screenshot_path) : null,
                'gcash_reference_number' => $booking->gcash_reference_number,
                'qr_ticket' => $booking->qr_token ? \Illuminate\Support\Facades\Storage::url('qr-tickets/' . $booking->id . '.svg') : null,
                'qr_token' => $booking->qr_token,
                'status' => $booking->status,
                'decline_reason' => $booking->decline_reason,
                'rejection_reason' => $booking->rejection_reason,
                'notes' => $booking->checked_in_at ? 'Checked in at ' . \Carbon\Carbon::parse($booking->checked_in_at)->format('M j, Y h:i A') : 'N/A',
            ]);
        }

        return view('bookings.show', compact('booking'));
    }

    /**
     * Confirm a booking (Staff action).
     */
    public function confirm(Booking $booking)
    {
        $user = auth()->user();

        // Admin is not permitted to perform booking actions
        if ($user->isAdmin()) {
            abort(403, 'Admins cannot manage bookings.');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        // Generate QR ticket code
        $destination = $booking->destination;
        $qrCode = strtoupper($destination->initials) . random_int(100000, 999999);

        // Ensure QR uniqueness
        while (Ticket::where('qr_code', $qrCode)->exists()) {
            $qrCode = strtoupper($destination->initials) . random_int(100000, 999999);
        }

        // Generate QR SVG file in storage
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('qr-tickets');
        $qrPath = 'qr-tickets/' . $booking->id . '.svg';
        $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)
            ->margin(1)
            ->generate($qrCode);
        \Illuminate\Support\Facades\Storage::disk('public')->put($qrPath, $qrCodeImage);

        // Update booking and payment statuses
        $booking->update([
            'status' => 'confirmed',
            'decided_by_staff_id' => $user->id,
            'qr_token' => $qrCode,
            'qr_generated_at' => now(),
        ]);

        Ticket::create([
            'booking_id' => $booking->id,
            'qr_code' => $qrCode,
        ]);

        // Notify tourist
        Notification::create([
            'recipient_id' => $booking->tourist_id,
            'recipient_type' => 'tourist',
            'type' => 'booking_alert',
            'message' => "Your booking for " . $destination->name . " on " . $booking->visit_date . " has been CONFIRMED! Your QR ticket code is: {$qrCode}.",
            'related_booking_id' => $booking->id,
        ]);

        return back()->with('success', 'Booking confirmed and QR ticket generated.');
    }

    /**
     * Decline a booking (Staff action).
     */
    public function decline(Request $request, Booking $booking)
    {
        $user = auth()->user();

        // Admin is not permitted to perform booking actions
        if ($user->isAdmin()) {
            abort(403, 'Admins cannot manage bookings.');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        $reason = $request->input('reason_category');
        $details = $request->input('decline_reason');
        $combinedReason = $reason;
        if (!empty($details)) {
            $combinedReason .= ' - ' . $details;
        }

        $booking->update([
            'status' => 'declined',
            'decline_reason' => $combinedReason,
            'decided_by_staff_id' => $user->id,
        ]);

        // Notify tourist
        Notification::create([
            'recipient_id' => $booking->tourist_id,
            'recipient_type' => 'tourist',
            'type' => 'booking_alert',
            'message' => "Your booking for " . $booking->destination->name . " on " . $booking->visit_date . " has been DECLINED. Reason: " . $request->decline_reason,
            'related_booking_id' => $booking->id,
        ]);

        return back()->with('success', 'Booking declined and tourist has been notified.');
    }

    /**
     * Submit payment proof (Tourist action).
     */
    public function submitPayment(Request $request, Booking $booking)
    {
        if (auth()->id() !== $booking->tourist_id) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'gcash_reference_number' => 'required|string|max:100',
            'payment_screenshot' => 'nullable|image|max:4096',
        ]);

        $screenshotPath = null;
        if ($request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('payment_screenshots', 'public');
        }

        $booking->update([
            'gcash_reference_number' => $request->gcash_reference_number,
            'payment_screenshot_path' => $screenshotPath,
            'payment_status' => 'pending_verification',
            'payment_submitted_at' => now(),
        ]);

        return back()->with('success', 'Payment proof submitted successfully! Staff will review it shortly.');
    }

    /**
     * Approve payment and confirm booking in one click (Staff action).
     */
    public function approvePayment(Booking $booking)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            abort(403, 'Admins cannot approve bookings.');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        // Generate secure unguessable qr token
        $qrToken = 'TKT-' . bin2hex(random_bytes(16));

        // Generate QR code SVG and store it
        \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('qr-tickets');
        $qrPath = 'qr-tickets/' . $booking->id . '.svg';
        $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)
            ->margin(1)
            ->generate($qrToken);
        \Illuminate\Support\Facades\Storage::disk('public')->put($qrPath, $qrCodeImage);

        // Update booking and payment statuses together
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'approved',
            'payment_reviewed_at' => now(),
            'reviewed_by' => $user->id,
            'qr_token' => $qrToken,
            'qr_generated_at' => now(),
        ]);

        // Create legacy ticket record for backwards compatibility
        Ticket::updateOrCreate(
            ['booking_id' => $booking->id],
            ['qr_code' => $qrToken]
        );

        // Notify tourist
        Notification::create([
            'recipient_id' => $booking->tourist_id,
            'recipient_type' => 'tourist',
            'type' => 'booking_alert',
            'message' => "Your payment and booking request for " . $booking->destination->name . " on " . $booking->visit_date . " has been APPROVED! Your QR ticket is ready.",
            'related_booking_id' => $booking->id,
        ]);

        return back()->with('success', 'Booking and payment approved successfully! QR ticket generated.');
    }

    /**
     * Reject payment and reject booking (Staff action).
     */
    public function rejectPayment(Request $request, Booking $booking)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            abort(403, 'Admins cannot reject bookings.');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            abort(403, 'Unauthorized.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'declined',
            'payment_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'payment_reviewed_at' => now(),
            'reviewed_by' => $user->id,
        ]);

        // Notify tourist
        Notification::create([
            'recipient_id' => $booking->tourist_id,
            'recipient_type' => 'tourist',
            'type' => 'booking_alert',
            'message' => "Your booking/payment for " . $booking->destination->name . " on " . $booking->visit_date . " was REJECTED. Reason: " . $request->rejection_reason,
            'related_booking_id' => $booking->id,
        ]);

        return back()->with('success', 'Booking and payment rejected.');
    }

    /**
     * View active tickets (Tourist dashboard).
     */
    public function myTickets()
    {
        $user = auth()->user();
        if (!$user->isTourist()) {
            abort(403, 'Only tourists can view tickets.');
        }

        $bookings = Booking::with(['destination', 'ticket'])
            ->where('tourist_id', $user->id)
            ->whereIn('status', ['confirmed', 'completed'])
            ->whereNotNull('qr_token')
            ->latest()
            ->get();

        return view('bookings.tickets', compact('bookings'));
    }

    /**
     * Show QR scanner screen (Staff only).
     */
    public function scanTicket()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            abort(403, 'Admins cannot perform ticket scanning.');
        }

        return view('bookings.scan');
    }

    /**
     * Preview ticket info WITHOUT completing check-in (Staff action).
     * Used by the scanner UI to show a confirmation card before finalising.
     */
    public function previewTicket(Request $request)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return response()->json(['valid' => false, 'message' => 'Admins cannot perform check-ins.'], 403);
        }

        $request->validate(['qr_token' => 'required|string']);

        $booking = Booking::with('tourist', 'destination')
            ->where('qr_token', $request->qr_token)
            ->first();

        if (!$booking) {
            return response()->json(['valid' => false, 'message' => 'Invalid ticket — booking not found.']);
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            return response()->json(['valid' => false, 'message' => 'This ticket belongs to a different destination.']);
        }

        if ($booking->checked_in_at !== null || $booking->status === 'completed') {
            $time = $booking->checked_in_at
                ? \Illuminate\Support\Carbon::parse($booking->checked_in_at)->format('M j, Y g:i A')
                : 'an earlier session';
            return response()->json(['valid' => false, 'message' => "Ticket already used — visitor checked in at {$time}."]);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json(['valid' => false, 'message' => 'Booking is not confirmed (Status: ' . ucfirst($booking->status) . ').
 Cannot check in.']);
        }

        if ($booking->visit_date !== now()->toDateString()) {
            $formatted = \Illuminate\Support\Carbon::parse($booking->visit_date)->format('M j, Y');
            return response()->json(['valid' => false, 'message' => "Scheduled visit date is {$formatted} — not today."]);
        }

        return response()->json([
            'valid'            => true,
            'tourist_name'     => $booking->tourist?->name ?? 'Unknown',
            'destination_name' => $booking->destination?->name ?? 'Unknown',
            'visit_date'       => \Illuminate\Support\Carbon::parse($booking->visit_date)->format('M j, Y'),
            'booking_status'   => ucfirst($booking->status),
        ]);
    }

    /**
     * Verify scanned QR token (Staff POST endpoint).
     */
    public function verifyTicket(Request $request)
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return response()->json(['valid' => false, 'message' => 'Admins cannot perform check-ins.'], 403);
        }

        $request->validate([
            'qr_token' => 'required|string',
        ]);

        $booking = Booking::with('tourist', 'destination')
            ->where('qr_token', $request->qr_token)
            ->first();

        if (!$booking) {
            return response()->json(['valid' => false, 'message' => 'Invalid ticket / Booking not found.'], 404);
        }

        // Staff assigned destination check
        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            return response()->json(['valid' => false, 'message' => 'This ticket is for another destination.'], 403);
        }

        if ($booking->status !== 'confirmed') {
            if ($booking->status === 'completed' || $booking->checked_in_at !== null) {
                $time = $booking->checked_in_at ? \Carbon\Carbon::parse($booking->checked_in_at)->format('M j, Y H:i') : 'an earlier date';
                return response()->json(['valid' => false, 'message' => 'Ticket already used / Checked in at ' . $time]);
            }
            return response()->json(['valid' => false, 'message' => 'This booking is not confirmed (Status: ' . ucfirst($booking->status) . ').']);
        }

        // Prevent replay check (double safety)
        if ($booking->checked_in_at !== null) {
            $time = \Carbon\Carbon::parse($booking->checked_in_at)->format('M j, Y H:i');
            return response()->json(['valid' => false, 'message' => 'Ticket already used / Checked in at ' . $time]);
        }

        // Date check - must be today
        if ($booking->visit_date !== now()->toDateString()) {
            return response()->json(['valid' => false, 'message' => 'Scheduled visit date is ' . $booking->visit_date . ' (not today).']);
        }

        // Log the check-in
        $booking->update([
            'status' => 'completed',
            'checked_in_at' => now(),
            'checked_in_by' => $user->id,
        ]);

        // Legacy check_ins log insert
        CheckIn::create([
            'booking_id' => $booking->id,
            'arrival_time' => now(),
            'verified_by_staff_id' => $user->id,
            'occupancy_updated' => true,
        ]);

        // Legacy ticket status update
        $ticket = Ticket::where('booking_id', $booking->id)->first();
        if ($ticket) {
            $ticket->update(['scanned_at' => now()]);
        }

        // Notify admins
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'recipient_id' => $admin->id,
                'recipient_type' => 'admin',
                'type' => 'info',
                'message' => $booking->tourist->name . " has arrived at " . $booking->destination->name . " (checked in via scanner at " . now()->format('h:i A') . ").",
                'related_booking_id' => $booking->id,
            ]);
        }

        return response()->json([
            'valid' => true,
            'tourist_name' => $booking->tourist->name,
            'destination_name' => $booking->destination->name,
            'visit_date' => $booking->visit_date,
            'checked_in_at' => now()->format('M j, Y h:i A'),
        ]);
    }
}
