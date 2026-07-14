<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="E-Turismo — The Official Digital Tourism Portal for managing tourist destinations, bookings, and check-ins.">
    <title>E-Turismo | Digital Tourism Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Favicon -->
    @php
        $faviconUrl = asset('Pictures/LOGO/LOGO-eturismo.png') . '?v=' . filemtime(public_path('Pictures/LOGO/LOGO-eturismo.png'));
    @endphp
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0fdf4;
        }

        /* ── Hero gradient ── */
        .hero-gradient {
            background: linear-gradient(135deg, #0B3D2E 0%, #166534 40%, #16a34a 70%, #4ADE80 100%);
        }

        /* ── Primary CTA button ── */
        .btn-primary {
            background: linear-gradient(135deg, #166534 0%, #16a34a 100%);
            transition: background 0.3s ease, transform 0.15s ease, box-shadow 0.15s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0B3D2E 0%, #166534 100%);
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(11, 61, 46, 0.35);
        }

        /* ── Outlined ghost button ── */
        .btn-outline {
            border: 2px solid rgba(255,255,255,0.45);
            color: #fff;
            transition: background 0.2s ease;
        }
        .btn-outline:hover {
            background: rgba(255,255,255,0.12);
        }

        /* ── Card hover lift ── */
        .card-hover {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card-hover:hover {
            transform: translateY(-6px);
            box-shadow: 0 24px 48px rgba(22, 101, 52, 0.14);
        }

        /* ── Floating animation ── */
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-14px); }
        }

        /* ── Section divider gradient strip ── */
        .section-divider {
            height: 5px;
            background: linear-gradient(90deg, #0B3D2E, #22c55e, #a3e635, #22c55e, #0B3D2E);
            background-size: 200% 100%;
            animation: shimmer 4s linear infinite;
        }
        @keyframes shimmer {
            0%   { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* ── Step number badge ── */
        .step-badge {
            background: linear-gradient(135deg, #166534 0%, #16a34a 100%);
        }

        /* ── Nav link hover ── */
        .nav-link-green:hover {
            color: #16a34a;
        }
        .nav-link-green.active {
            color: #0B3D2E;
            font-weight: 700;
        }

        /* ── Feature icon background ── */
        .icon-bg {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        }
    </style>
</head>

<body>

    {{-- ============================================================ --}}
    {{-- NAVIGATION --}}
    {{-- ============================================================ --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white/85 backdrop-blur-md border-b border-green-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('Pictures/LOGO/LOGO-eturismo2.png') }}" alt="E-Turismo Logo"
                    class="h-12 w-auto object-contain" />
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#discover" class="nav-link-green hover:text-green-700 transition">Discover</a>
                <a href="#features" class="nav-link-green hover:text-green-700 transition">Features</a>
                <a href="#how-it-works" class="nav-link-green hover:text-green-700 transition">How It Works</a>
            </nav>
            <div class="flex items-center gap-3">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-semibold text-green-700 hover:underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Sign In</a>
                        <a href="{{ route('register') }}"
                            class="btn-primary text-sm font-semibold text-white rounded-lg px-4 py-2">
                            Register
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}
    <section class="hero-gradient min-h-screen flex items-center justify-center pt-16 relative overflow-hidden">
        {{-- Background blobs --}}
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-green-400/15 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-lime-400/15 rounded-full blur-3xl"></div>
        <div class="absolute top-2/3 left-1/3 w-64 h-64 bg-emerald-300/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <div class="floating inline-block mb-6">
                <img src="{{ asset('Pictures/LOGO/LOGO-eturismo3.png') }}" alt="E-Turismo logo" class="w-20 h-20 object-contain mx-auto" />
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white leading-tight tracking-tight">
                Explore. Book.<br>
                <span class="text-green-300">Experience.</span>
            </h1>
            <p class="text-lg sm:text-xl text-green-200 mt-6 max-w-2xl mx-auto leading-relaxed">
               Tigbao E-Turismo Digital Tourism Portal
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-green-800 font-bold rounded-2xl px-8 py-4 text-base hover:bg-green-50 transition shadow-lg hover:shadow-xl hover:-translate-y-0.5 duration-200">
                    Get Started — It's Free
                </a>
                <a href="{{ route('login') }}"
                    class="btn-outline font-semibold rounded-2xl px-8 py-4 text-base">
                    Sign In
                </a>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </section>

    {{-- Section divider --}}
    <div class="section-divider"></div>

    {{-- ============================================================ --}}
    {{-- DISCOVER TIGBAO SHOWCASE --}}
    {{-- ============================================================ --}}
    <section id="discover" class="relative overflow-hidden" style="height: 600px;">
        {{-- Background image — zoom on hover via parent group --}}
        <div class="absolute inset-0 group" style="overflow:hidden;">
            <img src="{{ asset('Pictures/TIGBAO-VIEW.jpg') }}" alt="Tigbao scenic view"
                class="w-full h-full object-cover object-center transition-transform duration-[8000ms] ease-in-out group-hover:scale-110" />
        </div>

        {{-- Dark gradient overlay with green tint --}}
        <div class="absolute inset-0 bg-gradient-to-r from-green-950/80 via-green-900/50 to-black/10 pointer-events-none"
             style="--tw-gradient-from: #052e16cc; --tw-gradient-via: #0B3D2E88; --tw-gradient-to: transparent;
                    background: linear-gradient(to right, rgba(5,46,22,0.82), rgba(11,61,46,0.52), rgba(0,0,0,0.1));"></div>

        {{-- Content --}}
        <div class="relative z-10 h-full flex items-center px-6 md:px-16 max-w-7xl mx-auto">
            <div class="max-w-xl">
                <span
                    class="inline-block text-xs font-bold uppercase tracking-widest text-green-300 bg-green-900/60 backdrop-blur px-4 py-1.5 rounded-full mb-5 border border-green-700/40">
                    📍 Tigbao, Zamboanga del Sur
                </span>
                <h2 class="text-4xl sm:text-5xl font-black text-white leading-tight mb-4">
                    Discover the Beauty<br>of <span class="text-green-300">Tigbao</span>
                </h2>
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white/80" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>

        {{-- Bottom fade to page background --}}
        <div class="absolute bottom-0 inset-x-0 h-28 pointer-events-none z-10"
             style="background: linear-gradient(to top, #f0fdf4, transparent);"></div>
    </section>

    {{-- Section divider --}}
    <div class="section-divider"></div>

    {{-- ============================================================ --}}
    {{-- FEATURES --}}
    {{-- ============================================================ --}}
    @php
        $features = $features ?? [
            [
                'icon' => 'calendar',
                'title' => 'Smart Booking System',
                'desc' => 'Tourists submit booking requests. Staff review and confirm bookings while destination capacity is tracked automatically.',
            ],
            [
                'icon' => 'ticket',
                'title' => 'QR Ticket Generation',
                'desc' => 'Every confirmed booking generates a secure QR Code ticket for fast and hassle-free entry.',
            ],
            [
                'icon' => 'device',
                'title' => 'Digital Check-In',
                'desc' => 'Staff scan QR codes at the entrance to verify visitors and automatically update occupancy records.',
            ],
            [
                'icon' => 'bell',
                'title' => 'Real-Time Notifications',
                'desc' => 'Tourists receive booking updates while staff receive alerts whenever destination capacity is nearly full.',
            ],
        ];
    @endphp

    <section id="features" class="py-24 bg-white">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">
                <span class="text-green-600 font-semibold uppercase tracking-widest text-sm">
                    Why Choose E-Turismo
                </span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 mt-3">
                    Everything tourism needs,<br>
                    in one place.
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($features as $f)

                    <div class="card-hover bg-white border border-green-100 rounded-3xl p-8 shadow-sm">

                        {{-- Icon --}}
                        <div class="icon-bg w-16 h-16 rounded-2xl flex items-center justify-center mb-6">

                            @switch($f['icon'])

                                @case('map')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 20l-5-2V6l5 2m0 12l6-2m-6 2V8m6 10l5 2V8l-5-2m0 12V6"/>
                                    </svg>
                                @break

                                @case('calendar')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                                        <path stroke-width="2" d="M16 2v4M8 2v4M3 10h18"/>
                                    </svg>
                                @break

                                @case('ticket')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 8h16v3a2 2 0 010 4v3H4v-3a2 2 0 010-4V8z"/>
                                    </svg>
                                @break

                                @case('device')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <rect x="7" y="2" width="10" height="20" rx="2" stroke-width="2"/>
                                        <circle cx="12" cy="18" r="1"/>
                                    </svg>
                                @break

                                @case('bell')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"/>
                                    </svg>
                                @break

                                @case('chart')
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 17V9m4 8V5m4 12v-4M4 21h16"/>
                                    </svg>
                                @break

                            @endswitch

                        </div>

                        <h3 class="text-xl font-bold text-gray-900 mb-3">
                            {{ $f['title'] }}
                        </h3>

                        <p class="text-gray-500 leading-relaxed">
                            {{ $f['desc'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- Section divider --}}
    <div class="section-divider"></div>

    {{-- ============================================================ --}}
    {{-- HOW IT WORKS --}}
    {{-- ============================================================ --}}
    <section id="how-it-works" class="py-24" style="background-color: #f0fdf4;">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-green-600 uppercase tracking-widest">Process Flow</span>
                <h2 class="text-4xl font-black text-gray-900 mt-2">How E-Turismo Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                @php
                    $steps = [
                        ['num' => '01', 'title' => 'Register', 'desc' => 'Create your tourist account with government ID verification.'],
                        ['num' => '02', 'title' => 'Book', 'desc' => 'Choose a destination and submit your preferred visit date.'],
                        ['num' => '03', 'title' => 'Get Ticket', 'desc' => 'Receive your unique QR ticket once staff confirms your booking.'],
                        ['num' => '04', 'title' => 'Check In', 'desc' => 'Present your QR at the entrance. Staff scans and you\'re in!'],
                    ];
                @endphp
                @foreach($steps as $step)
                    <div class="text-center">
                        <div
                            class="step-badge inline-flex items-center justify-center w-14 h-14 rounded-2xl text-white font-black text-lg mb-4 shadow-md">
                            {{ $step['num'] }}
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $step['title'] }}</h3>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Section divider --}}
    <div class="section-divider"></div>

    {{-- ============================================================ --}}
    {{-- CTA --}}
    {{-- ============================================================ --}}
    <section class="py-24 hero-gradient">
        <div class="max-w-2xl mx-auto text-center px-6">
            <h2 class="text-4xl font-black text-white">Ready to explore?</h2>
            <p class="text-green-200 mt-4 text-lg">Register now and start booking your next adventure.</p>
            <a href="{{ route('register') }}"
                class="inline-block mt-8 bg-white text-green-800 font-bold rounded-2xl px-10 py-4 text-base hover:bg-green-50 transition shadow-xl hover:-translate-y-0.5 duration-200">
                Create Your Account
            </a>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FOOTER --}}
    {{-- ============================================================ --}}
    <footer style="background: #052e16;" class="text-green-300 py-10 text-center text-sm">
        <p class="font-semibold text-white">Tigbao E-Turismo Digital Tourism Portal</p>
        <p class="mt-1 text-green-400">Promoting tourism and local Spots in Tigbao · All rights reserved.</p>
    </footer>
</body>

</html>