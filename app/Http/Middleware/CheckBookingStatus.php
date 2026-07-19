<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class CheckBookingStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Cache::get('bookings_halted', false)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Bookings are currently halted by the administration. Please contact support.'
                ], 503);
            }
            return back()->withErrors(['error' => 'Bookings are currently halted by the administration. Please contact support.']);
        }

        return $next($request);
    }
}
