<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies — required for ngrok / reverse-proxy HTTPS
        $middleware->trustProxies(at: '*');

        // Exclude logout from CSRF token validation to prevent 419 Page Expired errors on refresh or direct visits
        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);

        $middleware->alias([
            'identity.verified' => \App\Http\Middleware\RequireIdentityVerified::class,
            'check.booking.status' => \App\Http\Middleware\CheckBookingStatus::class,
        ]);

        $middleware->append(\App\Http\Middleware\LogSlowQueries::class);
        $middleware->append(\App\Http\Middleware\PreventBackHistory::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->is('logout') || $request->routeIs('logout')) {
                \Illuminate\Support\Facades\Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect('/login')->with('status', 'You have been logged out.');
            }
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation', '_token'))
                ->with('status', 'Your session expired due to inactivity. Please try again.');
        });
    })->create();
