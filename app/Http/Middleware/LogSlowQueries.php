<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSlowQueries
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! config('app.debug')) {
            return $next($request);
        }

        DB::listen(function ($query) {
            $thresholdMs = 250;

            if ((float) $query->time < $thresholdMs) {
                return;
            }

            $sql = str_replace("\n", ' ', $query->sql);
            $bindings = is_array($query->bindings) ? $query->bindings : [];

            Log::warning('[slow-query] ' . number_format((float) $query->time, 2) . 'ms | ' . $sql, [
                'bindings' => $bindings,
            ]);
        });

        return $next($request);
    }
}
