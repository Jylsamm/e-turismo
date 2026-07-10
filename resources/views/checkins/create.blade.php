<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --ocean: #0891b2; --indigo: #4f46e5; --purple: #7c3aed;
            --emerald: #059669; --rose: #e11d48;
            --bg: #0f172a; --card-bg: #1e293b; --border: #334155;
            --text-1: #f1f5f9; --text-2: #cbd5e1; --text-3: #94a3b8; --text-4: #64748b;
            --t: 0.2s cubic-bezier(0.4,0,0.2,1);
        }
        #scanner-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        #scanner-page { background: var(--bg); min-height: 100vh; display: flex; flex-direction: column; }

        /* Header */
        .sc-header {
            background: linear-gradient(90deg, #0f172a, #1e293b);
            border-bottom: 1px solid var(--border);
            padding: 16px 24px; display: flex; align-items: center; justify-content: space-between; gap: 12px;
        }
        .sc-header-title { font-family: 'Fraunces', serif; font-size: 1.25rem; color: var(--text-1); display: flex; align-items: center; gap: 10px; }
        .sc-header-badge {
            display: flex; align-items: center; gap: 6px;
            background: rgba(13,148,136,.2); border: 1px solid rgba(13,148,136,.4); color: #5eead4;
            padding: 4px 12px; border-radius: 99px; font-size: .72rem; font-weight: 700;
        }
        .sc-dot { width: 7px; height: 7px; border-radius: 50%; background: #10b981; animation: blink 1.4s infinite; }
        @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

        /* Layout */
        .sc-body { flex: 1; display: grid; grid-template-columns: 1fr 380px; gap: 0; }
        @media (max-width: 900px) { .sc-body { grid-template-columns: 1fr; } }

        /* Camera panel */
        .sc-camera { background: #0a0f1e; position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 480px; }
        #reader {
            width: 100%; max-width: 560px;
            border-radius: 0;
        }
        /* Override html5-qrcode styles */
        #reader video { border-radius: 0 !important; }
        #reader__scan_region { min-height: 360px; }
        #reader__scan_region img { display: none !important; }

        .sc-viewfinder {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            width: 220px; height: 220px; pointer-events: none; z-index: 10;
        }
        .vf-corner {
            position: absolute; width: 28px; height: 28px;
            border-color: var(--teal); border-style: solid;
        }
        .vf-tl { top: 0; left: 0; border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
        .vf-tr { top: 0; right: 0; border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
        .vf-bl { bottom: 0; left: 0; border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
        .vf-br { bottom: 0; right: 0; border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }
        .vf-scan-line {
            position: absolute; left: 4px; right: 4px; height: 2px;
            background: linear-gradient(90deg, transparent, var(--teal), transparent);
            top: 4px; animation: scanLine 2s ease-in-out infinite;
        }
        @keyframes scanLine {
            0% { top: 4px; opacity: 1; }
            50% { opacity: .7; }
            100% { top: calc(100% - 6px); opacity: 1; }
        }

        .sc-camera-idle { color: var(--text-3); text-align: center; padding: 40px; }
        .sc-camera-idle .idle-icon { font-size: 4rem; margin-bottom: 16px; opacity: .4; }
        .sc-camera-idle p { font-size: .9rem; }

        /* Camera controls */
        .sc-controls { position: absolute; bottom: 20px; left: 0; right: 0; display: flex; justify-content: center; gap: 10px; z-index: 20; }
        .sc-ctrl-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 99px; font-size: .78rem; font-weight: 700;
            border: 1.5px solid; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .sc-ctrl-start { background: var(--teal); color: #fff; border-color: var(--teal); box-shadow: 0 4px 14px rgba(13,148,136,.4); }
        .sc-ctrl-start:hover { background: #0f766e; box-shadow: 0 6px 20px rgba(13,148,136,.5); }
        .sc-ctrl-stop { background: transparent; color: var(--text-3); border-color: var(--border); }
        .sc-ctrl-stop:hover { color: var(--text-1); border-color: var(--text-3); }

        /* Sidebar panel */
        .sc-side { background: var(--card-bg); border-left: 1px solid var(--border); display: flex; flex-direction: column; }
        @media (max-width: 900px) { .sc-side { border-left: none; border-top: 1px solid var(--border); } }

        .sc-side-section { padding: 20px; border-bottom: 1px solid var(--border); }
        .sc-side-title { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .8px; color: var(--text-4); margin-bottom: 14px; }

        /* Verification result */
        #result-area { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
        .result-idle { text-align: center; color: var(--text-4); }
        .result-idle-icon { font-size: 3rem; margin-bottom: 12px; opacity: .4; display: block; }
        .result-idle p  { font-size: .85rem; }

        .result-card {
            border-radius: 16px; padding: 20px; animation: popIn .25s cubic-bezier(0.34,1.56,0.64,1);
        }
        @keyframes popIn { from { opacity:0; transform:scale(.93); } to { opacity:1; transform:scale(1); } }
        .result-valid   { background: rgba(5,150,105,.12); border: 1.5px solid rgba(5,150,105,.4); }
        .result-invalid { background: rgba(225,29,72,.1); border: 1.5px solid rgba(225,29,72,.35); }
        .result-loading { background: rgba(79,70,229,.1); border: 1.5px solid rgba(79,70,229,.3); }

        .result-icon { font-size: 2.5rem; display: block; text-align: center; margin-bottom: 12px; }
        .result-title { font-family: 'Fraunces', serif; font-size: 1.1rem; text-align: center; margin-bottom: 14px; }
        .result-title-valid   { color: #6ee7b7; }
        .result-title-invalid { color: #fda4af; }

        .result-row { display: flex; justify-content: space-between; align-items: flex-start; gap: 8px; margin-bottom: 8px; font-size: .8rem; }
        .result-row-label { color: var(--text-4); }
        .result-row-value { color: var(--text-1); font-weight: 700; text-align: right; max-width: 180px; }

        .result-msg { font-size: .85rem; color: var(--text-2); text-align: center; margin-top: 4px; }

        .btn-scan-next {
            width: 100%; margin-top: 16px; padding: 10px; border-radius: 12px;
            font-size: .82rem; font-weight: 800; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif; border: none;
        }
        .btn-scan-next-valid { background: linear-gradient(135deg, var(--teal), var(--ocean)); color: #fff; box-shadow: 0 4px 14px rgba(13,148,136,.3); }
        .btn-scan-next-valid:hover { transform: translateY(-1px); box-shadow: 0 7px 20px rgba(13,148,136,.4); }
        .btn-scan-next-invalid { background: var(--border); color: var(--text-2); }
        .btn-scan-next-invalid:hover { background: #475569; }

        /* Manual input */
        .sc-manual-wrap { display: flex; gap: 8px; }
        .sc-manual-input {
            flex: 1; background: #0f172a; border: 1.5px solid var(--border);
            border-radius: 10px; padding: 9px 14px; color: var(--text-1);
            font-family: 'Courier New', monospace; font-size: .82rem; outline: none;
            transition: border-color var(--t);
        }
        .sc-manual-input:focus { border-color: var(--teal); }
        .sc-manual-input::placeholder { color: var(--text-4); font-family: 'Plus Jakarta Sans', sans-serif; }
        .sc-manual-btn {
            background: var(--indigo); color: #fff; border: none; border-radius: 10px;
            padding: 9px 16px; font-size: .78rem; font-weight: 700; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif; white-space: nowrap;
        }
        .sc-manual-btn:hover { background: #4338ca; }

        /* History log */
        #history-log { list-style: none; display: flex; flex-direction: column; gap: 6px; }
        .log-item { display: flex; align-items: center; gap: 8px; font-size: .75rem; padding: 6px 0; border-bottom: 1px solid #1e293b; }
        .log-dot  { width: 7px; height: 7px; border-radius: 50%; flex-shrink: 0; }
        .log-dot-ok   { background: #10b981; }
        .log-dot-fail { background: #f43f5e; }
        .log-name { color: var(--text-2); font-weight: 600; flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .log-time { color: var(--text-4); flex-shrink: 0; }
        .log-empty { color: var(--text-4); font-size: .8rem; font-style: italic; }

        /* Loading spinner */
        .sc-spinner {
            width: 40px; height: 40px; border: 3px solid var(--border);
            border-top-color: var(--teal); border-radius: 50%;
            animation: spin .7s linear infinite; margin: 0 auto 12px;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    <div id="scanner-page">
        {{-- Header --}}
        <div class="sc-header">
            <div class="sc-header-title">
                📷 QR Ticket Scanner
            </div>
            <div class="sc-header-badge">
                <span class="sc-dot" id="status-dot"></span>
                <span id="status-text">Starting camera…</span>
            </div>
        </div>

        <div class="sc-body">
            {{-- Camera --}}
            <div class="sc-camera">
                <div id="reader"></div>
                <div class="sc-viewfinder" id="viewfinder" style="display:none;">
                    <div class="vf-corner vf-tl"></div>
                    <div class="vf-corner vf-tr"></div>
                    <div class="vf-corner vf-bl"></div>
                    <div class="vf-corner vf-br"></div>
                    <div class="vf-scan-line"></div>
                </div>
                <div class="sc-camera-idle" id="camera-idle">
                    <div class="idle-icon">📷</div>
                    <p>Initializing camera…</p>
                </div>
                <div class="sc-controls">
                    <button class="sc-ctrl-btn sc-ctrl-start" onclick="startCamera()" id="btn-start">▶ Start Camera</button>
                    <button class="sc-ctrl-btn sc-ctrl-stop" onclick="stopCamera()" id="btn-stop" style="display:none;">⏸ Pause</button>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="sc-side">
                {{-- Verification result --}}
                <div id="result-area">
                    <div class="result-idle" id="result-idle">
                        <span class="result-idle-icon">🎟️</span>
                        <p>Scan a tourist's QR ticket or enter the code manually to verify and check them in.</p>
                    </div>
                    <div id="result-card" style="display:none;"></div>
                </div>

                {{-- Manual input --}}
                <div class="sc-side-section">
                    <div class="sc-side-title">Manual Entry</div>
                    <div class="sc-manual-wrap">
                        <input type="text" id="manual-input" class="sc-manual-input"
                            placeholder="Paste token or scan code…"
                            onkeydown="if(event.key==='Enter') verifyManual()">
                        <button class="sc-manual-btn" onclick="verifyManual()">Verify</button>
                    </div>
                </div>

                {{-- Session log --}}
                <div class="sc-side-section" style="border-bottom:none;flex:1;overflow-y:auto;">
                    <div class="sc-side-title">Session Log</div>
                    <ul id="history-log">
                        <li class="log-empty">No scans yet this session.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
    let scanner = null;
    let lastToken = null;
    let scanning = false;
    const VERIFY_URL = "{{ route('staff.verify-ticket') }}";
    const CSRF = "{{ csrf_token() }}";

    function setStatus(text, active = true) {
        document.getElementById('status-text').textContent = text;
        const dot = document.getElementById('status-dot');
        dot.style.background = active ? '#10b981' : '#64748b';
        dot.style.animation  = active ? 'blink 1.4s infinite' : 'none';
    }

    function startCamera() {
        document.getElementById('camera-idle').style.display = 'none';
        document.getElementById('viewfinder').style.display = 'block';
        document.getElementById('btn-start').style.display = 'none';
        document.getElementById('btn-stop').style.display  = 'flex';
        setStatus('Camera active — scanning…');
        lastToken = null;

        scanner = new Html5Qrcode("reader");
        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 230, height: 230 } },
            onScan, () => {}
        ).catch(err => {
            setStatus('Camera unavailable', false);
            document.getElementById('camera-idle').innerHTML = `<div class="idle-icon">⚠️</div><p>${err.message || 'Camera access denied.'}</p>`;
            document.getElementById('camera-idle').style.display = 'block';
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
        setStatus('Camera paused', false);
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
        document.getElementById('result-idle').style.display = 'none';
        const card = document.getElementById('result-card');
        card.style.display = 'block';
        card.innerHTML = `
            <div class="result-card result-loading">
                <div class="sc-spinner"></div>
                <p style="text-align:center;color:#94a3b8;font-size:.85rem;">Verifying ticket…</p>
            </div>`;
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
            if (data.valid) {
                showValid(data);
                addLog(true, data.tourist_name);
            } else {
                showInvalid(data.message);
                addLog(false, token.substring(0,12) + '…');
            }
        })
        .catch(() => showInvalid('Network error — please try again.'));
    }

    function showValid(d) {
        const card = document.getElementById('result-card');
        card.style.display = 'block';
        card.innerHTML = `
            <div class="result-card result-valid">
                <span class="result-icon">✅</span>
                <div class="result-title result-title-valid">Check-In Successful!</div>
                <div class="result-row"><span class="result-row-label">Tourist</span><span class="result-row-value">${d.tourist_name}</span></div>
                <div class="result-row"><span class="result-row-label">Destination</span><span class="result-row-value">${d.destination_name}</span></div>
                <div class="result-row"><span class="result-row-label">Visit Date</span><span class="result-row-value">${d.visit_date}</span></div>
                <div class="result-row"><span class="result-row-label">Checked In At</span><span class="result-row-value">${d.checked_in_at}</span></div>
                <button class="btn-scan-next btn-scan-next-valid" onclick="resetAndScan()">▶ Scan Next Ticket</button>
            </div>`;
    }

    function showInvalid(msg) {
        const card = document.getElementById('result-card');
        card.style.display = 'block';
        card.innerHTML = `
            <div class="result-card result-invalid">
                <span class="result-icon">🚫</span>
                <div class="result-title result-title-invalid">Access Denied</div>
                <p class="result-msg">${msg}</p>
                <button class="btn-scan-next btn-scan-next-invalid" onclick="resetAndScan()">↩ Scan Again</button>
            </div>`;
    }

    function resetAndScan() {
        lastToken = null;
        document.getElementById('manual-input').value = '';
        document.getElementById('result-card').style.display = 'none';
        document.getElementById('result-idle').style.display = 'block';
        startCamera();
    }

    function addLog(ok, name) {
        const ul = document.getElementById('history-log');
        const empty = ul.querySelector('.log-empty');
        if (empty) empty.remove();
        const now = new Date().toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit' });
        const li = document.createElement('li');
        li.className = 'log-item';
        li.innerHTML = `
            <span class="log-dot ${ok ? 'log-dot-ok' : 'log-dot-fail'}"></span>
            <span class="log-name">${ok ? '✅ ' : '❌ '}${name}</span>
            <span class="log-time">${now}</span>`;
        ul.prepend(li);
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
        setStatus('Ready', false);
        startCamera();
    });
    </script>
</x-app-layout>
