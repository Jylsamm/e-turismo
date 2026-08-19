<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Turismo') }}</title>

    <!-- Typography: Space Grotesk & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    @php
        $faviconPath = public_path('Pictures/LOGO/LOGO-eturismo.png');
        $faviconVersion = file_exists($faviconPath) ? filemtime($faviconPath) : '1';
        $faviconUrl = asset('Pictures/LOGO/LOGO-eturismo.png') . '?v=' . $faviconVersion;
    @endphp
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

<<<<<<< Updated upstream
    <!-- Scripts -->
=======
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

    <!-- Scripts & Bundled Local Icons -->
>>>>>>> Stashed changes
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')

    @push('head')
    <style>
<<<<<<< Updated upstream
=======
        [x-cloak] {
            display: none !important;
        }

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

>>>>>>> Stashed changes
        @keyframes bell-ring {
            0%, 100% { transform: rotate(0); }
            20%, 60% { transform: rotate(-15deg); }
            40%, 80% { transform: rotate(15deg); }
        }
        .bell-ring-hover:hover svg {
            animation: bell-ring 0.6s ease-in-out infinite;
            transform-origin: top center;
        }
<<<<<<< Updated upstream
=======

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
            font-family: 'Poppins', sans-serif;
            padding: 4px;
            min-width: 230px;
        }

        .checkin-popup-header {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 7px;
        }

        .checkin-popup-icon-badge {
            width: 32px;
            height: 32px;
            border-radius: 9px;
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
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
            font-size: 14.5px;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .checkin-popup-spotname {
            font-weight: 700;
            color: #1f2937;
            font-size: 15.5px;
            margin-bottom: 5px;
        }

        .checkin-popup-desc {
            font-size: 13px;
            color: #4b5563;
            line-height: 1.5;
            margin: 0;
        }
>>>>>>> Stashed changes
    </style>
    @endpush
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
                    <svg class="h-5 w-5 text-current animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                </span>
                <p class="font-semibold truncate text-sm" id="global-emergency-message">
                    <!-- Alert message goes here -->
                </p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="dismissGlobalEmergencyAlert()" class="flex p-1.5 rounded-md hover:bg-black/10 focus:outline-none transition">
                    <svg class="h-4 w-4 text-current" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">
                    {{ $unreadCount }}
                </span>
                @endif
            </a>

            <button id="mobile-menu-btn" class="p-2 focus:outline-none focus:bg-gray-100 rounded-md text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">
<<<<<<< Updated upstream
        
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-gradient-to-b from-green-800 to-green-600 w-64 shadow-xl flex-shrink-0 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40 flex flex-col justify-between">
            
            <div class="flex flex-col flex-1 overflow-y-auto">
                <div class="h-16 flex items-center justify-center border-b border-green-700/50 shrink-0">
=======
        <!-- Sidebar -->
        <aside id="sidebar"
            class="bg-gradient-to-b from-emerald-900 via-emerald-800 to-emerald-900 w-64 shadow-2xl flex-shrink-0 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out z-40 flex flex-col justify-between border-r border-emerald-700/40">

            <div class="flex flex-col flex-1 overflow-y-auto no-scrollbar">
                <!-- Brand Logo Header -->
                <div class="h-20 flex items-center justify-center border-b border-emerald-700/50 shrink-0 px-4">
>>>>>>> Stashed changes
                    <div class="flex items-center gap-2">
                        <x-application-logo class="h-12 w-auto object-contain brightness-0 invert drop-shadow" />
                    </div>
                </div>

<<<<<<< Updated upstream
                <nav class="flex-1 p-4 space-y-1.5 mt-2">
                    
                    {{-- Common Dashboard link --}}
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $dashboardActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
=======
                <nav class="flex-1 p-3.5 space-y-1.5 mt-1">

                    {{-- Common Dashboard link --}}
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-sm sm:text-base transition-all duration-200 {{ $dashboardActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        <span>Dashboard</span>
>>>>>>> Stashed changes
                    </a>

                    {{-- Admin Controls --}}
                    @if(Auth::check() && Auth::user()->isAdmin())
<<<<<<< Updated upstream
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">Admin Controls</p>
                        {{-- Accordion Accounts & Verification --}}
                        <div x-data="{ open: {{ request()->routeIs('verification.*') ? 'true' : 'false' }} }" 
                             @mouseenter="open = true" 
                             @mouseleave="open = {{ request()->routeIs('verification.*') ? 'true' : 'false' }}" 
                             class="space-y-1">
                            <div class="flex items-center justify-between rounded-lg {{ request()->routeIs('verification.*') ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }} transition-colors pl-4 pr-1 py-0.5">
                                <a href="{{ route('verification.reviews') }}" class="flex-1 flex items-center py-2 font-medium">
                                    <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                    Verification
                                </a>
                                <button @click="open = !open" class="p-2 text-green-200 hover:text-white rounded-md focus:outline-none transition-colors" aria-label="Toggle Verification Options">
                                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>

                            <div x-show="open" x-collapse class="mt-1 space-y-1" style="display: none;">
                                <a href="{{ route('verification.reviews') }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.reviews') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    ID Verification Reviews
                                </a>
                                <a href="{{ route('verification.accounts') }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.accounts') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Verify Tourists
                                </a>
                                <a href="{{ route('verification.staff') }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.staff') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    Manage Staff
                                </a>
                                <a href="{{ route('verification.add_account') }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('verification.add_account') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    Add Account
                                </a>
                            </div>
                        </div>
                        <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $reportsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Reports
=======
                        <div class="pt-4 pb-1">
                            <p class="px-3 text-2xs font-bold text-emerald-300/90 uppercase tracking-wider">Admin Controls</p>
                        </div>

                        {{-- Accordion Accounts & Verification --}}
                        <div x-data="{ open: {{ request()->routeIs('verification.*') ? 'true' : 'false' }} }"
                            class="space-y-1">
                            <div
                                class="flex items-center justify-between rounded-xl {{ request()->routeIs('verification.*') ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }} transition-colors pl-3.5 pr-1 py-0.5">
                                <a href="{{ route('verification.reviews') }}"
                                    class="flex-1 flex items-center py-2 font-bold text-sm sm:text-base">
                                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                    <span>Verification</span>
                                </a>
                                <button type="button" @click="open = !open"
                                    class="p-2 text-emerald-200 hover:text-white rounded-lg focus:outline-none transition-colors"
                                    aria-label="Toggle Verification Options">
                                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" x-cloak class="my-1 border-l-2 border-emerald-400/30 ml-4 pl-2 space-y-0.5" @if(!request()->routeIs('verification.*')) style="display: none;" @endif>
                                <a href="{{ route('verification.reviews') }}"
                                    class="flex items-center px-2.5 py-1.5 rounded-lg text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('verification.reviews') || request()->routeIs('verification.accounts') ? 'bg-white/15 text-white font-bold shadow-2xs' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <span class="truncate">Verify Tourists</span>
                                </a>
                                <a href="{{ route('verification.staff') }}"
                                    class="flex items-center px-2.5 py-1.5 rounded-lg text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('verification.staff') ? 'bg-white/15 text-white font-bold shadow-2xs' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">Manage Staff</span>
                                </a>
                                <a href="{{ route('verification.add_account') }}"
                                    class="flex items-center px-2.5 py-1.5 rounded-lg text-xs sm:text-sm font-semibold transition-colors {{ request()->routeIs('verification.add_account') ? 'bg-white/15 text-white font-bold shadow-2xs' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                    </svg>
                                    <span class="truncate">Add Account</span>
                                </a>
                            </div>
                        </div>

                        <a href="{{ route('reports.index') }}"
                            class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-sm sm:text-base transition-all duration-200 {{ $reportsActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 17v-2m3 2v-4m3 2v-6m-9 9h12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>Reports</span>
>>>>>>> Stashed changes
                        </a>
                    @endif

                    {{-- Staff Controls --}}
                    @if(Auth::check() && Auth::user()->isStaff())
<<<<<<< Updated upstream
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">Spot Management</p>
                        <a href="{{ route('staff.bookings.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $bookingsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Bookings
                        </a>
                        <a href="{{ route('checkins.create') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $checkinActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            Check-In
                        </a>

                        {{-- Accordion Spot Status --}}
                        <div x-data="{ open: {{ request()->routeIs('spots.*') ? 'true' : 'false' }} }" 
                             @mouseenter="open = true" 
                             @mouseleave="open = {{ request()->routeIs('spots.*') ? 'true' : 'false' }}" 
                             class="space-y-1">
                            <div class="flex items-center justify-between rounded-lg {{ request()->routeIs('spots.*') ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }} transition-colors pl-4 pr-1 py-0.5">
                                <a href="{{ route('spots.index') }}" class="flex-1 flex items-center py-2 font-medium">
                                    <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    Status
                                </a>
                                <button @click="open = !open" class="p-2 text-green-200 hover:text-white rounded-md focus:outline-none transition-colors" aria-label="Toggle Spot Options">
                                    <svg class="w-4 h-4 transform transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>

                            <div x-show="open" x-collapse class="mt-1 space-y-1" style="display: none;">
                                <a href="{{ route('spots.index') }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('spots.index') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                    Spot Status
=======
                        <div class="pt-4 pb-1">
                            <p class="px-3 text-[10px] font-black text-emerald-300/80 uppercase tracking-widest">Spot Management</p>
                        </div>
                        <a href="{{ route('staff.bookings.index') }}"
                            class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ $bookingsActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span>Bookings</span>
                        </a>
                        <a href="{{ route('checkins.create') }}"
                            class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ $checkinActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                </path>
                            </svg>
                            <span>Check-In</span>
                        </a>

                        {{-- Accordion Spot Status --}}
                        <div x-data="{ open: {{ request()->routeIs('spots.*') ? 'true' : 'false' }} }"
                            class="space-y-1">
                            <div
                                class="flex items-center justify-between rounded-xl {{ request()->routeIs('spots.*') ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }} transition-colors pl-3.5 pr-1 py-0.5">
                                <a href="{{ route('spots.index') }}" class="flex-1 flex items-center py-2 font-bold text-xs sm:text-sm">
                                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    <span>Status</span>
                                </a>
                                <button type="button" @click="open = !open"
                                    class="p-2 text-emerald-200 hover:text-white rounded-lg focus:outline-none transition-colors"
                                    aria-label="Toggle Spot Options">
                                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>

                            <div x-show="open" x-cloak class="my-1 border-l-2 border-emerald-400/30 ml-4 pl-2 space-y-0.5" @if(!request()->routeIs('spots.*')) style="display: none;" @endif>
                                <a href="{{ route('spots.index') }}"
                                    class="flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request()->routeIs('spots.index') ? 'bg-white/15 text-white font-bold shadow-2xs' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                                    <svg class="w-3.5 h-3.5 mr-2 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span class="truncate">Spot Status</span>
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
                                    <a href="{{ route('spots.edit', $activeDestinationId) }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('spots.edit') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                        <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        Edit Details
                                    </a>
                                    <a href="{{ route('spots.gallery', $activeDestinationId) }}" class="flex items-center pl-12 pr-4 py-2 rounded-lg text-sm transition-colors {{ request()->routeIs('spots.gallery') ? 'bg-white/10 text-white font-medium shadow-sm' : 'text-green-100 hover:bg-white/5 hover:text-white' }}">
                                        <svg class="w-4 h-4 mr-2.5 opacity-75" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        Image Gallery
=======
                                    <a href="{{ route('spots.edit', $activeDestinationId) }}"
                                        class="flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold transition-colors {{ request()->routeIs('spots.edit') ? 'bg-white/15 text-white font-bold shadow-2xs' : 'text-emerald-100/80 hover:bg-white/5 hover:text-white' }}">
                                        <svg class="w-3.5 h-3.5 mr-2 shrink-0 opacity-80" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span class="truncate">Edit Details</span>
>>>>>>> Stashed changes
                                    </a>
                                @endif
                            </div>
                        </div>

<<<<<<< Updated upstream
                        <a href="{{ route('staff.walkins.create') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $walkinActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                            Walk-In
=======
                        <a href="{{ route('staff.walkins.create') }}"
                            class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-xs sm:text-sm transition-all duration-200 {{ $walkinActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                            <span>Walk-In</span>
>>>>>>> Stashed changes
                        </a>
                    @endif

                    {{-- Tourist Controls --}}
                    @if(Auth::check() && Auth::user()->isTourist())
<<<<<<< Updated upstream
                        <p class="px-4 pt-4 pb-1 text-xs font-semibold text-green-200 uppercase tracking-wider">My Travel</p>
                        <a href="{{ route('destinations.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $destinationsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Explore Spots
                        </a>
                        <a href="{{ route('bookings.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $bookingsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            My Bookings
                        </a>
                        <a href="{{ route('bookings.my-tickets') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition-colors {{ $ticketsActive ? 'bg-white/20 text-white shadow-sm' : 'text-green-100 hover:bg-white/10 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 opacity-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                            My Tickets
                        </a>
=======
                        @php $isVerified = Auth::user()->id_verification_status === 'verified'; @endphp
                        <div class="pt-4 pb-1">
                            <p class="px-3 text-2xs font-bold text-emerald-300/90 uppercase tracking-wider">My Travel</p>
                        </div>
                        @if($isVerified)
                            <a href="{{ route('destinations.index') }}"
                                class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-sm sm:text-base transition-all duration-200 {{ $destinationsActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <span>Explore Spots</span>
                            </a>
                            <a href="{{ route('bookings.index') }}"
                                class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-sm sm:text-base transition-all duration-200 {{ $bookingsActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                <span>My Bookings</span>
                            </a>
                            <a href="{{ route('bookings.my-tickets') }}"
                                class="flex items-center px-3.5 py-2.5 rounded-xl font-bold text-sm sm:text-base transition-all duration-200 {{ $ticketsActive ? 'bg-white/20 text-white shadow-xs backdrop-blur-xs' : 'text-emerald-100/90 hover:bg-white/10 hover:text-white' }}">
                                <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-90" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                    </path>
                                </svg>
                                <span>My Tickets</span>
                            </a>
                        @else
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-emerald-200/50 opacity-60 cursor-not-allowed select-none bg-black/10">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-60" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span>Explore Spots</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-amber-300 opacity-90 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-emerald-200/50 opacity-60 cursor-not-allowed select-none bg-black/10">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-60" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                    <span>My Bookings</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-amber-300 opacity-90 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div title="Identity verification pending — feature locked"
                                class="flex items-center justify-between px-3.5 py-2.5 rounded-xl font-semibold text-xs sm:text-sm text-emerald-200/50 opacity-60 cursor-not-allowed select-none bg-black/10">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-2.5 shrink-0 opacity-60" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                    <span>My Tickets</span>
                                </span>
                                <svg class="w-3.5 h-3.5 text-amber-300 opacity-90 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        @endif
>>>>>>> Stashed changes
                    @endif
                </nav>
            </div>

<<<<<<< Updated upstream
            {{-- Sidebar Footer (User details + Logout) --}}
            <div class="p-3 border-t border-white/10 bg-black/10 backdrop-blur-md shrink-0 relative overflow-hidden">
                <!-- Decorative glow -->
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-emerald-400/20 blur-2xl rounded-full pointer-events-none"></div>

                @if(Auth::check())
                <div class="flex items-center gap-3 p-2 rounded-2xl border border-transparent hover:bg-white/5 hover:border-white/10 transition-all duration-300 group/profile">
                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full border-2 border-emerald-300/80 text-emerald-100 flex items-center justify-center font-black text-lg shrink-0 relative transform group-hover/profile:scale-105 group-hover/profile:border-emerald-300 group-hover/profile:text-white group-hover/profile:shadow-[0_0_15px_rgba(52,211,153,0.6)] transition-all duration-300 shadow-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
=======
            {{-- Sidebar Footer (User Profile + Refined Glass Logout) --}}
            <div class="p-3 border-t border-emerald-700/50 bg-black/20 backdrop-blur-md shrink-0 relative overflow-hidden">
                @if(Auth::check())
                    <div class="flex items-center gap-2.5 p-1.5 rounded-xl transition-all duration-200">
                        <!-- Avatar -->
                        <div class="w-9 h-9 rounded-full border-2 border-emerald-400 bg-emerald-700/80 text-white flex items-center justify-center font-black text-sm shrink-0 shadow-xs">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <!-- Info -->
                        <div class="min-w-0 flex-1 flex flex-col justify-center">
                            <p class="text-sm font-bold text-white truncate leading-tight tracking-wide">
                                {{ Auth::user()->name }}
                            </p>
                            <div class="mt-0.5 flex items-center">
                                <span class="inline-flex items-center gap-1 bg-black/30 border border-white/10 text-2xs text-emerald-200 px-2 py-0.5 rounded-md font-bold uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </div>

                        <!-- Logout Button -->
                        <button x-data @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })"
                            class="p-2 text-white bg-rose-600/90 hover:bg-rose-600 border border-rose-500/50 rounded-xl transition-all duration-200 shadow-xs hover:scale-105 active:scale-95 cursor-pointer shrink-0"
                            title="Log Out">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
>>>>>>> Stashed changes
                    </div>
                    
                    <!-- Info -->
                    <div class="min-w-0 flex-1 flex flex-col justify-center">
                        <p class="text-sm font-extrabold text-white truncate leading-tight tracking-wide drop-shadow-sm">{{ Auth::user()->name }}</p>
                        <div class="mt-1 flex items-center">
                            <span class="inline-flex items-center gap-1.5 bg-black/20 border border-white/10 text-[9px] text-emerald-100 px-2 py-0.5 rounded-lg font-bold uppercase tracking-widest backdrop-blur-sm shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_5px_#34d399] animate-pulse"></span>
                                {{ Auth::user()->role }}
                            </span>
                        </div>
                    </div>

                    <!-- Logout Button -->
                    <button x-data @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })" 
                            class="group/logout p-1.5 border-2 border-red-500 text-white bg-red-500 hover:bg-red-400 hover:border-red-400 rounded-xl transition-all duration-300 focus:outline-none hover:shadow-[0_0_20px_rgba(239,68,68,0.6)]" 
                            title="Log Out">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover/logout:translate-x-0.5 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
                @endif
            </div>
        </aside>

        <!-- Sidebar overlay for mobile -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity md:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50">
            <!-- Top Header for Desktop -->
            <header class="bg-transparent h-16 flex items-center justify-end px-6 md:px-10 shrink-0 relative z-30">
                
                <div class="hidden md:flex items-center gap-3 shrink-0">
                    {{-- Unified Control Widget (The Pill) --}}
                    <div class="bg-white shadow-[0_4px_20px_-4px_rgba(16,185,129,0.15)] rounded-full flex items-center p-1.5 gap-2 border border-gray-100">
                        {{-- Notifications Bell Link --}}
                        <div class="relative group bell-ring-hover">
                            <a href="{{ route('notifications.index') }}"
                                class="relative flex items-center justify-center text-gray-500 hover:text-amber-600 hover:bg-amber-100 p-2 rounded-full transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @if($unreadCount > 0)
                                <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-[9px] rounded-full h-3.5 w-3.5 flex items-center justify-center font-bold">
                                    {{ $unreadCount }}
                                </span>
                                @endif
                            </a>
                            {{-- Tooltip --}}
                            <div class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                                Notifications
                            </div>
                        </div>

                        <div class="h-6 w-[1px] bg-gray-200"></div>

                        {{-- Settings Gear Dropdown --}}
                        <div class="relative group">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition-all focus:outline-none duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 ease-in-out group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link href="#"
                                            @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })"
                                            class="flex items-center gap-2 text-gray-700 hover:text-red-750 hover:bg-red-50 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                            {{-- Tooltip --}}
                            <div class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                                Settings
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto bg-gray-50 px-6 pt-4 pb-6 md:px-10 md:pt-4 md:pb-10">
                {{ $slot }}
            </main>
        </div>
        
    </div>

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
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Confirm
            </button>
        </form>
    </x-confirm-modal>

    @auth
    <script>
        (function() {
            let currentAlertId = null;

            function checkEmergencyAlerts() {
                fetch("{{ route('notifications.latest-alert') }}")
                    .then(r => {
                        if (!r.ok) throw new Error('Unauthenticated');
                        return r.json();
                    })
                    .then(data => {
                        const banner = document.getElementById('global-emergency-banner');
                        const messageEl = document.getElementById('global-emergency-message');
                        if (!banner || !messageEl) return;

                        if (data.has_alert) {
                            currentAlertId = data.id;
                            messageEl.textContent = data.message;
                            banner.classList.remove('hidden');
                            
                            // Style based on severity prefix in the notification message
                            if (data.message.includes('[CRITICAL]')) {
                                banner.className = "py-3 px-4 shadow-lg sticky top-0 z-50 transition-all duration-300 bg-red-600 text-white";
                            } else if (data.message.includes('[WARNING]')) {
                                banner.className = "py-3 px-4 shadow-lg sticky top-0 z-50 transition-all duration-300 bg-amber-500 text-amber-950";
                            } else {
                                banner.className = "py-3 px-4 shadow-lg sticky top-0 z-50 transition-all duration-300 bg-blue-600 text-white";
                            }
                        } else {
                            banner.classList.add('hidden');
                        }
                    })
                    .catch(err => {
                        // Suppress background errors if page is unloading or session expired
                    });
            }

            window.dismissGlobalEmergencyAlert = function() {
                if (!currentAlertId) return;
                fetch(`/notifications/${currentAlertId}/dismiss`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        const banner = document.getElementById('global-emergency-banner');
                        if (banner) banner.classList.add('hidden');
                        currentAlertId = null;
                    }
                })
                .catch(err => console.error('Error dismissing alert:', err));
            };

            // Check every 6 seconds for fast user-experience and immediate delivery
            setInterval(checkEmergencyAlerts, 6000);
            // Initial check
            document.addEventListener('DOMContentLoaded', checkEmergencyAlerts);
        })();
    </script>
    @endauth

    @stack('scripts')
</body>
</html>
