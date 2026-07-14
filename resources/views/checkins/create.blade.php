<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Check-In Management</h1>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .scanner-container {
            border: 4px solid #e5e7eb;
            transition: border-color 0.3s ease;
            position: relative;
        }
        .scanner-container.detecting {
            border-color: #2d7a4a;
        }
        .scanner-container.detecting .scan-icon-pulse {
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }
        .spinner-loader {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .vf-corner {
            position: absolute; width: 28px; height: 28px;
            border-color: #2d7a4a; border-style: solid;
        }
        .vf-tl { top: 12px; left: 12px; border-width: 4px 0 0 4px; border-radius: 4px 0 0 0; }
        .vf-tr { top: 12px; right: 12px; border-width: 4px 4px 0 0; border-radius: 0 4px 0 0; }
        .vf-bl { bottom: 12px; left: 12px; border-width: 0 0 4px 4px; border-radius: 0 0 0 4px; }
        .vf-br { bottom: 12px; right: 12px; border-width: 0 4px 4px 0; border-radius: 0 0 4px 0; }
        .vf-scan-line {
            position: absolute; left: 16px; right: 16px; height: 3px;
            background: linear-gradient(90deg, transparent, #2d7a4a, transparent);
            top: 16px; animation: scanLine 2.5s ease-in-out infinite;
            z-index: 10;
        }
        @keyframes scanLine {
            0% { top: 16px; opacity: 1; }
            50% { opacity: 0.5; }
            100% { top: calc(100% - 20px); opacity: 1; }
        }
        .sc-controls {
            position: absolute; bottom: 20px; left: 0; right: 0;
            display: flex; justify-content: center; gap: 10px; z-index: 20;
        }
        #reader video {
            width: 100% !important;
            height: auto !important;
            object-fit: cover !important;
        }
    </style>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        {{-- 1. Top Information Bar (Grid 5 cols on Desktop) --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="text-2xl text-green-700 shrink-0"><i class="ti ti-user-check"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase">Check-ins</div>
                    <div class="text-lg font-bold text-gray-900" id="top-checkins">{{ $stats['today_checkins'] }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="text-2xl text-amber-500 shrink-0"><i class="ti ti-ticket"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase">Pending</div>
                    <div class="text-lg font-bold text-gray-900" id="top-pending">{{ $stats['pending_arrivals'] }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-3">
                <div class="text-2xl text-blue-600 shrink-0"><i class="ti ti-users"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase">Current</div>
                    <div class="text-lg font-bold text-gray-900" id="top-current">{{ $stats['current_visitors'] }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-3 col-span-2 md:col-span-1">
                <div class="text-2xl text-purple-600 shrink-0"><i class="ti ti-map-pin"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase font-sans truncate max-w-[120px]">Spot Name</div>
                    <div class="text-sm font-bold text-gray-900 truncate max-w-[120px]" title="{{ $stats['destination_name'] }}">{{ $stats['destination_name'] }}</div>
                </div>
            </div>
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm flex items-center gap-3 col-span-2 md:col-span-1">
                <div class="text-2xl text-gray-600 shrink-0" id="top-status-icon"><i class="ti ti-camera"></i></div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase">Camera</div>
                    <div class="text-sm font-bold text-gray-500" id="top-status-text">Disconnected</div>
                </div>
            </div>
        </div>

        {{-- Main Scanner Section Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Left: Scanner Area (70% on desktop) --}}
            <div class="lg:col-span-8 space-y-4">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-150 flex justify-between items-center bg-gray-50">
                        <h2 class="font-bold text-gray-800 text-base flex items-center gap-2">
                            <i class="ti ti-qrcode text-green-700"></i> QR Code Ticket Scanner
                        </h2>
                        <span id="camera-badge" class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-semibold">
                            <i class="ti ti-camera"></i> <span id="camera-badge-text">Camera Idle</span>
                        </span>
                    </div>
                    
                    {{-- Camera frame view --}}
                    <div class="p-6">
                        <div class="scanner-container bg-black rounded-xl overflow-hidden min-h-[380px] flex items-center justify-center relative" id="scanner-frame">
                            <div id="reader" class="w-full"></div>
                            
                            {{-- Target Viewfinder Frame --}}
                            <div class="absolute inset-0 pointer-events-none z-10" id="viewfinder" style="display: none;">
                                <div class="vf-corner vf-tl"></div>
                                <div class="vf-corner vf-tr"></div>
                                <div class="vf-corner vf-bl"></div>
                                <div class="vf-corner vf-br"></div>
                                <div class="vf-scan-line"></div>
                            </div>
                            
                            {{-- Camera Off Screen --}}
                            <div class="text-center text-gray-500 absolute" id="camera-idle">
                                <div class="text-5xl mb-3"><i class="ti ti-camera-off text-gray-600"></i></div>
                                <p class="text-sm">Camera is paused or inactive</p>
                            </div>

                            {{-- Realtime Overlays --}}
                            <div class="absolute inset-0 bg-black/75 z-20 flex flex-col items-center justify-center text-white" id="verifying-overlay" style="display: none;">
                                <i class="ti ti-loader-2 text-4xl text-green-500 spinner-loader mb-2"></i>
                                <span class="text-sm font-semibold tracking-wide">Verifying ticket details...</span>
                            </div>

                            <div class="sc-controls">
                                <button class="bg-green-700 hover:bg-green-800 text-white font-bold px-6 py-2.5 rounded-full text-sm flex items-center gap-1.5 shadow" onclick="startCamera()" id="btn-start">
                                    <i class="ti ti-player-play"></i> Start Camera
                                </button>
                                <button class="bg-white/10 hover:bg-white/20 text-white border border-white/25 font-bold px-6 py-2.5 rounded-full text-sm flex items-center gap-1.5 shadow" onclick="stopCamera()" id="btn-stop" style="display: none;">
                                    <i class="ti ti-player-pause"></i> Pause Camera
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Panel: Status, Manual Entry, Verification Card & Log (30% on desktop) --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Status Overview Card --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Scanner Health</h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-sm" id="health-camera">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-camera"></i> Camera Link</span>
                            <span class="font-bold text-gray-400" id="health-camera-val">Inactive</span>
                        </div>
                        <div class="flex items-center justify-between text-sm" id="health-scanner">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-scan"></i> Decoder Status</span>
                            <span class="font-bold text-gray-400" id="health-scanner-val">Off</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500 flex items-center gap-1.5"><i class="ti ti-wifi"></i> Connection</span>
                            <span class="font-bold text-green-600">Online</span>
                        </div>
                    </div>
                </div>

                {{-- Post-Scan Verification Result Card --}}
                <div id="result-card" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm" style="display: none;"></div>

                {{-- Manual Verification Card --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
                    <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                        <i class="ti ti-keyboard text-green-700"></i> Manual Verification
                    </h3>
                    <div class="space-y-2.5">
                        <input type="text" id="manual-input" placeholder="Enter Booking Code or QR Token" onkeydown="if(event.key === 'Enter') verifyManual()" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none h-11">
                        <button onclick="verifyManual()" class="w-full bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg py-2.5 text-sm flex items-center justify-center gap-1.5 transition">
                            <i class="ti ti-search"></i> Verify Ticket
                        </button>
                    </div>
                </div>

                {{-- Visual Activity Log Timeline --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Recent Activity Timeline</h3>
                    <div class="max-h-48 overflow-y-auto pr-1">
                        <ul id="history-log" class="space-y-3 relative border-l border-gray-150 pl-4 py-1">
                            <li id="log-empty" class="text-xs text-gray-400 italic">No verification activities recorded yet.</li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- Notification Toast Container --}}
    <div id="toast-wrapper" class="fixed bottom-5 right-5 z-50 space-y-2"></div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        let scanner = null;
        let lastToken = null;
        let scanning = false;
        const VERIFY_URL = "{{ route('staff.verify-ticket') }}";
        const STATS_URL = "{{ route('checkins.stats') }}";
        const CSRF = "{{ csrf_token() }}";

        function updateScannerHealth(status) {
            const cameraVal = document.getElementById('health-camera-val');
            const scannerVal = document.getElementById('health-scanner-val');
            const topStatusIcon = document.getElementById('top-status-icon');
            const topStatusText = document.getElementById('top-status-text');
            const cameraBadgeText = document.getElementById('camera-badge-text');
            const cameraBadge = document.getElementById('camera-badge');

            if (status === 'active') {
                cameraVal.textContent = 'Active';
                cameraVal.className = 'font-bold text-green-600';
                scannerVal.textContent = 'Running';
                scannerVal.className = 'font-bold text-green-600';
                topStatusIcon.className = 'text-2xl text-green-600 shrink-0';
                topStatusText.textContent = 'Connected';
                topStatusText.className = 'text-sm font-bold text-green-600';
                cameraBadgeText.textContent = 'Camera Active';
                cameraBadge.className = 'inline-flex items-center gap-1 bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs font-semibold';
            } else {
                cameraVal.textContent = 'Inactive';
                cameraVal.className = 'font-bold text-gray-400';
                scannerVal.textContent = 'Off';
                scannerVal.className = 'font-bold text-gray-400';
                topStatusIcon.className = 'text-2xl text-gray-600 shrink-0';
                topStatusText.textContent = 'Disconnected';
                topStatusText.className = 'text-sm font-bold text-gray-500';
                cameraBadgeText.textContent = 'Camera Idle';
                cameraBadge.className = 'inline-flex items-center gap-1 bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs font-semibold';
            }
        }

        function triggerToast(message, type = 'success') {
            const wrapper = document.getElementById('toast-wrapper');
            const toast = document.createElement('div');
            toast.className = `p-4 rounded-xl border flex items-center gap-2.5 shadow-lg text-sm text-white transition-all duration-300 transform translate-y-2 opacity-0
                ${type === 'success' ? 'bg-green-700 border-green-800' : 'bg-red-600 border-red-700'}`;
            
            toast.innerHTML = `
                <i class="ti ${type === 'success' ? 'ti-circle-check' : 'ti-alert-circle'}"></i>
                <span class="font-medium">${message}</span>
            `;
            wrapper.appendChild(toast);
            setTimeout(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            }, 10);

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function refreshStats() {
            fetch(STATS_URL, {
                headers: { 'Accept': 'application/json' }
            })
            .then(r => r.json())
            .then(data => {
                document.getElementById('top-checkins').textContent = data.today_checkins;
                document.getElementById('top-pending').textContent = data.pending_arrivals;
                document.getElementById('top-current').textContent = data.current_visitors;
            })
            .catch(() => {});
        }

        function startCamera() {
            document.getElementById('camera-idle').style.display = 'none';
            document.getElementById('viewfinder').style.display = 'block';
            document.getElementById('btn-start').style.display = 'none';
            document.getElementById('btn-stop').style.display  = 'flex';
            document.getElementById('scanner-frame').className = 'scanner-container bg-black rounded-xl overflow-hidden min-h-[380px] flex items-center justify-center relative detecting';
            
            updateScannerHealth('active');
            lastToken = null;

            scanner = new Html5Qrcode("reader");
            scanner.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 230, height: 230 } },
                onScan, () => {}
            ).catch(err => {
                stopCamera();
                triggerToast(err.message || 'Camera access denied.', 'error');
            });
            scanning = true;
        }

        function stopCamera() {
            if (scanner) {
                scanner.stop().catch(() => {});
                scanner = null;
            }
            scanning = false;
            document.getElementById('viewfinder').style.display = 'none';
            document.getElementById('btn-start').style.display = 'flex';
            document.getElementById('btn-stop').style.display  = 'none';
            document.getElementById('scanner-frame').className = 'scanner-container bg-black rounded-xl overflow-hidden min-h-[380px] flex items-center justify-center relative';
            document.getElementById('camera-idle').style.display = 'block';
            
            updateScannerHealth('inactive');
        }

        function onScan(token) {
            if (token === lastToken) return;
            lastToken = token;
            stopCamera();
            beep();
            verify(token);
        }

        function verifyManual() {
            const token = document.getElementById('manual-input').value.trim();
            if (!token) { document.getElementById('manual-input').focus(); return; }
            verify(token);
        }

        function showLoading() {
            document.getElementById('verifying-overlay').style.display = 'flex';
        }

        function hideLoading() {
            document.getElementById('verifying-overlay').style.display = 'none';
        }

        function verify(token) {
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
                    showValid(data);
                    addLog('success', data.tourist_name || 'Visitor');
                    triggerToast('Check-in successful!');
                    refreshStats();
                } else {
                    showInvalid(data.message || 'Verification failed');
                    addLog('fail', token.substring(0, 12) + '…', data.message);
                    triggerToast(data.message || 'Invalid Ticket', 'error');
                }
            })
            .catch(() => {
                hideLoading();
                showInvalid('Network error — please try again.');
                addLog('pending', token.substring(0, 12) + '…', 'Network Connection Error');
                triggerToast('Network verification failure', 'error');
            });
        }

        function showValid(d) {
            const card = document.getElementById('result-card');
            card.style.display = 'block';
            card.className = "bg-green-50 border border-green-300 rounded-xl p-5 shadow-sm space-y-3.5";
            card.innerHTML = `
                <div class="flex items-center gap-2 border-b border-green-200 pb-2">
                    <i class="ti ti-circle-check text-green-700 text-xl"></i>
                    <h3 class="font-bold text-green-800 text-sm">Check-in Verified</h3>
                </div>
                <div class="space-y-2 text-xs text-green-900">
                    <div class="flex justify-between"><span class="font-medium flex items-center gap-1"><i class="ti ti-user"></i> Visitor</span> <span class="font-bold">${d.tourist_name}</span></div>
                    <div class="flex justify-between"><span class="font-medium flex items-center gap-1"><i class="ti ti-map-pin"></i> Spot</span> <span class="font-bold">${d.destination_name}</span></div>
                    <div class="flex justify-between"><span class="font-medium flex items-center gap-1"><i class="ti ti-calendar"></i> Visit Date</span> <span class="font-bold">${d.visit_date}</span></div>
                    <div class="flex justify-between"><span class="font-medium flex items-center gap-1"><i class="ti ti-users-group"></i> Guests</span> <span class="font-bold">1 Guest</span></div>
                    <div class="flex justify-between items-center"><span class="font-medium flex items-center gap-1"><i class="ti ti-ticket"></i> Booking Status</span> <span class="bg-green-200 text-green-800 px-2 py-0.5 rounded-full font-bold">Confirmed</span></div>
                    <div class="flex justify-between items-center"><span class="font-medium flex items-center gap-1"><i class="ti ti-circle-check"></i> Check-in Status</span> <span class="bg-green-800 text-white px-2 py-0.5 rounded-full font-bold">Completed</span></div>
                </div>
                <div class="pt-2 flex gap-2">
                    <button onclick="resetScanner()" class="flex-1 bg-green-700 hover:bg-green-800 text-white font-semibold py-2 rounded-lg text-xs flex items-center justify-center gap-1 transition">
                        <i class="ti ti-scan"></i> Scan Next
                    </button>
                </div>
            `;
        }

        function showInvalid(msg) {
            const card = document.getElementById('result-card');
            card.style.display = 'block';
            card.className = "bg-red-50 border border-red-300 rounded-xl p-5 shadow-sm space-y-3.5";
            card.innerHTML = `
                <div class="flex items-center gap-2 border-b border-red-200 pb-2">
                    <i class="ti ti-alert-triangle text-red-600 text-xl"></i>
                    <h3 class="font-bold text-red-800 text-sm">Access Denied</h3>
                </div>
                <p class="text-xs text-red-900 font-medium leading-relaxed">${msg}</p>
                <div class="pt-2">
                    <button onclick="resetScanner()" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg text-xs flex items-center justify-center gap-1 transition">
                        <i class="ti ti-rotate-clockwise"></i> Try Again
                    </button>
                </div>
            `;
        }

        function resetScanner() {
            document.getElementById('manual-input').value = '';
            document.getElementById('result-card').style.display = 'none';
            startCamera();
        }

        function addLog(type, name, errorMsg = '') {
            const ul = document.getElementById('history-log');
            const empty = document.getElementById('log-empty');
            if (empty) empty.remove();
            
            const now = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            const li = document.createElement('li');
            li.className = 'flex items-start gap-2 text-xs relative pl-1';
            
            let statusIcon = '<i class="ti ti-circle-check text-green-600 mt-0.5"></i>';
            let label = name;
            
            if (type === 'fail') {
                statusIcon = '<i class="ti ti-alert-circle text-red-600 mt-0.5"></i>';
                label = `<span class="text-red-700 font-medium">Invalid QR Code</span> <span class="text-gray-400 block text-[10px]">${errorMsg}</span>`;
            } else if (type === 'pending') {
                statusIcon = '<i class="ti ti-clock text-amber-500 mt-0.5"></i>';
                label = `<span class="text-amber-700 font-medium">${name}</span> <span class="text-gray-400 block text-[10px]">${errorMsg}</span>`;
            }
            
            li.innerHTML = `
                <div class="flex items-center gap-2 w-full justify-between">
                    <div class="flex gap-2">
                        ${statusIcon}
                        <div class="flex flex-col">
                            <span class="font-semibold text-gray-800">${label}</span>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 shrink-0 font-mono">${now}</span>
                </div>
            `;
            
            ul.prepend(li);
            
            // Limit timeline to 5 logs
            if (ul.children.length > 5) {
                ul.removeChild(ul.lastChild);
            }
        }

        function beep() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain); gain.connect(ctx.destination);
                osc.type = 'sine'; osc.frequency.setValueAtTime(880, ctx.currentTime);
                gain.gain.setValueAtTime(0.08, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.15);
                osc.start(); osc.stop(ctx.currentTime + 0.15);
            } catch {}
        }

        window.addEventListener('DOMContentLoaded', () => {
            updateScannerHealth('inactive');
            startCamera();
        });
    </script>
</x-app-layout>
