<x-app-layout>
    <x-slot name="header">
<<<<<<< Updated upstream
        <h1 class="flex items-center gap-2 text-2xl font-bold text-gray-800">
            Welcome back, {{ auth()->user()->name }}!
            <svg class="w-6 h-6 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/><path d="M6 14v-1.5a2 2 0 0 1 2-2v0a2 2 0 0 1 2 2v0"/></svg>
        </h1>
=======
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5 font-medium">Manage your eco-tours, active entry passes, and upcoming adventures.</p>
            </div>
            <div>
                <a href="{{ route('destinations.index') }}"
                   class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M8 16l2 -6l6 -2l-2 6l-6 2" />
  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
  <path d="M12 3l0 2" />
  <path d="M12 19l0 2" />
  <path d="M3 12l2 0" />
  <path d="M19 12l2 0" />
</svg>
                    <span>Explore Destinations</span>
                </a>
            </div>
        </div>
>>>>>>> Stashed changes
    </x-slot>

    <div id="tourist-dashboard-root" class="opacity-0 transition-opacity duration-700 ease-out pb-8 pt-0 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
<<<<<<< Updated upstream
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
=======
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-4 py-3 rounded-2xl shadow-xs flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
  <path d="M9 12l2 2l4 -4" />
</svg>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
>>>>>>> Stashed changes
        @endif

        {{-- Verification Banner --}}
        @php
            $status = auth()->user()->id_verification_status ?? 'unverified';
            // Pending/processing: show full banner only on first dashboard visit per session
            $pendingBannerSeen = session()->has('pending_banner_seen');
            if (in_array($status, ['pending', 'processing']) && !$pendingBannerSeen) {
                session(['pending_banner_seen' => true]);
            }
        @endphp

<<<<<<< Updated upstream
        @if($status === 'processing')
            {{-- Shown immediately after registration while OCR runs in background --}}
            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 rounded-r-lg shadow-sm" id="verification-banner">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-indigo-500 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                            </svg>
=======
        @if(!$isVerified)
            <div class="bg-gradient-to-r from-amber-50 to-orange-50/80 border border-amber-200/90 rounded-2xl p-5 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 border border-amber-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M7 12h3v4h-3l0 -4" />
  <path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" />
  <path d="M10 4a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1l0 -3" />
  <path d="M14 16h2" />
  <path d="M14 12h4" />
</svg>
>>>>>>> Stashed changes
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-indigo-800">Your ID is being verified…</h3>
                            <p class="text-sm text-indigo-700 mt-1">This usually takes under a minute. Refresh the page to check the latest status.</p>
                        </div>
                    </div>
                    <div>
<<<<<<< Updated upstream
                        <button onclick="window.location.reload()" class="text-sm font-semibold text-indigo-800 hover:text-indigo-600 bg-indigo-100 px-3 py-1.5 rounded-lg border border-indigo-200">Refresh ↻</button>
                    </div>
                </div>
            </div>
        @elseif($status === 'unverified')
            {{-- Always show — user needs to act --}}
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-sm" id="verification-banner">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">You're not verified yet.</h3>
                            <p class="text-sm text-yellow-700 mt-1">Verify your identity to unlock bookings.</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}#verification" class="text-sm font-semibold text-yellow-800 hover:text-yellow-600 bg-yellow-100 px-3 py-1.5 rounded-lg border border-yellow-200">Verify Now &rarr;</a>
                    </div>
                </div>
            </div>
        @elseif($status === 'pending')
            {{-- First visit this session: full banner; subsequent visits: small badge only --}}
            @if(!$pendingBannerSeen)
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg shadow-sm" id="verification-banner">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400 animate-pulse" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Your ID is under review.</h3>
                                <p class="text-sm text-blue-700 mt-1">This usually takes up to 24 hours.</p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('profile.edit') }}#verification" class="text-sm font-semibold text-blue-800 hover:text-blue-600 bg-blue-100 px-3 py-1.5 rounded-lg border border-blue-200">View Status</a>
                        </div>
                    </div>
                </div>
            @else
                {{-- Subsequent visits: collapsed to a quiet pill badge in the header area --}}
                <div class="flex items-center gap-2 text-xs text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full w-fit">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    ID under review &middot; <a href="{{ route('profile.edit') }}#verification" class="underline font-medium">View Status</a>
                </div>
            @endif
        @elseif($status === 'rejected')
            {{-- Always show — user needs to retry --}}
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg shadow-sm" id="verification-banner">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">We couldn't verify your ID.</h3>
                            <p class="text-sm text-red-700 mt-1">Please try again to unlock bookings.</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}#verification" class="text-sm font-semibold text-red-800 hover:text-red-600 bg-red-100 px-3 py-1.5 rounded-lg border border-red-200">Retry Verification</a>
=======
                        <a href="{{ route('profile.edit') }}#verification" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 bg-amber-200/90 hover:bg-amber-300 px-4 py-2 rounded-xl border border-amber-300 transition-all duration-200 shadow-2xs">
                            <span>Check Status</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M5 12l14 0" />
  <path d="M13 18l6 -6" />
  <path d="M13 6l6 6" />
</svg>
                        </a>
>>>>>>> Stashed changes
                    </div>
                </div>
            </div>
        @endif

<<<<<<< Updated upstream

        {{-- Notifications --}}
        @if($notifications->count())
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
            <h2 class="font-semibold text-blue-800 mb-2 flex items-center gap-1.5"><i class="ti ti-bell-ringing"></i> Your Notifications</h2>
            <ul class="space-y-1">
                @foreach($notifications as $notif)
                <li class="text-sm text-blue-900">{{ $notif->message }}</li>
                @endforeach
            </ul>
            <form action="{{ route('notifications.read-all') }}" method="POST" class="mt-3">
                @csrf
                <button class="text-xs text-blue-600 underline">Mark all as read</button>
            </form>
        </div>
        @endif

        {{-- Explore Destinations CTA --}}
        <div class="bg-et-gradient rounded-2xl p-8 text-white flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Explore Tourist Destinations</h2>
                <p class="text-brand-100 mt-1">Browse available destinations and book your next adventure.</p>
=======
        {{-- 1. Unified Summary Metrics Rail (Eliminating Floating Stat Islands) --}}
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 overflow-hidden">
            <!-- Active Passes -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M15 5l0 2" />
  <path d="M15 11l0 2" />
  <path d="M15 17l0 2" />
  <path d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
</svg>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Active Passes</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['confirmed'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Ready</span>
                    </div>
                </div>
            </div>

            <!-- Pending Review -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
  <path d="M12 12l3 2" />
  <path d="M12 7v5" />
</svg>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Pending Review</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['pending'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Review</span>
                    </div>
                </div>
            </div>

            <!-- Unpaid Bookings -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center shrink-0 border border-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M3 3l18 18" />
  <path d="M9 5h9a3 3 0 0 1 3 3v8a3 3 0 0 1 -.128 .87" />
  <path d="M18.87 18.872a3 3 0 0 1 -.87 .128h-12a3 3 0 0 1 -3 -3v-8c0 -1.352 .894 -2.495 2.124 -2.87" />
  <path d="M3 11l8 0" />
  <path d="M15 11l6 0" />
  <path d="M7 15l.01 0" />
  <path d="M11 15l2 0" />
</svg>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Unpaid</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['unpaid'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full">Unpaid</span>
                    </div>
                </div>
            </div>

            <!-- Places Visited -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
  <path d="M11.87 21.48a1.992 1.992 0 0 1 -1.283 -.58l-4.244 -4.243a8 8 0 1 1 13.355 -3.474" />
  <path d="M15 19l2 2l4 -4" />
</svg>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Places Visited</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['completed'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full">Visited</span>
                    </div>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 3h3l2 2h5a2 2 0 0 1 2 2v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2" />
  <path d="M17 16v2a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2" />
</svg>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Total Bookings</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['total'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">History</span>
                    </div>
                </div>
>>>>>>> Stashed changes
            </div>
            <a href="{{ route('destinations.index') }}"
                class="bg-white text-brand-900 font-semibold px-6 py-3 rounded-xl hover:bg-brand-50 transition text-sm">
                Browse Destinations →
            </a>
        </div>

<<<<<<< Updated upstream
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- My Bookings --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h2 class="font-semibold text-gray-700">My Bookings</h2>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-brand-700 hover:underline">View all →</a>
=======
        {{-- Notifications Accordion / Box --}}
        @if($notifications->count())
            <div class="bg-white border border-gray-200/90 rounded-2xl p-5 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between gap-3 mb-3 border-b border-gray-100 pb-2.5">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
  <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
  <path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" />
  <path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />
</svg>
                        </span>
                        <span>Your Notifications</span>
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full font-mono">{{ $notifications->count() }}</span>
                    </h2>
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 text-xs text-emerald-700 hover:text-emerald-900 font-bold hover:underline transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-emerald-600 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M7 12l5 5l10 -10" />
  <path d="M2 12l5 5m5 -5l5 -5" />
</svg> Mark all as read
                        </button>
                    </form>
>>>>>>> Stashed changes
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($myBookings as $booking)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ $booking->destination?->name }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->visit_date }}</p>
                            @if($booking->ticket)
                            <p class="text-xs mt-0.5">
                                <a href="{{ route('tickets.show', $booking->ticket) }}" class="text-brand-700 font-mono hover:underline inline-flex items-center gap-1">
                                    <span>View QR: {{ $booking->ticket->qr_code }}</span>
                                </a>
                            </p>
                            @endif
                        </div>
                        @php
                        $colors = ['pending'=>'yellow','confirmed'=>'green','declined'=>'red','completed'=>'blue'];
                        $c = $colors[$booking->status] ?? 'gray';
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $c }}-100 text-{{ $c }}-700 capitalize">{{ $booking->status }}</span>
                    </li>
                    @empty
                    <li class="px-6 py-8 text-center text-gray-400 text-sm">No bookings yet. Start exploring!</li>
                    @endforelse
                </ul>
            </div>

<<<<<<< Updated upstream
            {{-- Suggested Destinations --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h2 class="font-semibold text-gray-700">Suggested Destinations</h2>
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($destinations as $dest)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ $dest->name }}</p>
                            <p class="text-xs text-gray-400">{{ $dest->location }}</p>
=======
        {{-- 2. Main Asymmetric 2-Column Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            {{-- Left Column (7 cols): My Bookings & Digital Passes --}}
            <div class="lg:col-span-7 bg-white rounded-3xl shadow-sm border border-gray-200/90 overflow-hidden flex flex-col h-full card-hover-effect">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/80 to-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2l0 -12" />
  <path d="M16 3l0 4" />
  <path d="M8 3l0 4" />
  <path d="M4 11l16 0" />
  <path d="M8 15h2v2h-2l0 -2" />
</svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-sm sm:text-base">Recent Bookings</h2>
                            <p class="text-[11px] text-gray-400">Your reservation schedule and active passes</p>
                        </div>
                    </div>
                    @if($isVerified)
                        <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 hover:underline inline-flex items-center gap-1">
                            <span>View all</span>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 6l6 6l-6 6" />
</svg>
                        </a>
                    @else
                        <span class="text-xs text-gray-400 font-medium">Locked 🔒</span>
                    @endif
                </div>

                <div class="flex-1 divide-y divide-gray-100">
                    @forelse($myBookings as $booking)
                        @php
                            $isConfirmed = $booking->status === 'confirmed';
                            $isCompleted = $booking->status === 'completed';
                            $isPending = $booking->status === 'pending';
                            $qrCodeToken = $booking->ticket?->qr_code ?? $booking->qr_token;
                            $ticketId = $booking->ticket?->id ?? $booking->id;

                            $badgeMap = [
                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/80'],
                                'confirmed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200/80'],
                                'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'border' => 'border-gray-200'],
                                'declined' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200/80'],
                                'completed' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'border' => 'border-indigo-200/80'],
                            ];
                            $style = $badgeMap[$booking->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200'];
                        @endphp

                        <div class="p-5 hover:bg-emerald-50/20 transition-all duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 {{ $isConfirmed ? 'bg-emerald-50/10' : '' }}">
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-bold text-gray-900 text-sm sm:text-base tracking-tight truncate">{{ $booking->destination?->name }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border capitalize {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 font-medium">
                                    <span class="inline-flex items-center gap-1 font-mono text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-emerald-600 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
  <path d="M16 3v4" />
  <path d="M8 3v4" />
  <path d="M4 11h16" />
  <path d="M11 15h1" />
  <path d="M12 15v3" />
</svg>
                                        {{ date('M d, Y', strtotime($booking->visit_date)) }}
                                    </span>
                                    <span>•</span>
                                    <span class="text-[11px] text-gray-400 font-mono">Booked {{ $booking->created_at->diffForHumans() }}</span>
                                </div>

                                @if($qrCodeToken && $isVerified && $booking->status !== 'declined' && $booking->payment_status !== 'rejected')
                                    <!-- Hidden SVG Template for QR Download -->
                                    <div id="qr-svg-{{ $qrCodeToken }}" class="hidden">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qrCodeToken) !!}
                                    </div>
                                    <div class="pt-1">
                                        <button type="button" @click="openQrModal('{{ $qrCodeToken }}', '{{ e($booking->destination?->name) }}', '{{ e($booking->destination?->location) }}', '{{ date('M j, Y', strtotime($booking->visit_date)) }}', '{{ e($booking->tourist?->name ?? auth()->user()->name) }}', '{{ url('/tickets/' . $ticketId) }}')"
                                            class="text-emerald-800 font-mono font-bold hover:text-emerald-950 inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-xl text-xs transition-all duration-200 cursor-pointer shadow-2xs">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-emerald-700 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M4 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
  <path d="M7 17l0 .01" />
  <path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
  <path d="M7 7l0 .01" />
  <path d="M4 15a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1l0 -4" />
  <path d="M17 7l0 .01" />
  <path d="M14 14l3 0" />
  <path d="M20 14l0 .01" />
  <path d="M14 14l0 3" />
  <path d="M14 20l3 0" />
  <path d="M17 17l3 0" />
  <path d="M20 17l0 3" />
</svg>
                                            <span>Scan Pass: {{ $qrCodeToken }}</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-gray-600 hover:text-emerald-800 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-200 px-3 py-1.5 rounded-xl transition-all inline-flex items-center gap-1">
                                    <span>Details</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M17 7l-10 10" />
  <path d="M8 7l9 0l0 9" />
</svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 5h9a2 2 0 0 1 2 2v9m-.184 3.839a2 2 0 0 1 -1.816 1.161h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 1.158 -1.815" />
  <path d="M16 3v4" />
  <path d="M8 3v1" />
  <path d="M4 11h7m4 0h5" />
  <path d="M3 3l18 18" />
</svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">No bookings yet</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Ready for your next trip? Discover destinations and reserve your slot.</p>
                            </div>
                            <div class="pt-1">
                                <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3.5 py-2 rounded-xl hover:bg-emerald-100 transition-colors">
                                    <span>Browse Spots</span> &rarr;
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Right Column (5 cols): Suggested Destinations with Media-First Visual Cards & Most Visited UI --}}
            <div class="lg:col-span-5 bg-white rounded-3xl shadow-sm border border-gray-200/90 overflow-hidden flex flex-col h-full card-hover-effect {{ !$isVerified ? 'opacity-75' : '' }}">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/80 to-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center border border-teal-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M8 16l2 -6l6 -2l-2 6l-6 2" />
  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
  <path d="M12 3l0 2" />
  <path d="M12 19l0 2" />
  <path d="M3 12l2 0" />
  <path d="M19 12l2 0" />
</svg>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-sm sm:text-base leading-snug">Suggested Destinations</h2>
                            <p class="text-[11px] text-gray-400 leading-relaxed mt-0.5">Top eco-tourism attractions in Tigbao</p>
                        </div>
                    </div>
                    <a href="{{ route('destinations.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 hover:underline inline-flex items-center gap-1">
                        <span>All Spots</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 6l6 6l-6 6" />
</svg>
                    </a>
                </div>

                <div class="flex-1 divide-y divide-gray-100">
                    @forelse($destinations as $dest)
                        @php
                            $isTopVisited = $loop->first && ($dest->visits_count > 0 || $loop->count > 1);
                        @endphp
                        <div class="p-4 sm:p-5 hover:bg-teal-50/20 transition-all duration-150 flex items-center gap-3.5 {{ $isTopVisited ? 'bg-gradient-to-r from-amber-50/40 via-emerald-50/20 to-transparent' : '' }}">
                            <!-- Visual Destination Thumbnail with Badge -->
                            <a href="{{ route('destinations.show', $dest) }}" class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl overflow-hidden shrink-0 bg-emerald-100 border {{ $isTopVisited ? 'border-amber-300 ring-2 ring-amber-400/20' : 'border-gray-200' }} shadow-2xs relative block group/img">
                                @if($dest->photos)
                                    <img src="{{ asset('storage/' . $dest->photos) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover/img:scale-105">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 opacity-80 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M16 5l3 3l-2 1l4 4l-3 1l4 4h-9" />
  <path d="M15 21l0 -3" />
  <path d="M8 13l-2 -2" />
  <path d="M8 12l2 -2" />
  <path d="M8 21v-13" />
  <path d="M5.824 16a3 3 0 0 1 -2.743 -3.69a3 3 0 0 1 .304 -4.833a3 3 0 0 1 4.615 -3.707a3 3 0 0 1 4.614 3.707a3 3 0 0 1 .305 4.833a3 3 0 0 1 -2.919 3.695h-4l-.176 -.005" />
</svg>
                                    </div>
                                @endif

                                @if($isTopVisited)
                                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent py-0.5 px-1 text-center">
                                        <span class="text-[9px] font-black text-amber-300 uppercase tracking-tighter">★ Top Pick</span>
                                    </div>
                                @endif
                            </a>

                            <!-- Destination Details -->
                            <div class="space-y-1 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <a href="{{ route('destinations.show', $dest) }}" class="font-bold text-gray-900 text-sm sm:text-base tracking-tight truncate hover:text-emerald-700 transition-colors">
                                        {{ $dest->name }}
                                    </a>
                                    @if($isTopVisited)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-amber-800 bg-amber-100/80 border border-amber-300/80 px-2 py-0.5 rounded-full shadow-2xs">
                                            <span>🔥 Most Visited</span>
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 flex items-center gap-1 truncate">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-emerald-600 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
  <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
</svg>
                                    <span class="truncate">{{ $dest->location }}</span>
                                </p>
                                
                                <div class="flex flex-wrap items-center gap-2 pt-0.5">
                                    @if($dest->capacity > 0)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-md font-mono">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-[10px] text-gray-500 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
  <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
  <path d="M16 3.13a4 4 0 0 1 0 7.75" />
  <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
</svg> {{ $dest->capacity }} max/day
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action -->
                            <div class="shrink-0">
                                @if($isVerified)
                                    <a href="{{ route('destinations.show', $dest) }}"
                                       class="text-xs bg-emerald-700 hover:bg-emerald-800 text-white px-3.5 py-2 rounded-xl font-bold shadow-xs hover:shadow transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center gap-1 cursor-pointer">
                                        <span>Book</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M5 12l14 0" />
  <path d="M13 18l6 -6" />
  <path d="M13 6l6 6" />
</svg>
                                    </a>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded-xl font-medium cursor-not-allowed pointer-events-none select-none">
                                        Locked 🔒
                                    </span>
                                @endif
                            </div>
>>>>>>> Stashed changes
                        </div>
                        <a href="{{ route('bookings.create', $dest) }}"
                            class="text-xs bg-brand-100 text-brand-700 px-3 py-1.5 rounded-full font-medium hover:bg-brand-200 transition">
                            Book Now
                        </a>
                    </li>
                    @empty
                    <li class="px-6 py-8 text-center text-gray-400 text-sm">No destinations registered yet.</li>
                    @endforelse
<<<<<<< Updated upstream
                </ul>
=======
                </div>
            </div>
        </div>

        <!-- In-Dashboard Quick QR View & Download Modal -->
        <div x-show="showQrModal" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/75 backdrop-blur-md overflow-hidden"
            style="display: none;">
            
            <div @click.away="closeQrModal()" class="relative w-full max-w-md sm:max-w-lg h-full max-h-[550px] flex flex-col bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
                <!-- Modal Header (Pinned top) -->
                <div class="shrink-0 px-5 py-4 flex items-center justify-between relative overflow-hidden rounded-t-3xl border-b border-emerald-900/20" style="background: linear-gradient(135deg, #052e16 0%, #14532d 50%, #047857 100%); color: #ffffff;">
                    <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full pointer-events-none" style="background: rgba(255, 255, 255, 0.1); filter: blur(16px);"></div>
                    <div>
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 shrink-0" style="color: #a7f3d0;">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M11.46 20.846a12 12 0 0 1 -7.96 -14.846a12 12 0 0 0 8.5 -3a12 12 0 0 0 8.5 3a12 12 0 0 1 -.09 7.06" />
  <path d="M15 19l2 2l4 -4" />
</svg> Digital Entry Pass
                        </span>
                        <h3 class="text-lg sm:text-xl font-black tracking-tight mt-1" style="color: #ffffff;" x-text="qrData.destination"></h3>
                        <p class="text-[11px] flex items-center gap-1 mt-0.5" style="color: #d1fae5;">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 shrink-0" style="color: #6ee7b7;">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
  <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
</svg>
                            <span x-text="qrData.location"></span>
                        </p>
                    </div>
                    <button type="button" @click="closeQrModal()" class="p-2 rounded-xl transition cursor-pointer" style="background: rgba(255, 255, 255, 0.15); color: #ffffff;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M18 6l-12 12" />
  <path d="M6 6l12 12" />
</svg>
                    </button>
                </div>

                <!-- Modal Content Body (Scrolls internally if screen is small) -->
                <div class="overflow-y-auto flex-1 p-5 text-center space-y-4 custom-modal-scroll">
                    <!-- QR Frame Container -->
                    <div id="dashboard-modal-qr-frame" class="inline-block p-3.5 bg-slate-50 border-2 border-emerald-100 rounded-2xl shadow-inner relative group">
                        <div id="dashboard-modal-qr-render" class="bg-white p-1.5 rounded-xl"></div>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-extrabold tracking-wider">Pass Reference Code</p>
                        <p class="text-2xl font-mono font-black text-emerald-950 tracking-wider mt-0.5" x-text="qrData.code"></p>
                    </div>

                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-2 gap-2.5 text-left bg-slate-50/80 p-3 rounded-2xl border border-slate-150">
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Visitor</span>
                            <p class="text-xs font-black text-slate-900 truncate mt-0.5" x-text="qrData.visitorName"></p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Scheduled Visit</span>
                            <p class="text-xs font-black text-slate-900 mt-0.5" x-text="qrData.visitDate"></p>
                        </div>
                    </div>

                    <!-- Simple Entrance Reminders Box -->
                    <div class="text-left bg-amber-50/90 border border-amber-200/90 rounded-2xl p-3.5 shadow-xs">
                        <div class="flex items-center gap-1.5 mb-1 text-amber-950 font-bold text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-amber-600 shrink-0">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M12 1.67c.955 0 1.845 .467 2.39 1.247l.105 .16l8.114 13.548a2.914 2.914 0 0 1 -2.307 4.363l-.195 .008h-16.225a2.914 2.914 0 0 1 -2.582 -4.2l.099 -.185l8.11 -13.538a2.914 2.914 0 0 1 2.491 -1.403zm.01 13.33l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007zm-.01 -7a1 1 0 0 0 -.993 .883l-.007 .117v4l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4l-.007 -.117a1 1 0 0 0 -.993 -.883z" />
</svg>
                            <span>Entrance Check-in Reminders</span>
                        </div>
                        <ul class="space-y-1 text-[11px] text-amber-900/90 font-medium leading-relaxed">
                            <li class="flex items-start gap-1.5">
                                <span class="text-amber-600 font-bold">•</span>
                                <span>Present this QR code to staff at the entrance checkpoint.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-amber-600 font-bold">•</span>
                                <span>Download or screenshot this pass for offline gate entry.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Modal Actions Footer (Pinned bottom) -->
                <div class="shrink-0 bg-gray-50 px-5 py-3.5 flex items-center gap-3 border-t border-gray-150">
                    <button type="button" @click="downloadModalFormattedQR()"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 font-bold py-2.5 px-4 rounded-xl text-xs uppercase tracking-wider transition shadow-md cursor-pointer" style="background: linear-gradient(135deg, #059669 0%, #16a34a 100%); color: #ffffff;">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 shrink-0" style="color: #ffffff;">
  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
  <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
  <path d="M7 11l5 5l5 -5" />
  <path d="M12 4l0 12" />
</svg>
                        <span style="color: #ffffff;">Download QR Pass</span>
                    </button>
                    <button type="button" @click="closeQrModal()" class="px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Close
                    </button>
                </div>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>

    <style>
        .dashboard-welcome-flash {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0b3d2e 0%, #061810 100%);
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .dashboard-welcome-flash.fade-out {
            opacity: 0;
        }
    </style>
    <div id="welcome-flash" class="dashboard-welcome-flash" style="display: none;">
        <div class="text-center px-4">
            <h2 class="text-3xl font-black text-white tracking-tight">E-Turismo</h2>
            <p class="text-emerald-400 text-sm mt-2">Setting up your profile...</p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const flash = document.getElementById('welcome-flash');
            const root = document.getElementById('tourist-dashboard-root');
            
            const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            
            if (sessionStorage.getItem('just_registered') === 'true') {
                sessionStorage.removeItem('just_registered'); // clear it
                
                if (reducedMotion) {
                    if (root) root.classList.remove('opacity-0');
                    return;
                }
                
                if (flash) {
                    flash.style.display = 'flex';
                    setTimeout(() => {
                        flash.classList.add('fade-out');
                        if (root) root.classList.remove('opacity-0');
                    }, 1200);
                    setTimeout(() => {
                        flash.remove();
                    }, 2000);
                }
            } else {
                // Regular load
                if (root) {
                    root.style.transition = 'opacity 0.25s ease-out';
                    root.classList.remove('opacity-0');
                }
            }
        });
    </script>
</x-app-layout>
