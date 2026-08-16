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

        $status = $user->id_verification_status ?? 'pending';
        $path   = $request->getPathInfo();

        // Gated routes for non-verified tourists: Booking creation, Bookings list, My Tickets
        $isRestrictedRoute = str_contains($path, '/book')
            || str_starts_with($path, '/bookings')
            || str_starts_with($path, '/tickets');

        if ($isRestrictedRoute && $status !== 'verified') {
            return redirect(route('profile.edit') . '#verification')
                ->with('warning', 'Your identity is under review (Pending). Bookings and Tickets are locked until your ID is verified.');
        }

        return $next($request);
    }
}
