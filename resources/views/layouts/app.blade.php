<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(request()->routeIs('spots.edit*') || request()->is('staff/*') || request()->is('admin/*'))
        <meta name="robots" content="noindex, nofollow">
    @endif

    <title>@stack('title', config('app.name', 'E-Turismo'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    @php
        $faviconPath = public_path('Pictures/LOGO/LOGO-eturismo.png');
        $faviconVersion = file_exists($faviconPath) ? filemtime($faviconPath) : '1';
        $faviconUrl = asset('Pictures/LOGO/LOGO-eturismo.png') . '?v=' . $faviconVersion;
    @endphp
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    <!-- Automatic Passive Event Listener Handler (Eliminates Chrome [Violation] warnings for ApexCharts / Touch events) -->
    <script>
        (function () {
            if (typeof EventTarget === 'undefined') return;
            const passiveEvents = ['touchstart', 'touchmove', 'wheel', 'mousewheel'];
            const originalAddEventListener = EventTarget.prototype.addEventListener;
            EventTarget.prototype.addEventListener = function (type, listener, options) {
                let opts = options;
                if (passiveEvents.includes(type)) {
                    if (typeof options === 'boolean') {
                        opts = { capture: options, passive: true };
                    } else if (typeof options === 'object' && options !== null) {
                        if (options.passive === undefined) {
                            opts = Object.assign({}, options, { passive: true });
                        }
                    } else if (options === undefined) {
                        opts = { passive: true };
                    }
                }
                return originalAddEventListener.call(this, type, listener, opts);
            };
        })();
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    @stack('head')


    <style>
        @media (min-width: 768px) {
            .desktop-page-padding {
                padding-top: 3rem !important;
            }
        }

        /* ── Seamless Unified Card Hover & Micro-Animations ── */
        .card-hover-effect,
        .admin-card-hover,
        .dest-card,
        .booking-card,
        .tourist-card {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                box-shadow 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                border-color 0.3s ease !important;
            will-change: transform, box-shadow;
        }

        .card-hover-effect:not(.pointer-events-none):hover,
        .admin-card-hover:hover,
        .dest-card:hover,
        .booking-card:hover,
        .tourist-card:hover {
            transform: translateY(-5px) scale(1.006) !important;
            box-shadow: 0 16px 32px -6px rgba(16, 185, 129, 0.16),
                0 6px 16px -4px rgba(0, 0, 0, 0.05) !important;
            border-color: #a7f3d0 !important;
        }

        .card-hover-effect img,
        .dest-card img,
        .booking-card img,
        .tourist-card img {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .card-hover-effect:not(.pointer-events-none):hover img,
        .dest-card:hover img,
        .booking-card:hover img,
        .tourist-card:hover img {
            transform: scale(1.05) !important;
        }

        @keyframes bell-ring {

            0%,
            100% {
                transform: rotate(0);
            }

            20%,
            60% {
                transform: rotate(-15deg);
            }

            40%,
            80% {
                transform: rotate(15deg);
            }
        }

        .bell-ring-hover:hover svg {
            animation: bell-ring 0.6s ease-in-out infinite;
            transform-origin: top center;
        }

        /* ── Seamless Visitor Check-in Pin & Popup (Shared UI) ── */
        @keyframes checkin-pulse-wave {
            0% {
                transform: translate(-50%, -50%) scale(0.85);
                opacity: 0.85;
            }

            70%,
            100% {
                transform: translate(-50%, -50%) scale(2.3);
                opacity: 0;
            }
        }

        @keyframes checkin-icon-pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        .visitor-pin-wrapper {
            position: relative;
            width: 38px;
            height: 38px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .visitor-pin-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 38px;
            height: 38px;
            background: radial-gradient(circle, rgba(34, 197, 94, 0.4) 0%, rgba(21, 128, 61, 0) 70%);
            border: 2px solid rgba(34, 197, 94, 0.65);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            animation: checkin-pulse-wave 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
            pointer-events: none;
        }

        .visitor-pin-body {
            position: relative;
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #15803d 0%, #16a34a 100%);
            border: 3px solid #ffffff;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            box-shadow: 0 4px 14px rgba(21, 128, 61, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .visitor-pin-wrapper:hover .visitor-pin-body {
            transform: rotate(-45deg) scale(1.18) translate(2px, -2px);
            background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
            box-shadow: 0 8px 22px rgba(21, 128, 61, 0.65);
        }

        .visitor-pin-icon {
            transform: rotate(45deg);
            color: #ffffff;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .visitor-pin-wrapper:hover .visitor-pin-icon {
            transform: rotate(45deg) scale(1.2);
        }

        /* Seamless Popup Card Styling */
        .checkin-popup-card {
            font-family: 'Plus Jakarta Sans', sans-serif;
            padding: 2px;
            min-width: 210px;
        }

        .checkin-popup-header {
            display: flex;
            align-items: center;
            gap: 8.5px;
            margin-bottom: 6px;
        }

        .checkin-popup-icon-badge {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            box-shadow: 0 2px 6px rgba(22, 101, 52, 0.12);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            flex-shrink: 0;
        }

        .checkin-popup-card:hover .checkin-popup-icon-badge {
            transform: scale(1.15) rotate(6deg);
            background: linear-gradient(135deg, #166534 0%, #15803d 100%);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(22, 101, 52, 0.35);
        }

        .checkin-popup-icon-badge i {
            animation: checkin-icon-pulse 2.2s infinite ease-in-out;
        }

        .checkin-popup-title {
            font-weight: 800;
            color: #166534;
            font-size: 13.5px;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .checkin-popup-spotname {
            font-weight: 700;
            color: #1f2937;
            font-size: 14.5px;
            margin-bottom: 4px;
        }

        .checkin-popup-desc {
            font-size: 11.5px;
            color: #4b5563;
            line-height: 1.45;
            margin: 0;
        }
    </style>

</head>

<body class="bg-gray-100 font-sans antialiased text-gray-900">

    <?php
$unreadCount = auth()->check() ? \App\Models\Notification::where('recipient_id', auth()->id())->where('is_read', false)->count() : 0;

$dashboardActive = request()->routeIs('dashboard');
$usersActive = request()->routeIs('verification.admin');
$reportsActive = request()->routeIs('reports.*');
$bookingsActive = request()->routeIs('staff.bookings.*') || request()->routeIs('bookings.index');
$checkinActive = request()->routeIs('checkins.*');
$spotsActive = request()->routeIs('spots.*');
$walkinActive = request()->routeIs('staff.walkins.*');
$ticketsActive = request()->routeIs('bookings.my-tickets');
$destinationsActive = request()->routeIs('destinations.*');
    ?>

    <!-- Global Emergency Broadcast Banner -->
    <div id="global-emergency-banner" class="hidden py-3 px-4 shadow-lg sticky top-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2.5 min-w-0">
                <span class="flex p-1.5 rounded-lg bg-black/10">
                    <svg class="h-5 w-5 text-current animate-bounce" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </span>
                <p class="font-semibold truncate text-sm" id="global-emergency-message">
                    <!-- Alert message goes here -->
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="dismissGlobalEmergencyAlert()"
                    class="flex p-1.5 rounded-md hover:bg-black/10 focus:outline-none transition">
                    <svg class="h-4 w-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Top Navigation Header -->
    <div class="md:hidden flex items-center justify-between bg-white p-4 shadow-sm z-30 relative">
        <div class="flex items-center gap-2">
            <x-application-logo class="h-10 w-auto object-contain" />
        </div>
        <div class="flex items-center gap-3">
            {{-- Mobile Notification Link --}}
            <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span id="mobile-notification-badge"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold {{ $unreadCount > 0 ? '' : 'hidden' }}">
                    {{ $unreadCount }}
                </span>
            </a>

            <button id="mobile-menu-btn" class="p-2 focus:outline-none focus:bg-gray-100 rounded-md text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-gradient-to-b from-green-800 to-green-600 w-64 shadow-xl flex-shrink-0 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40 flex flex-col justify-between">

            <div class="flex flex-col flex-1 overflow-y-auto">
                <div class="h-16 flex items-center justify-center border-b border-green-700/50 shrink-0">
                    <div class="flex items-center gap-2">
                        <x-application-logo class="h-12 w-auto object-contain brightness-0 invert" />
                    </div>
                </div>

                <nav class="flex-1 p-4 space-y-1.5 mt-2">

                    {{-- Common Dashboard link --}}
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $dashboardActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    {{-- Admin Controls --}}
                    @if(Auth::check() && Auth::user()->isAdmin())
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">Admin
                            Controls</p>
                        {{-- Accordion Accounts & Verification --}}
                        <div x-data="{ open: {{ request()->routeIs('verification.*') ? 'true' : 'false' }} }"
                            @mouseenter="open = true"
                            @mouseleave="open = {{ request()->routeIs('verification.*') ? 'true' : 'false' }}"
                            class="space-y-1">
                            <div
                                class="flex items-center justify-between rounded-lg {{ request()->routeIs('verification.*') ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }} transition-colors pl-4 pr-1 py-0.5">
                                <a href="{{ route('verification.reviews') }}"
                                    class="flex-1 flex items-center py-2 font-medium">
                                    <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    Verification
                                </a>
                                <button @click="open = !open"
                                    class="p-2 text-green-200 hover:text-white rounded-md focus:outline-none transition-colors"
                                    aria-label="Toggle Verification Options">
                                    <svg class="w-4 h-4 transform transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" x-collapse class="mt-1 space-y-1" style="display: none;">
                                <a href="{{ route('verification.reviews') }}"
                                    class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.reviews') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    ID Verification Reviews
                                </a>
                                <a href="{{ route('verification.accounts') }}"
                                    class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.accounts') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    Verify Tourists
                                </a>
                                <a href="{{ route('verification.staff') }}"
                                    class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.staff') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Manage Staff
                                </a>
                                <a href="{{ route('verification.add_account') }}"
                                    class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.add_account') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                    Add Account
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('reports.index') }}"
                            class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $reportsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            Reports
                        </a>
                    @endif

                    {{-- Staff Controls --}}
                    @if(Auth::check() && Auth::user()->isStaff())
                                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">Spot
                                            Management</p>
                                        <a href="{{ route('staff.bookings.index') }}"
                                            class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $bookingsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            Bookings
                                        </a>
                                        <a href="{{ route('checkins.create') }}"
                                            class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $checkinActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                                </path>
                                            </svg>
                                            Check-In
                                        </a>

                                        {{-- Accordion Spot Status --}}
                                        <div x-data="{ open: {{ request()->routeIs('spots.*') ? 'true' : 'false' }} }"
                                            @mouseenter="open = true"
                                            @mouseleave="open = {{ request()->routeIs('spots.*') ? 'true' : 'false' }}" class="space-y-1">
                                            <div
                                                class="flex items-center justify-between rounded-lg {{ request()->routeIs('spots.*') ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }} transition-colors pl-4 pr-1 py-0.5">
                                                <a href="{{ route('spots.index') }}" class="flex-1 flex items-center py-2 font-medium">
                                                    <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                    Status
                                                </a>
                                                <button @click="open = !open"
                                                    class="p-2 text-green-200 hover:text-white rounded-md focus:outline-none transition-colors"
                                                    aria-label="Toggle Spot Options">
                                                    <svg class="w-4 h-4 transform transition-transform duration-200"
                                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 9l-7 7-7-7"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div x-show="open" x-collapse class="mt-1 space-y-1" style="display: none;">
                                                <a href="{{ route('spots.index') }}"
                                                    class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('spots.index') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                                        stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                    Spot Status
                                                </a>
                                                <?php
                        $activeDestination = request()->route('destination');
                        $activeDestinationId = null;
                        if ($activeDestination) {
                            $activeDestinationId = is_object($activeDestination) ? $activeDestination->id : $activeDestination;
                        } else {
                            $activeDestinationId = Auth::check() ? Auth::user()->assigned_destination_id : null;
                        }
                                                                                                                                    ?>
                                                @if($activeDestinationId)
                                                    <a href="{{ route('spots.edit', $activeDestinationId) }}"
                                                        class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('spots.edit') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                                        <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor"
                                                            stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                            </path>
                                                        </svg>
                                                        Edit Details
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <a href="{{ route('staff.walkins.create') }}"
                                            class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $walkinActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                                </path>
                                            </svg>
                                            Walk-In
                                        </a>
                    @endif

                    {{-- Tourist Controls --}}
                    @if(Auth::check() && Auth::user()->isTourist())
                        @php $isVerified = Auth::user()->id_verification_status === 'verified'; @endphp
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">My Travel
                        </p>
                        @if($isVerified)
                            <a href="{{ route('destinations.index') }}"
                                class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $destinationsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Explore Spots
                            </a>
                            <a href="{{ route('bookings.index') }}"
                                class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $bookingsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                My Bookings
                            </a>
                            <a href="{{ route('bookings.my-tickets') }}"
                                class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $ticketsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                                My Tickets
                            </a>
                        @else
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-4 py-2.5 rounded-lg font-medium text-green-200/50 opacity-50 cursor-not-allowed pointer-events-none select-none">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 opacity-50" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    Explore Spots
                                </span>
                                <svg class="w-4 h-4 text-amber-400 opacity-80" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-4 py-2.5 rounded-lg font-medium text-green-200/50 opacity-50 cursor-not-allowed pointer-events-none select-none">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 opacity-50" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    My Bookings
                                </span>
                                <svg class="w-4 h-4 text-amber-400 opacity-80" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-4 py-2.5 rounded-lg font-medium text-green-200/50 opacity-50 cursor-not-allowed pointer-events-none select-none">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 opacity-50" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                    My Tickets
                                </span>
                                <svg class="w-4 h-4 text-amber-400 opacity-80" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        @endif
                    @endif
                </nav>
            </div>

            {{-- Sidebar Footer (User details + Logout) --}}
            <div class="p-3 border-t border-white/10 bg-black/10 backdrop-blur-md shrink-0 relative overflow-hidden">
                <!-- Decorative glow -->
                <div
                    class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-400/20 blur-2xl rounded-full pointer-events-none">
                </div>

                @if(Auth::check())
                    <div
                        class="flex items-center gap-3 p-2 rounded-2xl border border-transparent hover:bg-white/5 hover:border-white/10 transition-all duration-300 group/profile">
                        <!-- Avatar -->
                        <div
                            class="w-10 h-10 rounded-full border-2 border-emerald-300/80 text-emerald-100 flex items-center justify-center font-black text-lg shrink-0 relative transform group-hover/profile:scale-105 group-hover/profile:border-emerald-300 group-hover/profile:text-white group-hover/profile:shadow-[0_0_15px_rgba(52,211,153,0.6)] transition-all duration-300 shadow-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <!-- Info -->
                        <div class="min-w-0 flex-1 flex flex-col justify-center">
                            <p
                                class="text-sm font-extrabold text-white truncate leading-tight tracking-wide drop-shadow-sm">
                                {{ Auth::user()->name }}
                            </p>
                            <div class="mt-1 flex items-center">
                                <span
                                    class="inline-flex items-center gap-1.5 bg-black/20 border border-white/10 text-[9px] text-emerald-100 px-2 py-0.5 rounded-lg font-bold uppercase tracking-widest backdrop-blur-sm shadow-sm">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_5px_#34d399] animate-pulse"></span>
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <button x-data @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })"
                            class="group/logout p-1.5 border-2 border-red-500 text-white bg-red-500 hover:bg-red-400 hover:border-red-400 rounded-xl transition-all duration-300 focus:outline-none hover:shadow-[0_0_20px_rgba(239,68,68,0.6)]"
                            title="Log Out">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transform group-hover/logout:translate-x-0.5 transition-transform duration-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </aside>

        <!-- Sidebar overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity md:hidden">
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <header
                class="bg-transparent h-16 flex items-center justify-end px-6 md:px-10 shrink-0 absolute top-0 right-0 left-0 z-30 pointer-events-none">

                <div class="hidden md:flex items-center gap-3 shrink-0 pointer-events-auto">
                    {{-- Unified Control Widget (The Pill) --}}
                    <div
                        class="bg-white shadow-[0_4px_20px_-4px_rgba(16,185,129,0.15)] rounded-full flex items-center p-1.5 gap-2 border border-gray-100">
                        {{-- Notifications Bell Link --}}
                        <div class="relative group bell-ring-hover">
                            <a href="{{ route('notifications.index') }}"
                                class="relative flex items-center justify-center text-gray-500 hover:text-amber-600 hover:bg-amber-100 p-2 rounded-full transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span id="desktop-notification-badge"
                                    class="absolute top-1.5 right-1.5 bg-red-500 text-white text-[9px] rounded-full h-3.5 w-3.5 flex items-center justify-center font-bold {{ $unreadCount > 0 ? '' : 'hidden' }}">
                                    {{ $unreadCount }}
                                </span>
                            </a>
                            {{-- Tooltip --}}
                            <div
                                class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                                Notifications
                            </div>
                        </div>

                        <div class="h-6 w-[1px] bg-gray-200"></div>

                        {{-- Settings Gear Dropdown --}}
                        <div class="relative group">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition-all focus:outline-none duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 transition-transform duration-300 ease-in-out group-hover:rotate-90"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')"
                                        class="flex items-center gap-2 text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link href="#"
                                        @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })"
                                        class="flex items-center gap-2 text-gray-700 hover:text-red-750 hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                            {{-- Tooltip --}}
                            <div
                                class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                                Settings
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50 px-6 pt-4 pb-6 md:px-10 md:pt-4 md:pb-10">
                <div class="pt-0 desktop-page-padding">
                    {{ $slot }}
                </div>
            </main>
        </div>

    </div>

    {{-- Global Studio-Grade Toast Notification System --}}
    <x-toast-notification />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            const toggleSidebar = () => {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            };

            if (btn && sidebar && overlay) {
                btn.addEventListener('click', toggleSidebar);
                overlay.addEventListener('click', toggleSidebar);
            }
        });
    </script>

    {{-- Logout Confirmation Modal --}}
    <x-confirm-modal id="logout-modal" title="Log Out" message="Are you sure you want to end your session?">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Confirm
            </button>
        </form>
    </x-confirm-modal>

    @auth
        <script>
            // Prevent multiple browser back clicks while resolving Chromium non-interactive skippable history warning
            (function () {
                try {
                    let historyLocked = false;
                    const lockHistory = function () {
                        if (!historyLocked) {
                            historyLocked = true;
                            history.pushState(null, null, location.href);
                        }
                    };
                    window.addEventListener('click', lockHistory, { once: true });
                    window.addEventListener('keydown', lockHistory, { once: true });
                    window.addEventListener('touchstart', lockHistory, { once: true });

                    window.onpopstate = function () {
                        if (historyLocked) {
                            history.go(1);
                        }
                    };
                } catch (_) {}
            })();
        </script>
        <script>
            (function () {
                let currentAlertId = null;
                let eventSource = null;
                let reconnectTimeout = null;
                const reconnectDelay = 5000;

                // Render Emergency / Severe Weather Toast Notification with bulletproof inline styles
                window.renderEmergencyToast = function (alertId, alertMessage) {
                    const container = document.getElementById('toast-notification-container');
                    if (!container) return;

                    const toastId = 'toast-alert-' + (alertId || 'test');
                    if (document.getElementById(toastId)) return; // Prevent duplicate toast cards

                    const msgText = alertMessage || '';
                    const isCritical = msgText.includes('[CRITICAL]') || msgText.toLowerCase().includes('severe weather') || msgText.toLowerCase().includes('rainfall');
                    const isWarning = msgText.includes('[WARNING]');

                    const toast = document.createElement('div');
                    toast.id = toastId;
                    toast.dataset.alertId = alertId || '';
                    toast.setAttribute('role', 'alert');
                    
                    if (isCritical) {
                        toast.className = 'toast-card pointer-events-auto relative overflow-hidden transition-all duration-300 transform translate-y-4 opacity-0';
                        toast.style.cssText = 'background: linear-gradient(135deg, #450a0a 0%, #7f1d1d 45%, #991b1b 100%); border: 2px solid #ef4444; border-radius: 1rem; box-shadow: 0 20px 45px -10px rgba(185, 28, 28, 0.7), 0 0 25px rgba(239, 68, 68, 0.35); color: #ffffff; width: 100%; box-sizing: border-box; backdrop-filter: blur(16px);';
                        toast.innerHTML = `
                            <!-- Ambient Red Glow Overlay -->
                            <div style="position: absolute; top: -30px; right: -30px; width: 130px; height: 130px; background: rgba(239, 68, 68, 0.25); filter: blur(30px); border-radius: 9999px; pointer-events: none;"></div>
                            <div style="position: absolute; top: 0; left: 0; width: 6px; height: 100%; background: linear-gradient(to bottom, #fca5a5, #ef4444, #f59e0b);"></div>

                            <div style="display: flex; align-items: flex-start; gap: 12px; position: relative; z-index: 10; padding: 16px 18px;">
                                <!-- Animated Weather Alert Badge -->
                                <div style="position: relative; display: flex; width: 42px; height: 42px; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 12px; background: rgba(0, 0, 0, 0.4); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.5);">
                                    <span style="position: absolute; top: -3px; right: -3px; display: flex; width: 10px; height: 10px;">
                                      <span class="animate-ping" style="position: absolute; display: inline-flex; width: 100%; height: 100%; border-radius: 9999px; background-color: #ef4444; opacity: 0.75;"></span>
                                      <span style="position: relative; display: inline-flex; border-radius: 9999px; width: 10px; height: 10px; background-color: #f87171;"></span>
                                    </span>
                                    <svg style="width: 22px; height: 22px; color: #fca5a5;" class="animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>

                                <div style="flex: 1; min-width: 0; padding-right: 4px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px; flex-wrap: wrap;">
                                        <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; background: #dc2626; color: #ffffff; border: 1px solid rgba(254, 202, 202, 0.4);">
                                            CRITICAL WARNING
                                        </span>
                                        <span style="font-size: 10px; font-weight: 700; color: #fca5a5; text-transform: uppercase; letter-spacing: 0.04em;">Manual Exit Required</span>
                                    </div>
                                    <h4 style="font-size: 14px; font-weight: 800; color: #ffffff; margin: 0; line-height: 1.3; letter-spacing: -0.01em;">
                                        Severe Weather Advisory
                                    </h4>
                                    <p style="font-size: 12px; color: #f8fafc; margin-top: 4px; margin-bottom: 0; line-height: 1.5; font-weight: 500; word-break: break-word; white-space: normal;">
                                        ${msgText.replace(/^\[(CRITICAL|WARNING|INFO)\]\s*/i, '')}
                                    </p>
                                </div>

                                <!-- Manual Close / Exit Button -->
                                <button type="button" onclick="dismissGlobalEmergencyAlert('${alertId || ''}', this)"
                                    style="flex-shrink: 0; padding: 6px; margin: -2px -2px 0 0; border-radius: 10px; color: #cbd5e1; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='rgba(220,38,38,0.85)'; this.style.color='#ffffff';"
                                    onmouseout="this.style.background='rgba(0,0,0,0.3)'; this.style.color='#cbd5e1';"
                                    title="Dismiss severe weather notification" aria-label="Dismiss warning notification">
                                    <svg style="width: 18px; height: 18px; display: block;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        `;
                    } else if (isWarning) {
                        toast.className = 'toast-card pointer-events-auto relative overflow-hidden transition-all duration-300 transform translate-y-4 opacity-0';
                        toast.style.cssText = 'background: linear-gradient(135deg, #451a03 0%, #78350f 50%, #92400e 100%); border: 2px solid #f59e0b; border-radius: 1rem; box-shadow: 0 20px 40px -10px rgba(245, 158, 11, 0.5); color: #ffffff; width: 100%; box-sizing: border-box; backdrop-filter: blur(16px);';
                        toast.innerHTML = `
                            <div style="display: flex; align-items: flex-start; gap: 12px; position: relative; z-index: 10; padding: 16px 18px;">
                                <div style="display: flex; width: 40px; height: 40px; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 12px; background: rgba(0, 0, 0, 0.4); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.5);">
                                    <svg style="width: 20px; height: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div style="flex: 1; min-width: 0; padding-right: 4px;">
                                    <span style="display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; background: #f59e0b; color: #000000; margin-bottom: 4px;">
                                        WARNING ADVISORY
                                    </span>
                                    <p style="font-size: 12px; color: #f8fafc; margin: 4px 0 0 0; line-height: 1.5; font-weight: 500; word-break: break-word;">
                                        ${msgText.replace(/^\[(CRITICAL|WARNING|INFO)\]\s*/i, '')}
                                    </p>
                                </div>
                                <button type="button" onclick="dismissGlobalEmergencyAlert('${alertId || ''}', this)"
                                    style="flex-shrink: 0; padding: 6px; margin: -2px -2px 0 0; border-radius: 10px; color: #cbd5e1; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.2); cursor: pointer; transition: all 0.2s;"
                                    onmouseover="this.style.background='rgba(245,158,11,0.85)'; this.style.color='#000000';"
                                    onmouseout="this.style.background='rgba(0,0,0,0.3)'; this.style.color='#cbd5e1';"
                                    aria-label="Dismiss warning notification">
                                    <svg style="width: 18px; height: 18px; display: block;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        `;
                    } else {
                        toast.className = 'toast-card pointer-events-auto relative overflow-hidden transition-all duration-300 transform translate-y-4 opacity-0';
                        toast.style.cssText = 'background: #0f172a; border: 1px solid #334155; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); color: #ffffff; width: 100%; box-sizing: border-box; padding: 14px 16px;';
                        toast.innerHTML = `
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div style="display: flex; width: 36px; height: 36px; flex-shrink: 0; align-items: center; justify-content: center; border-radius: 10px; background: rgba(37,99,235,0.3); color: #60a5fa; border: 1px solid rgba(59,130,246,0.4);">
                                    <svg style="width: 18px; height: 18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <p style="font-size: 12px; color: #e2e8f0; flex: 1; margin: 0; line-height: 1.4; word-break: break-word;">${msgText.replace(/^\[(CRITICAL|WARNING|INFO)\]\s*/i, '')}</p>
                                <button type="button" onclick="dismissGlobalEmergencyAlert('${alertId || ''}', this)" style="flex-shrink: 0; padding: 4px; color: #94a3b8; background: transparent; border: none; cursor: pointer;">
                                    <svg style="width: 16px; height: 16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        `;
                    }

                    container.appendChild(toast);

                    // Trigger smooth entrance animation
                    requestAnimationFrame(() => {
                        toast.style.opacity = '1';
                        toast.style.transform = 'translateY(0)';
                    });

                    // CRITICAL severe weather notifications & WARNINGs DO NOT auto-dismiss.
                    // Only standard info toasts auto-dismiss after 6 seconds.
                    if (!isCritical && !isWarning) {
                        setTimeout(() => {
                            window.dismissGlobalEmergencyAlert(alertId, toast);
                        }, 6000);
                    }
                };

                function initSSE() {
                    teardownSSE();

                    // Resolve full route URL to ensure complete compatibility across local ports, subdirectories & XAMPP paths
                    const streamUrl = "{{ route('notifications.realtime') }}";
                    eventSource = new EventSource(streamUrl);

                    eventSource.onmessage = function (event) {
                        if (!event.data || event.data.trim() === "") return;

                        try {
                            const data = JSON.parse(event.data);

                            // Render Toast Notification for active emergency alerts
                            if (data.has_alert && data.alert_message) {
                                currentAlertId = data.alert_id;
                                window.renderEmergencyToast(data.alert_id, data.alert_message);

                                // Hide sticky top banner so emergency alert ONLY appears as a Toast Notification (no duplicate top banner)
                                const banner = document.getElementById('global-emergency-banner');
                                if (banner) banner.classList.add('hidden');
                            } else {
                                const banner = document.getElementById('global-emergency-banner');
                                if (banner) banner.classList.add('hidden');
                                currentAlertId = null;
                            }

                            // Update notification badge counts
                            const badges = [
                                document.getElementById('mobile-notification-badge'),
                                document.getElementById('desktop-notification-badge')
                            ];

                            badges.forEach(badge => {
                                if (!badge) return;
                                const unreadNum = parseInt(data.unread_count, 10) || 0;
                                if (unreadNum > 0) {
                                    badge.textContent = unreadNum > 99 ? '99+' : unreadNum;
                                    badge.classList.remove('hidden');
                                } else {
                                    badge.classList.add('hidden');
                                }
                            });

                            // Dispatch global custom event for other dashboard/table pages
                            window.dispatchEvent(new CustomEvent('notificationsUpdated', {
                                detail: {
                                    unreadCount: data.unread_count,
                                    recent: data.recent
                                }
                            }));

                        } catch (e) {
                            console.error('Error parsing SSE data:', e);
                        }
                    };

                    eventSource.onerror = function (err) {
                        teardownSSE();
                        reconnectTimeout = setTimeout(initSSE, reconnectDelay);
                    };
                }

                function teardownSSE() {
                    if (eventSource) {
                        eventSource.close();
                        eventSource = null;
                    }
                    if (reconnectTimeout) {
                        clearTimeout(reconnectTimeout);
                        reconnectTimeout = null;
                    }
                }

                // Dismiss emergency toast & persist to backend database
                window.dismissGlobalEmergencyAlert = function (alertId, elementOrBtn) {
                    let toastEl = null;
                    if (elementOrBtn) {
                        toastEl = elementOrBtn.classList && elementOrBtn.classList.contains('toast-card')
                            ? elementOrBtn
                            : elementOrBtn.closest('.toast-card');
                    }
                    if (!toastEl && alertId) {
                        toastEl = document.getElementById('toast-alert-' + alertId);
                    }

                    if (toastEl) {
                        toastEl.style.transform = 'translateX(100%)';
                        toastEl.style.opacity = '0';
                        setTimeout(() => {
                            if (toastEl && toastEl.parentNode) {
                                toastEl.parentNode.removeChild(toastEl);
                            }
                        }, 300);
                    }

                    const banner = document.getElementById('global-emergency-banner');
                    if (banner) banner.classList.add('hidden');

                    const targetId = alertId || currentAlertId;
                    if (targetId && String(targetId).indexOf('test') === -1) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
                        fetch(`/notifications/${targetId}/dismiss`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                            .then(r => r.json())
                            .then(data => {
                                if (data && data.success) {
                                    if (targetId === currentAlertId) {
                                        currentAlertId = null;
                                    }
                                }
                            })
                            .catch(err => console.error('Error dismissing alert:', err));
                    }
                };

                // Start Real-Time SSE listener
                document.addEventListener('DOMContentLoaded', initSSE);
                window.addEventListener("beforeunload", teardownSSE);
            })();
        </script>
    @endauth

    @stack('scripts')
</body>

</html>