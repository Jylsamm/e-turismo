<x-app-layout>
    @push('title')
        Edit Spot: {{ $spot->name }} — E-Turismo
    @endpush

    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    <style>
        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }
        .field-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1f2937;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .field-input:focus {
            outline: none;
            border-color: #15803d;
            box-shadow: 0 0 0 3px rgba(21, 128, 61, 0.1);
        }
        .field-input.border-red-500 {
            border-color: #ef4444;
        }
        .field-input.border-red-500:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
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
        #checkin-map {
            height: 360px;
            width: 100%;
            z-index: 0;
        }
        .map-wrapper {
            position: relative;
            height: 360px;
            width: 100%;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            overflow: hidden;
        }
        .coord-pill {
            font-family: ui-monospace, monospace;
            font-size: 12.5px;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 6px 10px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .save-toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #15803d;
            color: #fff;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            transform: translateY(20px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.25s ease;
            z-index: 9999;
        }
        .save-toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .save-toast.error {
            background: #b91c1c;
        }
        /* Loader Overlay styling */
        .map-loader {
            position: absolute;
            inset: 0;
            background: rgba(249, 250, 251, 0.95);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: opacity 0.3s ease;
        }
        .spinner {
            width: 36px;
            height: 36px;
            border: 4px solid #d1d5db;
            border-top: 4px solid #15803d;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Toggle Switch styling */
        .toggle-switch {
            position: relative;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
        }
        .toggle-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .toggle-slider {
            width: 44px;
            height: 24px;
            background-color: #cbd5e1;
            border-radius: 99px;
            position: relative;
            transition: background-color 0.2s;
            margin-right: 8px;
        }
        .toggle-slider::before {
            content: "";
            position: absolute;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: white;
            top: 3px;
            left: 3px;
            transition: transform 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .toggle-input:checked + .toggle-slider {
            background-color: #15803d;
        }
        .toggle-input:checked + .toggle-slider::before {
            transform: translateX(20px);
        }
        .preview-active .editor-only-ui {
            opacity: 0.5;
            pointer-events: none;
            user-select: none;
        }
        .gallery-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .gallery-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div x-data="{ deleteUrl: '' }" class="pb-8 pt-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Sub-Navigation Tabs (Unified for 1-Staff-1-Spot & Admin Spot Selector) -->
        <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3 mb-6">
            <a href="{{ route('spots.dashboard', $spot) }}"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.index') || request()->routeIs('spots.dashboard') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                <i class="ti ti-chart-bar md:mr-1 text-lg"></i> <span class="hidden md:inline">Spot Status</span>
            </a>
            <a href="{{ route('spots.edit', $spot) }}"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.edit') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-600 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                <i class="ti ti-edit md:mr-1 text-lg"></i> <span class="hidden md:inline">Edit Details</span>
            </a>
        </div>

        <!-- Semantic Heading Landmark -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="ti ti-edit text-green-700"></i> Edit Spot: {{ $spot->name }}
            </h1>
            <p class="text-sm text-gray-600 mt-0.5">Manage spot specifications, geofenced check-in radius, and visitor photo gallery.</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2 mb-6">
                <i class="ti ti-circle-check" style="font-size:18px;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2 mb-6">
                <i class="ti ti-alert-circle" style="font-size:18px;"></i>
                {{ session('error') }}
            </div>
        @endif

        <form id="spot-edit-form" class="interactive-card p-6 space-y-8">
            @csrf
            <input type="hidden" name="spot_id" value="{{ $spot->id }}">

            {{-- Basic Info --}}
            <div>
                <h2 class="font-bold text-gray-800 text-lg mb-4">Spot Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="name" class="field-label flex items-center gap-1">Spot Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="field-input" value="{{ old('name', $spot->name) }}" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-name"></span>
                    </div>
                    <div>
                        <label for="location-text" class="field-label flex items-center gap-1">Location (display address) <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location-text" class="field-input"
                               value="{{ old('location', $spot->location) }}"
                               placeholder="e.g. Limas, Tigbao, Zamboanga del Sur" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-location"></span>
                    </div>
                    <div>
                        <label for="capacity" class="field-label flex items-center gap-1">Daily Capacity <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="capacity" class="field-input" min="1" value="{{ old('capacity', $spot->capacity) }}" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-capacity"></span>
                    </div>
                    <div>
                        <label for="availability_status" class="field-label">Availability Status</label>
                        <select name="availability_status" id="availability_status" class="field-input">
                            <option value="available" @selected($spot->availability_status === 'Available' || $spot->availability_status === 'available')>Available</option>
                            <option value="limited"   @selected($spot->availability_status === 'Limited' || $spot->availability_status === 'limited')>Limited</option>
                            <option value="closed"    @selected($spot->availability_status === 'Unavailable' || $spot->availability_status === 'closed')>Closed</option>
                        </select>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-availability_status"></span>
                    </div>
                    <div class="md:col-span-2">
                        <label for="description" class="field-label">Description</label>
                        <textarea name="description" id="description" rows="3" class="field-input">{{ old('description', $spot->description) }}</textarea>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-description"></span>
                    </div>
                </div>
            </div>

            {{-- Check-in Location Picker --}}
            <div class="border-t border-gray-100 pt-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-3">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h2 class="font-bold text-gray-800 text-lg">Check-In Location</h2>
                        <span class="coord-pill">
                            <i class="ti ti-map-pin-filled" style="font-size:14px;"></i>
                            <span id="coord-display">
                                @if($spot->checkin_latitude && $spot->checkin_longitude)
                                    {{ number_format($spot->checkin_latitude, 6) }}, {{ number_format($spot->checkin_longitude, 6) }}
                                @else
                                    Not set — click the map
                                @endif
                            </span>
                        </span>
                    </div>
                    
                    {{-- Reset marker button --}}
                    <button type="button" id="reset-map-btn" class="inline-flex items-center gap-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold border border-gray-300 rounded-xl px-3 py-1.5 text-xs transition">
                        <i class="ti ti-rotate-clockwise"></i> Reset to Saved
                    </button>
                </div>

                {{-- Last Updated Info --}}
                @if($spot->updated_at)
                    <div class="text-xs text-gray-600 mb-4 flex items-center gap-1.5">
                        <i class="ti ti-info-circle"></i>
                        <span>Last updated @if($spot->last_updated_by) by <strong class="text-gray-700 font-semibold">{{ $spot->last_updated_by }}</strong> @endif on {{ $spot->updated_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                @endif

                <p id="map-instructions" class="text-sm text-gray-600 mb-4">
                    Set precise check-in coordinates by entering values directly or dragging the map pin.
                </p>

                {{-- Coordinate inputs & Radius --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4 editor-only-ui">
                    <div>
                        <label for="checkin_latitude" class="field-label flex items-center gap-0.5">Latitude <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="checkin_latitude" id="checkin_latitude" class="field-input" value="{{ $spot->checkin_latitude ?? '' }}" placeholder="e.g. 7.7961" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_latitude"></span>
                    </div>
                    <div>
                        <label for="checkin_longitude" class="field-label flex items-center gap-0.5">Longitude <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="checkin_longitude" id="checkin_longitude" class="field-input" value="{{ $spot->checkin_longitude ?? '' }}" placeholder="e.g. 123.4359" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_longitude"></span>
                    </div>
                    <div>
                        <label for="checkin_radius" class="field-label flex items-center gap-0.5">Check-In Radius (meters) <span class="text-red-500">*</span></label>
                        <input type="number" name="checkin_radius" id="checkin_radius" class="field-input" value="{{ $spot->checkin_radius ?? 100 }}" min="5" max="5000" required>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_radius"></span>
                    </div>
                </div>

                {{-- Control Bar (Responsive at 375px) --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                    {{-- Map search UI --}}
                    <div class="flex flex-wrap sm:flex-nowrap gap-2 flex-1 max-w-lg editor-only-ui">
                        <input type="text" id="map-search" name="map_search" class="field-input min-w-0 flex-1" placeholder="Search a place to jump the map...">
                        <button type="button" id="map-search-btn" class="inline-flex items-center justify-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl px-4 py-2 text-sm transition whitespace-nowrap">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <button type="button" id="use-my-location" class="inline-flex items-center justify-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl px-4 py-2 text-sm transition whitespace-nowrap">
                            <i class="ti ti-current-location"></i> My Location
                        </button>
                    </div>

                    {{-- Preview toggle switch --}}
                    <div class="flex justify-end items-center sm:ml-auto">
                        <label class="toggle-switch">
                            <input type="checkbox" id="visitor-preview-toggle" name="visitor_preview_toggle" class="toggle-input">
                            <div class="toggle-slider"></div>
                            <span class="text-xs font-semibold text-gray-700">Preview as visitor</span>
                        </label>
                    </div>
                </div>

                {{-- Map Container with skeleton loader and accessibility landmark --}}
                <div class="map-wrapper" id="map-container-wrapper">
                    <div class="map-loader" id="map-loader">
                        <div class="spinner"></div>
                        <span class="text-sm font-semibold text-gray-700">Loading interactive map...</span>
                    </div>
                    <div id="checkin-map" role="region" aria-label="Interactive map for selecting {{ $spot->name }} check-in coordinates" aria-describedby="map-instructions"></div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('spots.dashboard', $spot) }}" class="inline-flex items-center gap-1.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold rounded-xl px-4 py-2.5 text-sm transition">
                    Cancel
                </a>
                <button type="submit" id="save-btn" class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition">
                    <i class="ti ti-device-floppy"></i> <span id="save-btn-label">Save Changes</span>
                </button>
            </div>
        </form>

        {{-- Image Gallery Section --}}
        <div class="mt-12 border-t border-gray-200 pt-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-bold text-gray-800 text-xl">Image Gallery</h2>
                    <p class="text-sm text-gray-600 mt-1">Manage public photos displayed to visitors for this spot.</p>
                </div>
            </div>

            {{-- Upload Area --}}
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-6">
                <form action="{{ route('spots.images.upload', $spot) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <label class="block text-sm font-semibold text-gray-700">Upload New Photo</label>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <input type="file" name="image" accept="image/*" 
                               class="w-full text-sm text-gray-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-xl p-1" required>
                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-5 py-2.5 transition text-sm shrink-0 flex items-center justify-center gap-1.5">
                            <i class="ti ti-upload"></i> Upload Photo
                        </button>
                    </div>
                </form>
            </div>

            {{-- Photo List --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($spot->images as $img)
                    <div class="gallery-card relative group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <img src="{{ asset('storage/' . $img->path) }}" 
                             class="w-full h-48 object-cover" 
                             alt="{{ $spot->name }} photo {{ $loop->iteration }}"
                             loading="lazy"
                             decoding="async"
                             width="400"
                             height="192">
                        <div class="p-4 flex items-center justify-between border-t border-gray-50">
                            <div class="flex items-center gap-1.5">
                                @if($img->is_primary)
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full border border-green-200">
                                        <i class="ti ti-star-filled" style="font-size: 11px;"></i> Primary Cover
                                    </span>
                                @else
                                    <form action="{{ route('spots.images.primary', $img) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs text-gray-600 hover:text-green-700 font-semibold flex items-center gap-1">
                                            <i class="ti ti-star"></i> Set as Cover
                                        </button>
                                    </form>
                                @endif
                            </div>
                            
                            <button type="button" 
                                    @click="deleteUrl = '{{ route('spots.images.delete', $img) }}'; $dispatch('open-confirm-modal', { id: 'delete-photo-modal' })"
                                    class="text-red-600 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" 
                                    title="Delete photo {{ $loop->iteration }}"
                                    aria-label="Delete photo {{ $loop->iteration }} for {{ $spot->name }}">
                                <i class="ti ti-trash" style="font-size:16px;"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-sm">
                        <div class="flex flex-col items-center gap-2 text-gray-500">
                            <i class="ti ti-photo" style="font-size:36px;"></i>
                            <span class="text-sm">No photos uploaded yet for this spot.</span>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Delete Photo Confirmation Modal --}}
            <x-confirm-modal id="delete-photo-modal" title="Delete Photo" message="Are you sure you want to delete this photo? This action cannot be undone.">
                <form method="POST" :action="deleteUrl">
                    @csrf
                    @method('DELETE')
                    <button type="submit" @click.stop class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete
                    </button>
                </form>
            </x-confirm-modal>
        </div>
    </div>

    {{-- Toast Notification --}}
    <div class="save-toast" id="save-toast" role="status" aria-live="polite">
        <i class="ti ti-circle-check-filled" id="save-toast-icon"></i>
        <span id="save-toast-msg">Check-in location updated</span>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            const spotId = @json($spot->id);
            const updateUrl = @json(route('spots.update', $spot));

            // Saved states for resetting
            const savedLat = {{ $spot->checkin_latitude  ?? 'null' }};
            const savedLng = {{ $spot->checkin_longitude ?? 'null' }};
            const savedRadius = {{ $spot->checkin_radius ?? 100 }};
            const hasInitial = savedLat !== null && savedLng !== null;

            const defaultLat = hasInitial ? savedLat : 7.7961; // Zamboanga del Sur fallback
            const defaultLng = hasInitial ? savedLng : 123.4359;

            const latInput = document.getElementById('checkin_latitude');
            const lngInput = document.getElementById('checkin_longitude');
            const radiusInput = document.getElementById('checkin_radius');
            const coordDisplay = document.getElementById('coord-display');
            const form = document.getElementById('spot-edit-form');
            const mapLoader = document.getElementById('map-loader');

            let map, marker, radiusCircle;
            let isPreviewMode = false;

            const spotName = @json($spot->name);
            const getVisitorPinIcon = () => L.divIcon({
                className: 'custom-visitor-pin-container',
                html: `
                    <div class="visitor-pin-wrapper">
                        <div class="visitor-pin-pulse"></div>
                        <div class="visitor-pin-body">
                            <span class="visitor-pin-icon"><i class="ti ti-scan"></i></span>
                        </div>
                    </div>
                `,
                iconSize: [38, 38],
                iconAnchor: [19, 38],
                popupAnchor: [0, -40]
            });

            // ── Robust Map Initialization ─────────────────────────────────────
            function initCheckinMap() {
                if (typeof L === 'undefined') {
                    setTimeout(initCheckinMap, 100);
                    return;
                }

                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

                map = L.map('checkin-map', {
                    zoomControl: true,
                    scrollWheelZoom: false, // Prevents page-scroll trapping
                    tap: !isMobile,
                    dragging: true
                }).setView([defaultLat, defaultLng], hasInitial ? 15 : 10);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors',
                    maxZoom: 19,
                }).addTo(map);

                // Setup Pin Marker
                marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

                // Setup Radius Geofence Circle
                const radiusVal = parseInt(radiusInput.value) || 100;
                radiusCircle = L.circle([defaultLat, defaultLng], {
                    radius: radiusVal,
                    color: '#15803d',
                    fillColor: '#22c55e',
                    fillOpacity: 0.15,
                    weight: 1.5
                }).addTo(map);

                // Hide skeleton loader once map completes loading
                map.whenReady(() => {
                    if (mapLoader) {
                        mapLoader.style.opacity = '0';
                        setTimeout(() => mapLoader.style.display = 'none', 300);
                    }
                });

                // ── Map Interactions & Syncing ───────────────────────────────
                marker.on('dragend', function (e) {
                    if (isPreviewMode) return;
                    const pos = e.target.getLatLng();
                    updateCoordinates(pos.lat, pos.lng, true);
                });

                map.on('click', function (e) {
                    if (isPreviewMode) return;
                    marker.setLatLng(e.latlng);
                    updateCoordinates(e.latlng.lat, e.latlng.lng, true);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCheckinMap);
            } else {
                initCheckinMap();
            }

            // ── Update values & sync circle overlay ───────────────────────────
            function updateCoordinates(lat, lng, fetchAddress = false) {
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);
                coordDisplay.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;

                clearInputError(latInput);
                clearInputError(lngInput);

                if (marker) {
                    marker.setLatLng([lat, lng]);
                }
                if (radiusCircle) {
                    radiusCircle.setLatLng([lat, lng]);
                }

                if (fetchAddress) {
                    reverseGeocode(lat, lng);
                }
            }

            // ── Keyboard Accessibility: Sync form inputs with map pin ────────
            function syncInputsToMap() {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (!isNaN(lat) && !isNaN(lng) && lat >= -90 && lat <= 90 && lng >= -180 && lng <= 180) {
                    updateCoordinates(lat, lng, false);
                    if (map) map.panTo([lat, lng]);
                }
            }

            latInput.addEventListener('input', syncInputsToMap);
            lngInput.addEventListener('input', syncInputsToMap);

            // Update circle radius dynamically as user types
            radiusInput.addEventListener('input', function () {
                const r = parseInt(radiusInput.value);
                if (radiusCircle && !isNaN(r) && r >= 5 && r <= 5000) {
                    radiusCircle.setRadius(r);
                    clearInputError(radiusInput);
                }
            });

            // ── Sync display Address text and map pin via Geocoding ─────────────
            let reverseGeocodeTimeout;
            async function reverseGeocode(lat, lng) {
                clearTimeout(reverseGeocodeTimeout);
                reverseGeocodeTimeout = setTimeout(async () => {
                    try {
                        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18`);
                        if (res.ok) {
                            const data = await res.json();
                            if (data.display_name) {
                                const locationInput = document.getElementById('location-text');
                                locationInput.value = data.display_name;
                                clearInputError(locationInput);
                            }
                        }
                    } catch (e) {
                        // Fail silently
                    }
                }, 1000);
            }

            // ── Search & Geocoding address query ─────────────────────────────
            async function searchAddress() {
                const q = document.getElementById('map-search').value.trim();
                if (!q) return;
                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(q)}`);
                    const results = await res.json();
                    if (results.length) {
                        const { lat, lon, display_name } = results[0];
                        const latF = parseFloat(lat), lngF = parseFloat(lon);
                        if (map) map.setView([latF, lngF], 16);
                        updateCoordinates(latF, lngF, false);
                        document.getElementById('location-text').value = display_name;
                    } else {
                        showToast('No results found for that location search.', true);
                    }
                } catch {
                    showToast('Search failed. Check your network connection.', true);
                }
            }

            document.getElementById('map-search-btn').addEventListener('click', searchAddress);
            document.getElementById('map-search').addEventListener('keydown', e => {
                if (e.key === 'Enter') { e.preventDefault(); searchAddress(); }
            });

            // ── Device Geolocation button ────────────────────────────────────
            document.getElementById('use-my-location').addEventListener('click', function () {
                if (!navigator.geolocation) {
                    showToast('Geolocation is not supported on this device.', true);
                    return;
                }
                navigator.geolocation.getCurrentPosition(pos => {
                    const { latitude, longitude } = pos.coords;
                    if (map) map.setView([latitude, longitude], 16);
                    updateCoordinates(latitude, longitude, true);
                }, () => {
                    showToast('Unable to retrieve your device location.', true);
                });
            });

            // ── Reset to Last Saved Location ─────────────────────────────────
            document.getElementById('reset-map-btn').addEventListener('click', function () {
                if (isPreviewMode) return;
                if (hasInitial) {
                    latInput.value = savedLat;
                    lngInput.value = savedLng;
                    radiusInput.value = savedRadius;
                    updateCoordinates(savedLat, savedLng, false);
                    if (map) map.setView([savedLat, savedLng], 15);
                    if (radiusCircle) radiusCircle.setRadius(savedRadius);
                } else {
                    latInput.value = '';
                    lngInput.value = '';
                    radiusInput.value = 100;
                    if (marker && map) map.removeLayer(marker);
                    if (radiusCircle && map) map.removeLayer(radiusCircle);
                    coordDisplay.textContent = 'Not set — click the map';
                }
                showToast('Reset pin to last saved location');
            });

            // ── Visitor Preview Mode Toggle ──────────────────────────────────
            document.getElementById('visitor-preview-toggle').addEventListener('change', function (e) {
                isPreviewMode = e.target.checked;
                const wrapper = document.getElementById('map-container-wrapper');
                
                if (isPreviewMode) {
                    wrapper.classList.add('preview-active');
                    form.classList.add('preview-active');
                    
                    if (marker) {
                        marker.dragging.disable();
                        marker.setIcon(getVisitorPinIcon());
                        marker.bindPopup(`
                            <div class="checkin-popup-card">
                                <div class="checkin-popup-header">
                                    <span class="checkin-popup-icon-badge">
                                        <i class="ti ti-radar"></i>
                                    </span>
                                    <span class="checkin-popup-title">Tourist Check-in Point</span>
                                </div>
                                <div class="checkin-popup-spotname">${spotName}</div>
                                <p class="checkin-popup-desc">Scan your QR ticket within the geofenced circle area to check-in.</p>
                            </div>
                        `).openPopup();
                    }
                    
                    if (radiusCircle) {
                        radiusCircle.setStyle({
                            color: '#15803d',
                            fillColor: '#22c55e',
                            fillOpacity: 0.18,
                            weight: 2
                        });
                    }
                } else {
                    wrapper.classList.remove('preview-active');
                    form.classList.remove('preview-active');
                    
                    if (marker) {
                        marker.dragging.enable();
                        marker.unbindPopup();
                        marker.setIcon(new L.Icon.Default());
                    }
                    
                    if (radiusCircle) {
                        radiusCircle.setStyle({
                            color: '#15803d',
                            fillColor: '#22c55e',
                            fillOpacity: 0.15,
                            weight: 1.5
                        });
                    }
                }
            });

            // ── Validation & inline error rendering helpers ───────────────────
            function showInputError(inputEl, message) {
                inputEl.classList.add('border-red-500');
                const errorSpan = document.getElementById('error-' + inputEl.id);
                if (errorSpan) {
                    errorSpan.textContent = message;
                    errorSpan.classList.remove('hidden');
                }
            }

            function clearInputError(inputEl) {
                inputEl.classList.remove('border-red-500');
                const errorSpan = document.getElementById('error-' + inputEl.id);
                if (errorSpan) {
                    errorSpan.classList.add('hidden');
                }
            }

            const formInputs = form.querySelectorAll('.field-input');
            formInputs.forEach(input => {
                input.addEventListener('input', () => clearInputError(input));
            });

            // ── Form submit with inline validation ─────────────────────────────
            const saveBtn = document.getElementById('save-btn');
            const saveLabel = document.getElementById('save-btn-label');
            const toast = document.getElementById('save-toast');
            const toastMsg = document.getElementById('save-toast-msg');
            const toastIcon = document.getElementById('save-toast-icon');

            function showToast(msg, isError = false) {
                toastMsg.textContent = msg;
                toast.classList.toggle('error', isError);
                toastIcon.className = isError ? 'ti ti-alert-circle-filled' : 'ti ti-circle-check-filled';
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3500);
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                let hasErrors = false;
                
                const nameInput = document.getElementById('name');
                const locationInput = document.getElementById('location-text');
                const capacityInput = document.getElementById('capacity');
                const checkinLat = document.getElementById('checkin_latitude');
                const checkinLng = document.getElementById('checkin_longitude');
                const checkinRad = document.getElementById('checkin_radius');

                if (!nameInput.value.trim()) {
                    showInputError(nameInput, 'Spot Name is required.');
                    hasErrors = true;
                }
                if (!locationInput.value.trim()) {
                    showInputError(locationInput, 'Display Address location is required.');
                    hasErrors = true;
                }
                if (!capacityInput.value || parseInt(capacityInput.value) <= 0) {
                    showInputError(capacityInput, 'Daily Capacity must be greater than 0.');
                    hasErrors = true;
                }
                
                const latVal = parseFloat(checkinLat.value);
                if (isNaN(latVal) || latVal < -90 || latVal > 90) {
                    showInputError(checkinLat, 'Latitude must be a valid number between -90 and 90.');
                    hasErrors = true;
                }
                
                const lngVal = parseFloat(checkinLng.value);
                if (isNaN(lngVal) || lngVal < -180 || lngVal > 180) {
                    showInputError(checkinLng, 'Longitude must be a valid number between -180 and 180.');
                    hasErrors = true;
                }

                const radVal = parseInt(checkinRad.value);
                if (isNaN(radVal) || radVal < 5 || radVal > 5000) {
                    showInputError(checkinRad, 'Geofence radius must be between 5 and 5000 meters.');
                    hasErrors = true;
                }

                if (hasErrors) {
                    showToast('Please fix the errors highlighted below.', true);
                    return;
                }

                saveBtn.disabled = true;
                saveLabel.textContent = 'Saving...';

                try {
                    const formData = new FormData(form);
                    formData.append('_method', 'PATCH');

                    const res = await fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        },
                        body: formData,
                    });

                    const data = await res.json();

                    if (!res.ok) {
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const inputEl = document.getElementById(field) || document.getElementById('location-text');
                                if (inputEl) {
                                    showInputError(inputEl, data.errors[field][0]);
                                }
                            });
                            showToast('Server validation failed.', true);
                        } else {
                            showToast(data.message || 'Save failed.', true);
                        }
                        return;
                    }

                    showToast(data.message || 'Spot details updated successfully!');

                    window.dispatchEvent(new CustomEvent('spot-checkin-updated', {
                        detail: {
                            spotId: spotId,
                            latitude: parseFloat(checkinLat.value),
                            longitude: parseFloat(checkinLng.value),
                            radius: parseInt(checkinRad.value),
                        },
                    }));

                } catch (err) {
                    showToast('Something went wrong. Please try again.', true);
                } finally {
                    saveBtn.disabled = false;
                    saveLabel.textContent = 'Save Changes';
                }
            });
        })();
    </script>
    @endpush
</x-app-layout>
