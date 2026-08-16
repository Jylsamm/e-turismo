<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">📷 On-Site QR Ticket Check-In</h1>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white rounded-2xl border border-gray-150 overflow-hidden shadow-sm p-6">
            <div class="text-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Scan Tourist Ticket</h2>
                <p class="text-xs text-gray-500 mt-1">Position the tourist's QR code in front of the camera to verify their booking and check them in.</p>
            </div>

            {{-- Scanner Window --}}
            <div class="relative bg-gray-900 rounded-2xl overflow-hidden aspect-video border border-gray-800 flex items-center justify-center">
                <div id="reader" class="w-full h-full"></div>
                <div id="scanner-overlay" class="absolute inset-0 border-2 border-brand-500/50 rounded-2xl pointer-events-none flex items-center justify-center">
                    <div class="w-48 h-48 border-2 border-dashed border-brand-400 rounded-xl animate-pulse"></div>
                </div>
            </div>

            {{-- Controls --}}
            <div class="mt-4 flex justify-center gap-3">
                <button onclick="startScanning()" class="bg-brand-700 hover:bg-brand-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition">
                    🔄 Start/Switch Camera
                </button>
                <button onclick="stopScanning()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-xs px-4 py-2 rounded-xl transition">
                    🛑 Pause Camera
                </button>
            </div>

            {{-- Verification Results --}}
            <div id="verification-result" class="mt-6 space-y-4 hidden">
                {{-- Dynamic content injected here --}}
            </div>
        </div>
    </div>

    {{-- html5-qrcode Library CDN --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js" type="text/javascript"></script>

    <script>
        let html5QrcodeScanner = null;
        let lastResult = null;
        let isScanningActive = false;
        let scanCanvas = null;
        let scanContext = null;

        async function startScanning() {
            if (html5QrcodeScanner) await stopScanning();

            document.getElementById('verification-result').classList.add('hidden');
            lastResult = null;

            const config = {
                fps: 25,
                qrbox: (viewfinderWidth, viewfinderHeight) => {
                    const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                    const size = Math.floor(minEdge * 0.85);
                    return { width: size, height: size };
                }
            };

            const constraintsToTry = [
                { facingMode: "environment" },
                { facingMode: "environment", width: { ideal: 1280 }, height: { ideal: 720 } },
                {}
            ];

            let started = false;
            let lastError = null;

            for (const c of constraintsToTry) {
                try {
                    if (html5QrcodeScanner) {
                        try {
                            if (html5QrcodeScanner.isScanning || (typeof html5QrcodeScanner.getState === 'function' && html5QrcodeScanner.getState() === 2)) {
                                await html5QrcodeScanner.stop();
                            }
                        } catch (_) { }
                        html5QrcodeScanner = null;
                    }
                    html5QrcodeScanner = new Html5Qrcode("reader");
                    await html5QrcodeScanner.start(c, config, onScanSuccess, onScanFailure);
                    started = true;
                    isScanningActive = true;
                    requestAnimationFrame(scanVideoFrameWithJsQRScanPage);
                    break;
                } catch (err) {
                    lastError = err;
                }
            }

            if (!started) {
                stopScanning();
                console.error("Error starting scanner: ", lastError);
                alert("Camera permission denied or camera not found: " + ((lastError && lastError.message) || lastError));
            }
        }

        function scanVideoFrameWithJsQRScanPage() {
            if (!isScanningActive) return;
            try {
                const video = document.querySelector('#reader video');
                if (video && video.readyState >= 2 && video.videoWidth > 0) {
                    if (!scanCanvas) {
                        scanCanvas = document.createElement('canvas');
                        scanContext = scanCanvas.getContext('2d', { willReadFrequently: true });
                    }
                    scanCanvas.width = video.videoWidth;
                    scanCanvas.height = video.videoHeight;

                    // Pass 1: Standard Frame + Inverted Color Check
                    scanContext.drawImage(video, 0, 0, scanCanvas.width, scanCanvas.height);
                    let imageData = scanContext.getImageData(0, 0, scanCanvas.width, scanCanvas.height);

                    if (typeof jsQR !== 'undefined') {
                        let code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: "attemptBoth",
                        });

                        // Pass 2: Horizontally Flipped Frame (handles mirrored QR codes / front-camera mirrors)
                        if (!code || !code.data) {
                            scanContext.save();
                            scanContext.translate(scanCanvas.width, 0);
                            scanContext.scale(-1, 1);
                            scanContext.drawImage(video, 0, 0, scanCanvas.width, scanCanvas.height);
                            scanContext.restore();
                            imageData = scanContext.getImageData(0, 0, scanCanvas.width, scanCanvas.height);
                            code = jsQR(imageData.data, imageData.width, imageData.height, {
                                inversionAttempts: "attemptBoth",
                            });
                        }

                        // Pass 3: Contrast Binarization (thresholding for creased/damaged/shadowed prints)
                        if (!code || !code.data) {
                            const d = imageData.data;
                            for (let i = 0; i < d.length; i += 4) {
                                const gray = (d[i] * 0.299 + d[i + 1] * 0.587 + d[i + 2] * 0.114);
                                const val = gray < 128 ? 0 : 255;
                                d[i] = val;
                                d[i + 1] = val;
                                d[i + 2] = val;
                            }
                            code = jsQR(d, imageData.width, imageData.height, {
                                inversionAttempts: "attemptBoth",
                            });
                        }

                        if (code && code.data && code.data.trim()) {
                            onScanSuccess(code.data.trim());
                            return;
                        }
                    }
                }
            } catch (_) { }

            if (isScanningActive) {
                requestAnimationFrame(scanVideoFrameWithJsQRScanPage);
            }
        }

        function stopScanning() {
            isScanningActive = false;
            if (html5QrcodeScanner) {
                try {
                    if (html5QrcodeScanner.isScanning || (typeof html5QrcodeScanner.getState === 'function' && html5QrcodeScanner.getState() === 2)) {
                        html5QrcodeScanner.stop().catch(() => { });
                    }
                } catch (_) { }
                html5QrcodeScanner = null;
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText === lastResult) return; // Prevent duplicate reads
            lastResult = decodedText;

            // Pause scanning while verifying
            stopScanning();

            // Play scan sound if possible
            try {
                const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.type = "sine";
                osc.frequency.setValueAtTime(800, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.1, audioCtx.currentTime);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.1);
            } catch(e) {}

            verifyTicketToken(decodedText);
        }

        function onScanFailure(error) {
            // Silence minor scanning noise / errors
        }

        function verifyTicketToken(token) {
            const resultBox = document.getElementById('verification-result');
            resultBox.classList.remove('hidden');
            resultBox.innerHTML = `
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center gap-3">
                    <svg class="animate-spin h-5 w-5 text-brand-600" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-600">Verifying ticket payload...</span>
                </div>`;

            fetch("{{ route('staff.verify-ticket') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ qr_token: token })
            })
            .then(res => res.json())
            .then(data => {
                if (data.valid) {
                    resultBox.innerHTML = `
                        <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-950 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">✅</span>
                                <h3 class="font-bold text-base text-emerald-900">Check-in Successful!</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-xs border-t border-emerald-100 pt-3">
                                <div><span class="opacity-75">Tourist:</span> <p class="font-bold">${data.tourist_name}</p></div>
                                <div><span class="opacity-75">Destination:</span> <p class="font-bold">${data.destination_name}</p></div>
                                <div><span class="opacity-75">Visit Date:</span> <p class="font-bold">${data.visit_date}</p></div>
                                <div><span class="opacity-75">Checked In:</span> <p class="font-bold">${data.checked_in_at}</p></div>
                            </div>
                            <button onclick="startScanning()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs py-2 rounded-xl transition mt-2">
                                Scan Next Ticket
                            </button>
                        </div>`;
                } else {
                    resultBox.innerHTML = `
                        <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-950 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xl">🚫</span>
                                <h3 class="font-bold text-base text-rose-900">Access Denied</h3>
                            </div>
                            <p class="text-xs text-rose-800">${data.message}</p>
                            <button onclick="startScanning()" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-2 rounded-xl transition mt-2">
                                Scan Next Ticket
                            </button>
                        </div>`;
                }
            })
            .catch(err => {
                console.error("Verification error:", err);
                resultBox.innerHTML = `
                    <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-950 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="text-xl">⚠️</span>
                            <h3 class="font-bold text-base text-rose-900">Network / Server Error</h3>
                        </div>
                        <p class="text-xs text-rose-800">Could not communicate with the verification server. Please try again.</p>
                        <button onclick="startScanning()" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs py-2 rounded-xl transition mt-2">
                            Scan Next Ticket
                        </button>
                    </div>`;
            });
        }

        // Auto start on page load
        window.addEventListener('DOMContentLoaded', startScanning);
    </script>
</x-app-layout>
