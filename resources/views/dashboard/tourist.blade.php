<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Welcome back, {{ auth()->user()->name }}! 👋</h1>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">{{ session('success') }}</div>
        @endif

        {{-- Verification Banner --}}
        @php
            $status = auth()->user()->id_verification_status ?? 'unverified';
            // Pending: show full banner only on first dashboard visit per session
            $pendingBannerSeen = session()->has('pending_banner_seen');
            if ($status === 'pending' && !$pendingBannerSeen) {
                session(['pending_banner_seen' => true]);
            }
        @endphp

        @if($status === 'unverified')
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
            <h2 class="font-semibold text-blue-800 mb-2">🔔 Your Notifications</h2>
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
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Explore Tourist Destinations</h2>
                <p class="text-indigo-200 mt-1">Browse available destinations and book your next adventure.</p>
            </div>
            <a href="{{ route('destinations.index') }}"
                class="bg-white text-indigo-700 font-semibold px-6 py-3 rounded-xl hover:bg-indigo-50 transition text-sm">
                Browse Destinations →
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- My Bookings --}}
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between">
                    <h2 class="font-semibold text-gray-700">My Bookings</h2>
                    <a href="{{ route('bookings.index') }}" class="text-sm text-indigo-600 hover:underline">View all →</a>
                </div>
                <ul class="divide-y divide-gray-100">
                    @forelse($myBookings as $booking)
                    <li class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800">{{ $booking->destination?->name }}</p>
                            <p class="text-xs text-gray-400">{{ $booking->visit_date }}</p>
                            @if($booking->ticket)
                            <p class="text-xs mt-0.5">
                                <a href="{{ route('tickets.show', $booking->ticket) }}" class="text-indigo-600 font-mono hover:underline inline-flex items-center gap-1">
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
                            class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full font-medium hover:bg-indigo-200 transition">
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
</x-app-layout>
