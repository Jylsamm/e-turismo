<x-app-layout>
    <x-slot name="header">
        <h1 class="flex items-center gap-2 text-2xl font-bold text-gray-800">
            Welcome back, {{ auth()->user()->name }}!
            <svg class="w-6 h-6 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/><path d="M6 14v-1.5a2 2 0 0 1 2-2v0a2 2 0 0 1 2 2v0"/></svg>
        </h1>
    </x-slot>

    <div id="tourist-dashboard-root" class="opacity-0 transition-opacity duration-700 ease-out pb-8 pt-0 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
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
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-indigo-800">Your ID is being verified…</h3>
                            <p class="text-sm text-indigo-700 mt-1">This usually takes under a minute. Refresh the page to check the latest status.</p>
                        </div>
                    </div>
                    <div>
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
                    </div>
                </div>
            </div>
        @endif


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
            </div>
            <a href="{{ route('destinations.index') }}"
                class="bg-white text-brand-900 font-semibold px-6 py-3 rounded-xl hover:bg-brand-50 transition text-sm">
                Browse Destinations →
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- My Bookings --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h2 class="font-semibold text-gray-700">My Bookings</h2>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-brand-700 hover:underline">View all →</a>
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
                        </div>
                        <a href="{{ route('bookings.create', $dest) }}"
                            class="text-xs bg-brand-100 text-brand-700 px-3 py-1.5 rounded-full font-medium hover:bg-brand-200 transition">
                            Book Now
                        </a>
                    </li>
                    @empty
                    <li class="px-6 py-8 text-center text-gray-400 text-sm">No destinations registered yet.</li>
                    @endforelse
                </ul>
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
