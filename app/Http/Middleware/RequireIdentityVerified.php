<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireIdentityVerified
{
    /**
     * Handle an incoming request.
     *
     * Design intent (post-restructure):
     *  - Admins & staff: always pass through.
     *  - Tourists (any status): can access dashboard, profile, destinations, notifications.
     *  - Only BOOKING routes are gated behind a verified status.
     *  - Pending tourists also cannot book; all others can if verified.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admins and staff are always fully verified
        if ($user->isAdmin() || $user->isStaff()) {
            return $next($request);
        }

        $status = $user->id_verification_status ?? 'unverified';
        $path   = $request->getPathInfo();

        // Only booking routes require a verified identity
        $isBookingRoute = str_starts_with($path, '/destinations') && str_ends_with($path, '/book')
            || str_starts_with($path, '/bookings');

        if ($isBookingRoute && $status !== 'verified') {
            $msg = match($status) {
                'pending'   => 'Your identity is under review. Booking is temporarily unavailable.',
                'rejected'  => 'Your identity verification was unsuccessful. Please update your details to book.',
                default     => 'Please verify your identity to make a booking.',
            };

            return redirect(route('profile.edit') . '#verification')->with('warning', $msg);
        }

        return $next($request);
    }
}
