<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies — required for ngrok / reverse-proxy HTTPS
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'identity.verified' => \App\Http\Middleware\RequireIdentityVerified::class,
        ]);

        $middleware->append(\App\Http\Middleware\LogSlowQueries::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
