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
        $faviconPath = public_path('Pictures/LOGO/LOGO-eturismo.png');
        $faviconVersion = file_exists($faviconPath) ? filemtime($faviconPath) : '1';
        $faviconUrl = asset('Pictures/LOGO/LOGO-eturismo.png') . '?v=' . $faviconVersion;
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

        /* ── Staggered fade-in-up entry animations ── */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .animation-delay-200 {
            animation-delay: 200ms;
        }
        .animation-delay-400 {
            animation-delay: 400ms;
        }
        .animation-delay-600 {
            animation-delay: 600ms;
        }

        /* ── Slow Zoom Hero Animation ── */
        @keyframes slowZoom {
            0% { transform: scale(1); }
            100% { transform: scale(1.08); }
        }
        .animate-slow-zoom {
            animation: slowZoom 30s ease-in-out infinite alternate;
        }
    </style>
</head>

<body>

    {{-- ============================================================ --}}
    {{-- LANDING PAGE NAVIGATION --}}
    {{-- ============================================================ --}}
    <header
        x-data="{ scrolled: false, mobileMenuOpen: false }"
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="scrolled ? 'backdrop-blur-xl bg-white border-b border-gray-200 shadow-sm' : 'bg-transparent border-transparent'"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 flex items-center justify-between transition-all duration-300"
             :class="scrolled ? 'h-16' : 'h-24'">

            {{-- 1. Logo --}}
            <div class="flex items-center gap-2 transition-all duration-200 hover:scale-105 z-50 select-none">
                <img src="{{ asset('Pictures/LOGO/LOGO-eturismo2.png') }}" alt="E-Turismo Logo"
                     :class="scrolled ? 'brightness-100 invert-0' : 'brightness-0 invert'"
                     class="h-16 sm:h-18 w-auto object-contain transition-all duration-300" />
            </div>

            {{-- 2. Desktop Navigation Links --}}
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold transition-colors duration-300"
                 :class="scrolled ? 'text-gray-700' : 'text-white drop-shadow-md'">
                <a href="#discover" :class="scrolled ? 'hover:text-green-600' : 'hover:text-green-300'" class="transition-all duration-200 hover:scale-105">Discover</a>
                <a href="#features" :class="scrolled ? 'hover:text-green-600' : 'hover:text-green-300'" class="transition-all duration-200 hover:scale-105">Features</a>
                <a href="#how-it-works" :class="scrolled ? 'hover:text-green-600' : 'hover:text-green-300'" class="transition-all duration-200 hover:scale-105">How It Works</a>
            </nav>

            {{-- 3. Desktop Auth Buttons --}}
            <div class="hidden md:flex items-center gap-4 z-50">
                @if(Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           :class="scrolled ? 'text-gray-700 border-gray-300 hover:border-gray-400 hover:text-green-600' : 'text-white border-white/50 hover:bg-white/10 drop-shadow-md'"
                           class="text-sm font-bold border-2 px-6 py-2.5 rounded-full transition-all duration-300">
                            Dashboard →
                        </a>
                    @else
                        {{-- Sign In --}}
                        <a href="{{ route('login') }}"
                           :class="scrolled 
                                ? 'text-gray-700 border-gray-400 hover:bg-green-600 hover:text-white hover:border-green-600 bg-transparent' 
                                : 'text-white border-white/60 hover:bg-white hover:text-green-800 hover:border-white drop-shadow-md bg-transparent'"
                           class="text-sm font-bold border-2 px-5 py-2 rounded-full transition-all duration-300 hover:scale-105 hover:-translate-y-0.5">
                            Sign In
                        </a>
                        {{-- Register: Green outline when scrolled, solid white at top --}}
                        <a href="{{ route('register') }}"
                           :class="scrolled 
                                ? 'text-green-600 border-green-500 hover:bg-green-50 bg-transparent' 
                                : 'text-green-800 bg-white border-white hover:bg-green-50 shadow-lg'"
                           class="text-sm font-bold border-2 px-6 py-2.5 rounded-full hover:-translate-y-0.5 transition-all duration-300">
                            Register
                        </a>
                    @endauth
                @endif
            </div>

            {{-- 4. Mobile Menu Toggle Button --}}
            <div class="md:hidden flex items-center z-50">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        :class="scrolled || mobileMenuOpen ? 'text-gray-900' : 'text-white drop-shadow-md'"
                        class="p-2 focus:outline-none transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- 5. Mobile Dropdown Menu --}}
        <div x-show="mobileMenuOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-5"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-5"
             class="md:hidden absolute top-0 inset-x-0 bg-white border-b border-gray-200 shadow-xl pt-20 pb-6 px-6 flex flex-col gap-4 text-center z-40">
            
            <a href="#discover" @click="mobileMenuOpen = false" class="text-gray-800 font-semibold py-2 hover:text-green-600">Discover</a>
            <a href="#features" @click="mobileMenuOpen = false" class="text-gray-800 font-semibold py-2 hover:text-green-600">Features</a>
            <a href="#how-it-works" @click="mobileMenuOpen = false" class="text-gray-800 font-semibold py-2 hover:text-green-600">How It Works</a>
            
            <div class="h-px bg-gray-100 my-2"></div>
            
            @if(Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-green-600 border-2 border-green-500 font-bold py-3 rounded-full hover:bg-green-50">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 border-2 border-gray-300 font-bold py-3 rounded-full hover:bg-gray-50">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white font-bold py-3 rounded-full hover:bg-green-700">Register</a>
                @endauth
            @endif
        </div>
    </header>

    {{-- ============================================================ --}}
    {{-- HERO --}}
    {{-- ============================================================ --}}
    <section class="min-h-screen flex items-center justify-center pt-16 relative overflow-hidden">

        {{-- Hero Background Image with slow zoom --}}
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div class="w-full h-full bg-cover bg-center bg-no-repeat animate-slow-zoom"
                 style="background-image: url('{{ asset('Pictures/bgp.png') }}');"></div>
        </div>

        {{-- Low-opacity dark overlay so the green gradient stays dominant --}}
        <div class="absolute inset-0 z-10" style="background: linear-gradient(180deg, rgba(0, 8, 0, 0.85) 0%, rgba(2, 25, 8, 0.55) 25%, rgba(0, 40, 12, 0.4) 55%, rgba(4, 55, 30, 0.5) 100%);"></div>
        
        {{-- Background blobs --}}
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-green-400/15 rounded-full blur-3xl z-[2]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-lime-400/15 rounded-full blur-3xl z-[2]"></div>
        <div class="absolute top-2/3 left-1/3 w-64 h-64 bg-emerald-300/10 rounded-full blur-3xl z-[2]"></div>

        <div class="relative z-20 text-center px-6 max-w-4xl mx-auto">
            <div class="animate-fade-in-up">
                <div class="floating inline-block mb-6">
                    <img src="{{ asset('Pictures/LOGO/LOGO-eturismo3.png') }}" alt="E-Turismo logo" class="w-20 h-20 object-contain mx-auto" />
                </div>
            </div>
            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black leading-tight tracking-tight animate-fade-in-up animation-delay-200">
    <span class="bg-gradient-to-br from-white via-green-50 to-green-200 bg-clip-text text-transparent drop-shadow-[0_3px_4px_rgba(14,14,14,0.9)]">Explore. Book.</span><br>
    <span class="text-green-300 drop-shadow-[0_3px_4px_rgba(14,14,14,0.9)]">Experience.</span>
</h1>
            <p class="text-lg sm:text-xl text-white mt-6 max-w-2xl mx-auto leading-relaxed animate-fade-in-up animation-delay-400" style="text-shadow: 0 3px 4px rgba(14, 14, 14, 0.9);">
               Tigbao E-Turismo Digital Tourism Portal
            </p>
            <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up animation-delay-600">
                <a href="{{ route('register') }}"
                    class="bg-white text-green-800 font-bold rounded-2xl px-8 py-4 text-base transition-all duration-200 hover:-translate-y-1 hover:scale-105 hover:bg-green-50 hover:shadow-[0_12px_24px_rgba(34,197,94,0.3)]">
                    Get Started
                </a>
                <a href="{{ route('login') }}"
                    class="border-2 border-white/50 text-white font-bold rounded-2xl px-8 py-4 text-base transition-all duration-300 hover:-translate-y-0.5 hover:scale-105 hover:bg-white hover:text-green-800 hover:border-white hover:shadow-[0_12px_24px_rgba(255,255,255,0.2)]">
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
                <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-green-300 bg-green-900/60 backdrop-blur px-4 py-1.5 rounded-full mb-5 border border-green-700/40">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    Tigbao, Zamboanga del Sur
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
    <style>
        /* ── Features section ───────────────────────────────────── */
        #features-section {
            padding: 96px 0;
            background: #ffffff;
        }

        #feat-header { text-align: center; margin-bottom: 64px; }
        #feat-header .eyebrow {
            font-size: 12px; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: #059669; display: block; margin-bottom: 12px;
        }
        #feat-header h2 {
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 900; color: #111827; line-height: 1.15;
        }
        #feat-header h2 span { color: #059669; }

        /* ── Grid: 1 col → 2 col (md) → 4 col (lg) ────────────── */
        #feat-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
        }
        @media (min-width: 640px)  { #feat-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { #feat-grid { grid-template-columns: repeat(4, 1fr); } }

        /* ── Feature card ───────────────────────────────────────── */
        .feat-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 32px 28px;
            border: 1.5px solid rgba(16, 185, 129, 0.1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            gap: 0;
            cursor: default;
            position: relative;
            overflow: hidden;

            /* Entrance: hidden until JS triggers */
            opacity: 0;
            transform: translateY(24px);
            transition:
                opacity   0.6s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                box-shadow 0.25s ease-out,
                border-color 0.25s ease-out;
        }
        .feat-card.visible { opacity: 1; transform: translateY(0); }

        /* Hover lift */
        .feat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(5, 150, 105, 0.12), 0 4px 16px rgba(0, 0, 0, 0.08);
            border-color: rgba(16, 185, 129, 0.35);
        }
        /* Keyboard focus ring */
        .feat-card:focus-visible {
            outline: 3px solid #10b981;
            outline-offset: 3px;
        }

        /* Subtle top-edge accent bar (unique per card via data-accent) */
        .feat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 24px; right: 24px;
            height: 3px;
            border-radius: 0 0 4px 4px;
            background: var(--accent, #10b981);
            opacity: 0;
            transition: opacity 0.25s ease-out;
        }
        .feat-card:hover::before { opacity: 1; }

        /* ── Icon container ─────────────────────────────────────── */
        .feat-icon-wrap {
            width: 64px; height: 64px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 22px;
            background: var(--icon-bg, linear-gradient(135deg, #d1fae5, #a7f3d0));
            box-shadow: 0 4px 12px var(--icon-shadow, rgba(16,185,129,0.2));
            transition: transform 0.25s cubic-bezier(0.22,1,0.36,1), box-shadow 0.25s ease-out;
            flex-shrink: 0;
        }
        .feat-card.visible .feat-icon-wrap {
            animation: feat-icon-in 0.5s cubic-bezier(0.22,1,0.36,1) both;
        }
        .feat-card:hover .feat-icon-wrap {
            transform: scale(1.1);
            box-shadow: 0 8px 24px var(--icon-shadow, rgba(16,185,129,0.3));
        }
        @keyframes feat-icon-in {
            0%   { transform: scale(0.7); opacity: 0; }
            70%  { transform: scale(1.06); }
            100% { transform: scale(1); opacity: 1; }
        }
        @media (prefers-reduced-motion: reduce) {
            .feat-card { transition: box-shadow 0.25s ease-out, border-color 0.25s ease-out !important; }
            .feat-card:hover { transform: none; }
            .feat-icon-wrap { animation: none !important; transition: none !important; }
            .feat-card:hover .feat-icon-wrap { transform: none; }
        }

        .feat-icon-wrap svg { width: 28px; height: 28px; }

        /* ── Card text ──────────────────────────────────────────── */
        .feat-title {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
            margin: 0 0 10px 0;
            line-height: 1.3;
            transition: color 0.2s ease-out;
        }
        .feat-card:hover .feat-title { color: #047857; }

        /* Force body copy to a single consistent gray — fixes the highlight bug */
        .feat-desc {
            font-size: 14px;
            line-height: 1.7;
            color: #6b7280 !important;
            margin: 0;
            /* Override any Tailwind or browser-applied inline colors */
            -webkit-text-fill-color: #6b7280;
        }
        .feat-desc * { color: #6b7280 !important; -webkit-text-fill-color: #6b7280; }
    </style>

    <section id="features-section">

        <div id="feat-header">
            <span class="eyebrow">Why Choose E-Turismo</span>
            <h2>Everything tourism needs,<br><span>in one place.</span></h2>
        </div>

        <div id="feat-grid">

            {{-- Card 1: Smart Booking --}}
            <div class="feat-card" tabindex="0"
                 style="--accent: #10b981; --icon-bg: linear-gradient(135deg, #d1fae5 0%, #6ee7b7 100%); --icon-shadow: rgba(16,185,129,0.25);">
                <div class="feat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                </div>
                <h3 class="feat-title">Smart Booking System</h3>
                <p class="feat-desc">Tourists submit booking requests. Staff review and confirm bookings while destination capacity is tracked automatically.</p>
            </div>

            {{-- Card 2: QR Ticket --}}
            <div class="feat-card" tabindex="0"
                 style="--accent: #0d9488; --icon-bg: linear-gradient(135deg, #ccfbf1 0%, #5eead4 100%); --icon-shadow: rgba(13,148,136,0.25);">
                <div class="feat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 8h16v3a2 2 0 010 4v3H4v-3a2 2 0 010-4V8z"/>
                    </svg>
                </div>
                <h3 class="feat-title">QR Ticket Generation</h3>
                <p class="feat-desc">Every confirmed booking generates a secure QR Code ticket for fast and hassle-free entry.</p>
            </div>

            {{-- Card 3: Digital Check-In --}}
            <div class="feat-card" tabindex="0"
                 style="--accent: #059669; --icon-bg: linear-gradient(135deg, #dcfce7 0%, #86efac 100%); --icon-shadow: rgba(5,150,105,0.25);">
                <div class="feat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="7" y="2" width="10" height="20" rx="2" stroke-width="2"/>
                        <circle cx="12" cy="18" r="1" fill="#16a34a"/>
                    </svg>
                </div>
                <h3 class="feat-title">Digital Check-In</h3>
                <p class="feat-desc">Staff scan QR codes at the entrance to verify visitors and automatically update occupancy records.</p>
            </div>

            {{-- Card 4: Notifications --}}
            <div class="feat-card" tabindex="0"
                 style="--accent: #047857; --icon-bg: linear-gradient(135deg, #d1fae5 0%, #34d399 100%); --icon-shadow: rgba(4,120,87,0.25);">
                <div class="feat-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#047857" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0h6z"/>
                    </svg>
                </div>
                <h3 class="feat-title">Real-Time Notifications</h3>
                <p class="feat-desc">Tourists receive booking updates while staff receive alerts whenever destination capacity is nearly full.</p>
            </div>

        </div>
    </section>

    <script>
    (function () {
        var cards = Array.from(document.querySelectorAll('#feat-grid .feat-card'));
        var triggered = false;
        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function revealCards() {
            if (triggered) return;
            triggered = true;
            cards.forEach(function (card, i) {
                var delay = reducedMotion ? 0 : i * 90;
                setTimeout(function () {
                    card.classList.add('visible');
                }, delay);
            });
        }

        var observer = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                revealCards();
                observer.disconnect();
            }
        }, { threshold: 0.1 });

        observer.observe(document.getElementById('features-section'));
    })();
    </script>

    {{-- Section divider --}}
    <div class="section-divider"></div>

    {{-- ============================================================ --}}
    {{-- HOW IT WORKS --}}
    {{-- ============================================================ --}}
    <style>
        /* ── Section ─────────────────────────────────────────── */
        #how-it-works {
            padding: 96px 0;
            position: relative;
            overflow: hidden;
            background: linear-gradient(160deg, #f0fdf4 0%, #ecfdf5 100%);
        }
        #how-it-works::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 60%, rgba(16,185,129,0.07) 0%, transparent 65%);
            pointer-events: none;
        }

        /* ── Header ──────────────────────────────────────────── */
        #hiw-header {
            text-align: center;
            margin-bottom: 64px;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        #hiw-header.visible { opacity: 1; transform: translateY(0); }
        #hiw-header .label {
            font-size: 12px; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: #059669;
        }
        #hiw-header h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 900; color: #111827; margin-top: 8px;
        }

        /* ── Per-segment connectors (SVG overlay) ───────────────── */
        #hiw-svg-overlay {
            display: none;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            pointer-events: none;
            z-index: 3;
            overflow: visible;
        }
        @media (min-width: 768px) { #hiw-svg-overlay { display: block; } }

        /* Track lines (dim base) */
        .seg-track { stroke: #d1fae5; stroke-width: 3; fill: none; stroke-linecap: round; }

        /* Fill lines draw in via stroke-dashoffset */
        .seg-fill {
            stroke-width: 3; fill: none; stroke-linecap: round;
            stroke: url(#seg-grad);
            stroke-dashoffset: 9999; /* overridden by JS */
            transition: stroke-dashoffset 0.7s cubic-bezier(0.22, 1, 0.36, 1),
                        stroke-width 0.2s ease-out;
        }
        .seg-fill.drawn { stroke-dashoffset: 0; }
        .seg-fill.hovered { stroke: url(#seg-grad-bright); stroke-width: 4.5; }

        /* Traveling pulse dot */
        .seg-dot { r: 4; fill: #34d399; filter: url(#seg-blur); opacity: 0; }

        /* Respect prefers-reduced-motion */
        @media (prefers-reduced-motion: reduce) {
            .seg-dot { display: none !important; }
            .hiw-pulse-ring { animation: none !important; opacity: 0 !important; }
            .seg-fill { transition: stroke-dashoffset 0.1s; }
        }

        /* ── Mobile vertical connector ───────────────────────── */
        #hiw-connector-v {
            display: block;
            position: absolute;
            left: 50%;
            top: calc(12.5% + 32px);
            bottom: calc(12.5% + 32px);
            width: 3px;
            border-radius: 99px;
            background: #d1fae5;
            transform: translateX(-50%);
            z-index: 1;
            overflow: hidden;
        }
        #hiw-connector-v-fill {
            position: absolute; left: 0; right: 0; top: 0;
            background: linear-gradient(180deg, #059669, #10b981, #34d399);
            border-radius: 99px;
            height: 0;
            transition: height 1.4s cubic-bezier(0.22, 1, 0.36, 1);
        }
        #hiw-connector-v-fill.drawn { height: 100%; }
        @media (min-width: 768px) {
            #hiw-connector-v { display: none; }
        }

        /* ── Grid wrapper ────────────────────────────────────── */
        #hiw-grid-wrap { position: relative; }

        /* ── Grid ────────────────────────────────────────────── */
        #hiw-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            position: relative;
            z-index: 2;
        }
        @media (min-width: 768px) {
            #hiw-grid { grid-template-columns: repeat(4, 1fr); gap: 28px; }
        }

        /* ── Step card ───────────────────────────────────────── */
        .hiw-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 32px 24px 28px;
            border: 1px solid rgba(16,185,129,0.12);
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
            position: relative;
            opacity: 0;
            transform: translateY(28px);
            transition:
                opacity 0.65s cubic-bezier(0.22,1,0.36,1),
                transform 0.65s cubic-bezier(0.22,1,0.36,1),
                box-shadow 0.25s ease-out,
                border-color 0.25s ease-out;
        }
        .hiw-card.visible { opacity: 1; transform: translateY(0); }
        .hiw-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(5,150,105,0.12), 0 4px 16px rgba(0,0,0,0.08);
            border-color: rgba(16,185,129,0.3);
        }

        /* ── Badge wrapper ───────────────────────────────────── */
        .hiw-badge-wrap {
            position: relative;
            margin-bottom: 20px;
            width: 64px; height: 64px;
        }

        /* Ambient glow (consistent on all badges) */
        .hiw-glow {
            position: absolute;
            inset: -8px;
            border-radius: 24px;
            background: radial-gradient(circle, rgba(52,211,153,0.22) 0%, transparent 70%);
            filter: blur(6px);
            transition: opacity 0.25s ease-out;
            pointer-events: none;
        }
        .hiw-card:hover .hiw-glow { opacity: 1.6; filter: blur(10px); }

        /* Hover glow ring */
        .hiw-glow-ring {
            position: absolute;
            inset: -4px;
            border-radius: 20px;
            border: 2px solid rgba(16,185,129,0);
            transition: border-color 0.25s ease-out, box-shadow 0.25s ease-out;
            pointer-events: none;
        }
        .hiw-card:hover .hiw-glow-ring {
            border-color: rgba(16,185,129,0.5);
            box-shadow: 0 0 16px rgba(16,185,129,0.3);
        }

        /* Pulse ring on step 1 */
        @keyframes hiw-pulse {
            0%   { transform: scale(1);   opacity: 0.45; }
            70%  { transform: scale(1.45); opacity: 0; }
            100% { transform: scale(1.45); opacity: 0; }
        }
        .hiw-pulse-ring {
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: rgba(52,211,153,0.4);
            animation: hiw-pulse 2.2s cubic-bezier(0.22,1,0.36,1) infinite;
            pointer-events: none;
        }

        /* The badge itself */
        @keyframes hiw-badge-in {
            0%   { transform: scale(0.6); opacity: 0; }
            70%  { transform: scale(1.08); }
            100% { transform: scale(1);  opacity: 1; }
        }
        .hiw-badge {
            position: relative;
            z-index: 2;
            width: 64px; height: 64px;
            border-radius: 16px;
            background: linear-gradient(135deg, #059669 0%, #10b981 60%, #34d399 100%);
            color: #fff;
            font-weight: 900;
            font-size: 20px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 20px rgba(5,150,105,0.35);
            transition: transform 0.25s cubic-bezier(0.22,1,0.36,1), box-shadow 0.25s ease-out;
            opacity: 0;
        }
        .hiw-card.visible .hiw-badge {
            animation: hiw-badge-in 0.55s cubic-bezier(0.22,1,0.36,1) forwards;
        }
        .hiw-card:hover .hiw-badge {
            transform: scale(1.1);
            box-shadow: 0 12px 28px rgba(5,150,105,0.5);
        }

        /* ── Title & desc ────────────────────────────────────── */
        .hiw-title {
            font-weight: 700; font-size: 17px; color: #111827;
            transition: color 0.2s ease-out;
        }
        .hiw-card:hover .hiw-title { color: #047857; }
        .hiw-desc {
            font-size: 14px; color: #6b7280; margin-top: 10px; line-height: 1.65;
        }
    </style>

    <section id="how-it-works">
        <div style="max-width: 1100px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 10;">

            <div id="hiw-header">
                <span class="label">Process Flow</span>
                <h2>How E-Turismo Works</h2>
            </div>

            <div id="hiw-grid-wrap">
                <!-- SVG overlay for animated segment connectors (desktop) -->
                <svg id="hiw-svg-overlay" aria-hidden="true">
                    <defs>
                        <!-- Normal gradient -->
                        <linearGradient id="seg-grad" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%"  stop-color="#059669"/>
                            <stop offset="100%" stop-color="#34d399"/>
                        </linearGradient>
                        <!-- Hover-brightened gradient -->
                        <linearGradient id="seg-grad-bright" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%"  stop-color="#10b981"/>
                            <stop offset="100%" stop-color="#6ee7b7"/>
                        </linearGradient>
                        <!-- Soft blur for the pulse dot -->
                        <filter id="seg-blur" x="-200%" y="-200%" width="500%" height="500%">
                            <feGaussianBlur in="SourceGraphic" stdDeviation="3"/>
                        </filter>
                    </defs>

                    <!-- 3 segments, one between each adjacent card pair -->
                    <!-- positions are calculated in JS after layout -->
                    <g id="seg-0"><line class="seg-track"/><line class="seg-fill"/><circle class="seg-dot"/></g>
                    <g id="seg-1"><line class="seg-track"/><line class="seg-fill"/><circle class="seg-dot"/></g>
                    <g id="seg-2"><line class="seg-track"/><line class="seg-fill"/><circle class="seg-dot"/></g>
                </svg>

                <!-- Mobile vertical connector -->
                <div id="hiw-connector-v">
                    <div id="hiw-connector-v-fill"></div>
                </div>

                <div id="hiw-grid">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Register',   'desc' => 'Create your tourist account with government ID verification.'],
                            ['num' => '02', 'title' => 'Book',       'desc' => 'Choose a destination and submit your preferred visit date.'],
                            ['num' => '03', 'title' => 'Get Ticket', 'desc' => 'Receive your unique QR ticket once staff confirms your booking.'],
                            ['num' => '04', 'title' => 'Check In',   'desc' => 'Present your QR at the entrance. Staff scans and you\'re in!'],
                        ];
                    @endphp

                    @foreach($steps as $index => $step)
                        <div class="hiw-card" data-step="{{ $index }}">
                            <div class="hiw-badge-wrap">
                                @if($index === 0)
                                    <div class="hiw-pulse-ring"></div>
                                @endif
                                <div class="hiw-glow"></div>
                                <div class="hiw-glow-ring"></div>
                                <div class="hiw-badge">{{ $step['num'] }}</div>
                            </div>
                            <div class="hiw-title">{{ $step['title'] }}</div>
                            <p class="hiw-desc">{{ $step['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <script>
    (function () {
        var header    = document.getElementById('hiw-header');
        var cards     = Array.from(document.querySelectorAll('.hiw-card'));
        var svgEl     = document.getElementById('hiw-svg-overlay');
        var connVFill = document.getElementById('hiw-connector-v-fill');
        var segs      = [0,1,2].map(function(i){ return document.getElementById('seg-'+i); });
        var triggered = false;
        var dotAnims  = []; // store rAF handles per segment
        var reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        /* ── Compute connector geometry from card positions ─── */
        function positionSegments() {
            if (window.innerWidth < 768) return;
            var wrap = document.getElementById('hiw-grid-wrap');
            var wrapRect = wrap.getBoundingClientRect();

            // Compute Y ONCE from the first card so all 3 segments share the exact same Y.
            // Badge is 64px tall, card top-padding is 32px → badge center = 32 + 32 = 64px from card top.
            var firstRect = cards[0].getBoundingClientRect();
            var y = Math.round(firstRect.top - wrapRect.top + 32 + 32);

            for (var i = 0; i < 3; i++) {
                var leftCard  = cards[i];
                var rightCard = cards[i + 1];
                var lRect = leftCard.getBoundingClientRect();
                var rRect = rightCard.getBoundingClientRect();

                // Badge centers (card center-x = card left + half width)
                var lcx = Math.round(lRect.left - wrapRect.left + lRect.width / 2);
                var rcx = Math.round(rRect.left - wrapRect.left + rRect.width / 2);
                // Start just past the right edge of the left badge, end just before the left edge of the right badge
                var x1 = lcx + 32;
                var x2 = rcx - 32;

                var len = x2 - x1;
                var g   = segs[i];
                var track = g.querySelector('.seg-track');
                var fill  = g.querySelector('.seg-fill');
                var dot   = g.querySelector('.seg-dot');

                [track, fill].forEach(function(line) {
                    line.setAttribute('x1', x1);
                    line.setAttribute('y1', y);
                    line.setAttribute('x2', x2);
                    line.setAttribute('y2', y);
                });
                fill.style.setProperty('--seg-len', len);
                fill.setAttribute('stroke-dasharray', len);
                fill.setAttribute('stroke-dashoffset', triggered ? 0 : len);
                dot.setAttribute('cy', y);
                dot._x1 = x1; dot._x2 = x2; dot._y = y;
            }
        }

        /* ── Entrance: sequenced draw-in per segment ─────────── */
        // Timing: card 0 → seg 0 draws → card 1 → seg 1 draws → card 2 → seg 2 draws → card 3
        // Card i appears at: 120*i + 100ms
        // Segment i draw starts right after card i appears: 120*i + 100 + 300ms (card anim ~0.65s but starts immediately)
        function triggerEntrance() {
            if (triggered) return;
            triggered = true;

            header.classList.add('visible');

            cards.forEach(function(card, i) {
                setTimeout(function() { card.classList.add('visible'); }, 120 * i + 100);
            });

            // Per-segment draw-in: starts after the LEFT card of that segment has appeared
            segs.forEach(function(g, i) {
                var fill = g.querySelector('.seg-fill');
                setTimeout(function() {
                    fill.classList.add('drawn');
                    // Start ambient pulse after fill completes (0.7s transition)
                    if (!reducedMotion) {
                        setTimeout(function() { startPulse(i); }, 750);
                    }
                }, 120 * i + 100 + 350);
            });

            // Mobile vertical draw
            setTimeout(function() { connVFill.classList.add('drawn'); }, 250);
        }

        /* ── Continuous traveling pulse dot ─────────────────── */
        // Each segment has a staggered phase offset so the dot appears to flow
        // seamlessly across all 3 segments as one continuous signal.
        var PULSE_DURATION = 2200; // ms for a dot to traverse one segment
        var STAGGER = PULSE_DURATION / 3; // ~733ms offset between segments

        function startPulse(segIndex) {
            var g   = segs[segIndex];
            var dot = g.querySelector('.seg-dot');
            var startTime = null;
            var phase = segIndex * STAGGER; // stagger so it reads as one flow

            function tick(ts) {
                if (!startTime) startTime = ts - phase;
                var elapsed = (ts - startTime) % PULSE_DURATION;
                var progress = elapsed / PULSE_DURATION; // 0 → 1

                // Ease-in-out: slow start, fast middle, slow end
                var eased = progress < 0.5
                    ? 2 * progress * progress
                    : 1 - Math.pow(-2 * progress + 2, 2) / 2;

                var x = dot._x1 + (dot._x2 - dot._x1) * eased;
                dot.setAttribute('cx', x);

                // Opacity: fade in for first 15%, full for 70%, fade out for last 15%
                var opacity;
                if (progress < 0.15)      opacity = progress / 0.15 * 0.85;
                else if (progress > 0.85) opacity = (1 - progress) / 0.15 * 0.85;
                else                      opacity = 0.85;
                dot.setAttribute('opacity', opacity);

                dotAnims[segIndex] = requestAnimationFrame(tick);
            }
            dotAnims[segIndex] = requestAnimationFrame(tick);
        }

        /* ── Hover: brighten adjacent segments + speed pulse ─── */
        cards.forEach(function(card, i) {
            card.addEventListener('mouseenter', function() {
                // Segments adjacent to card i: seg i-1 and seg i
                segs.forEach(function(g, si) {
                    var fill = g.querySelector('.seg-fill');
                    var dot  = g.querySelector('.seg-dot');
                    if (si === i - 1 || si === i) {
                        fill.classList.add('hovered');
                        dot.setAttribute('r', 5);
                    }
                });
            });
            card.addEventListener('mouseleave', function() {
                segs.forEach(function(g) {
                    var fill = g.querySelector('.seg-fill');
                    var dot  = g.querySelector('.seg-dot');
                    fill.classList.remove('hovered');
                    dot.setAttribute('r', 4);
                });
            });
        });

        /* ── IntersectionObserver ────────────────────────────── */
        var observer = new IntersectionObserver(function(entries) {
            if (entries[0].isIntersecting) {
                positionSegments();
                triggerEntrance();
                observer.disconnect();
            }
        }, { threshold: 0.15 });
        observer.observe(document.getElementById('how-it-works'));

        // Recompute geometry on resize
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(positionSegments, 100);
        });
    })();
    </script>
</body>

</html>