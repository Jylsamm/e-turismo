<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class StaffBookingController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if (!$user->isStaff()) {
            return redirect()->route('dashboard')
                ->with('warning', 'Access Restricted: Only assigned destination staff can manage tourist bookings.')
                ->with('warning_title', 'Access Restricted (Staff Only)');
        }

        $destinationId = $user->assigned_destination_id;
        $period = request('period', 'all');
        $query = Booking::with(['tourist', 'destination', 'ticket', 'companions'])
            ->where('destination_id', $destinationId);

        if ($period !== 'all') {
            $now = now();
            if ($period === 'today') {
                $query->whereDate('visit_date', today());
            } elseif ($period === 'week') {
                $query->whereBetween('visit_date', [
                    $now->startOfWeek()->toDateString(),
                    $now->endOfWeek()->toDateString()
                ]);
            } elseif ($period === 'month') {
                $query->whereMonth('visit_date', $now->month)
                      ->whereYear('visit_date', $now->year);
            } elseif ($period === 'year') {
                $query->whereYear('visit_date', $now->year);
            }
        }

        $bookings = $query->latest()->get();

        $pending = $bookings->where('status', 'pending')->values();
        $confirmed = $bookings->where('status', 'confirmed')->values();
        $completed = $bookings->where('status', 'completed')->values();
        $cancelled = $bookings->where('status', 'declined')->values();

        if (request()->wantsJson()) {
            return response()->json([
                'pending' => $pending,
                'confirmed' => $confirmed,
                'completed' => $completed,
                'cancelled' => $cancelled,
            ]);
        }

        return view('bookings.staff-pending', compact('pending', 'confirmed', 'completed', 'cancelled', 'period'));
    }

    public function show(Booking $booking)
    {
        $user = auth()->user();
        if (!$user->isStaff() || $user->assigned_destination_id !== $booking->destination_id) {
            $assignedSpot = optional($user->assignedDestination)->name ?? 'your assigned spot';
            $bookingSpot = optional($booking->destination)->name ?? 'this destination';
            return redirect()->route('staff.bookings.pending')
                ->with('warning', "Access Restricted: You are assigned to {$assignedSpot}. Viewing bookings for {$bookingSpot} is unauthorized under the 1-Staff-1-Spot policy.")
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

        return response()->json([
            'id' => $booking->id,
            'tourist' => [
                'name' => $booking->tourist?->name ?? 'Unknown',
                'email' => $booking->tourist?->email ?? 'N/A',
                'phone' => $booking->tourist?->phone ?? 'N/A',
            ],
            'spot' => $booking->destination?->name ?? 'Unknown',
            'visit_date' => \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y'),
            'guest_count' => 1 + $booking->companions->count(),
            'duration_days' => $booking->duration_days ?? 1,
            'gcash_reference_number' => $booking->gcash_reference_number,
            'payment_status' => $booking->payment_status ?? 'unpaid',
            'payment_receipt' => $booking->payment_screenshot_path ? asset('storage/' . $booking->payment_screenshot_path) : null,
            'qr_ticket' => $booking->qr_token ? asset('storage/qr-tickets/' . $booking->id . '.svg') : null,
            'qr_token' => $booking->qr_token,
            'status' => $booking->status,
            'decline_reason' => $booking->decline_reason,
            'rejection_reason' => $booking->rejection_reason,
            'notes' => 'Checked in at ' . ($booking->checked_in_at ? \Carbon\Carbon::parse($booking->checked_in_at)->format('M j, Y h:i A') : 'N/A'),
        ]);
    }
}
