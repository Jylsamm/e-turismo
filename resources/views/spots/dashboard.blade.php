<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 w-full">
            <h1 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <i class="ti ti-chart-bar text-green-700"></i> Spot Management Dashboard
            </h1>

            {{-- Spot Selector Dropdown --}}
            @if(count($allSpots) > 1)
                <div class="flex items-center gap-2" x-data="{ showSpotDropdown: false }">
                    <span class="text-sm font-medium text-gray-600">Switch Spot:</span>
                    <div class="relative">
                        <!-- Dropdown Trigger Button -->
                        <button type="button" @click="showSpotDropdown = !showSpotDropdown" @click.away="showSpotDropdown = false" class="flex justify-between items-center w-52 rounded-xl border border-gray-250 bg-white px-3 py-1.5 text-sm text-gray-700 font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-green-400 shadow-sm">
                            <span class="truncate">{{ $destination->name }}</span>
                            <svg class="h-4 w-4 text-gray-500 transform transition-transform duration-200 shrink-0 ml-1" :class="showSpotDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="showSpotDropdown" 
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-1.5 z-40 w-52 rounded-xl bg-white border border-gray-200 shadow-xl py-1 max-h-48 overflow-y-auto"
                             style="display: none;">
                             @foreach($allSpots as $spot)
                                <a href="{{ route('spots.dashboard', $spot->id) }}" class="block px-3.5 py-2 text-sm text-left hover:bg-green-50/40 hover:text-green-950 transition-colors {{ $destination->id === $spot->id ? 'bg-green-50 text-green-700 font-bold' : 'text-gray-700' }}">
                                    {{ $spot->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .tab-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 4px;
            font-size: 14px;
            font-weight: 500;
            color: #4b5563;
            border-bottom: 2px solid transparent;
            text-decoration: none;
        }

        .tab-link.active {
            color: #15803d;
            border-color: #15803d;
            font-weight: 600;
        }
    </style>

    <div class="pb-8 pt-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Sub-Navigation Tabs -->
        <div class="flex flex-wrap items-center gap-3 border-b border-gray-200 pb-3 w-full">
            <div class="flex gap-2">
                <a href="{{ route('spots.index') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.index') || request()->routeIs('spots.dashboard') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-chart-bar mr-1 text-lg"></i> <span>Spot Status</span>
                </a>
                <a href="{{ route('spots.edit', $destination->id) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.edit') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-edit mr-1 text-lg"></i> <span>Edit Details</span>
                </a>
            </div>

            <a href="{{ route('checkins.create') }}"
                class="ml-auto px-4 py-2 text-sm font-bold rounded-xl bg-green-700 hover:bg-green-800 text-white shadow-md shadow-green-700/15 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center gap-1.5">
                <i class="ti ti-qrcode text-lg"></i> <span>Scan Tickets</span>
            </a>
        </div>

        {{-- Flash Messages & 403 Access Restriction Alerts --}}
        @if(session('warning'))
            <div class="bg-amber-50 border border-amber-300 text-amber-950 px-5 py-4 rounded-2xl flex items-start gap-3.5 shadow-sm animate-fade-in">
                <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-amber-100 text-amber-800 shrink-0 border border-amber-200">
                    <i class="ti ti-shield-lock text-lg"></i>
                </span>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-bold text-amber-900">Access Restricted (1 Staff = 1 Spot Policy)</h3>
                    <p class="text-xs text-amber-800 mt-0.5">{{ session('warning') }}</p>
                </div>
            </div>
        @endif
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-xs">
                <i class="ti ti-circle-check" style="font-size:18px;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-xl text-sm shadow-xs">
                @foreach($errors->all() as $error)
                    <p class="flex items-center gap-1"><i class="ti ti-alert-circle"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- Tab 1: Spot Status Dashboard --}}
        <div class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Occupancy Section --}}
                <div class="interactive-card p-6 lg:col-span-1 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-lg font-bold text-gray-800">Spot Occupancy Overview</h2>
                                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                    <i class="ti ti-map-pin text-green-700"></i> {{ $destination->name }}
                                </p>
                            </div>
                            @if($isFull)
                                <span
                                    class="bg-red-100 text-red-800 text-xs px-2.5 py-1 rounded-full font-semibold flex items-center gap-1">
                                    <i class="ti ti-ban"></i> Full
                                </span>
                            @else
                                <span
                                    class="bg-green-100 text-green-800 text-xs px-2.5 py-1 rounded-full font-semibold flex items-center gap-1">
                                    <i class="ti ti-circle-check"></i> Open
                                </span>
                            @endif
                        </div>

                        <div class="my-6 text-center">
                            <div class="text-5xl font-extrabold text-gray-900">{{ $currentVisitors }}</div>
                            <div class="text-sm font-medium text-gray-600 mt-1">Active Visitors</div>
                            <div class="text-xs text-gray-500">of {{ $maxCapacity }} Max Capacity</div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold text-gray-600 mb-1">
                            <span>Occupancy Rate</span>
                            <span>{{ $occupancyPct }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-3">
                            <div class="h-3 rounded-full {{ $occupancyPct >= 90 ? 'bg-red-600' : ($occupancyPct >= 70 ? 'bg-yellow-500' : 'bg-green-600') }}"
                                style="width: {{ $occupancyPct }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Stats Cards Grid --}}
                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="interactive-card p-5 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-2xl shrink-0">
                            <i class="ti ti-users"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $totalVisitorsToday }}</div>
                            <div class="text-sm font-medium text-gray-600">Total Visitors Today</div>
                        </div>
                    </div>

                    <div class="interactive-card p-5 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600 text-2xl shrink-0">
                            <i class="ti ti-clock"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-gray-900">{{ $peakHour ?? 'N/A' }}</div>
                            <div class="text-sm font-medium text-gray-600">Peak Hours (Today)</div>
                        </div>
                    </div>

                    <div class="interactive-card p-5 flex items-center gap-4 group relative cursor-help">
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-2xl shrink-0">
                            <i class="ti ti-hourglass-low"></i>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-purple-700">Coming Soon</div>
                            <div class="text-sm font-medium text-gray-600">Avg Visit Duration</div>
                        </div>
                        <!-- Tooltip -->
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 bg-gray-900 text-white text-xs rounded-lg py-2 px-3 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-lg z-50 text-center">
                            Duration analytics tracking will be enabled in a future release.
                        </div>
                    </div>

                    <div class="interactive-card p-5 flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-2xl shrink-0">
                            <i class="ti ti-trending-up"></i>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $conversionRate }}%</div>
                            <div class="text-sm font-medium text-gray-600">Booking Conversion Rate</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Booking History Section --}}
            <div class="interactive-card overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-history text-gray-500" style="font-size:20px;"></i>
                        <h2 class="font-semibold text-gray-700">Today's Booking & Check-In History</h2>
                    </div>
                    <div>
                        <a href="?sort={{ $sortDir === 'asc' ? 'desc' : 'asc' }}"
                            aria-label="Sort bookings by check-in time, current order: {{ strtoupper($sortDir) }}"
                            class="text-xs font-semibold text-green-700 hover:text-green-800 flex items-center gap-1">
                            <i class="ti ti-arrows-sort"></i> Sort by Time ({{ strtoupper($sortDir) }})
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                    Booking ID</th>
                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                    Visitor Name</th>
                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                    Check-In Time</th>
                                <th
                                    class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($bookingHistory as $booking)
                                <tr>
                                    <td class="px-5 py-4 text-gray-500 font-mono">#{{ $booking->id }}</td>
                                    <td class="px-5 py-4 text-gray-800 font-medium">
                                        {{ $booking->tourist?->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-5 py-4 text-gray-500">
                                        {{ $booking->checked_in_at ? \Carbon\Carbon::parse($booking->checked_in_at)->format('g:i A') : 'Not Checked In' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold
                                                    {{ $booking->status === 'completed' ? 'bg-blue-50 text-blue-700' : '' }}
                                                    {{ $booking->status === 'confirmed' ? 'bg-green-50 text-green-700' : '' }}
                                                    {{ $booking->status === 'pending' ? 'bg-yellow-50 text-yellow-700' : '' }}
                                                    {{ $booking->status === 'declined' ? 'bg-red-50 text-red-700' : '' }}
                                                ">
                                            @if($booking->status === 'completed')
                                                <i class="ti ti-circle-check"></i> Completed
                                            @elseif($booking->status === 'confirmed')
                                                <i class="ti ti-checkbox"></i> Confirmed
                                            @elseif($booking->status === 'pending')
                                                <i class="ti ti-clock"></i> Pending
                                            @else
                                                <i class="ti ti-x"></i> Declined
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-gray-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <i class="ti ti-inbox" style="font-size:28px;"></i>
                                            <span class="text-sm">No bookings recorded for today.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>