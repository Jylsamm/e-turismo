<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Notification;
use App\Models\Ticket;
use App\Models\CheckIn;
use Illuminate\Http\Request;
use App\Jobs\SendBookingNotificationJob;
use App\Jobs\GenerateQrTicketJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Show booking form for a specific destination.
     */
    public function create(Destination $destination)
    {
        $visitDate = request('visit_date', old('visit_date'));
        
        $confirmedToday = Booking::where('destination_id', $destination->id)
            ->where('visit_date', $visitDate)
            ->where('status', 'confirmed')
            ->count();

        $confirmedCompanions = \App\Models\BookingCompanion::whereHas('booking', function ($q) use ($destination, $visitDate) {
            $q->where('destination_id', $destination->id)
              ->where('visit_date', $visitDate)
              ->where('status', 'confirmed');
        })->count();

        $totalConfirmed = $confirmedToday + $confirmedCompanions;

        return view('bookings.create', compact('destination', 'totalConfirmed'));
    }

    /**
     * Store a new booking (Tourist submits).
     */
    public function store(Request $request, Destination $destination)
    {
        $request->validate([
            'visit_date' => 'required|date|after:today',
            'duration_days' => 'nullable|integer|min:1|max:30',
            'visitors' => 'nullable|array',
            'visitors.*.name' => 'required|string|max:255',
            'visitors.*.age' => 'required|integer|min:1|max:150',
            'visitors.*.gender' => 'required|string|in:Male,Female',
            'visitors.*.contact_number' => 'nullable|string|max:50',
            'visitors.*.email' => 'nullable|email|max:255',
            'visitors.*.classification' => 'required|string|in:Local,Domestic Tourist,International Tourist',
            'visitors.*.duration_days' => 'required|integer|min:1|max:30',
        ]);

        // Check if destination has capacity including companions
        $confirmedBookingsCount = Booking::where('destination_id', $destination->id)
            ->where('visit_date', $request->visit_date)
            ->where('status', 'confirmed')
            ->count();

        $confirmedCompanionsCount = \App\Models\BookingCompanion::whereHas('booking', function ($q) use ($destination, $request) {
            $q->where('destination_id', $destination->id)
              ->where('visit_date', $request->visit_date)
              ->where('status', 'confirmed');
        })->count();

        $totalConfirmed = $confirmedBookingsCount + $confirmedCompanionsCount;
        $visitors = $request->input('visitors', []);
        $totalRequested = 1 + count($visitors);

        // Prevent duplicate application (Limitation: 1 active booking per tourist per spot per visit date)
        $existingBooking = Booking::where('tourist_id', auth()->id())
            ->where('destination_id', $destination->id)
            ->where('visit_date', $request->visit_date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();

        if ($existingBooking) {
            return back()->withInput()->with('error', 'Duplicate request denied: You already have an active booking (' . ucfirst($existingBooking->status) . ') for ' . $destination->name . ' on ' . $request->visit_date . '.');
        }

        if (($totalConfirmed + $totalRequested) > $destination->capacity) {
            return back()->withInput()->with('error', 'This destination does not have enough capacity on the selected date. Only ' . max(0, $destination->capacity - $totalConfirmed) . ' slots remaining.');
        }

        $booking = \Illuminate\Support\Facades\DB::transaction(function () use ($destination, $request, $visitors) {
            $b = Booking::create([
                'tourist_id'     => auth()->id(),
                'destination_id' => $destination->id,
                'visit_date'     => $request->visit_date,
                'duration_days' => $request->input('duration_days', 1),
                'status'         => 'pending',
            ]);

            if (!empty($visitors)) {
                $now = now();
                $companionData = array_map(function ($v) use ($b, $now) {
                    return [
                        'booking_id'     => $b->id,
                        'name'           => $v['name'],
                        'age'            => $v['age'],
                        'gender'         => $v['gender'],
                        'contact_number' => $v['contact_number'] ?? null,
                        'email'          => $v['email'] ?? null,
                        'classification' => $v['classification'],
                        'duration_days'  => $v['duration_days'],
                        'created_at'     => $now,
                        'updated_at'     => $now,
                    ];
                }, $visitors);
                \App\Models\BookingCompanion::insert($companionData);
            }

            return $b;
        });

        // Notify all staff assigned to this destination
        $staffIds = $destination->staff()->pluck('id')->toArray();
        $message = "New booking request from " . auth()->user()->name . " (group of " . $totalRequested . ") for " . $destination->name . " on " . $request->visit_date . ".";
        SendBookingNotificationJob::dispatch($staffIds, 'staff', 'booking_alert', $message, $booking->id);

        // Notify the tourist about pending payment required
        $touristMessage = "Booking request #" . $booking->id . " submitted for " . $destination->name . " on " . $booking->visit_date . ". Pending payment required: Please send your GCash payment and submit the reference number to confirm your slot.";
        SendBookingNotificationJob::dispatch([auth()->id()], 'tourist', 'booking_alert', $touristMessage, $booking->id);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking submitted! Pending payment required — please upload your GCash receipt to confirm.')
            ->with('success_title', 'Payment Required')
            ->with('toast_type', 'booking');
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
                ->cursorPaginate(20);
        } elseif ($user->isStaff()) {
            $bookings = Booking::with(['tourist', 'destination', 'ticket'])
                ->where('destination_id', $user->assigned_destination_id)
                ->latest()
                ->cursorPaginate(20);
        } else {
            // Admin is not allowed here (blocked at the route level via 'cannot:admin-only')
            return redirect()->route('dashboard')
                ->with('warning', 'Access Restricted: Administrator accounts do not have access to direct booking management.')
                ->with('warning_title', 'Administrative Restriction');
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
            return redirect()->route('bookings.index')
                ->with('warning', 'Access Restricted: You can only view details of your own bookings.')
                ->with('warning_title', 'Access Restricted');
        }
        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $targetSpot = optional($booking->destination)->name ?? 'this destination';
            return redirect()->route('bookings.index')
                ->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Managing bookings for {$targetSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        $booking->load(['tourist', 'destination', 'ticket']);

        if ($booking->qr_token && $booking->status !== 'declined' && $booking->payment_status !== 'rejected') {
            $qrPath = 'qr-tickets/' . $booking->id . '.svg';
            if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($qrPath)) {
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('qr-tickets');
                $qrCodeImage = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(250)->margin(1)->generate($booking->qr_token);
                \Illuminate\Support\Facades\Storage::disk('public')->put($qrPath, $qrCodeImage);
            }
        }

        if (request()->wantsJson() || request()->ajax() || request()->expectsJson() || request()->header('X-Requested-With') === 'XMLHttpRequest' || request()->header('Accept') === 'application/json') {
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
                'payment_receipt' => $booking->payment_screenshot_path ? asset('storage/' . $booking->payment_screenshot_path) : null,
                'gcash_reference_number' => $booking->gcash_reference_number,
                'qr_ticket' => $booking->qr_token ? asset('storage/qr-tickets/' . $booking->id . '.svg') : null,
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
            return back()->with('warning', 'Access Restricted: Administrator accounts cannot confirm bookings directly.')
                         ->with('warning_title', 'Administrative Restriction');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $targetSpot = optional($booking->destination)->name ?? 'this destination';
            return back()->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Confirming bookings for {$targetSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                         ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        // Generate QR ticket code
        $destination = $booking->destination;
        do {
            $qrCode = strtoupper($destination->initials) . strtoupper(Str::random(6));
        } while (Ticket::where('qr_code', $qrCode)->exists());

        // Offload QR Code file generation to queue
        GenerateQrTicketJob::dispatch($qrCode, $booking->id);

        // Update booking and payment statuses
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'approved',
            'decided_by_staff_id' => $user->id,
            'qr_token' => $qrCode,
            'qr_generated_at' => now(),
        ]);

        Ticket::create([
            'booking_id' => $booking->id,
            'qr_code' => $qrCode,
        ]);

        // Notify tourist via Job
        $message = "Your booking for " . $destination->name . " on " . $booking->visit_date . " has been CONFIRMED! Your QR ticket code is: {$qrCode}.";
        SendBookingNotificationJob::dispatch([$booking->tourist_id], 'tourist', 'booking_alert', $message, $booking->id);

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
            return back()->with('warning', 'Access Restricted: Administrator accounts cannot decline bookings directly.')
                         ->with('warning_title', 'Administrative Restriction');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $targetSpot = optional($booking->destination)->name ?? 'this destination';
            return back()->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Declining bookings for {$targetSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                         ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        if ($booking->status === 'confirmed' && now()->startOfDay()->isAfter(\Carbon\Carbon::parse($booking->visit_date))) {
            return back()->with('error', 'Confirmed bookings cannot be cancelled after the visit date.');
        }

        $reason = $request->input('reason_category');
        $details = $request->input('decline_reason');
        $combinedReason = $reason;
        if (!empty($details)) {
            $combinedReason .= ' - ' . $details;
        }

        // Delete any generated QR token, ticket, and storage SVG for declined bookings
        if ($booking->qr_token || $booking->ticket) {
            \App\Models\Ticket::where('booking_id', $booking->id)->delete();
            \Illuminate\Support\Facades\Storage::disk('public')->delete('qr-tickets/' . $booking->id . '.svg');
        }

        $newPaymentStatus = in_array($booking->payment_status, ['pending_verification', 'approved']) 
            ? 'refund_pending' 
            : 'not_charged';

        $booking->update([
            'status' => 'declined',
            'payment_status' => $newPaymentStatus,
            'decline_reason' => $combinedReason,
            'decided_by_staff_id' => $user->id,
            'qr_token' => null,
        ]);

        // Notify tourist
        $message = "Your booking for " . $booking->destination->name . " on " . $booking->visit_date . " has been DECLINED. Reason: " . $request->decline_reason;
        SendBookingNotificationJob::dispatch([$booking->tourist_id], 'tourist', 'booking_alert', $message, $booking->id);

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
            'gcash_reference_number' => ['required', 'string', 'regex:/^[0-9]+$/', 'max:50'],
            'payment_screenshot' => 'required|image|max:4096',
        ], [
            'gcash_reference_number.regex' => 'The GCash reference number must strictly contain digits (0-9) only.',
            'payment_screenshot.required' => 'Payment receipt is required to submit your booking.',
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

        // Notify staff of payment submission
        $staffIds = $booking->destination ? $booking->destination->staff()->pluck('id')->toArray() : [];
        if (!empty($staffIds)) {
            $staffMessage = "Payment proof submitted by " . auth()->user()->name . " for booking #" . $booking->id . " (" . optional($booking->destination)->name . "). GCash Ref: " . $request->gcash_reference_number;
            SendBookingNotificationJob::dispatch($staffIds, 'staff', 'booking_alert', $staffMessage, $booking->id);
        }

        // Notify tourist that proof was submitted
        $touristMessage = "Payment proof for booking #" . $booking->id . " has been submitted. Staff will verify your transaction shortly.";
        SendBookingNotificationJob::dispatch([$booking->tourist_id], 'tourist', 'booking_alert', $touristMessage, $booking->id);

        return back()
            ->with('success', 'Payment proof submitted successfully! Staff will review it shortly.')
            ->with('success_title', 'Payment Submitted')
            ->with('toast_type', 'booking');
    }

    /**
     * Cancel a booking (Tourist action).
     */
    public function cancel(Booking $booking)
    {
        $user = auth()->user();

        if ($user->id !== $booking->tourist_id) {
            abort(403, 'Unauthorized.');
        }

        // Check if booking can be cancelled
        if (in_array($booking->status, ['declined', 'cancelled', 'completed'])) {
            return back()->with('error', 'This booking is already ' . $booking->status . ' and cannot be cancelled.')
                         ->with('error_title', 'Cancellation Denied')
                         ->with('toast_type', 'error');
        }

        // If booking was already checked in
        if ($booking->checked_in_at) {
            return back()->with('error', 'Checked-in bookings cannot be cancelled.')
                         ->with('error_title', 'Cancellation Denied')
                         ->with('toast_type', 'error');
        }

        // Delete any generated QR token, ticket, and storage SVG
        if ($booking->qr_token || $booking->ticket) {
            \App\Models\Ticket::where('booking_id', $booking->id)->delete();
            \Illuminate\Support\Facades\Storage::disk('public')->delete('qr-tickets/' . $booking->id . '.svg');
        }

        $newPaymentStatus = in_array($booking->payment_status, ['pending_verification', 'approved']) 
            ? 'refund_pending' 
            : 'not_charged';

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => $newPaymentStatus,
            'decline_reason' => 'Cancelled by tourist',
            'qr_token' => null,
        ]);

        // Notify assigned staff
        $staffIds = $booking->destination ? $booking->destination->staff()->pluck('id')->toArray() : [];
        if (!empty($staffIds)) {
            $staffMessage = "Booking #" . $booking->id . " for " . optional($booking->destination)->name . " on " . $booking->visit_date . " has been cancelled by tourist " . $user->name . ".";
            SendBookingNotificationJob::dispatch($staffIds, 'staff', 'booking_alert', $staffMessage, $booking->id);
        }

        // Notify tourist
        $touristMessage = "Your booking #" . $booking->id . " for " . optional($booking->destination)->name . " on " . $booking->visit_date . " has been cancelled.";
        SendBookingNotificationJob::dispatch([$user->id], 'tourist', 'booking_alert', $touristMessage, $booking->id);

        return back()
            ->with('success', 'Booking #' . $booking->id . ' has been cancelled successfully.')
            ->with('success_title', 'Booking Cancelled')
            ->with('toast_type', 'booking');
    }

    /**
     * Approve payment and confirm booking in one click (Staff action).
     */
    public function approvePayment(Booking $booking)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return back()->with('warning', 'Access Restricted: Administrator accounts cannot approve bookings.')
                         ->with('warning_title', 'Administrative Restriction');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $targetSpot = optional($booking->destination)->name ?? 'this destination';
            return back()->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Approving payments for {$targetSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                         ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        // Generate secure unguessable qr token
        $qrToken = 'TKT-' . bin2hex(random_bytes(16));

        // Generate QR code SVG and store it via Job
        GenerateQrTicketJob::dispatch($qrToken, $booking->id);

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

        // Notify tourist via Job
        $message = "Your payment and booking request for " . $booking->destination->name . " on " . $booking->visit_date . " has been APPROVED! Your QR ticket is ready.";
        SendBookingNotificationJob::dispatch([$booking->tourist_id], 'tourist', 'booking_alert', $message, $booking->id);

        return back()->with('success', 'Booking and payment approved successfully! QR ticket generated.');
    }

    /**
     * Reject payment and reject booking (Staff action).
     */
    public function rejectPayment(Request $request, Booking $booking)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return back()->with('warning', 'Access Restricted: Administrator accounts cannot reject bookings.')
                         ->with('warning_title', 'Administrative Restriction');
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $targetSpot = optional($booking->destination)->name ?? 'this destination';
            return back()->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Rejecting payments for {$targetSpot} is unauthorized under the 1-Staff-1-Spot policy.")
                         ->with('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        // Delete any generated QR token, ticket, and storage SVG for rejected payments/declined bookings
        if ($booking->qr_token || $booking->ticket) {
            \App\Models\Ticket::where('booking_id', $booking->id)->delete();
            \Illuminate\Support\Facades\Storage::disk('public')->delete('qr-tickets/' . $booking->id . '.svg');
        }

        $booking->update([
            'status' => 'declined',
            'payment_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'payment_reviewed_at' => now(),
            'reviewed_by' => $user->id,
            'qr_token' => null,
        ]);

        // Notify tourist via Job
        $message = "Your booking/payment for " . $booking->destination->name . " on " . $booking->visit_date . " was REJECTED. Reason: " . $request->rejection_reason;
        SendBookingNotificationJob::dispatch([$booking->tourist_id], 'tourist', 'booking_alert', $message, $booking->id);

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
            ->cursorPaginate(20);

        return view('bookings.tickets', compact('bookings'));
    }

    /**
     * Show QR scanner screen (Staff only).
     */
    public function scanTicket()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('warning', 'Access Restricted: Administrator accounts cannot access the ticket scanner.')
                ->with('warning_title', 'Administrative Restriction');
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
            ->where(function ($q) use ($request) {
                $q->where('qr_token', $request->qr_token)
                  ->orWhere('id', $request->qr_token)
                  ->orWhere('gcash_reference_number', $request->qr_token)
                  ->orWhereHas('ticket', fn($tq) => $tq->where('qr_code', $request->qr_token));
            })
            ->first();

        if (!$booking) {
            return response()->json(['valid' => false, 'message' => 'Invalid ticket — booking not found.']);
        }

        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $ticketSpot = optional($booking->destination)->name ?? 'this destination';
            return response()->json([
                'valid' => false,
                'message' => "Access Restricted: You are assigned to {$assignedSpot}. This ticket is for {$ticketSpot} (1-Staff-1-Spot Policy)."
            ]);
        }

        if ($booking->checked_in_at !== null || $booking->status === 'completed') {
            $time = $booking->checked_in_at
                ? \Illuminate\Support\Carbon::parse($booking->checked_in_at)->format('M j, Y g:i A')
                : 'an earlier session';
            return response()->json(['valid' => false, 'message' => "Ticket already used — visitor checked in at {$time}."]);
        }

        if ($booking->status !== 'confirmed') {
            return response()->json(['valid' => false, 'message' => 'Booking is not confirmed (Status: ' . ucfirst($booking->status) . '). Cannot check in.']);
        }

        $warning = null;
        if ($booking->visit_date !== now()->toDateString()) {
            $formatted = \Illuminate\Support\Carbon::parse($booking->visit_date)->format('M j, Y');
            $warning = "Scheduled visit date is {$formatted} (not today).";
        }

        return response()->json([
            'valid'            => true,
            'tourist_name'     => $booking->tourist?->name ?? 'Unknown',
            'destination_name' => $booking->destination?->name ?? 'Unknown',
            'visit_date'       => \Illuminate\Support\Carbon::parse($booking->visit_date)->format('M j, Y'),
            'booking_status'   => ucfirst($booking->status),
            'warning'          => $warning,
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
            ->where(function ($q) use ($request) {
                $q->where('qr_token', $request->qr_token)
                  ->orWhere('id', $request->qr_token)
                  ->orWhere('gcash_reference_number', $request->qr_token)
                  ->orWhereHas('ticket', fn($tq) => $tq->where('qr_code', $request->qr_token));
            })
            ->first();

        if (!$booking) {
            return response()->json(['valid' => false, 'message' => 'Invalid ticket / Booking not found.'], 404);
        }

        // Staff assigned destination check
        if ($user->isStaff() && $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $ticketSpot = optional($booking->destination)->name ?? 'this destination';
            return response()->json([
                'valid' => false,
                'message' => "Access Restricted: You are assigned to {$assignedSpot}. This ticket is for {$ticketSpot} (1-Staff-1-Spot Policy)."
            ], 403);
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

        // Notify admins via Job
        $adminIds = Cache::remember('system_admin_ids', 86400, function () {
            return \App\Models\User::where('role', 'admin')->pluck('id')->toArray();
        });

        $message = $booking->tourist->name . " has arrived at " . $booking->destination->name . " (checked in via scanner at " . now()->format('h:i A') . ").";
        SendBookingNotificationJob::dispatch($adminIds, 'admin', 'info', $message, $booking->id);

        return response()->json([
            'valid' => true,
            'tourist_name' => $booking->tourist->name,
            'destination_name' => $booking->destination->name,
            'visit_date' => $booking->visit_date,
            'checked_in_at' => now()->format('M j, Y h:i A'),
        ]);
    }
}
