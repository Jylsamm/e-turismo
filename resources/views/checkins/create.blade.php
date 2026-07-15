<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ti ti-qrcode text-green-700"></i> Check-In Management
        </h1>
        <p class="text-sm text-gray-500 mt-1">{{ $stats['destination_name'] }}</p>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        /* ── Variables ─────────────────────────────── */
        :root {
            --green: #15803d;
            --green-light: #dcfce7;
            --amber: #d97706;
            --red: #dc2626;
            --border: #e5e7eb;
        }

        /* ── Spinner ────────────────────────────────── */
        .spinner-loader {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* ── Scanner Container ──────────────────────── */
        .scanner-container {
            border: 3px solid var(--border);
            transition: border-color 0.25s, box-shadow 0.25s;
        }

        .scanner-container.detecting {
            border-color: var(--green);
        }

        /* Flash animations */
        @keyframes flashSuccess {
            0% {
                border-color: var(--border);
                box-shadow: none;
            }

            20% {
                border-color: var(--green);
                box-shadow: 0 0 0 6px rgba(21, 128, 61, .25);
            }

            100% {
                border-color: var(--border);
                box-shadow: none;
            }
        }

        @keyframes flashError {
            0% {
                border-color: var(--border);
                box-shadow: none;
            }

            20% {
                border-color: var(--red);
                box-shadow: 0 0 0 6px rgba(220, 38, 38, .22);
            }

            100% {
                border-color: var(--border);
                box-shadow: none;
            }
        }

        .scanner-container.flash-success {
            animation: flashSuccess 0.7s ease-out forwards;
        }

        .scanner-container.flash-error {
            animation: flashError 0.7s ease-out forwards;
        }

        /* ── Viewfinder corners ─────────────────────── */
        .vf-corner {
            position: absolute;
            width: 22px;
            height: 22px;
            border-color: var(--green);
            border-style: solid;
        }

        .vf-tl {
            top: 10px;
            left: 10px;
            border-width: 3px 0 0 3px;
            border-radius: 3px 0 0 0;
        }

        .vf-tr {
            top: 10px;
            right: 10px;
            border-width: 3px 3px 0 0;
            border-radius: 0 3px 0 0;
        }

        .vf-bl {
            bottom: 10px;
            left: 10px;
            border-width: 0 0 3px 3px;
            border-radius: 0 0 0 3px;
        }

        .vf-br {
            bottom: 10px;
            right: 10px;
            border-width: 0 3px 3px 0;
            border-radius: 0 0 3px 0;
        }

        .vf-scan-line {
            position: absolute;
            left: 14px;
            right: 14px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
            top: 14px;
            animation: scanLine 2.2s ease-in-out infinite;
            z-index: 10;
        }

        @keyframes scanLine {
            0% {
                top: 14px;
                opacity: 0.9;
            }

            50% {
                opacity: 0.5;
            }

            100% {
                top: calc(100% - 18px);
                opacity: 0.9;
            }
        }

        /* Camera controls pinned inside box */
        .sc-controls {
            position: absolute;
            bottom: 14px;
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            gap: 8px;
            z-index: 20;
        }

        /* Force html5-qrcode video to fill container */
        #reader,
        #reader>* {
            width: 100% !important;
            height: 100% !important;
        }

        #reader video {
            object-fit: cover !important;
        }

        #reader img {
            display: none !important;
        }

        #reader__scan_region {
            width: 100% !important;
            height: 100% !important;
        }

        /* ── Collapsible panels ─────────────────────── */
        .panel-body {
            overflow: hidden;
            transition: max-height 0.25s ease;
        }

        .panel-body.open {
            max-height: 600px;
        }

        .panel-body.closed {
            max-height: 0;
        }

        .panel-chevron {
            transition: transform 0.2s;
        }

        .panel-chevron.open {
            transform: rotate(180deg);
        }

        /* ── Stat pill ──────────────────────────────── */
        .stat-pill {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: .85rem 1rem;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: border-color .15s, box-shadow .15s;
            user-select: none;
        }

        .stat-pill:hover {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(21, 128, 61, .07);
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 10px;
            color: #9ca3af;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-value {
            font-size: 1.35rem;
            font-weight: 700;
            color: #111827;
            line-height: 1;
        }
    </style>

    <div class="pt-2 pb-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-5">

        {{-- ① Stats Row ─────────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
            <div class="stat-pill shadow-sm">
                <div class="stat-icon bg-green-50 text-green-700"><i class="ti ti-user-check"></i></div>
                <div>
                    <div class="stat-label">Check-ins</div>
                    <div class="stat-value" id="top-checkins">{{ $stats['today_checkins'] }}</div>
                </div>
            </div>

            {{-- Pending — clicking toggles the queue panel --}}
            <div class="stat-pill shadow-sm" onclick="jumpToPendingQueue()"
                title="Click to view pending arrivals queue">
                <div class="stat-icon bg-amber-50 text-amber-600"><i class="ti ti-ticket"></i></div>
                <div>
                    <div class="stat-label flex items-center gap-1">Pending <i class="ti ti-arrow-right text-amber-400"
                            style="font-size:9px;"></i></div>
                    <div class="stat-value text-amber-600" id="top-pending">{{ $stats['pending_arrivals'] }}</div>
                </div>
            </div>

            <div class="stat-pill shadow-sm" style="cursor:default;">
                <div class="stat-icon bg-blue-50 text-blue-600"><i class="ti ti-users"></i></div>
                <div>
                    <div class="stat-label">Current</div>
                    <div class="stat-value" id="top-current">{{ $stats['current_visitors'] }}</div>
                </div>
            </div>

            <div class="stat-pill shadow-sm col-span-2 md:col-span-1" style="cursor:default;">
                <div class="stat-icon bg-purple-50 text-purple-600"><i class="ti ti-map-pin"></i></div>
                <div class="min-w-0">
                    <div class="stat-label">Spot</div>
                    <div class="stat-value text-sm truncate" title="{{ $stats['destination_name'] }}">
                        {{ $stats['destination_name'] }}</div>
                </div>
            </div>

            <div class="stat-pill shadow-sm col-span-2 md:col-span-1" style="cursor:default;">
                <div class="stat-icon bg-gray-100 text-gray-500" id="top-status-icon"><i class="ti ti-camera"></i></div>
                <div>
                    <div class="stat-label">Camera</div>
                    <div class="text-sm font-bold text-gray-400" id="top-status-text">Idle</div>
                </div>
            </div>
        </div>

        {{-- ② Two-Column Main Layout ─────────────────────────────────────── --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            {{-- Left: Compact Scanner (5/12) ─────────────────────────────── --}}
            <div class="contents lg:block lg:col-span-5 lg:space-y-4">

                {{-- Scanner Card --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden order-1">
                    <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                        <h2 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                            <i class="ti ti-qrcode text-green-700"></i> QR Scanner
                        </h2>
                        <span id="camera-badge"
                            class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <i class="ti ti-camera"></i>
                            <span id="camera-badge-text">Camera Idle</span>
                        </span>
                    </div>

                    <div class="p-5">
                        {{-- Camera device selector (shown when >1 camera) --}}
                        <div id="camera-select-wrapper" class="mb-3 hidden">
                            <label class="text-xs font-semibold text-gray-500 mb-1.5 flex items-center gap-1">
                                <i class="ti ti-camera-rotate"></i> Switch Camera
                            </label>
                            <div class="relative">
                                <select id="camera-select" onchange="switchCamera(this.value)"
                                    class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-400 outline-none appearance-none bg-white pr-8">
                                </select>
                                <span
                                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs">▾</span>
                            </div>
                        </div>

                        {{-- Compact QR Camera Box (Sized to fit column width) --}}
                        <div class="scanner-container bg-gray-900 rounded-xl overflow-hidden flex items-center justify-center relative mx-auto w-full aspect-square"
                            id="scanner-frame">

                            <div id="reader" style="width:100%; height:100%;"></div>

                            {{-- Viewfinder corners overlay --}}
                            <div class="absolute inset-0 pointer-events-none z-10" id="viewfinder"
                                style="display:none;">
                                <div class="vf-corner vf-tl"></div>
                                <div class="vf-corner vf-tr"></div>
                                <div class="vf-corner vf-bl"></div>
                                <div class="vf-corner vf-br"></div>
                                <div class="vf-scan-line"></div>
                            </div>

                            {{-- Camera idle state --}}
                            <div class="text-center text-gray-400 z-10 px-4 absolute" id="camera-idle">
                                <div class="text-5xl mb-3"><i class="ti ti-camera-off"></i></div>
                                <p class="text-sm font-medium">Camera paused</p>
                                <p class="text-xs mt-1 opacity-60">Press Start to activate</p>
                            </div>

                            {{-- Verifying overlay --}}
                            <div class="absolute inset-0 bg-black/75 z-20 flex flex-col items-center justify-center text-white"
                                id="verifying-overlay" style="display:none;">
                                <i class="ti ti-loader-2 text-4xl text-green-400 spinner-loader mb-2"></i>
                                <span class="text-sm font-semibold tracking-wide">Verifying ticket...</span>
                            </div>

                            {{-- Camera Controls --}}
                            <div class="sc-controls">
                                <button onclick="startCamera()" id="btn-start"
                                    class="bg-green-700 hover:bg-green-800 text-white font-bold px-5 py-2 rounded-full text-xs flex items-center gap-1.5 shadow transition">
                                    <i class="ti ti-player-play"></i> Start Camera
                                </button>
                                <button onclick="stopCamera()" id="btn-stop" style="display:none;"
                                    class="bg-white/10 hover:bg-white/20 text-white border border-white/25 font-bold px-5 py-2 rounded-full text-xs flex items-center gap-1.5 shadow transition">
                                    <i class="ti ti-player-pause"></i> Pause
                                </button>
                            </div>
                        </div>

                        {{-- Privacy Notice --}}
                        <p class="text-center text-xs text-gray-400 mt-3 flex items-center justify-center gap-1">
                            <i class="ti ti-shield-lock"></i>
                            Camera is used only for QR detection — not recorded or stored.
                        </p>
                    </div>
                </div>

                {{-- Scanner Health Card --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-3 order-5 w-full">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Scanner Health</h3>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-camera"></i> Camera
                                Link</span>
                            <span class="font-bold text-gray-400" id="health-camera-val">Inactive</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-scan"></i>
                                Decoder</span>
                            <span class="font-bold text-gray-400" id="health-scanner-val">Off</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-wifi"></i>
                                Connection</span>
                            <span class="font-bold text-green-600">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Verification Tools (7/12) ─────────────────────────── --}}
            <div class="contents lg:block lg:col-span-7 lg:space-y-4">

                {{-- ③ Result / Confirm card (hidden until scan/verify) --}}
                <div id="result-card" style="display:none;" class="order-2 w-full"></div>

                {{-- Manual Verification Card --}}
                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm space-y-3 order-3 w-full">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="ti ti-keyboard text-green-700"></i> Manual Verification
                    </h3>
                    <div class="flex gap-2">
                        <input type="text" id="manual-input" placeholder="Enter Booking Code or QR Token…"
                            onkeydown="if(event.key==='Enter') previewManual()"
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none h-[42px]">
                        <button onclick="previewManual()"
                            class="bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg px-5 text-sm flex items-center gap-1.5 transition whitespace-nowrap h-[42px]">
                            <i class="ti ti-search"></i> Verify
                        </button>
                    </div>
                    <p class="text-xs text-gray-400">Paste the QR token from the tourist's ticket confirmation.</p>
                </div>

                {{-- ④ Pending Arrivals Queue (collapsible) --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden order-4 w-full"
                    id="pending-panel">
                    <button
                        class="w-full px-5 py-3.5 flex items-center justify-between text-left hover:bg-gray-50 transition"
                        onclick="togglePending()">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-ticket text-amber-500"></i>
                            <span class="font-bold text-gray-800 text-sm">Pending Arrivals Queue</span>
                            <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded-full"
                                id="pending-count-badge">{{ $stats['pending_arrivals'] }}</span>
                        </div>
                        <i class="ti ti-chevron-down text-gray-400 panel-chevron open" id="pending-chevron"></i>
                    </button>
                    <div class="panel-body open" id="pending-body">
                        <div class="border-t border-gray-100">
                            <ul id="pending-list" class="divide-y divide-gray-50 max-h-64 overflow-y-auto">
                                <li class="px-5 py-4 text-sm text-gray-400 text-center" id="pending-placeholder">
                                    <i class="ti ti-loader-2 spinner-loader text-lg block mb-1 mx-auto"></i>
                                    Loading queue...
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Activity Timeline (collapsible) --}}
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden order-6 w-full">
                    <button
                        class="w-full px-5 py-3.5 flex items-center justify-between text-left hover:bg-gray-50 transition"
                        onclick="toggleActivity()">
                        <div class="flex items-center gap-2">
                            <i class="ti ti-activity text-green-700"></i>
                            <span class="font-bold text-gray-800 text-sm">Recent Activity</span>
                        </div>
                        <i class="ti ti-chevron-down text-gray-400 panel-chevron open" id="activity-chevron"></i>
                    </button>
                    <div class="panel-body open" id="activity-body">
                        <div class="border-t border-gray-100 p-4 max-h-56 overflow-y-auto">
                            <ul id="history-log" class="space-y-2.5 relative border-l border-gray-100 pl-4 py-1">
                                <li id="log-empty" class="text-xs text-gray-400 italic py-6 text-center">
                                    <i class="ti ti-history text-gray-300 text-2xl block mb-1.5 mx-auto"></i>
                                    No verification activities yet.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Toast Container --}}
    <div id="toast-wrapper" class="fixed bottom-5 right-5 z-50 space-y-2 pointer-events-none"></div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        /* ── Constants ──────────────────────────────────────────────────────── */
        const PREVIEW_URL = @json(route('staff.preview-ticket'));
        const VERIFY_URL = @json(route('staff.verify-ticket'));
        const STATS_URL = @json(route('checkins.stats'));
        const CSRF = @json(csrf_token());

        /* ── State ──────────────────────────────────────────────────────────── */
        let scanner = null;
        let scanning = false;
        let lastToken = null;
        let pendingToken = null;   // awaiting staff approval
        let activeCamId = null;
        let pendingOpen = true;
        let activityOpen = true;

        /* ── Camera Management ──────────────────────────────────────────────── */
        function startCamera(deviceId) {
            if (scanning) stopCamera();

            document.getElementById('camera-idle').style.display = 'none';
            document.getElementById('viewfinder').style.display = 'block';
            document.getElementById('btn-start').style.display = 'none';
            document.getElementById('btn-stop').style.display = 'flex';
            document.getElementById('scanner-frame').classList.add('detecting');
            updateScannerHealth('active');
            lastToken = null;

            const constraint = deviceId
                ? { deviceId: { exact: deviceId } }
                : { facingMode: 'environment' };

            scanner = new Html5Qrcode('reader');
            scanner.start(
                constraint,
                { fps: 10, qrbox: { width: 230, height: 230 } },
                onScan,
                () => { }
            ).then(() => {
                scanning = true;
                enumerateCameras();         // populate device selector now permissions are granted
            }).catch(err => {
                stopCamera();
                triggerToast(err.message || 'Camera access denied.', 'error');
            });
        }

        function stopCamera() {
            if (scanner) { scanner.stop().catch(() => { }); scanner = null; }
            scanning = false;
            document.getElementById('viewfinder').style.display = 'none';
            document.getElementById('btn-start').style.display = 'flex';
            document.getElementById('btn-stop').style.display = 'none';
            document.getElementById('scanner-frame').classList.remove('detecting', 'flash-success', 'flash-error');
            document.getElementById('camera-idle').style.display = 'block';
            updateScannerHealth('inactive');
        }

        function switchCamera(deviceId) {
            activeCamId = deviceId;
            startCamera(deviceId);
        }

        async function enumerateCameras() {
            try {
                const devices = await navigator.mediaDevices.enumerateDevices();
                const cams = devices.filter(d => d.kind === 'videoinput');
                if (cams.length < 2) return;

                const sel = document.getElementById('camera-select');
                sel.innerHTML = '';
                cams.forEach((cam, i) => {
                    const opt = document.createElement('option');
                    opt.value = cam.deviceId;
                    opt.textContent = cam.label || `Camera ${i + 1}`;
                    if (cam.deviceId === activeCamId) opt.selected = true;
                    sel.appendChild(opt);
                });
                document.getElementById('camera-select-wrapper').classList.remove('hidden');
            } catch (_) { }
        }

        /* ── Scan Detection ─────────────────────────────────────────────────── */
        function onScan(token) {
            if (token === lastToken) return;
            lastToken = token;
            stopCamera();
            previewTicket(token);
        }

        function previewManual() {
            const token = document.getElementById('manual-input').value.trim();
            if (!token) { document.getElementById('manual-input').focus(); return; }
            previewTicket(token);
        }

        /* ── Ticket Preview (two-step: preview → approve) ───────────────────── */
        function previewTicket(token) {
            pendingToken = null;
            showLoading();

            fetch(PREVIEW_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ qr_token: token })
            })
                .then(r => r.json())
                .then(data => {
                    hideLoading();
                    if (data.valid) {
                        pendingToken = token;
                        flashFrame('success');
                        beep('success');
                        showPreviewCard(data, token);
                    } else {
                        flashFrame('error');
                        beep('error');
                        showErrorCard(data.message);
                        addLog('fail', token.substring(0, 14) + '…', data.message);
                        triggerToast(data.message, 'error');
                    }
                })
                .catch(() => {
                    hideLoading();
                    flashFrame('error');
                    showErrorCard('Network error — please check your connection and try again.');
                });
        }

        function approveCheckin() {
            if (!pendingToken) return;
            const token = pendingToken;
            pendingToken = null;
            showLoading();

            fetch(VERIFY_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ qr_token: token })
            })
                .then(r => r.json())
                .then(data => {
                    hideLoading();
                    if (data.valid) {
                        showSuccessCard(data);
                        addLog('success', data.tourist_name || 'Visitor');
                        triggerToast('✅ Check-in approved!', 'success');
                        refreshStats();
                    } else {
                        showErrorCard(data.message);
                        addLog('fail', '…', data.message);
                        triggerToast(data.message, 'error');
                    }
                })
                .catch(() => {
                    hideLoading();
                    showErrorCard('Network error during final check-in. Please try again.');
                });
        }

        function cancelPreview() {
            pendingToken = null;
            document.getElementById('result-card').style.display = 'none';
            document.getElementById('manual-input').value = '';
            startCamera();
        }

        /* ── Result Cards ───────────────────────────────────────────────────── */
        function showPreviewCard(d, token) {
            const card = document.getElementById('result-card');
            card.style.display = 'block';
            card.innerHTML = `
            <div class="bg-white border-2 border-green-300 rounded-2xl p-5 shadow-md space-y-4">
                <div class="flex items-center gap-3 border-b border-green-100 pb-3">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-ticket text-green-700 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">Confirm Check-In</h3>
                        <p class="text-xs text-green-700 font-semibold">Valid ticket found — review then approve</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                        <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-user"></i> Visitor</span>
                        <span class="font-bold text-gray-800">${escHtml(d.tourist_name)}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                        <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-map-pin"></i> Spot</span>
                        <span class="font-bold text-gray-800">${escHtml(d.destination_name)}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                        <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-calendar"></i> Visit Date</span>
                        <span class="font-bold text-gray-800">${escHtml(d.visit_date)}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-badge-check"></i> Status</span>
                        <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-0.5 rounded-full">${escHtml(d.booking_status)}</span>
                    </div>
                </div>
                <div class="flex gap-3 pt-1">
                    <button onclick="approveCheckin()"
                            class="flex-1 bg-green-700 hover:bg-green-800 text-white font-bold py-3 rounded-xl text-sm flex items-center justify-center gap-2 transition shadow-sm">
                        <i class="ti ti-circle-check-filled"></i> Approve Check-In
                    </button>
                    <button onclick="cancelPreview()"
                            class="w-24 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl text-sm transition">
                        Cancel
                    </button>
                </div>
            </div>`;
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function showSuccessCard(d) {
            const card = document.getElementById('result-card');
            card.style.display = 'block';
            card.innerHTML = `
            <div class="bg-green-50 border border-green-300 rounded-2xl p-5 shadow-sm space-y-4">
                <div class="flex items-center gap-3 border-b border-green-200 pb-3">
                    <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-circle-check-filled text-green-700 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-green-800 text-base">Check-In Successful!</h3>
                        <p class="text-xs text-green-600">${escHtml(d.checked_in_at || '')}</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm text-green-900">
                    <div class="flex justify-between py-1 border-b border-green-100">
                        <span class="flex items-center gap-1.5 opacity-75"><i class="ti ti-user"></i> Visitor</span>
                        <span class="font-bold">${escHtml(d.tourist_name)}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-green-100">
                        <span class="flex items-center gap-1.5 opacity-75"><i class="ti ti-map-pin"></i> Spot</span>
                        <span class="font-bold">${escHtml(d.destination_name)}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span class="flex items-center gap-1.5 opacity-75"><i class="ti ti-calendar"></i> Visit Date</span>
                        <span class="font-bold">${escHtml(d.visit_date)}</span>
                    </div>
                </div>
                <button onclick="resetScanner()"
                        class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 transition">
                    <i class="ti ti-scan"></i> Scan Next Ticket
                </button>
            </div>`;
        }

        function showErrorCard(msg) {
            const card = document.getElementById('result-card');
            card.style.display = 'block';
            card.innerHTML = `
            <div class="bg-red-50 border border-red-300 rounded-2xl p-5 shadow-sm space-y-3">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <i class="ti ti-alert-circle-filled text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-red-800 text-sm">Access Denied</h3>
                        <p class="text-sm text-red-700 mt-1 leading-relaxed">${escHtml(msg)}</p>
                    </div>
                </div>
                <button onclick="resetScanner()"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl text-sm flex items-center justify-center gap-1.5 transition">
                    <i class="ti ti-rotate-clockwise"></i> Try Again
                </button>
            </div>`;
            card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        function resetScanner() {
            pendingToken = null;
            document.getElementById('result-card').style.display = 'none';
            document.getElementById('manual-input').value = '';
            startCamera();
        }

        /* ── Scan Frame Flash ──────────────────────────────────────────────── */
        function flashFrame(type) {
            const frame = document.getElementById('scanner-frame');
            frame.classList.remove('flash-success', 'flash-error');
            void frame.offsetWidth; // reflow to restart animation
            frame.classList.add(type === 'success' ? 'flash-success' : 'flash-error');
            setTimeout(() => frame.classList.remove('flash-success', 'flash-error'), 800);
        }

        /* ── Audio Feedback ─────────────────────────────────────────────────── */
        function beep(type) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);

                if (type === 'success') {
                    osc.type = 'sine'; osc.frequency.setValueAtTime(880, ctx.currentTime);
                    gain.gain.setValueAtTime(0.08, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.12);
                    osc.start(); osc.stop(ctx.currentTime + 0.12);
                } else {
                    osc.type = 'square'; osc.frequency.setValueAtTime(220, ctx.currentTime);
                    gain.gain.setValueAtTime(0.06, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.28);
                    osc.start(); osc.stop(ctx.currentTime + 0.28);
                }
            } catch (_) { }
        }

        /* ── Stats Refresh ─────────────────────────────────────────────────── */
        function refreshStats() {
            fetch(STATS_URL, { headers: { Accept: 'application/json' } })
                .then(r => r.json())
                .then(data => {
                    document.getElementById('top-checkins').textContent = data.today_checkins;
                    document.getElementById('top-pending').textContent = data.pending_arrivals;
                    document.getElementById('top-current').textContent = data.current_visitors;
                    document.getElementById('pending-count-badge').textContent = data.pending_arrivals;
                    if (data.pending_list) renderPendingQueue(data.pending_list);
                })
                .catch(() => { });
        }

        /* ── Pending Queue ─────────────────────────────────────────────────── */
        const INITIAL_PENDING = @json($stats['pending_list'] ?? []);

        function renderPendingQueue(list) {
            const ul = document.getElementById('pending-list');
            ul.innerHTML = '';

            if (!list || list.length === 0) {
                ul.innerHTML = '<li class="px-5 py-5 text-sm text-gray-400 text-center"><i class="ti ti-check text-green-500 text-xl block mb-1 mx-auto"></i>No pending arrivals — all checked in!</li>';
                return;
            }

            list.forEach(item => {
                const li = document.createElement('li');
                li.className = 'px-5 py-3 flex items-center justify-between gap-3 hover:bg-gray-50 transition';
                li.innerHTML = `
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center flex-shrink-0 text-xs font-bold">
                        ${escHtml(item.tourist_name.charAt(0).toUpperCase())}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">${escHtml(item.tourist_name)}</p>
                        <p class="text-xs text-gray-400 font-mono truncate">${escHtml(item.qr_token ? item.qr_token.substring(0, 16) + '…' : 'No token')}</p>
                    </div>
                </div>
                <button onclick="checkInFromQueue(${escHtml(JSON.stringify(item.qr_token))})"
                        class="shrink-0 inline-flex items-center gap-1 bg-green-700 hover:bg-green-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                    <i class="ti ti-scan"></i> Check In
                </button>`;
                ul.appendChild(li);
            });
        }

        function checkInFromQueue(token) {
            document.getElementById('manual-input').value = token;
            previewTicket(token);
            // Scroll to result card
            setTimeout(() => {
                document.getElementById('result-card').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 200);
        }

        function togglePending() {
            pendingOpen = !pendingOpen;
            const body = document.getElementById('pending-body');
            const chevron = document.getElementById('pending-chevron');
            body.classList.toggle('open', pendingOpen);
            body.classList.toggle('closed', !pendingOpen);
            chevron.classList.toggle('open', pendingOpen);
            if (pendingOpen) renderPendingQueue(INITIAL_PENDING);
        }

        function toggleActivity() {
            activityOpen = !activityOpen;
            const body = document.getElementById('activity-body');
            const chevron = document.getElementById('activity-chevron');
            body.classList.toggle('open', activityOpen);
            body.classList.toggle('closed', !activityOpen);
            chevron.classList.toggle('open', activityOpen);
        }

        function jumpToPendingQueue() {
            if (!pendingOpen) togglePending();
            document.getElementById('pending-panel').scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        /* ── Loading Overlay ─────────────────────────────────────────────── */
        function showLoading() { document.getElementById('verifying-overlay').style.display = 'flex'; }
        function hideLoading() { document.getElementById('verifying-overlay').style.display = 'none'; }

        /* ── Health Indicator ────────────────────────────────────────────── */
        function updateScannerHealth(status) {
            const camVal = document.getElementById('health-camera-val');
            const scanVal = document.getElementById('health-scanner-val');
            const topIcon = document.getElementById('top-status-icon');
            const topText = document.getElementById('top-status-text');
            const badge = document.getElementById('camera-badge');
            const badgeTx = document.getElementById('camera-badge-text');

            if (status === 'active') {
                camVal.textContent = 'Active'; camVal.className = 'font-bold text-green-600';
                scanVal.textContent = 'Running'; scanVal.className = 'font-bold text-green-600';
                topIcon.className = 'stat-icon bg-green-50 text-green-600';
                topText.textContent = 'Connected'; topText.className = 'text-sm font-bold text-green-600';
                badgeTx.textContent = 'Active';
                badge.className = 'inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-1 rounded-full text-xs font-semibold';
            } else {
                camVal.textContent = 'Inactive'; camVal.className = 'font-bold text-gray-400';
                scanVal.textContent = 'Off'; scanVal.className = 'font-bold text-gray-400';
                topIcon.className = 'stat-icon bg-gray-100 text-gray-500';
                topText.textContent = 'Idle'; topText.className = 'text-sm font-bold text-gray-400';
                badgeTx.textContent = 'Camera Idle';
                badge.className = 'inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-2.5 py-1 rounded-full text-xs font-semibold';
            }
        }

        /* ── Activity Log ────────────────────────────────────────────────── */
        function addLog(type, name, errorMsg = '') {
            const ul = document.getElementById('history-log');
            const empty = document.getElementById('log-empty');
            if (empty) empty.remove();

            const now = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            const li = document.createElement('li');
            li.className = 'flex items-start gap-2 text-xs relative pl-1';

            let icon = '<i class="ti ti-circle-check text-green-600 mt-0.5"></i>';
            let label = `<span class="font-semibold text-gray-800">${escHtml(name)}</span>`;

            if (type === 'fail') {
                icon = '<i class="ti ti-alert-circle text-red-600 mt-0.5"></i>';
                label = `<span class="text-red-700 font-semibold">${escHtml(name)}</span>
                     <span class="text-gray-400 block text-[10px]">${escHtml(errorMsg)}</span>`;
            }

            li.innerHTML = `
            <div class="flex items-center justify-between w-full gap-2">
                <div class="flex gap-2">${icon}<div>${label}</div></div>
                <span class="text-[10px] text-gray-400 shrink-0 font-mono">${now}</span>
            </div>`;

            ul.prepend(li);
            if (ul.children.length > 8) ul.removeChild(ul.lastChild);
        }

        /* ── Toast ───────────────────────────────────────────────────────── */
        function triggerToast(message, type = 'success') {
            const wrapper = document.getElementById('toast-wrapper');
            const toast = document.createElement('div');
            toast.className = `pointer-events-auto p-4 rounded-xl border flex items-center gap-2.5 shadow-lg text-sm text-white
            transition-all duration-300 transform translate-y-2 opacity-0
            ${type === 'success' ? 'bg-green-700 border-green-800' : 'bg-red-600 border-red-700'}`;
            toast.innerHTML = `
            <i class="ti ${type === 'success' ? 'ti-circle-check' : 'ti-alert-circle'}"></i>
            <span class="font-medium">${escHtml(message)}</span>`;
            wrapper.appendChild(toast);
            requestAnimationFrame(() => toast.classList.remove('translate-y-2', 'opacity-0'));
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        /* ── XSS helper ──────────────────────────────────────────────────── */
        function escHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        /* ── Init ────────────────────────────────────────────────────────── */
        window.addEventListener('DOMContentLoaded', () => {
            updateScannerHealth('inactive');
            renderPendingQueue(INITIAL_PENDING);
            // Auto-refresh stats every 30s
            setInterval(refreshStats, 30000);
            startCamera();
        });
    </script>
</x-app-layout>