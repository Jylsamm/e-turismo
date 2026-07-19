<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: all 0.3s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1);
            border-color: #bbf7d0;
        }
        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-label {
            font-size: 13px;
            color: #9ca3af;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .stat-value {
            font-size: 32px;
            font-weight: 600;
            line-height: 1;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.15s;
            text-decoration: none;
        }
        .action-btn-view { background: #eff6ff; color: #3b82f6; }
        .action-btn-view:hover { background: #dbeafe; }
    </style>

    <div class="pb-8 pt-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Header Summary --}}
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Operations Center</h1>
                <p class="text-sm text-gray-500 mt-1">Real-time overview of today's tourist spot activities.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('checkins.create') }}" class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-4 py-2 text-sm transition">
                    <i class="ti ti-qrcode"></i> Scan Check-In
                </a>
            </div>
        </div>

        {{-- Statistics Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            {{-- Today's Bookings --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#eff6ff;">
                        <i class="ti ti-calendar" style="color:#3b82f6;"></i>
                    </div>
                    <span class="stat-label">Today's Bookings</span>
                </div>
                <span class="stat-value" style="color:#3b82f6;">{{ $stats['todays_bookings'] }}</span>
            </div>

            {{-- Pending Bookings --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#fef3c7;">
                        <i class="ti ti-clock" style="color:#f59e0b;"></i>
                    </div>
                    <span class="stat-label">Pending</span>
                </div>
                <span class="stat-value" style="color:#f59e0b;">{{ $stats['pending_bookings'] }}</span>
            </div>

            {{-- Confirmed Bookings --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#d1fae5;">
                        <i class="ti ti-check" style="color:#10b981;"></i>
                    </div>
                    <span class="stat-label">Confirmed</span>
                </div>
                <span class="stat-value" style="color:#10b981;">{{ $stats['confirmed_bookings'] }}</span>
            </div>

            {{-- Today's Check-ins --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#e0f2fe;">
                        <i class="ti ti-user-check" style="color:#0284c7;"></i>
                    </div>
                    <span class="stat-label">Check-ins</span>
                </div>
                <span class="stat-value" style="color:#0284c7;">{{ $stats['todays_checkins'] }}</span>
            </div>

            {{-- Current Visitors --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#f3e8ff;">
                        <i class="ti ti-users" style="color:#a855f7;"></i>
                    </div>
                    <span class="stat-label">Current Visitors</span>
                </div>
                <span class="stat-value" style="color:#a855f7;">{{ $stats['current_visitors'] }}</span>
            </div>

            {{-- Available Capacity --}}
            <div class="stat-card">
                <div class="flex items-center gap-3">
                    <div class="stat-icon" style="background:#ecfdf5;">
                        <i class="ti ti-gauge" style="color:#059669;"></i>
                    </div>
                    <span class="stat-label">Available Capacity</span>
                </div>
                <span class="stat-value" style="color:#059669;">{{ $stats['available_capacity_pct'] }}%</span>
            </div>
        </div>

        {{-- Bookings & Check-ins Columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Booking Requests --}}
            <div class="interactive-card overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <i class="ti ti-list-details text-gray-400" style="font-size:20px;"></i>
                        <h2 class="font-semibold text-gray-700">Recent Booking Requests</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Visitor</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Spot</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Visit Date</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wide">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentPendingBookings as $booking)
                                    <tr>
                                        <td class="px-6 py-3 font-medium text-gray-800">{{ $booking->tourist?->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $booking->destination?->name ?? '—' }}</td>
                                        <td class="px-6 py-3 text-gray-500">{{ \Illuminate\Support\Carbon::parse($booking->visit_date)->format('M j, Y') }}</td>
                                        <td class="px-6 py-3">
                                            <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">
                                                <i class="ti ti-clock" style="font-size:10px;"></i> Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-3 text-center">
                                            <a href="{{ route('staff.bookings.index') }}" class="action-btn action-btn-view" title="Quick View">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-450">
                                            <div class="flex flex-col items-center gap-2">
                                                <i class="ti ti-inbox" style="font-size:28px;"></i>
                                                <span class="text-sm">No pending booking requests</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 text-right bg-gray-50">
                    <a href="{{ route('staff.bookings.index') }}" class="text-sm font-semibold text-green-700 hover:text-green-800 inline-flex items-center gap-1">
                        Go to Bookings <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Recent Check-ins --}}
            <div class="interactive-card overflow-hidden flex flex-col justify-between">
                <div>
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                        <i class="ti ti-user-check text-gray-400" style="font-size:20px;"></i>
                        <h2 class="font-semibold text-gray-700">Recent Check-ins</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Visitor</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Spot</th>
                                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Check-in Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recentCheckIns as $checkIn)
                                    <tr>
                                        <td class="px-6 py-3 font-medium text-gray-800">{{ $checkIn->booking->tourist?->name ?? 'Unknown' }}</td>
                                        <td class="px-6 py-3 text-gray-600">{{ $checkIn->booking->destination?->name ?? '—' }}</td>
                                        <td class="px-6 py-3 text-gray-500">{{ $checkIn->arrival_time->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-gray-450">
                                            <div class="flex flex-col items-center gap-2">
                                                <i class="ti ti-inbox" style="font-size:28px;"></i>
                                                <span class="text-sm">No arrivals recorded today</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="p-4 border-t border-gray-100 text-right bg-gray-50">
                    <a href="{{ route('checkins.create') }}" class="text-sm font-semibold text-green-700 hover:text-green-800 inline-flex items-center gap-1">
                        Open Check-in Panel <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Spot Occupancy Overview --}}
        <div class="interactive-card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2">
                <i class="ti ti-gauge text-gray-400" style="font-size:20px;"></i>
                <h2 class="font-semibold text-gray-700">Spot Occupancy Overview</h2>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($spots as $spot)
                    <a href="{{ route('spots.dashboard', $spot) }}" class="block p-5 border border-gray-200 rounded-xl hover:border-green-600 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg space-y-4">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $spot->name }}</h3>
                                <p class="text-xs text-gray-400 mt-0.5"><i class="ti ti-map-pin"></i> {{ $spot->location }}</p>
                            </div>
                            @if($spot->occupancy_pct >= 100)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-red-700 bg-red-50 px-2 py-0.5 rounded-full">
                                    <i class="ti ti-circle-x-filled" style="font-size:10px;"></i> Full
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 px-2 py-0.5 rounded-full">
                                    <i class="ti ti-circle-check-filled" style="font-size:10px;"></i> Open
                                </span>
                            @endif
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs text-gray-500">
                                <span>Visitors: {{ $spot->current_visitors }} / {{ $spot->capacity }}</span>
                                <span>{{ $spot->occupancy_pct }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $spot->occupancy_pct }}%"></div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Check-In Location Map --}}
        @if($destination)
        <div class="interactive-card overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i class="ti ti-map-pin text-green-700" style="font-size:20px;"></i>
                    <h2 class="font-semibold text-gray-700">Check-In Location</h2>
                    @if($destination->checkin_latitude && $destination->checkin_longitude)
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full ml-1">
                            <i class="ti ti-point-filled" style="font-size:10px;"></i> Pin Set
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-100 px-2 py-0.5 rounded-full ml-1">
                            <i class="ti ti-alert-triangle" style="font-size:10px;"></i> Not Set
                        </span>
                    @endif
                </div>
                <a href="{{ route('spots.edit', $destination) }}"
                   class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-3 py-1.5 text-xs transition">
                    <i class="ti ti-pencil"></i> Edit Location
                </a>
            </div>

            <div class="p-6">
                @if($destination->checkin_latitude && $destination->checkin_longitude)
                    {{-- Coordinate pill row --}}
                    <div class="flex flex-wrap items-center gap-3 mb-4">
                        <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2">
                            <i class="ti ti-location text-gray-400" style="font-size:14px;"></i>
                            <span class="text-xs text-gray-500 font-medium">Spot</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $destination->name }}</span>
                        </div>
                        <div class="flex items-center gap-2 font-mono text-xs bg-green-50 border border-green-100 text-green-800 rounded-lg px-3 py-2">
                            <i class="ti ti-map-pin-filled text-green-600" style="font-size:13px;"></i>
                            {{ number_format($destination->checkin_latitude, 6) }},
                            {{ number_format($destination->checkin_longitude, 6) }}
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-gray-400">
                            <i class="ti ti-refresh"></i>
                            Updated {{ $destination->updated_at->diffForHumans() }}
                        </div>
                    </div>

                    {{-- Leaflet map --}}
                    @push('head')
                        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
                    @endpush
                    <div id="staff-checkin-map" style="height:280px; border-radius:12px; border:1px solid #e5e7eb; z-index:0;"></div>

                    @push('scripts')
                    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                    <script>
                    (function () {
                        const lat = {{ $destination->checkin_latitude }};
                        const lng = {{ $destination->checkin_longitude }};
                        const spotName = @json($destination->name);
                        const coordsEndpoint = @json(route('spots.checkin-coords', $destination));
                        const editUrl = @json(route('spots.edit', $destination));

                        const map = L.map('staff-checkin-map', { zoomControl: true, scrollWheelZoom: false })
                                     .setView([lat, lng], 15);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors',
                            maxZoom: 19,
                        }).addTo(map);

                        // Custom green pin icon
                        const pinIcon = L.divIcon({
                            className: '',
                            html: `<div style="
                                width:32px; height:32px; border-radius:50% 50% 50% 0;
                                background:#15803d; border:3px solid #fff;
                                box-shadow:0 2px 8px rgba(0,0,0,0.25);
                                transform:rotate(-45deg);
                            "></div>`,
                            iconSize: [32, 32],
                            iconAnchor: [16, 32],
                            popupAnchor: [0, -36],
                        });

                        const marker = L.marker([lat, lng], { icon: pinIcon })
                            .addTo(map)
                            .bindPopup(`
                                <div style="font-size:13px; font-weight:600; color:#1f2937;">${spotName}</div>
                                <div style="font-size:11px; color:#6b7280; margin-top:2px;">Check-in point</div>
                                <a href="${editUrl}" style="font-size:11px; color:#15803d; font-weight:600; text-decoration:none;">
                                    ✏ Edit location →
                                </a>
                            `);

                        // Auto-poll every 30 s so the pin stays in sync with staff edits
                        setInterval(async function () {
                            try {
                                const res  = await fetch(coordsEndpoint, { cache: 'no-store' });
                                const data = await res.json();
                                if (data.checkin_latitude && data.checkin_longitude) {
                                    const newLatLng = [data.checkin_latitude, data.checkin_longitude];
                                    marker.setLatLng(newLatLng);
                                    map.panTo(newLatLng);
                                }
                            } catch { /* silent — dashboard stays usable offline */ }
                        }, 30000);

                        // Also update immediately if the edit page fires a CustomEvent
                        window.addEventListener('spot-checkin-updated', function (e) {
                            if (e.detail.spotId === {{ $destination->id }}) {
                                const ll = [e.detail.latitude, e.detail.longitude];
                                marker.setLatLng(ll);
                                map.panTo(ll);
                            }
                        });
                    })();
                    </script>
                    @endpush

                @else
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center py-10 text-center gap-3">
                        <div class="w-14 h-14 rounded-full bg-amber-50 flex items-center justify-center">
                            <i class="ti ti-map-pin-off text-amber-500" style="font-size:26px;"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-700">No check-in pin set yet</p>
                            <p class="text-sm text-gray-400 mt-1">Visitors won't see a map marker until you set the check-in location.</p>
                        </div>
                        <a href="{{ route('spots.edit', $destination) }}"
                           class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-4 py-2 text-sm transition mt-1">
                            <i class="ti ti-pencil"></i> Set Check-In Location
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Alerts & Notifications System --}}

        @if($notifications->count())
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
                <h2 class="font-semibold text-amber-800 mb-3 flex items-center gap-2">
                    <i class="ti ti-bell-ringing" style="font-size:18px;"></i>
                    Alert Log
                </h2>
                <ul class="space-y-1.5">
                    @foreach($notifications as $notif)
                        <li class="text-sm text-amber-950 flex items-start gap-2">
                            <i class="ti ti-point-filled mt-0.5 text-amber-600" style="font-size:12px;"></i>
                            {{ $notif->message }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</x-app-layout>