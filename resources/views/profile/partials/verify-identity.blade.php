<style>
<<<<<<< Updated upstream
    .camera-box {
        position: relative;
        background-color: #090d16;
        border-radius: 0.75rem;
=======
    /* ── Camera container ── */
    .cam-box {
        background: #08111f;
        border-radius: 1rem;
>>>>>>> Stashed changes
        overflow: hidden;
        border: 1px solid #1e3a52;
    }
<<<<<<< Updated upstream
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
=======

    /* ── Teal dashed guide ── */
    .cam-guide-rect {
        fill: none;
        stroke: #14b8a6;
        stroke-width: 2.5;
        stroke-dasharray: 10 6;
        animation: teal-pulse 2.4s ease-in-out infinite;
    }

    /* ── Cut Edges Corner Brackets ── */
    .cam-corner-path {
        fill: none;
        stroke: #2dd4bf;
        stroke-width: 4;
        stroke-linecap: round;
        stroke-linejoin: round;
        filter: drop-shadow(0 0 4px rgba(45, 212, 191, 0.7));
    }

    @keyframes teal-pulse {

        0%,
        100% {
            stroke: #14b8a6;
            stroke-opacity: .7;
        }

        50% {
            stroke: #34d399;
            stroke-opacity: 1;
        }
    }

    /* ── Instruction pill ── */
    .cam-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0f172a;
        border: 1.5px solid #0d9488;
        color: #ffffff;
        font-size: .78rem;
        font-weight: 600;
        padding: .45rem 1rem;
        border-radius: 9999px;
        pointer-events: none;
        letter-spacing: .01em;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        max-width: 90%;
        text-align: center;
    }

    @keyframes scale-in {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-scale {
        animation: scale-in 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
    }

    /* ── Bottom bar ── */
    .cam-bottom-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: .55rem .85rem;
        background: rgba(8, 17, 31, .92);
        border-top: 1px solid rgba(20, 184, 166, .15);
    }

    .cam-orient-label {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: .7rem;
        font-weight: 600;
        color: #99f6e4;
        letter-spacing: .04em;
        text-transform: uppercase;
        cursor: pointer;
        user-select: none;
    }

    .cam-orient-label:hover {
        color: #ffffff;
    }

    .cam-flip-btn {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: .7rem;
        font-weight: 600;
        color: #94a3b8;
        background: rgba(255, 255, 255, .06);
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 6px;
        padding: .3rem .65rem;
        cursor: pointer;
        transition: .18s;
        text-transform: uppercase;
        letter-spacing: .04em;
    }

    .cam-flip-btn:hover {
        background: rgba(20, 184, 166, .15);
        color: #f0fdfa;
        border-color: rgba(20, 184, 166, .4);
    }

    /* ── Shutter ── */
    .cam-shutter {
        width: 52px;
        height: 52px;
        border-radius: 9999px;
        background: #fff;
        border: 4px solid #1e3a52;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: border-color .2s, transform .15s;
        box-shadow: 0 4px 16px rgba(0, 0, 0, .4);
        flex-shrink: 0;
    }

    .cam-shutter:hover {
        border-color: #14b8a6;
        transform: scale(1.06);
    }

    .cam-shutter-dot {
        width: 30px;
        height: 30px;
        border-radius: 9999px;
        background: #14b8a6;
>>>>>>> Stashed changes
    }
</style>

<section id="verification" class="scroll-mt-8">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Identity Verification') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
<<<<<<< Updated upstream
            {{ __("Verify your government ID to unlock bookings and full account access.") }}
=======
            {{ __("Verify your ID to unlock spot exploration, bookings, and ticket generation.") }}
>>>>>>> Stashed changes
        </p>
    </header>

    @php
        $user = auth()->user();
<<<<<<< Updated upstream
        $status = $user->id_verification_status ?? 'unverified';
        $score  = $user->id_verification_score;
        $notes  = $user->id_verification_notes;
        $isReadError = $notes ? str_starts_with($notes, 'OCR_READ_ERROR') : false;
    @endphp

    <div class="mt-6">
        <div class="border rounded-xl p-5 {{ $status === 'verified' ? 'bg-green-50 border-green-200' : ($status === 'pending' ? 'bg-blue-50 border-blue-200' : ($status === 'rejected' ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200')) }}">
            
            {{-- VERIFIED --}}
=======
        $status = $user->id_verification_status === 'verified' ? 'verified' : 'pending';
        $score = $user->id_verification_score;
        $notes = $user->id_verification_notes;
    @endphp

    <div class="mt-6">
        <div
            class="border rounded-xl p-5 {{ $status === 'verified' ? 'bg-green-50 border-green-200' : 'bg-amber-50 border-amber-200' }}">

            {{-- VERIFIED STATE --}}
>>>>>>> Stashed changes
            @if($status === 'verified')
                <div class="flex items-start gap-3">
                    <div class="text-green-600 mt-0.5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-green-800 text-lg">🟢 Verified</h4>
                        <p class="text-green-700 text-sm mt-1">
<<<<<<< Updated upstream
                            Your identity was confirmed on {{ $user->id_verified_at ? $user->id_verified_at->format('M d, Y') : 'recently' }}.
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-green-200/60 pt-4">
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Tourist Name</span><span class="font-medium text-green-900">{{ $user->name }}</span></div>
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Document Type</span><span class="font-medium text-green-900">{{ $user->id_type }}</span></div>
                            <div class="col-span-2"><span class="text-green-600/70 block text-xs uppercase tracking-wider">ID Reference No.</span><span class="font-medium text-green-900 font-mono">
                                {{ Str::mask((string)$user->id_number, '*', 0, max(1, strlen((string)$user->id_number) - 4)) }}
                            </span></div>
=======
                            Your identity was confirmed on
                            {{ $user->id_verified_at ? $user->id_verified_at->format('M d, Y') : 'recently' }}. All travel
                            features are unlocked!
                        </p>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-green-200/60 pt-4">
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Tourist
                                    Name</span><span class="font-medium text-green-900">{{ $user->name }}</span></div>
                            <div><span class="text-green-600/70 block text-xs uppercase tracking-wider">Document
                                    Type</span><span
                                    class="font-medium text-green-900">{{ $user->id_type ?? 'Government ID' }}</span></div>
                            <div class="col-span-2"><span
                                    class="text-green-600/70 block text-xs uppercase tracking-wider">ID Reference
                                    No.</span><span class="font-medium text-green-900 font-mono">
                                    {{ Str::mask((string) $user->id_number, '*', 0, max(1, strlen((string) $user->id_number) - 4)) }}
                                </span></div>
>>>>>>> Stashed changes
                        </div>
                    </div>
                </div>

<<<<<<< Updated upstream
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
                            <button type="button" id="btn-start-verification" class="text-sm font-medium text-white bg-brand-700 hover:bg-brand-800 px-4 py-2 rounded-lg transition shadow-sm">
                                Start Verification
=======
                {{-- PENDING STATE --}}
            @else
                <div class="flex items-start gap-3">
                    <div class="text-amber-600 mt-0.5 relative">
                        <span
                            class="absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-30 animate-ping inset-0"></span>
                        <svg class="w-6 h-6 relative" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="w-full">
                        <h4 class="font-bold text-amber-800 text-lg">🕓 Under Review (Pending)</h4>
                        <p class="text-amber-700 text-sm mt-1">
                            Submitted {{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'recently' }}. Features
                            (Explore Spots, Bookings, Tickets) remain locked until an admin approves your verification.
                        </p>

                        @if($notes)
                            <div class="mt-3 p-3 bg-amber-100/60 border border-amber-200 rounded-lg text-xs text-amber-800">
                                <strong>Note:</strong> {{ $notes }}
                            </div>
                        @endif

                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm border-t border-amber-200/60 pt-4">
                            <div><span class="text-amber-700/70 block text-xs uppercase tracking-wider">Tourist
                                    Name</span><span class="font-medium text-amber-900">{{ $user->name }}</span></div>
                            <div><span class="text-amber-700/70 block text-xs uppercase tracking-wider">Document
                                    Type</span><span
                                    class="font-medium text-amber-900">{{ $user->id_type ?? 'Not Provided' }}</span></div>
                        </div>

                        <div class="mt-4 pt-4 border-t border-amber-200/60 flex items-center gap-3">
                            <button type="button" id="btn-open-camera-modal"
                                class="text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 rounded-xl transition shadow-md flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Capture / Update ID Photo
                            </button>
                            <button type="button" id="btn-view-details"
                                class="text-sm font-medium text-amber-800 hover:text-amber-900 bg-amber-100 px-3.5 py-2.5 rounded-xl transition">
                                View Submitted Details
>>>>>>> Stashed changes
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

<<<<<<< Updated upstream
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
=======
    {{-- Full Details Modal --}}
    <div id="modal-view-details"
        style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(4px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div
            style="background:#fff;border-radius:1rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.25);width:90vw;max-width:36rem;max-height:90vh;display:flex;flex-direction:column;border:1px solid #e5e7eb;">
            <div
                style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <h3 style="font-weight:700;color:#1f2937;font-size:1.125rem;">Identity Verification Details</h3>
                <button type="button"
                    class="btn-close-modal text-gray-400 hover:text-gray-600 p-1 text-lg font-bold">✕</button>
>>>>>>> Stashed changes
            </div>
            {{-- Scrollable Body --}}
            <div style="padding:1.5rem;overflow-y:auto;flex:1;">
                <dl style="display:grid;grid-template-columns:1fr 1fr;gap:1rem 1.5rem;font-size:0.875rem;">
                    <div style="grid-column:span 2">
<<<<<<< Updated upstream
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
=======
                        <dt style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;">Full Name
                        </dt>
                        <dd style="font-weight:600;color:#111827;margin-top:0.25rem;">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;">Gender
                        </dt>
                        <dd style="font-weight:600;color:#111827;margin-top:0.25rem;">{{ $user->gender ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;">Date of
                            Birth</dt>
                        <dd style="font-weight:600;color:#111827;margin-top:0.25rem;">
                            {{ $user->dob ? \Carbon\Carbon::parse($user->dob)->format('M d, Y') : '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;">
                            Classification</dt>
                        <dd style="font-weight:600;color:#111827;margin-top:0.25rem;">{{ $user->classification ?? '—' }}
                        </dd>
                    </div>
                    <div>
                        <dt style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;">ID Type
                        </dt>
                        <dd style="font-weight:600;color:#111827;margin-top:0.25rem;">{{ $user->id_type ?? '—' }}</dd>
>>>>>>> Stashed changes
                    </div>
                    <div>
                        <dt style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">ID Number</dt>
                        <dd style="font-weight:600;color:#111827;font-family:monospace;font-size:0.95em;">{{ $user->id_number ?? '—' }}</dd>
                    </div>
                </dl>
                @if($user->id_photo)
<<<<<<< Updated upstream
                <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f3f4f6;">
                    <p style="color:#9ca3af;font-size:0.7rem;text-transform:uppercase;letter-spacing:.05em;margin-bottom:.5rem;">Uploaded ID Photo</p>
                    {{-- image-orientation: from-image reads EXIF rotation metadata, fixing sideways phone photos --}}
                    <img src="{{ Storage::url($user->id_photo) }}" alt="Uploaded ID"
                         style="width:100%;max-height:16rem;object-fit:contain;border-radius:0.75rem;border:1px solid #e5e7eb;box-shadow:0 1px 3px rgba(0,0,0,.1);image-orientation:from-image;" />
                </div>
=======
                    <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #f3f4f6;" class="relative select-none" oncontextmenu="return false;">
                        <p
                            style="color:#64748b;font-size:0.75rem;text-transform:uppercase;font-weight:700;margin-bottom:.5rem;">
                            Current ID Photo (Protected)</p>
                        <img src="{{ Storage::url($user->id_photo) }}" alt="Uploaded ID"
                            oncontextmenu="return false;"
                            ondragstart="return false;"
                            class="pointer-events-none select-none"
                            style="width:100%;max-height:16rem;object-fit:contain;border-radius:0.75rem;border:1px solid #e5e7eb;-webkit-user-drag:none;user-drag:none;-webkit-user-select:none;user-select:none;" />
                    </div>
>>>>>>> Stashed changes
                @endif
            </div>
            {{-- Sticky Footer --}}
            <div style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;text-align:right;flex-shrink:0;">
<<<<<<< Updated upstream
                <button type="button" class="btn-close-modal" style="padding:0.5rem 1.25rem;background:#f3f4f6;color:#374151;border-radius:0.5rem;font-size:0.875rem;font-weight:500;border:none;cursor:pointer;" onmouseenter="this.style.background='#e5e7eb'" onmouseleave="this.style.background='#f3f4f6'">Close</button>
=======
                <button type="button"
                    class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-lg text-sm font-semibold">Close</button>
>>>>>>> Stashed changes
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
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
                            <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required>
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
                        <select id="classification" name="classification" class="block mt-1 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required>
                            <option value="Local" {{ $user->classification === 'Local' ? 'selected' : '' }}>Local</option>
                            <option value="Domestic" {{ $user->classification === 'Domestic' ? 'selected' : '' }}>Domestic</option>
                            <option value="Foreign" {{ $user->classification === 'Foreign' ? 'selected' : '' }}>Foreign</option>
                        </select>
                    </div>
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-brand-700 text-white rounded-lg text-sm font-medium hover:bg-brand-800 transition">
                            Save Details & Re-verify
=======
    {{-- Live Front & Back ID Camera Capture Modal --}}
    <div id="modal-camera-capture"
        style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.7);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:1rem;overflow-y:auto;">
        <div
            style="background:#ffffff;color:#1f2937;border-radius:1.25rem;box-shadow:0 25px 50px -12px rgba(0,0,0,.35);width:95vw;max-width:32rem;max-height:92vh;display:flex;flex-direction:column;border:1px solid #e5e7eb;overflow:hidden;">

            {{-- Modal Header --}}
            <div
                style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;flex-shrink:0;">
                <div>
                    <h3 class="font-bold text-gray-900 text-base sm:text-lg">ID Photo Capture — Front + Back</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Capture both sides of your ID</p>
                </div>
                <button type="button"
                    class="btn-close-modal text-gray-400 hover:text-gray-600 p-1 text-xl font-bold transition-colors">✕</button>
            </div>

            {{-- Form Body --}}
            <form id="profile-cam-form" method="POST" action="{{ route('profile.upload-id-photo') }}"
                enctype="multipart/form-data" class="p-4 sm:p-5 overflow-y-auto space-y-4 flex-1">
                @csrf

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">ID Type</label>
                        <select id="prof_id_type" name="id_type"
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg text-xs py-2 px-2.5 focus:ring-emerald-500 focus:border-emerald-500 shadow-xs">
                            @foreach(['Passport', 'National ID', "Driver's License", 'SSS ID', 'GSIS ID', 'PhilHealth ID', 'Pag-IBIG ID', 'Voter ID', 'Postal ID', 'School ID', 'Barangay ID', 'Company ID'] as $type)
                                <option value="{{ $type }}" {{ $user->id_type === $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-700 mb-1">ID Number / Code</label>
                        <input type="text" id="prof_id_number" name="id_number" value="{{ $user->id_number }}"
                            placeholder="ID Number"
                            class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg text-xs py-2 px-2.5 focus:ring-emerald-500 focus:border-emerald-500 shadow-xs" />
                    </div>
                </div>

                {{-- Camera Viewfinder Container (.cam-box matching register.blade.php) --}}
                <div class="cam-box" id="prof-cam-box">

                    {{-- State A: Pending Camera Enable --}}
                    <div id="prof-cam-state-pending"
                        class="flex flex-col items-center justify-center text-center gap-4 px-6 py-10">
                        <div class="relative w-16 h-16 flex items-center justify-center">
                            <div class="absolute inset-0 rounded-full animate-ping opacity-35 bg-teal-500"
                                style="animation-duration: 2s;"></div>
                            <div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:rgba(13,148,136,0.18);border:1.5px solid rgba(20,184,166,0.5);display:flex;align-items:center;justify-content:center;color:#2dd4bf;"
                                class="relative z-10">
                                <svg style="width:1.75rem;height:1.75rem;" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p style="color:#f8fafc; font-weight:600; font-size:.875rem;">Capture Your ID with Live
                                Camera</p>
                            <p style="color:#cbd5e1; font-size:.75rem; margin-top:.25rem; line-height:1.6;">Requires
                                camera permission. You will capture Front ID then Back ID.</p>
                        </div>
                        <button type="button" id="prof-btn-start-cam"
                            class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition shadow-md flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 10l4.553-2.069A1 1 0 0121 8.868V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Enable Live Camera
>>>>>>> Stashed changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<<<<<<< Updated upstream
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
                                <div class="w-16 h-16 bg-slate-900 rounded-full flex items-center justify-center text-brand-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-sm text-slate-200">Camera Access Required</h5>
                                    <p class="text-xs text-slate-400 mt-1">Please allow camera access to capture your ID directly.</p>
                                </div>
                                <button type="button" id="btn-activate-camera" class="px-4 py-2 bg-brand-700 hover:bg-brand-800 text-white rounded-lg text-xs font-semibold shadow-md transition duration-150">
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

                                    <button type="button" id="btn-capture-photo" class="w-12 h-12 bg-white hover:bg-slate-100 rounded-full border-4 border-slate-700 hover:border-brand-500 shadow-lg flex items-center justify-center transition focus:outline-none">
                                        <div class="w-7 h-7 bg-brand-700 rounded-full"></div>
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
                        <button type="submit" id="submit-upload-btn" disabled class="px-5 py-2 bg-brand-700 text-white rounded-lg text-sm font-medium hover:bg-brand-800 transition opacity-50 cursor-not-allowed">
                            Submit ID Photo
                        </button>
=======
                    {{-- State B: Active Live Video Stream --}}
                    <div id="prof-cam-state-active" class="hidden flex flex-col">
                        <div class="relative" style="aspect-ratio:4/3;background:#000;overflow:hidden;">
                            <video id="prof-cam-video" autoplay playsinline muted
                                class="w-full h-full object-cover"></video>

                            {{-- Step & Side Badges (Top Left) --}}
                            <div class="absolute top-3 left-3 z-20 flex flex-row gap-2 pointer-events-none">
                                <span id="prof-cam-step-badge"
                                    class="bg-emerald-700/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Step
                                    1 of 2</span>
                                <span id="prof-cam-side-badge"
                                    class="bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Front
                                    ID</span>
                            </div>

                            {{-- Auto-advance Confirmation Overlay --}}
                            <div id="prof-cam-transition-overlay"
                                class="absolute inset-0 bg-slate-900/95 flex flex-col items-center justify-center text-center gap-3 z-30 hidden">
                                <div
                                    class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white text-xl animate-scale shadow-lg">
                                    ✓</div>
                                <p class="text-white font-bold text-sm">Front Captured Successfully!</p>
                                <p class="text-teal-300 text-xs">Automatically switching to Back of ID...</p>
                            </div>

                            {{-- SVG Framing Guide with Corner Cut Accents --}}
                            <svg id="prof-cam-guide-svg" class="absolute inset-0 w-full h-full pointer-events-none"
                                xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <mask id="cam-guide-mask-prof">
                                        <rect width="100%" height="100%" fill="white" />
                                        <rect id="prof-guide-cutout" x="8%" y="12%" width="84%" height="76%" rx="16"
                                            fill="black" />
                                    </mask>
                                </defs>
                                <rect width="100%" height="100%" fill="rgba(8,17,31,0.7)"
                                    mask="url(#cam-guide-mask-prof)" />
                                <rect id="prof-guide-outline" x="8%" y="12%" width="84%" height="76%" rx="16"
                                    fill="none" stroke="#14b8a6" stroke-width="2.5" stroke-dasharray="10 6"
                                    class="cam-guide-rect" />

                                {{-- Four Cut-Edge Corner Accents --}}
                                <g id="prof-cam-corners">
                                    <path id="prof-corner-tl" class="cam-corner-path" />
                                    <path id="prof-corner-tr" class="cam-corner-path" />
                                    <path id="prof-corner-bl" class="cam-corner-path" />
                                    <path id="prof-corner-br" class="cam-corner-path" />
                                </g>
                            </svg>

                            {{-- Floating Instruction Pill --}}
                            <div class="absolute bottom-4 inset-x-0 flex justify-center pointer-events-none z-10">
                                <span id="prof-cam-pill" class="cam-pill">
                                    <svg class="w-3.5 h-3.5 text-teal-400 flex-shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="prof-cam-pill-text">Align ID within the glowing frame</span>
                                </span>
                            </div>
                        </div>

                        {{-- Sleek Studio Bottom Bar --}}
                        <div class="cam-bottom-bar">
                            <div class="cam-orient-label" id="prof-btn-flip-guide" title="Toggle guide aspect ratio">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7" />
                                </svg>
                                <span id="prof-orient-label-text">Landscape Guide</span>
                            </div>
                            <button type="button" id="prof-btn-shutter" class="cam-shutter" title="Capture photo">
                                <div class="cam-shutter-dot"></div>
                            </button>
                            <button type="button" id="prof-btn-flip-cam" class="cam-flip-btn" title="Switch camera">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                Flip
                            </button>
                        </div>
                    </div>

                    {{-- State C: Captured Completion Review --}}
                    <div id="prof-cam-state-captured" class="hidden flex flex-col">
                        <div class="p-3 bg-slate-900 border-b border-teal-950 text-center">
                            <span
                                class="text-green-400 font-bold text-xs uppercase tracking-widest block flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                ID capture complete
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 p-3 bg-slate-950">
                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Front
                                    side</span>
                                <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
                                    <img id="prof-img-front-thumb" class="block w-full h-auto" alt="Front ID Preview" />
                                    <span
                                        class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <span
                                    class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Back
                                    side</span>
                                <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
                                    <img id="prof-img-back-thumb" class="block w-full h-auto" alt="Back ID Preview" />
                                    <span
                                        class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="cam-bottom-bar justify-center">
                            <button type="button" id="prof-btn-retake" class="cam-flip-btn"
                                style="color:#fb923c;border-color:rgba(251,146,60,.35);">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89" />
                                </svg>
                                Retake &amp; Restart
                            </button>
                        </div>
>>>>>>> Stashed changes
                    </div>
                </form>
            </div>

<<<<<<< Updated upstream
    {{-- Loading Overlay --}}
    <div id="loading-overlay" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/80 backdrop-blur-sm transition-opacity">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-100">
            <div class="text-6xl mb-6 animate-bounce">⏳</div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight mb-2">Reading Your ID...</h2>
            <p class="text-gray-500 text-sm">This usually takes a few seconds.</p>
=======
                </div>

                <!-- Hidden inputs -->
                <input type="hidden" id="prof_id_photo_base64" name="id_photo_base64" />
                <input type="file" id="prof_id_photo_file" name="id_photo" class="hidden" accept="image/jpeg" />

                <div class="pt-3 border-t border-gray-200 flex justify-end gap-3">
                    <button type="button"
                        class="btn-close-modal px-4 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 rounded-xl text-xs font-semibold transition-colors">Cancel</button>
                    <button type="submit" id="prof-submit-btn" disabled
                        class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition opacity-50 cursor-not-allowed shadow-md">
                        Submit ID for Review
                    </button>
                </div>
            </form>
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
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
=======
            // Camera Engine Elements
            const statePending = document.getElementById('prof-cam-state-pending');
            const stateActive = document.getElementById('prof-cam-state-active');
            const stateCaptured = document.getElementById('prof-cam-state-captured');
            const transitionOverlay = document.getElementById('prof-cam-transition-overlay');

            const btnStartCam = document.getElementById('prof-btn-start-cam');
            const btnShutter = document.getElementById('prof-btn-shutter');
            const btnRetake = document.getElementById('prof-btn-retake');
            const btnFlipGuide = document.getElementById('prof-btn-flip-guide');
            const btnFlipCam = document.getElementById('prof-btn-flip-cam');
            const submitBtn = document.getElementById('prof-submit-btn');

            const camVideo = document.getElementById('prof-cam-video');
            const imgFrontThumb = document.getElementById('prof-img-front-thumb');
            const imgBackThumb = document.getElementById('prof-img-back-thumb');
            const stepBadge = document.getElementById('prof-cam-step-badge');
            const sideBadge = document.getElementById('prof-cam-side-badge');
            const pillText = document.getElementById('prof-cam-pill-text');
            const orientLabel = document.getElementById('prof-orient-label-text');
            const guideCutout = document.getElementById('prof-guide-cutout');
            const guideOutline = document.getElementById('prof-guide-outline');

            let stream = null;
            let currentStep = 1; // 1 = Front, 2 = Back
            let frontPhotoData = null;
            let backPhotoData = null;
            let facingMode = 'environment';
            let isLandscape = true;
>>>>>>> Stashed changes

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
<<<<<<< Updated upstream
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
=======
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: { facingMode: { ideal: facingMode }, width: { ideal: 1920 }, height: { ideal: 1080 } },
                        audio: false
                    });
                    camVideo.srcObject = stream;
                    showState('active');
                    currentStep = 1;
                    if (transitionOverlay) transitionOverlay.classList.add('hidden');
                    stepBadge.textContent = 'Step 1 of 2';
                    sideBadge.textContent = 'Front ID';
                    sideBadge.className = 'bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
                    pillText.textContent = 'Align ID within the glowing frame';
                    setTimeout(updateCornerCuts, 60);
                } catch (e) {
                    alert('Camera error: ' + e.message);
                    showState('pending');
                }
            }

            // Calculate and draw corner cut brackets matching viewfinder
            function updateCornerCuts() {
                const svg = document.getElementById('prof-cam-guide-svg');
                if (!svg) return;
                const rect = svg.getBoundingClientRect();
                const W = rect.width;
                const H = rect.height;
                if (!W || !H) return;

                const xP = isLandscape ? 0.08 : 0.20;
                const yP = isLandscape ? 0.12 : 0.06;
                const wP = isLandscape ? 0.84 : 0.60;
                const hP = isLandscape ? 0.76 : 0.88;
                const r = 16;
                const arm = Math.min(W * 0.08, 26);

                const x = W * xP;
                const y = H * yP;
                const w = W * wP;
                const h = H * hP;

                const cTL = document.getElementById('prof-corner-tl');
                const cTR = document.getElementById('prof-corner-tr');
                const cBL = document.getElementById('prof-corner-bl');
                const cBR = document.getElementById('prof-corner-br');

                if (cTL) cTL.setAttribute('d', `M ${x} ${y + arm} L ${x} ${y + r} Q ${x} ${y} ${x + r} ${y} L ${x + arm} ${y}`);
                if (cTR) cTR.setAttribute('d', `M ${x + w - arm} ${y} L ${x + w - r} ${y} Q ${x + w} ${y} ${x + w} ${y + r} L ${x + w} ${y + arm}`);
                if (cBL) cBL.setAttribute('d', `M ${x} ${y + h - arm} L ${x} ${y + h - r} Q ${x} ${y + h} ${x + r} ${y + h} L ${x + arm} ${y + h}`);
                if (cBR) cBR.setAttribute('d', `M ${x + w - arm} ${y + h} L ${x + w - r} ${y + h} Q ${x + w} ${y + h} ${x + w} ${y + h - r} L ${x + w} ${y + h - arm}`);
            }

            window.addEventListener('resize', () => {
                if (stream) updateCornerCuts();
            });

            if (btnStartCam) btnStartCam.addEventListener('click', startCamera);

            // Shutter capture with auto-advance transition and automatic guide frame cropping
            if (btnShutter) {
                btnShutter.addEventListener('click', () => {
                    if (!stream || !camVideo.videoWidth) return;
                    const vW = camVideo.videoWidth, vH = camVideo.videoHeight;
                    if (!vW || !vH) return;

                    const svg = document.getElementById('prof-cam-guide-svg');
                    let cropX = 0, cropY = 0, cropW = vW, cropH = vH;

                    if (svg) {
                        const svgRect = svg.getBoundingClientRect();
                        const cDisplayWidth = svgRect.width;
                        const cDisplayHeight = svgRect.height;

                        if (cDisplayWidth > 0 && cDisplayHeight > 0) {
                            // Calculate scale factor & offsets for object-fit: cover
                            const scale = Math.max(cDisplayWidth / vW, cDisplayHeight / vH);
                            const offsetX = (cDisplayWidth - vW * scale) / 2;
                            const offsetY = (cDisplayHeight - vH * scale) / 2;

                            const xPct = isLandscape ? 0.08 : 0.20;
                            const yPct = isLandscape ? 0.12 : 0.06;
                            const wPct = isLandscape ? 0.84 : 0.60;
                            const hPct = isLandscape ? 0.76 : 0.88;

                            const boxX = cDisplayWidth * xPct;
                            const boxY = cDisplayHeight * yPct;
                            const boxW = cDisplayWidth * wPct;
                            const boxH = cDisplayHeight * hPct;

                            // Map SVG guide frame coordinates to intrinsic video stream coordinates
                            const videoRenderX = boxX - offsetX;
                            const videoRenderY = boxY - offsetY;

                            cropX = Math.max(0, Math.round(videoRenderX / scale));
                            cropY = Math.max(0, Math.round(videoRenderY / scale));
                            cropW = Math.min(vW - cropX, Math.round(boxW / scale));
                            cropH = Math.min(vH - cropY, Math.round(boxH / scale));
                        }
                    }

                    const canvas = document.createElement('canvas');
                    canvas.width = cropW;
                    canvas.height = cropH;
                    canvas.getContext('2d').drawImage(camVideo, cropX, cropY, cropW, cropH, 0, 0, cropW, cropH);
                    const url = canvas.toDataURL('image/jpeg', 0.9);

                    if (currentStep === 1) {
                        frontPhotoData = url;
                        imgFrontThumb.src = url;
                        currentStep = 2;

                        // Show auto-advance overlay
                        transitionOverlay.classList.remove('hidden');
                        setTimeout(() => {
                            transitionOverlay.classList.add('hidden');
                            stepBadge.textContent = 'Step 2 of 2';
                            sideBadge.textContent = 'Back ID';
                            sideBadge.className = 'bg-emerald-600/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
                            pillText.textContent = 'Now capture the Back side of your ID';
                            updateCornerCuts();
                        }, 1200);
                    } else {
                        backPhotoData = url;
                        imgBackThumb.src = url;

                        // Merge front and back cropped photos into vertical composite canvas
                        const imgF = new Image(), imgB = new Image();
                        imgF.onload = () => {
                            imgB.onload = () => {
                                const cW = Math.max(imgF.width, imgB.width);
                                const cH = imgF.height + imgB.height;
                                const compCanvas = document.createElement('canvas');
                                compCanvas.width = cW;
                                compCanvas.height = cH;
                                const ctx = compCanvas.getContext('2d');
                                ctx.fillStyle = '#08111f';
                                ctx.fillRect(0, 0, cW, cH);
                                ctx.drawImage(imgF, (cW - imgF.width) / 2, 0);
                                ctx.drawImage(imgB, (cW - imgB.width) / 2, imgF.height);

                                const compositeUrl = compCanvas.toDataURL('image/jpeg', 0.85);
                                document.getElementById('prof_id_photo_base64').value = compositeUrl;
>>>>>>> Stashed changes

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

<<<<<<< Updated upstream
            if (btnRetakePhoto) {
                btnRetakePhoto.addEventListener('click', () => {
                    isFileValid = false;
                    fileInput.value = '';
                    fileSuccess.classList.add('hidden');
                    submitUploadBtn.disabled = true;
                    submitUploadBtn.classList.add('opacity-50', 'cursor-not-allowed');
=======
            // Orientation toggle
            function toggleOrientation() {
                isLandscape = !isLandscape;
                if (isLandscape) {
                    orientLabel.textContent = 'Landscape Guide';
                    [guideCutout, guideOutline].forEach(el => {
                        el.setAttribute('x', '8%');
                        el.setAttribute('y', '12%');
                        el.setAttribute('width', '84%');
                        el.setAttribute('height', '76%');
                    });
                } else {
                    orientLabel.textContent = 'Portrait Guide';
                    [guideCutout, guideOutline].forEach(el => {
                        el.setAttribute('x', '20%');
                        el.setAttribute('y', '6%');
                        el.setAttribute('width', '60%');
                        el.setAttribute('height', '88%');
                    });
                }
                updateCornerCuts();
            }

            if (btnFlipGuide) btnFlipGuide.addEventListener('click', toggleOrientation);

            // Flip camera front/back facing
            if (btnFlipCam) {
                btnFlipCam.addEventListener('click', () => {
                    facingMode = facingMode === 'environment' ? 'user' : 'environment';
                    startCamera();
                });
            }

            // Retake & Restart
            if (btnRetake) {
                btnRetake.addEventListener('click', () => {
                    currentStep = 1;
                    frontPhotoData = null;
                    backPhotoData = null;
                    document.getElementById('prof_id_photo_base64').value = '';
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
>>>>>>> Stashed changes
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