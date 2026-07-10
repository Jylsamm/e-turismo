<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-Turismo — The Official Digital Tourism Portal for managing tourist destinations, bookings, and check-ins.">
    <title>E-Turismo | Digital Tourism Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Pictures/LOGO/LOGO-eturismo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4338ca 70%, #6366f1 100%);
        }
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        .floating {
            animation: float 4s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- ============================================================ --}}
    {{-- NAVIGATION                                                    --}}
    {{-- ============================================================ --}}
    <header class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2">
                <img src="{{ asset('Pictures/LOGO/LOGO-eturismo.png') }}" alt="E-Turismo Logo" class="h-10 w-auto object-contain" />
                <span class="hidden sm:block text-xs bg-indigo-100 text-indigo-600 px-2 py-0.5 rounded-full font-semibold">OFFICIAL</span>
            </a>
            <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
                <a href="#features" class="hover:text-indigo-700 transition">Features</a>
                <a href="#how-it-works" class="hover:text-indigo-700 transition">How It Works</a>
            </nav>
            <div class="flex items-center gap-3">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-sm font-semibold text-indigo-700 hover:underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium text-gray-600 hover:text-gray-900 transition">Sign In</a>
                        <a href="{{ route('register') }}"
                            class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 transition">
                            Register
                        </a>
                    @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- HERO                                                          --}}
    {{-- ============================================================ --}}
    <section class="hero-gradient min-h-screen flex items-center justify-center pt-16 relative overflow-hidden">
        {{-- Background blobs --}}
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-blue-400/20 rounded-full blur-3xl"></div>

        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <div class="floating inline-block text-7xl mb-6">🏝️</div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white leading-tight tracking-tight">
                Explore. Book.<br>
                <span class="text-indigo-300">Experience.</span>
            </h1>
            <p class="text-lg sm:text-xl text-indigo-200 mt-6 max-w-2xl mx-auto leading-relaxed">
                E-Turismo is the official digital tourism management portal — making it seamless for tourists to discover destinations, book visits, and check in with verified QR tickets.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                    class="bg-white text-indigo-700 font-bold rounded-2xl px-8 py-4 text-base hover:bg-indigo-50 transition shadow-lg">
                    Get Started — It's Free
                </a>
                <a href="{{ route('login') }}"
                    class="border-2 border-white/40 text-white font-semibold rounded-2xl px-8 py-4 text-base hover:bg-white/10 transition">
                    Sign In
                </a>
            </div>

            {{-- Quick stats --}}
            <div class="mt-16 grid grid-cols-3 gap-6 max-w-lg mx-auto">
                <div class="text-center">
                    <p class="text-3xl font-black text-white">100%</p>
                    <p class="text-xs text-indigo-300 mt-1">Digital Process</p>
                </div>
                <div class="text-center border-x border-white/20">
                    <p class="text-3xl font-black text-white">QR</p>
                    <p class="text-xs text-indigo-300 mt-1">Verified Tickets</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white">DOT</p>
                    <p class="text-xs text-indigo-300 mt-1">Compliant Reports</p>
                </div>
            </div>
        </div>

        {{-- Scroll hint --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FEATURES                                                      --}}
    {{-- ============================================================ --}}
    <section id="features" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Platform Features</span>
                <h2 class="text-4xl font-black text-gray-900 mt-2">Everything tourism needs,<br>in one place.</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                $features = [
                    ['icon'=>'🗺️',  'title'=>'Destination Registry',  'desc'=>'Browse and discover tourist spots with photos, descriptions, capacity info, and real-time availability.'],
                    ['icon'=>'📅',  'title'=>'Smart Booking System',   'desc'=>'Tourists submit booking requests. Staff review and confirm. Capacity is tracked automatically per visit date.'],
                    ['icon'=>'🎫',  'title'=>'QR Ticket Generation',   'desc'=>'Every confirmed booking generates a unique QR code ticket that tourists use for entry.'],
                    ['icon'=>'📱',  'title'=>'Digital Check-In',       'desc'=>'Staff scan QR codes at the entrance to verify tickets, log arrivals, and update occupancy counts.'],
                    ['icon'=>'🔔',  'title'=>'Real-Time Notifications', 'desc'=>'Tourists receive instant alerts on booking status. Staff get capacity warnings when thresholds are reached.'],
                    ['icon'=>'📊',  'title'=>'DOT-Compliant Reports',  'desc'=>'Admin can generate daily, weekly, or monthly tourism reports with CSV export for DOT submission.'],
                ];
                @endphp
                @foreach($features as $f)
                <div class="card-hover bg-gray-50 border border-gray-100 rounded-2xl p-8">
                    <div class="text-4xl mb-4">{{ $f['icon'] }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $f['title'] }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- HOW IT WORKS                                                  --}}
    {{-- ============================================================ --}}
    <section id="how-it-works" class="py-24 bg-indigo-50">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-16">
                <span class="text-sm font-semibold text-indigo-600 uppercase tracking-widest">Process Flow</span>
                <h2 class="text-4xl font-black text-gray-900 mt-2">How E-Turismo Works</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                @php
                $steps = [
                    ['num'=>'01', 'title'=>'Register',   'desc'=>'Create your tourist account with government ID verification.'],
                    ['num'=>'02', 'title'=>'Book',        'desc'=>'Choose a destination and submit your preferred visit date.'],
                    ['num'=>'03', 'title'=>'Get Ticket',  'desc'=>'Receive your unique QR ticket once staff confirms your booking.'],
                    ['num'=>'04', 'title'=>'Check In',    'desc'=>'Present your QR at the entrance. Staff scans and you\'re in!'],
                ];
                @endphp
                @foreach($steps as $step)
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-indigo-600 text-white font-black text-lg mb-4">
                        {{ $step['num'] }}
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg">{{ $step['title'] }}</h3>
                    <p class="text-gray-500 text-sm mt-2 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- CTA                                                           --}}
    {{-- ============================================================ --}}
    <section class="py-24 hero-gradient">
        <div class="max-w-2xl mx-auto text-center px-6">
            <h2 class="text-4xl font-black text-white">Ready to explore?</h2>
            <p class="text-indigo-200 mt-4 text-lg">Register now and start booking your next adventure.</p>
            <a href="{{ route('register') }}"
                class="inline-block mt-8 bg-white text-indigo-700 font-bold rounded-2xl px-10 py-4 text-base hover:bg-indigo-50 transition shadow-xl">
                Create Your Account
            </a>
        </div>
    </section>

    {{-- ============================================================ --}}
    {{-- FOOTER                                                        --}}
    {{-- ============================================================ --}}
    <footer class="bg-gray-900 text-gray-400 py-10 text-center text-sm">
        <p class="font-semibold text-white">E-Turismo Digital Tourism Portal</p>
        <p class="mt-1">In partnership with the Department of Tourism (DOT) · All rights reserved.</p>
    </footer>

</body>
</html>
