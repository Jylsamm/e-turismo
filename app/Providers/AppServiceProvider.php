<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate for admin-only access
        Gate::define('admin-only', function ($user) {
            return $user->isAdmin();
        });

        // Gate for non-admin access (tourists and staff)
        Gate::define('not-admin', function ($user) {
            return !$user->isAdmin();
        });

        // Gate for staff-only access (booking management & check-in)
        Gate::define('staff-or-admin', function ($user) {
            return $user->isStaff();
        });

        // Automatically apply ReportPolicy
        Gate::policy(\App\Models\Report::class, \App\Policies\ReportPolicy::class);
    }
}
