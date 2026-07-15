<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
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
            border: 1px solid #e5e7eb;
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
            color: #9ca3af;
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
            border: 1px solid #e5e7eb;
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
            border: 4px solid #e5e7eb;
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
    </style>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Spot Status</h1>
        </div>

        {{-- Tabs --}}
        <div class="border-b border-gray-200 flex gap-6 mb-6">
            <a href="{{ route('spots.status', $spot) }}" class="tab-link">
                <i class="ti ti-activity"></i> Spot Status
            </a>
            <a href="{{ route('spots.edit', $spot) }}" class="tab-link active">
                <i class="ti ti-edit"></i> Edit Details
            </a>
            <a href="{{ route('spots.gallery', $spot) }}" class="tab-link">
                <i class="ti ti-photo"></i> Image Gallery
            </a>
        </div>

        <form id="spot-edit-form" class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-8">
            @csrf
            <input type="hidden" name="spot_id" value="{{ $spot->id }}">

            {{-- Basic Info --}}
            <div>
                <h2 class="font-bold text-gray-800 text-lg mb-4">Spot Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="field-label flex items-center gap-1">Spot Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="field-input" value="{{ old('name', $spot->name) }}">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-name"></span>
                    </div>
                    <div>
                        <label class="field-label flex items-center gap-1">Location (display address) <span class="text-red-500">*</span></label>
                        <input type="text" name="location" id="location-text" class="field-input"
                               value="{{ old('location', $spot->location) }}"
                               placeholder="e.g. Limas, Tigbao, Zamboanga del Sur">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-location"></span>
                    </div>
                    <div>
                        <label class="field-label flex items-center gap-1">Daily Capacity <span class="text-red-500">*</span></label>
                        <input type="number" name="capacity" id="capacity" class="field-input" min="1" value="{{ old('capacity', $spot->capacity) }}">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-capacity"></span>
                    </div>
                    <div>
                        <label class="field-label">Availability Status</label>
                        <select name="availability_status" id="availability_status" class="field-input">
                            <option value="available" @selected($spot->availability_status === 'Available' || $spot->availability_status === 'available')>Available</option>
                            <option value="limited"   @selected($spot->availability_status === 'Limited' || $spot->availability_status === 'limited')>Limited</option>
                            <option value="closed"    @selected($spot->availability_status === 'Unavailable' || $spot->availability_status === 'closed')>Closed</option>
                        </select>
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-availability_status"></span>
                    </div>
                    <div class="md:col-span-2">
                        <label class="field-label">Description</label>
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
                    <button type="button" id="reset-map-btn" class="inline-flex items-center gap-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold border border-gray-200 rounded-xl px-3 py-1.5 text-xs transition">
                        <i class="ti ti-rotate-clockwise"></i> Reset to Saved
                    </button>
                </div>

                {{-- Last Updated Info --}}
                @if($spot->updated_at)
                    <div class="text-xs text-gray-400 mb-4 flex items-center gap-1.5">
                        <i class="ti ti-info-circle"></i>
                        <span>Last updated @if($spot->last_updated_by) by <strong class="text-gray-600 font-semibold">{{ $spot->last_updated_by }}</strong> @endif on {{ $spot->updated_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                @endif

                <p class="text-sm text-gray-500 mb-4">
                    Set precise check-in coordinates by entering values directly or using the interactive map pin below.
                </p>

                {{-- Coordinate inputs & Radius --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4 editor-only-ui">
                    <div>
                        <label class="field-label flex items-center gap-0.5">Latitude <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="checkin_latitude" id="checkin_latitude" class="field-input" value="{{ $spot->checkin_latitude ?? '' }}" placeholder="e.g. 7.7961">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_latitude"></span>
                    </div>
                    <div>
                        <label class="field-label flex items-center gap-0.5">Longitude <span class="text-red-500">*</span></label>
                        <input type="number" step="any" name="checkin_longitude" id="checkin_longitude" class="field-input" value="{{ $spot->checkin_longitude ?? '' }}" placeholder="e.g. 123.4359">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_longitude"></span>
                    </div>
                    <div>
                        <label class="field-label flex items-center gap-0.5">Check-In Radius (meters) <span class="text-red-500">*</span></label>
                        <input type="number" name="checkin_radius" id="checkin_radius" class="field-input" value="{{ $spot->checkin_radius ?? 100 }}" min="5" max="5000">
                        <span class="text-xs text-red-500 mt-1 hidden" id="error-checkin_radius"></span>
                    </div>
                </div>

                {{-- Control Bar --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-3">
                    {{-- Map search UI --}}
                    <div class="flex gap-2 flex-1 max-w-lg editor-only-ui">
                        <input type="text" id="map-search" class="field-input" placeholder="Search a place to jump the map...">
                        <button type="button" id="map-search-btn" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl px-4 text-sm transition whitespace-nowrap">
                            <i class="ti ti-search"></i> Search
                        </button>
                        <button type="button" id="use-my-location" class="inline-flex items-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl px-4 text-sm transition whitespace-nowrap">
                            <i class="ti ti-current-location"></i> My Location
                        </button>
                    </div>

                    {{-- Preview toggle switch --}}
                    <div class="flex justify-end items-center ml-auto">
                        <label class="toggle-switch">
                            <input type="checkbox" id="visitor-preview-toggle" class="toggle-input">
                            <div class="toggle-slider"></div>
                            <span class="text-xs font-semibold text-gray-600">Preview as visitor</span>
                        </label>
                    </div>
                </div>

                {{-- Map Container with skeleton loader --}}
                <div class="map-wrapper" id="map-container-wrapper">
                    <div class="map-loader" id="map-loader">
                        <div class="spinner"></div>
                        <span class="text-sm font-semibold text-gray-600">Loading interactive map...</span>
                    </div>
                    <div id="checkin-map"></div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">
                <button type="button" onclick="history.back()" class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold rounded-xl px-4 py-2.5 text-sm transition">
                    Cancel
                </button>
                <button type="submit" id="save-btn" class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition">
                    <i class="ti ti-device-floppy"></i> <span id="save-btn-label">Save Changes</span>
                </button>
            </div>
        </form>
    </div>

    {{-- Toast --}}
    <div class="save-toast" id="save-toast">
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

            // ── Initialize Map after document loads ───────────────────────────
            setTimeout(() => {
                map = L.map('checkin-map', {
                    zoomControl: true,
                    scrollWheelZoom: true
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

                // Hide skeleton loader once map completes loading tiles
                map.whenReady(() => {
                    mapLoader.style.opacity = '0';
                    setTimeout(() => mapLoader.style.display = 'none', 300);
                });

                // ── Map Interactions & Syncing ───────────────────────────────
                marker.on('dragend', function (e) {
                    if (isPreviewMode) return;
                    const pos = e.target.getLatLng();
                    updateCoordinates(pos.lat, pos.lng, true); // trigger reverse-geocoding
                });

                map.on('click', function (e) {
                    if (isPreviewMode) return;
                    marker.setLatLng(e.latlng);
                    updateCoordinates(e.latlng.lat, e.latlng.lng, true); // trigger reverse-geocoding
                });

            }, 200);

            // ── Update values & sync circle overlay ───────────────────────────
            function updateCoordinates(lat, lng, fetchAddress = false) {
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);
                coordDisplay.textContent = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;

                // Clear inline coord error highlight if filled
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
                    map.panTo([lat, lng]);
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
                }, 800);
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
                        map.setView([latF, lngF], 16);
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
                    map.setView([latitude, longitude], 16);
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
                    map.setView([savedLat, savedLng], 15);
                    radiusCircle.setRadius(savedRadius);
                } else {
                    latInput.value = '';
                    lngInput.value = '';
                    radiusInput.value = 100;
                    if (marker) map.removeLayer(marker);
                    if (radiusCircle) map.removeLayer(radiusCircle);
                    coordDisplay.textContent = 'Not set — click the map';
                }
                showToast('Reset pin to last saved location');
            });

            // ── Visitor Preview Mode Toggle ──────────────────────────────
            document.getElementById('visitor-preview-toggle').addEventListener('change', function (e) {
                isPreviewMode = e.target.checked;
                const wrapper = document.getElementById('map-container-wrapper');
                
                if (isPreviewMode) {
                    wrapper.classList.add('preview-active');
                    form.classList.add('preview-active');
                    
                    // Make marker static
                    if (marker) marker.dragging.disable();
                    
                    // Show a visitor view popup in style
                    if (marker) {
                        marker.bindPopup(`
                            <div style="font-family:'Plus Jakarta Sans', sans-serif;">
                                <div style="font-weight:700;color:#166534;font-size:13px;">📍 Tourist Check-in Point</div>
                                <p style="font-size:11px;color:#6b7280;margin-top:2px;">Scan your QR ticket within the geofenced circle area to check-in.</p>
                            </div>
                        `).openPopup();
                    }
                    
                    // Change Geofence circle styling to match visitor preview look (blue/teal)
                    if (radiusCircle) {
                        radiusCircle.setStyle({
                            color: '#2563eb',
                            fillColor: '#3b82f6',
                            fillOpacity: 0.12
                        });
                    }
                } else {
                    wrapper.classList.remove('preview-active');
                    form.classList.remove('preview-active');
                    
                    // Make marker draggable again
                    if (marker) {
                        marker.dragging.enable();
                        marker.unbindPopup();
                    }
                    
                    // Restore default styling
                    if (radiusCircle) {
                        radiusCircle.setStyle({
                            color: '#15803d',
                            fillColor: '#22c55e',
                            fillOpacity: 0.15
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

            // Remove errors when user starts typing
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

                // Client-side inline validation
                let hasErrors = false;
                
                const nameInput = document.getElementById('name');
                const locationInput = document.getElementById('location-text');
                const capacityInput = document.getElementById('capacity');
                const latInput = document.getElementById('checkin_latitude');
                const lngInput = document.getElementById('checkin_longitude');
                const radiusInput = document.getElementById('checkin_radius');

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
                
                const latVal = parseFloat(latInput.value);
                if (isNaN(latVal) || latVal < -90 || latVal > 90) {
                    showInputError(latInput, 'Latitude must be a valid number between -90 and 90.');
                    hasErrors = true;
                }
                
                const lngVal = parseFloat(lngInput.value);
                if (isNaN(lngVal) || lngVal < -180 || lngVal > 180) {
                    showInputError(lngInput, 'Longitude must be a valid number between -180 and 180.');
                    hasErrors = true;
                }

                const radVal = parseInt(radiusInput.value);
                if (isNaN(radVal) || radVal < 5 || radVal > 5000) {
                    showInputError(radiusInput, 'Geofence radius must be between 5 and 5000 meters.');
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

                    // Trigger event to sync maps on other components/tabs immediately
                    window.dispatchEvent(new CustomEvent('spot-checkin-updated', {
                        detail: {
                            spotId: spotId,
                            latitude: parseFloat(latInput.value),
                            longitude: parseFloat(lngInput.value),
                            radius: parseInt(radiusInput.value),
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
