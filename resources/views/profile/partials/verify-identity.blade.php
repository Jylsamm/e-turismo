<style>
    .camera-box {
        position: relative;
        background-color: #090d16;
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid #334155;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.6);
    }
    .guide-outline {
        stroke: #6366f1;
        stroke-width: 3px;
        stroke-dasharray: 8 4;
        animation: guide-pulse 2s infinite ease-in-out;
    }
    @keyframes guide-pulse {
        0%, 100% { stroke: #6366f1; stroke-opacity: 0.7; }
        50% { stroke: #10b981; stroke-opacity: 1; }
    }
    .instruction-badge {
        background-color: rgba(15, 23, 42, 0.85);
        backdrop-filter: blur(4px);
        color: #f1f5f9;
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.4rem 0.9rem;
        border-radius: 9999px;
        border: 1px solid #334155;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        display: inline-block;
        max-width: 90%;
        transition: all 0.3s ease;
    }
</style>

<section id="verification" class="scroll-mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Identity Verification') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Verify your government ID to unlock bookings and full account access.") }}
        </p>
    </header>

    @php
        $user = auth()->user();
        $status = $user->id_verification_status ?? 'unverified';
        $score  = $user->id_verification_score;
        $notes  = $user->id_verification_notes;
        $isReadError = $notes ? str_starts_with($notes, 'OCR_READ_ERROR') : false;
    @endphp

    <div class="mt-6">
        <div class="border rounded-xl p-5 {{ $status === 'verified' ? 'bg-green-50 border-green-200' : ($status === 'pending' ? 'bg-blue-50 border-blue-200' : ($status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200')) }}">
            
            {{-- VERIFIED --}}
            @if($status === 'verified')
                <div class="flex items-start gap-3">
                    <div class="text-green-600 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-800 text-lg">🟢 Verified</h4>
                        <p class="text-green-700 text-sm mt-1">
                            Your identity was confirmed on {{ $user->id_verified_at ? $user->id_verified_at->format('M d, Y') : 'recently' }}.
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-green-200/60 pt-4">
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Tourist Name</span><span class="font-medium text-green-900">{{ $user->name }}</span></div>
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Document Type</span><span class="font-medium text-green-900">{{ $user->id_type }}</span></div>
                            <div class="col-span-2"><span class="text-green-600/70 block text-xs uppercase tracking-wider">ID Reference No.</span><span class="font-medium text-green-900 font-mono">
                                {{ Str::mask((string)$user->id_number, '*', 0, max(1, strlen((string)$user->id_number) - 4)) }}
                            </span></div>
                        </div>
                    </div>
                </div>

            {{-- PENDING --}}
            @elseif($status === 'pending')
                @php
                    $noteItems = $notes ? array_map('trim', explode('|', $notes)) : [];
                    $hasDobMiss = collect($noteItems)->contains(fn($n) => str_contains(strtolower($n), 'dob') && str_contains(strtolower($n), 'not found'));
                @endphp
                <div class="flex items-start gap-3">
                    <div class="text-blue-600 mt-0.5 relative">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-30 animate-ping inset-0"></span>
                        <svg class="w-6 h-6 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="w-full">
                        <h4 class="font-bold text-blue-800 text-lg">🕓 Under Review</h4>
                        <p class="text-blue-700 text-sm mt-1">
                            Submitted {{ $user->updated_at->format('M d, Y') }}. Usually takes up to 24 hours.
                        </p>

                        {{-- ── Why am I pending? explanation note ── --}}
                        @if($score !== null)
                        <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                                <span class="text-amber-800 font-semibold text-sm">Why am I under review?</span>
                            </div>
                            <p class="text-amber-700 text-xs leading-relaxed mb-3">
                                Your verification score is <strong>{{ number_format($score, 0) }}/100</strong>.
                                A score of <strong>90 or above</strong> is required for instant approval — yours fell just short, so it's been queued for manual admin review.
                            </p>

                            {{-- Score breakdown --}}
                            <ul class="space-y-1.5 text-xs">
                                @foreach($noteItems as $item)
                                    @php
                                        $isGood = preg_match('/(found|100%|verified)/i', $item) && !preg_match('/not found/i', $item);
                                        $isBad  = preg_match('/not found|0%/i', $item);
                                    @endphp
                                    <li class="flex items-start gap-1.5">
                                        @if($isGood)
                                            <span class="text-green-500 mt-0.5">✔</span>
                                            <span class="text-green-700">{{ $item }}</span>
                                        @elseif($isBad)
                                            <span class="text-red-500 mt-0.5">✘</span>
                                            <span class="text-red-700">{{ $item }}</span>
                                        @else
                                            <span class="text-amber-500 mt-0.5">~</span>
                                            <span class="text-amber-700">{{ $item }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>

                            @if($hasDobMiss)
                            <p class="mt-3 text-xs text-amber-700 bg-amber-100 border border-amber-200 rounded p-2">
                                💡 <strong>Tip:</strong> Your <strong>School ID</strong> does not print a date of birth, so the system couldn't confirm it automatically. An admin will verify this manually — no action needed from you.
                            </p>
                            @endif
                        </div>
                        @endif

                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-blue-200/60 pt-4">
                            <div><span class="text-blue-600/70 block text-xs uppercase tracking-wider">Tourist Name</span><span class="font-medium text-blue-900">{{ $user->name }}</span></div>
                            <div><span class="text-blue-600/70 block text-xs uppercase tracking-wider">Document Type</span><span class="font-medium text-blue-900">{{ $user->id_type }}</span></div>
                            <div class="col-span-2"><span class="text-blue-600/70 block text-xs uppercase tracking-wider">ID Reference No.</span><span class="font-medium text-blue-900 font-mono">
                                {{ Str::mask((string)$user->id_number, '*', 0, max(1, strlen((string)$user->id_number) - 4)) }}
                            </span></div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-blue-200/60 flex justify-end">
                            <button type="button" id="btn-view-details" class="text-sm font-medium text-blue-700 hover:text-blue-800 bg-blue-100/50 hover:bg-blue-200/50 px-3 py-1.5 rounded transition">
                                View Full Details
                            </button>
                        </div>
                    </div>
                </div>

            {{-- REJECTED --}}
            @elseif($status === 'rejected')
                <div class="flex items-start gap-3">
                    <div class="text-red-600 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="w-full">
                        <h4 class="font-bold text-red-800 text-lg">🔴 Verification Failed</h4>
                        @if($isReadError)
                            <p class="text-red-700 text-sm mt-1">We couldn't read your ID. The photo may be blurry or unsupported.</p>
                        @else
                            <p class="text-red-700 text-sm mt-1">Details mismatch. The name or ID number on your document doesn't match what you entered.</p>
                        @endif
                        
                        <div class="mt-4 pt-4 border-t border-red-200/60 flex gap-3">
                            <button type="button" id="btn-start-verification" class="text-sm font-medium text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg transition shadow-sm">
                                Retry Verification
                            </button>
                            @if(!$isReadError)
                            <button type="button" id="btn-edit-details" class="text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-300 px-4 py-2 rounded-lg transition shadow-sm">
                                Edit Details & Re-verify
                            </button>
                            @endif
                        </div>
                    </div>
                </div>

            {{-- UNVERIFIED --}}
            @else
                <div class="flex items-start gap-3">
                    <div class="text-yellow-500 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-lg">🟡 Not Verified</h4>
                        <p class="text-gray-600 text-sm mt-1">
                            Verify your government ID to unlock bookings and full account access.
                        </p>
                        <div class="mt-4">
                            <button type="button" id="btn-start-verification" class="text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-lg transition shadow-sm">
                                Start Verification
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Full Details Modal (For Pending / Verified) --}}
    {{-- Overlay uses inline styles so Tailwind purge can never strip the positioning --}}
    <div id="modal-view-details" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div style="background:#fff;border-radius:0.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:90vw;max-width:36rem;max-height:90vh;display:flex;flex-direction:column;">
            {{-- Sticky Header --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <h3 style="font-weight:700;color:#1f2937;font-size:1rem;">Identity Verification Details</h3>
                <button type="button" class="btn-close-modal" style="color:#9ca3af;background:none;border:none;cursor:pointer;padding:0.25rem;border-radius:0.375rem;" onmouseenter="this.style.color='#374151'" onmouseleave="this.style.color='#9ca3af'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            {{-- Scrollable Body --}}
            <div style="padding:1.5rem;overflow-y:auto;flex:1;">
                <dl style="display:grid;grid-template-columns:1fr 1fr;gap:1rem 1.5rem;font-size:0.875rem;">
                    <div style="grid-column:span 2">
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Full Name</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Date of Birth</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->dob ? $user->dob->format('M d, Y') : '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">Classification</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->classification ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">ID Type</dt>
                        <dd style="font-weight:600;color:#111827;">{{ $user->id_type ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">ID Number</dt>
                        <dd style="font-weight:600;color:#111827;font-family:monospace;font-size:0.95em;">{{ $user->id_number ?? '—' }}</dd>
                    </div>
                </dl>
                @if($user->id_photo)
                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f3f4f6;">
                    <p style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem;">Uploaded ID Photo</p>
                    {{-- image-orientation: from-image reads EXIF rotation metadata, fixing sideways phone photos --}}
                    <img src="{{ asset('storage/' . $user->id_photo) }}" alt="Uploaded ID"
                         style="width:100%;max-height:16rem;object-fit:contain;border-radius:0.75rem;border:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,.1);image-orientation:from-image;" />
                </div>
                @endif
            </div>
            {{-- Sticky Footer --}}
            <div style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;text-align:right;flex-shrink:0;">
                <button type="button" class="btn-close-modal" style="padding:0.5rem 1.25rem;background:#f3f4f6;color:#374151;border-radius:0.5rem;font-size:0.875rem;font-weight:500;border:none;cursor:pointer;" onmouseenter="this.style.background='#e5e7eb'" onmouseleave="this.style.background='#f3f4f6'">Close</button>
            </div>
        </div>
    </div>

    {{-- Edit Details Modal --}}
    <div id="modal-edit-details" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div style="background:#fff;border-radius:0.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:90vw;max-width:36rem;max-height:90vh;display:flex;flex-direction:column;">
            {{-- Sticky Header --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <h3 style="font-weight:700;color:#1f2937;font-size:1rem;">Edit Details &amp; Re-verify</h3>
                <button type="button" class="btn-close-modal" style="color:#9ca3af;background:none;border:none;cursor:pointer;padding:0.25rem;border-radius:0.375rem;" onmouseenter="this.style.color='#374151'" onmouseleave="this.style.color='#9ca3af'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('verification.update_details') }}" class="space-y-4 edit-verify-form">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            @php
                                $parts = explode(' ', $user->name);
                                $lastName = array_pop($parts);
                                $firstName = implode(' ', $parts);
                            @endphp
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$firstName" required />
                        </div>
                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$user->last_name ?? $lastName" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="middle_initial" :value="__('Middle Initial')" />
                            <x-text-input id="middle_initial" class="block mt-1 w-full" type="text" name="middle_initial" :value="str_replace('.', '', $user->middle_initial ?? '')" maxlength="5" />
                        </div>
                        <div>
                            <x-input-label for="dob" :value="__('Date of Birth')" />
                            <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="$user->dob ? $user->dob->format('Y-m-d') : ''" required />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <x-input-label for="id_type" :value="__('ID Type')" />
                            <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                @foreach(['Passport', 'National ID', "Driver's License", 'SSS ID', 'GSIS ID', 'PhilHealth ID', 'Pag-IBIG ID', 'Voter ID', 'Postal ID', 'School ID', 'Barangay ID', 'Company ID'] as $type)
                                    <option value="{{ $type }}" {{ $user->id_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="id_number" :value="__('ID Number')" />
                            <x-text-input id="id_number" class="block mt-1 w-full" type="text" name="id_number" :value="$user->id_number" required />
                        </div>
                    </div>
                    <div>
                        <x-input-label for="classification" :value="__('Classification')" />
                        <select id="classification" name="classification" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="Local" {{ $user->classification === 'Local' ? 'selected' : '' }}>Local</option>
                            <option value="Domestic" {{ $user->classification === 'Domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="Foreign" {{ $user->classification === 'Foreign' ? 'selected' : '' }}>Foreign</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                            Save Details & Re-verify
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Verification Document Upload Modal --}}
    <div id="modal-start-verification" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div style="background:#fff;border-radius:0.75rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:90vw;max-width:36rem;max-height:90vh;display:flex;flex-direction:column;">
            {{-- Sticky Header --}}
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <h3 style="font-weight:700;color:#1f2937;font-size:1rem;">Capture ID Document</h3>
                <button type="button" class="btn-close-modal" style="color:#9ca3af;background:none;border:none;cursor:pointer;padding:0.25rem;border-radius:0.375rem;" onmouseenter="this.style.color='#374151'" onmouseleave="this.style.color='#9ca3af'">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6">
                <form id="verification-form" method="POST" action="{{ route('verification.resubmit') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <div class="camera-box mt-1 flex flex-col items-center justify-center relative min-h-[320px] bg-slate-950 text-white rounded-lg overflow-hidden border border-slate-700">
                            <!-- Initial State / Start Camera View -->
                            <div id="camera-prompt" class="flex flex-col items-center justify-center text-center p-6 space-y-4 w-full">
                                <div class="w-16 h-16 bg-slate-900 rounded-full flex items-center justify-center text-indigo-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-sm text-slate-200">Camera Access Required</h5>
                                    <p class="text-xs text-slate-400 mt-1">Please allow camera access to capture your ID directly.</p>
                                </div>
                                <button type="button" id="btn-activate-camera" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-semibold shadow-md transition duration-150">
                                    Start Camera
                                </button>
                            </div>

                            <!-- Active Camera Live Preview View -->
                            <div id="camera-active" class="hidden w-full flex flex-col items-center relative p-3">
                                <div class="relative w-full aspect-[4/3] max-w-sm bg-black rounded-lg overflow-hidden flex items-center justify-center">
                                    <video id="camera-video" autoplay playsinline muted class="w-full h-full object-cover"></video>
                                    
                                    <!-- Guide Overlay -->
                                    <div class="absolute inset-0 pointer-events-none flex items-center justify-center">
                                        <svg id="camera-guide-svg" class="absolute inset-0 w-full h-full" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <mask id="guide-mask-verify">
                                                    <rect width="100%" height="100%" fill="white" />
                                                    <rect id="guide-cutout-verify" x="10%" y="15%" width="80%" height="70%" rx="12" fill="black" />
                                                </mask>
                                            </defs>
                                            <rect width="100%" height="100%" fill="rgba(15, 23, 42, 0.75)" mask="url(#guide-mask-verify)" />
                                            <rect id="guide-outline-verify" x="10%" y="15%" width="80%" height="70%" rx="12" fill="none" stroke="#6366f1" stroke-width="3" stroke-dasharray="8 4" class="guide-outline" />
                                        </svg>
                                    </div>
                                    
                                    <!-- Instructions Badge -->
                                    <div class="absolute bottom-3 left-0 right-0 text-center px-4 pointer-events-none z-10">
                                        <span id="camera-instructions" class="instruction-badge">
                                            Align ID within the frame
                                        </span>
                                    </div>
                                </div>

                                <!-- Camera Control Toolbar -->
                                <div class="mt-4 flex items-center justify-between w-full max-w-sm px-2">
                                    <button type="button" id="btn-toggle-orientation" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-300 hover:text-white transition flex items-center gap-1 text-[11px]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                        <span id="orientation-label">Landscape Guide</span>
                                    </button>

                                    <button type="button" id="btn-capture-photo" class="w-12 h-12 bg-white hover:bg-slate-100 rounded-full border-4 border-slate-700 hover:border-indigo-500 shadow-lg flex items-center justify-center transition focus:outline-none">
                                        <div class="w-7 h-7 bg-indigo-600 rounded-full"></div>
                                    </button>

                                    <button type="button" id="btn-switch-camera" class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-300 hover:text-white transition flex items-center gap-1 text-[11px]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Flip</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Captured Image Preview View -->
                            <div id="camera-preview" class="hidden w-full flex flex-col items-center p-3">
                                <div class="relative w-full aspect-[4/3] max-w-sm bg-black rounded-lg overflow-hidden flex items-center justify-center border border-slate-800">
                                    <img id="captured-img" class="w-full h-full object-contain" />
                                    <div class="absolute top-2 left-2 z-10">
                                        <span class="bg-green-600/95 text-white font-bold text-[9px] px-2 py-0.5 rounded-full uppercase tracking-wider">
                                            Photo Confirmed
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 flex items-center justify-center gap-3 w-full max-w-sm">
                                    <button type="button" id="btn-retake-photo" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white rounded-lg text-xs font-semibold shadow-md transition duration-150 flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89M9 11l3-3 3 3m-3-3v12"/></svg>
                                        Retake Photo
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden input for file validation -->
                        <input id="id_photo" name="id_photo" type="file" required accept="image/jpeg" class="absolute w-0 h-0 opacity-0 pointer-events-none" />
                        
                        <p id="file-error" class="mt-2 text-sm text-red-600 hidden"></p>
                        <p id="file-success" class="mt-2 text-sm text-green-600 hidden"></p>
                        <x-input-error :messages="$errors->get('id_photo')" class="mt-1" />
                    </div>
                    <div class="pt-4 flex justify-end gap-3 border-t border-gray-100 mt-4">
                        <button type="button" class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Cancel</button>
                        <button type="submit" id="submit-upload-btn" disabled class="px-5 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition opacity-50 cursor-not-allowed">
                            Submit ID Photo
                        </button>
                    </div>
                </form>
            </div>

    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/80 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-100">
            <div class="text-6xl mb-6 animate-bounce">⏳</div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight mb-2">Reading Your ID...</h2>
            <p class="text-gray-500 text-sm">This usually takes a few seconds.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const btnViewDetails = document.getElementById('btn-view-details');
            const btnEditDetails = document.getElementById('btn-edit-details');
            const btnStartVerification = document.getElementById('btn-start-verification');
            
            const modalViewDetails = document.getElementById('modal-view-details');
            const modalEditDetails = document.getElementById('modal-edit-details');
            const modalStartVerification = document.getElementById('modal-start-verification');
            const loadingOverlay = document.getElementById('loading-overlay');
            
            const closeBtns = document.querySelectorAll('.btn-close-modal');

            // Camera elements
            const cameraPrompt = document.getElementById('camera-prompt');
            const cameraActive = document.getElementById('camera-active');
            const cameraPreview = document.getElementById('camera-preview');
            
            const btnActivateCamera = document.getElementById('btn-activate-camera');
            const btnCapturePhoto = document.getElementById('btn-capture-photo');
            const btnToggleOrientation = document.getElementById('btn-toggle-orientation');
            const btnSwitchCamera = document.getElementById('btn-switch-camera');
            const btnRetakePhoto = document.getElementById('btn-retake-photo');
            const submitUploadBtn = document.getElementById('submit-upload-btn');
            
            const cameraVideo = document.getElementById('camera-video');
            const capturedImg = document.getElementById('captured-img');
            const fileInput = document.getElementById('id_photo');
            const fileError = document.getElementById('file-error');
            const fileSuccess = document.getElementById('file-success');
            const instructionsText = document.getElementById('camera-instructions');
            const orientationLabel = document.getElementById('orientation-label');

            let cameraStream = null;
            let currentFacingMode = 'environment';
            let currentOrientation = 'landscape';
            let isFileValid = false;
            let instructionInterval = null;

            const instructionsList = [
                "Align your ID card within the glowing frame",
                "Ensure good lighting and avoid glare/shadows",
                "Hold steady to prevent blur",
                "Make sure all text on the ID is clear and readable"
            ];
            let instructionIdx = 0;

            // Modal Toggles — use style.display instead of classList to avoid Tailwind purge stripping 'flex'
            function openModal(modal) {
                if (modal) {
                    modal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeAllModals() {
                stopCamera();
                [modalViewDetails, modalEditDetails, modalStartVerification].forEach(modal => {
                    if (modal) modal.style.display = 'none';
                });
                document.body.style.overflow = '';
            }

            // Close when clicking the dark overlay background itself
            [modalViewDetails, modalEditDetails, modalStartVerification].forEach(modal => {
                if (modal) {
                    modal.addEventListener('click', (e) => {
                        if (e.target === modal) closeAllModals();
                    });
                }
            });

            if (btnViewDetails) btnViewDetails.addEventListener('click', () => openModal(modalViewDetails));
            if (btnEditDetails) btnEditDetails.addEventListener('click', () => openModal(modalEditDetails));
            
            if (btnStartVerification) {
                btnStartVerification.addEventListener('click', () => {
                    openModal(modalStartVerification);
                    // Reset UI inside modal
                    isFileValid = false;
                    fileInput.value = '';
                    submitUploadBtn.disabled = true;
                    submitUploadBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    cameraPrompt.classList.remove('hidden');
                    cameraActive.classList.add('hidden');
                    cameraPreview.classList.add('hidden');
                });
            }

            closeBtns.forEach(btn => {
                btn.addEventListener('click', closeAllModals);
            });

            // Toggle guide frame calculations
            function updateGuideFrame() {
                const svg = document.getElementById('camera-guide-svg');
                if (!svg || cameraActive.classList.contains('hidden')) return;
                
                const rect = svg.getBoundingClientRect();
                const w = rect.width;
                const h = rect.height;
                if (w === 0 || h === 0) return;
                
                let cutoutW, cutoutH;
                if (currentOrientation === 'landscape') {
                    cutoutW = w * 0.85;
                    cutoutH = cutoutW / 1.58; // Standard card aspect ratio
                    if (cutoutH > h * 0.8) {
                        cutoutH = h * 0.8;
                        cutoutW = cutoutH * 1.58;
                    }
                } else {
                    // Portrait guide
                    cutoutH = h * 0.8;
                    cutoutW = cutoutH / 1.58;
                    if (cutoutW > w * 0.85) {
                        cutoutW = w * 0.85;
                        cutoutH = cutoutW * 1.58;
                    }
                }
                
                const x = (w - cutoutW) / 2;
                const y = (h - cutoutH) / 2;
                
                const cutout = document.getElementById('guide-cutout-verify');
                const outline = document.getElementById('guide-outline-verify');
                
                if (cutout) {
                    cutout.setAttribute('x', x);
                    cutout.setAttribute('y', y);
                    cutout.setAttribute('width', cutoutW);
                    cutout.setAttribute('height', cutoutH);
                }
                if (outline) {
                    outline.setAttribute('x', x);
                    outline.setAttribute('y', y);
                    outline.setAttribute('width', cutoutW);
                    outline.setAttribute('height', cutoutH);
                }
            }

            window.addEventListener('resize', updateGuideFrame);

            // Instructions rotation
            function startInstructions() {
                stopInstructions();
                instructionIdx = 0;
                instructionsText.textContent = instructionsList[0];
                instructionInterval = setInterval(() => {
                    instructionIdx = (instructionIdx + 1) % instructionsList.length;
                    instructionsText.textContent = instructionsList[instructionIdx];
                }, 3500);
            }

            function stopInstructions() {
                if (instructionInterval) {
                    clearInterval(instructionInterval);
                    instructionInterval = null;
                }
            }

            async function startCamera() {
                fileError.classList.add('hidden');
                fileSuccess.classList.add('hidden');
                
                if (cameraStream) {
                    stopCamera();
                }

                if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    fileError.textContent = "Insecure Context: Camera access requires HTTPS or localhost. Try accessing via localhost or generate a local TLS cert.";
                    fileError.classList.remove('hidden');
                    return;
                }

                try {
                    const constraints = {
                        video: {
                            facingMode: { ideal: currentFacingMode },
                            width: { ideal: 1920 },
                            height: { ideal: 1080 }
                        },
                        audio: false
                    };
                    
                    cameraStream = await navigator.mediaDevices.getUserMedia(constraints);
                    cameraVideo.srcObject = cameraStream;
                    
                    cameraPrompt.classList.add('hidden');
                    cameraPreview.classList.add('hidden');
                    cameraActive.classList.remove('hidden');
                    
                    setTimeout(updateGuideFrame, 150);
                    startInstructions();
                    
                } catch (err) {
                    console.error("Camera access error:", err);
                    fileError.textContent = "Unable to access device camera. Please verify permission or try standard browser settings.";
                    fileError.classList.remove('hidden');
                }
            }

            function stopCamera() {
                stopInstructions();
                if (cameraStream) {
                    cameraStream.getTracks().forEach(track => track.stop());
                    cameraStream = null;
                }
                if (cameraVideo) {
                    cameraVideo.srcObject = null;
                }
            }

            if (btnActivateCamera) btnActivateCamera.addEventListener('click', startCamera);

            // Toggle Guide Shape
            if (btnToggleOrientation) {
                btnToggleOrientation.addEventListener('click', () => {
                    currentOrientation = (currentOrientation === 'landscape') ? 'portrait' : 'landscape';
                    orientationLabel.textContent = (currentOrientation === 'landscape') ? 'Landscape Guide' : 'Portrait Guide';
                    updateGuideFrame();
                });
            }

            // Toggle Facing Mode
            if (btnSwitchCamera) {
                btnSwitchCamera.addEventListener('click', () => {
                    currentFacingMode = (currentFacingMode === 'user') ? 'environment' : 'user';
                    startCamera();
                });
            }

            // Capture
            if (btnCapturePhoto) {
                btnCapturePhoto.addEventListener('click', () => {
                    if (!cameraStream) return;

                    const videoW = cameraVideo.videoWidth;
                    const videoH = cameraVideo.videoHeight;
                    const displayW = cameraVideo.clientWidth;
                    const displayH = cameraVideo.clientHeight;

                    if (!videoW || !videoH || !displayW || !displayH) return;

                    const cutout = document.getElementById('guide-cutout-verify');
                    const cX = parseFloat(cutout.getAttribute('x'));
                    const cY = parseFloat(cutout.getAttribute('y'));
                    const cW = parseFloat(cutout.getAttribute('width'));
                    const cH = parseFloat(cutout.getAttribute('height'));

                    const scaleX = videoW / displayW;
                    const scaleY = videoH / displayH;

                    const cropX = cX * scaleX;
                    const cropY = cY * scaleY;
                    const cropW = cW * scaleX;
                    const cropH = cH * scaleY;

                    const canvas = document.createElement('canvas');
                    canvas.width = cropW;
                    canvas.height = cropH;
                    const ctx = canvas.getContext('2d');
                    
                    ctx.drawImage(cameraVideo, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);

                    try {
                        const dataUrl = canvas.toDataURL('image/jpeg', 0.95);
                        capturedImg.src = dataUrl;

                        const blobBin = atob(dataUrl.split(',')[1]);
                        const array = [];
                        for (let i = 0; i < blobBin.length; i++) {
                            array.push(blobBin.charCodeAt(i));
                        }
                        const fileBlob = new Blob([new Uint8Array(array)], { type: 'image/jpeg' });
                        const file = new File([fileBlob], `captured_id_${Date.now()}.jpg`, { type: 'image/jpeg' });

                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        fileInput.files = dataTransfer.files;

                        isFileValid = true;
                        fileSuccess.textContent = "ID Photo captured successfully.";
                        fileSuccess.classList.remove('hidden');
                        fileError.classList.add('hidden');

                        stopCamera();
                        cameraActive.classList.add('hidden');
                        cameraPreview.classList.remove('hidden');
                        
                        submitUploadBtn.disabled = false;
                        submitUploadBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                    } catch (err) {
                        console.error("Capture capture processing error:", err);
                        fileError.textContent = "Failed to capture photo. Please try again.";
                        fileError.classList.remove('hidden');
                    }
                });
            }

            if (btnRetakePhoto) {
                btnRetakePhoto.addEventListener('click', () => {
                    isFileValid = false;
                    fileInput.value = '';
                    fileSuccess.classList.add('hidden');
                    submitUploadBtn.disabled = true;
                    submitUploadBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    startCamera();
                });
            }

            // Forms Submit Loading
            const uploadForm = document.getElementById('verification-form');
            const editForms = document.querySelectorAll('.edit-verify-form');
            
            if (uploadForm) {
                uploadForm.addEventListener('submit', function(e) {
                    if (!isFileValid) { e.preventDefault(); return; }
                    stopCamera();
                    loadingOverlay.classList.remove('hidden');
                    loadingOverlay.classList.add('flex');
                });
            }
            
            editForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    loadingOverlay.classList.remove('hidden');
                    loadingOverlay.classList.add('flex');
                    loadingOverlay.querySelector('h2').textContent = "Updating & Verifying...";
                });
            });

        });
    </script>
</section>
