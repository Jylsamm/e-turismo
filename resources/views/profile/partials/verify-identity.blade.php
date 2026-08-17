<style>
    .camera-box-profile {
        position: relative;
        background-color: #090d16;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #334155;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.6);
    }
    .guide-outline-profile {
        stroke: #6366f1;
        stroke-width: 3px;
        stroke-dasharray: 8 4;
        animation: guide-pulse-prof 2s infinite ease-in-out;
    }
    @keyframes guide-pulse-prof {
        0%, 100% { stroke: #6366f1; stroke-opacity: 0.7; }
        50% { stroke: #10b981; stroke-opacity: 1; }
    }
    .flash-success-prof {
        animation: flashGreen 0.8s ease-out;
    }
    @keyframes flashGreen {
        0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.8); }
        50% { box-shadow: 0 0 0 20px rgba(16, 185, 129, 0); }
        100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
</style>

<section id="verification" class="scroll-mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Identity Verification') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Verify your government ID to unlock spot exploration, bookings, and ticket generation.") }}
        </p>
    </header>

    @php
        $user = auth()->user();
        $status = $user->id_verification_status === 'verified' ? 'verified' : 'pending';
        $score  = $user->id_verification_score;
        $notes  = $user->id_verification_notes;
    @endphp

    <div class="mt-6">
        <div class="border rounded-xl p-5 {{ $status === 'verified' ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }}">
            
            {{-- VERIFIED STATE --}}
            @if($status === 'verified')
                <div class="flex items-start gap-3">
                    <div class="text-green-600 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-800 text-lg">🟢 Identity Verified</h4>
                        <p class="text-green-700 text-sm mt-1">
                            Your identity was confirmed on {{ $user->id_verified_at ? $user->id_verified_at->format('M d, Y') : 'recently' }}. All travel features are unlocked!
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-green-200/60 pt-4">
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Tourist Name</span><span class="font-medium text-green-900">{{ $user->name }}</span></div>
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Document Type</span><span class="font-medium text-green-900">{{ $user->id_type ?? 'Government ID' }}</span></div>
                            <div class="col-span-2"><span class="text-green-600/70 block text-xs uppercase tracking-wider">ID Reference No.</span><span class="font-medium text-green-900 font-mono">
                                {{ Str::mask((string)$user->id_number, '*', 0, max(1, strlen((string)$user->id_number) - 4)) }}
                            </span></div>
                        </div>
                    </div>
                </div>

            {{-- PENDING STATE --}}
            @else
                <div class="flex items-start gap-3">
                    <div class="text-amber-600 mt-0.5 relative">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-30 animate-ping inset-0"></span>
                        <svg class="w-6 h-6 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="w-full">
                        <h4 class="font-bold text-amber-800 text-lg">🕓 Under Review (Pending)</h4>
                        <p class="text-amber-700 text-sm mt-1">
                            Submitted {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'recently' }}. Features (Explore Spots, Bookings, Tickets) remain locked until an admin approves your verification.
                        </p>

                        @if($notes)
                        <div class="mt-3 p-3 bg-amber-100/60 border border-amber-200 rounded-lg text-xs text-amber-800">
                            <strong>Note:</strong> {{ $notes }}
                        </div>
                        @endif

                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-amber-200/60 pt-4">
                            <div><span class="text-amber-700/70 block text-xs uppercase tracking-wider">Tourist Name</span><span class="font-medium text-amber-900">{{ $user->name }}</span></div>
                            <div><span class="text-amber-700/70 block text-xs uppercase tracking-wider">Document Type</span><span class="font-medium text-amber-900">{{ $user->id_type ?? 'Not Provided' }}</span></div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-amber-200/60 flex items-center gap-3">
                            <button type="button" id="btn-open-camera-modal" class="text-sm font-semibold text-white bg-amber-600 hover:bg-amber-700 px-4 py-2 rounded-lg transition shadow-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Capture / Update ID Photo
                            </button>
                            <button type="button" id="btn-view-details" class="text-sm font-medium text-amber-800 hover:text-amber-900 bg-amber-100 px-3 py-2 rounded-lg transition">
                                View Submitted Details
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Full Details Modal --}}
    <div id="modal-view-details" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div style="background:#fff;border-radius:0.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:90vw;max-width:36rem;max-height:90vh;display:flex;flex-direction:column;">
            <div style="display:flex;justify-space:between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <h3 style="font-weight:700;color:#1f2937;font-size:1rem;">Identity Verification Details</h3>
                <button type="button" class="btn-close-modal" aria-label="Close" style="color:#9ca3af;background:none;border:none;cursor:pointer;padding:0.25rem;">✕</button>
            </div>
            <div style="padding:1.5rem;overflow-y:auto;flex:1;">
                <dl style="display:grid;grid-template-columns:1fr 1fr;gap:1rem 1.5rem;font-size:0.875rem;">
                    <div style="grid-column:span 2">
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;">Full Name</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;">Gender</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->gender ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;">Date of Birth</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('M d, Y') : '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;">Classification</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->classification ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;">ID Type</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->id_type ?? '—' }}</dd>
                    </div>
                </dl>
                @if($user->id_photo)
                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f3f4f6;">
                    <p style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;margin-bottom:.5rem;">Current ID Photo</p>
                    <img src="{{ Storage::url($user->id_photo) }}" alt="Uploaded ID" style="width:100%;max-height:16rem;object-fit:contain;border-radius:0.75rem;border:1px solid #e5e7eb;" />
                </div>
                @endif
            </div>
            <div style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;text-align:right;flex-shrink:0;">
                <button type="button" class="btn-close-modal" style="padding:0.5rem 1.25rem;background:#f3f4f6;color:#374151;border-radius:0.5rem;font-size:0.875rem;font-weight:500;border:none;cursor:pointer;">Close</button>
            </div>
        </div>
    </div>

    {{-- Live Front & Back ID Camera Capture Modal --}}
    <div id="modal-camera-capture" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div style="background:#ffffff;color:#1f2937;border-radius:1rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:95vw;max-width:34rem;max-height:90vh;display:flex;flex-direction:column;border:1px solid #e5e7eb;">
            
            {{-- Modal Header --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <div>
                    <h3 class="font-bold text-gray-900 text-base">Front &amp; Back ID Camera Capture</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Capture both sides of your government ID</p>
                </div>
                <button type="button" class="btn-close-modal text-gray-400 hover:text-gray-600 p-1 text-lg font-bold" aria-label="Close">✕</button>
            </div>

            {{-- Form Body --}}
            <form id="profile-cam-form" method="POST" action="{{ route('profile.upload-id-photo') }}" enctype="multipart/form-data" class="p-5 overflow-y-auto space-y-4 flex-1">
                @csrf

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">ID Type</label>
                        <select id="prof_id_type" name="id_type" class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg text-xs py-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm">
                            @foreach(['Passport', 'National ID', "Driver's License", 'SSS ID', 'GSIS ID', 'PhilHealth ID', 'Pag-IBIG ID', 'Voter ID', 'Postal ID', 'School ID', 'Barangay ID', 'Company ID'] as $type)
                                <option value="{{ $type }}" {{ $user->id_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-medium text-gray-700 mb-1">ID Number / Code</label>
                        <input type="text" id="prof_id_number" name="id_number" value="{{ $user->id_number }}" placeholder="ID Number" class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg text-xs py-2 focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" />
                    </div>
                </div>

                {{-- Camera Box --}}
                <div class="camera-box-profile p-3 min-h-[300px] flex flex-col items-center justify-center rounded-xl bg-slate-950 border border-slate-800 shadow-inner">
                    
                    {{-- State: Pending Camera Enable --}}
                    <div id="prof-cam-state-pending" class="flex flex-col items-center justify-center text-center p-6 space-y-3 w-full">
                        <div class="w-14 h-14 bg-slate-900 rounded-full flex items-center justify-center text-emerald-400 border border-slate-700">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h5 class="font-bold text-sm text-slate-200">Start Live Camera</h5>
                            <p class="text-xs text-slate-400 mt-1">Requires camera permission. You will capture Front ID then Back ID.</p>
                        </div>
                        <button type="button" id="prof-btn-start-cam" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition shadow">
                            Enable Camera
                        </button>
                    </div>

                    {{-- State: Active Live Video Stream --}}
                    <div id="prof-cam-state-active" class="hidden w-full flex flex-col items-center relative">
                        <div class="relative w-full aspect-[4/3] bg-black rounded-lg overflow-hidden flex items-center justify-center border border-slate-800">
                            <video id="prof-cam-video" autoplay playsinline muted class="w-full h-full object-cover"></video>
                            
                            <!-- Badges -->
                            <div class="absolute top-2 left-2 flex items-center gap-2 z-10">
                                <span id="prof-cam-step-badge" class="bg-black/60 text-slate-200 text-[10px] font-medium px-2 py-0.5 rounded backdrop-blur">Step 1 of 2</span>
                                <span id="prof-cam-side-badge" class="bg-teal-500/90 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Front ID</span>
                            </div>

                            <!-- Guide Overlay -->
                            <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                                <svg id="prof-cam-guide-svg" class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                    <defs>
                                        <mask id="guide-mask-prof">
                                            <rect width="100%" height="100%" fill="white" />
                                            <rect id="prof-guide-cutout" x="10%" y="15%" width="80%" height="70%" rx="12" fill="black" />
                                        </mask>
                                    </defs>
                                    <rect width="100%" height="100%" fill="rgba(15, 23, 42, 0.75)" mask="url(#guide-mask-prof)" />
                                    <rect id="prof-guide-outline" x="10%" y="15%" width="80%" height="70%" rx="12" fill="none" stroke="#10b981" stroke-width="3" stroke-dasharray="8 4" class="guide-outline-profile" />
                                </svg>
                            </div>
                            
                            <div class="absolute bottom-2 left-0 right-0 text-center px-4 pointer-events-none z-10">
                                <span class="bg-slate-900/80 backdrop-blur text-slate-200 text-[11px] font-medium px-3 py-1 rounded-full border border-slate-700">
                                    Align ID within the glowing frame
                                </span>
                            </div>
                        </div>

                        {{-- Toolbar --}}
                        <div class="mt-3 flex items-center justify-between w-full px-2">
                            <button type="button" id="prof-btn-flip-guide" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-300 text-[11px]">
                                Orientation
                            </button>

                            <button type="button" id="prof-btn-shutter" class="w-11 h-11 bg-white hover:bg-slate-100 rounded-full border-4 border-slate-700 flex items-center justify-center shadow-lg transition">
                                <div class="w-6 h-6 bg-emerald-600 rounded-full"></div>
                            </button>

                            <span class="text-[10px] text-slate-400">Step 1: Front</span>
                        </div>
                    </div>

                    {{-- State: Captured Confirmation --}}
                    <div id="prof-cam-state-captured" class="hidden w-full flex flex-col items-center">
                        <div class="relative w-full aspect-[4/3] max-w-sm bg-black rounded-lg overflow-hidden flex items-center justify-center border border-slate-800">
                            <img id="prof-cam-cap-img" class="w-full h-full object-contain" />
                            <div class="absolute top-2 left-2 z-10">
                                <span class="bg-emerald-600 text-white font-bold text-[9px] px-2 py-0.5 rounded uppercase tracking-wider">
                                    ✓ Front &amp; Back Captured
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 flex items-center justify-center gap-3">
                            <button type="button" id="prof-btn-retake" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs rounded-lg font-medium transition">
                                ↺ Retake Photos
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Hidden inputs -->
                <input type="hidden" id="prof_id_photo_base64" name="id_photo_base64" />
                <input type="file" id="prof_id_photo_file" name="id_photo" class="hidden" accept="image/jpeg" />

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button" class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-xs font-semibold">Cancel</button>
                    <button type="submit" id="prof-submit-btn" disabled class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition opacity-50 cursor-not-allowed shadow-sm">
                        Submit ID for Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnOpenCameraModal = document.getElementById('btn-open-camera-modal');
            const btnViewDetails = document.getElementById('btn-view-details');
            const modalViewDetails = document.getElementById('modal-view-details');
            const modalCameraCapture = document.getElementById('modal-camera-capture');
            const closeBtns = document.querySelectorAll('.btn-close-modal');

            // Camera JS Engine
            const statePending = document.getElementById('prof-cam-state-pending');
            const stateActive = document.getElementById('prof-cam-state-active');
            const stateCaptured = document.getElementById('prof-cam-state-captured');

            const btnStartCam = document.getElementById('prof-btn-start-cam');
            const btnShutter = document.getElementById('prof-btn-shutter');
            const btnRetake = document.getElementById('prof-btn-retake');
            const btnFlipGuide = document.getElementById('prof-btn-flip-guide');
            const submitBtn = document.getElementById('prof-submit-btn');

            const camVideo = document.getElementById('prof-cam-video');
            const camCapImg = document.getElementById('prof-cam-cap-img');

            let stream = null;
            let currentStep = 1;
            let frontPhotoData = null;
            let backPhotoData = null;

            function openModal(modal) {
                if (modal) {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeAllModals() {
                stopStream();
                [modalViewDetails, modalCameraCapture].forEach(m => {
                    if (m) m.style.display = 'none';
                });
                document.body.style.overflow = '';
            }

            if (btnOpenCameraModal) btnOpenCameraModal.addEventListener('click', () => openModal(modalCameraCapture));
            if (btnViewDetails) btnViewDetails.addEventListener('click', () => openModal(modalViewDetails));
            closeBtns.forEach(btn => btn.addEventListener('click', closeAllModals));

            function showState(name) {
                [statePending, stateActive, stateCaptured].forEach(el => el.classList.add('hidden'));
                if (name === 'pending') statePending.classList.remove('hidden');
                if (name === 'active') stateActive.classList.remove('hidden');
                if (name === 'captured') stateCaptured.classList.remove('hidden');
            }

            function stopStream() {
                if (stream) {
                    stream.getTracks().forEach(t => t.stop());
                    stream = null;
                }
                if (camVideo) camVideo.srcObject = null;
            }

            async function startCamera() {
                stopStream();
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    alert('Camera access requires HTTPS or localhost.');
                    showState('pending');
                    return;
                }
                try {
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: { ideal: 'environment' }, width: { ideal: 1920 }, height: { ideal: 1080 } },
                        audio: false
                    });
                    camVideo.srcObject = stream;
                    showState('active');
                    currentStep = 1;
                    document.getElementById('prof-cam-step-badge').textContent = 'Step 1 of 2';
                    document.getElementById('prof-cam-side-badge').textContent = 'Front ID';
                } catch(e) {
                    alert('Camera error: ' + e.message);
                    showState('pending');
                }
            }

            if (btnStartCam) btnStartCam.addEventListener('click', startCamera);

            if (btnShutter) {
                btnShutter.addEventListener('click', () => {
                    if (!stream || !camVideo.videoWidth) return;
                    const vW = camVideo.videoWidth, vH = camVideo.videoHeight;
                    const canvas = document.createElement('canvas');
                    canvas.width = vW;
                    canvas.height = vH;
                    canvas.getContext('2d').drawImage(camVideo, 0, 0, vW, vH);
                    const url = canvas.toDataURL('image/jpeg', 0.9);

                    if (currentStep === 1) {
                        frontPhotoData = url;
                        currentStep = 2;
                        document.getElementById('prof-cam-step-badge').textContent = 'Step 2 of 2';
                        document.getElementById('prof-cam-side-badge').textContent = 'Back ID';
                        document.getElementById('prof-cam-side-badge').className = 'bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider';
                    } else {
                        backPhotoData = url;

                        // Merge front and back photos into composite canvas
                        const imgF = new Image(), imgB = new Image();
                        imgF.onload = () => {
                            imgB.onload = () => {
                                const cW = Math.max(imgF.width, imgB.width);
                                const cH = imgF.height + imgB.height;
                                const compCanvas = document.createElement('canvas');
                                compCanvas.width = cW;
                                compCanvas.height = cH;
                                const ctx = compCanvas.getContext('2d');
                                ctx.fillStyle = '#0f172a';
                                ctx.fillRect(0, 0, cW, cH);
                                ctx.drawImage(imgF, (cW - imgF.width) / 2, 0);
                                ctx.drawImage(imgB, (cW - imgB.width) / 2, imgF.height);

                                const compositeUrl = compCanvas.toDataURL('image/jpeg', 0.85);
                                camCapImg.src = compositeUrl;
                                document.getElementById('prof_id_photo_base64').value = compositeUrl;

                                stopStream();
                                showState('captured');
                                submitBtn.disabled = false;
                                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                            };
                            imgB.src = backPhotoData;
                        };
                        imgF.src = frontPhotoData;
                    }
                });
            }

            if (btnRetake) {
                btnRetake.addEventListener('click', () => {
                    currentStep = 1;
                    frontPhotoData = null;
                    backPhotoData = null;
                    document.getElementById('prof_id_photo_base64').value = '';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    startCamera();
                });
            }
        });
    </script>
</section>
