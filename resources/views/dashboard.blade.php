{{--
    This view is intentionally left as a redirect fallback only.
    DashboardController::index() renders the correct role-specific view directly.
    This file is only hit if someone routes here without going through the controller.
--}}
@php
    $user = auth()->user();
@endphp

@if($user->isAdmin())
    @include('dashboard.admin')
@elseif($user->isStaff())
    @include('dashboard.staff')
@else
    @include('dashboard.tourist')
@endif
