<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --teal-dark: #0f766e; --ocean: #0891b2;
            --emerald: #10b981; --rose: #f43f5e; --sand: #f59e0b;
            --border: #ccfbf1; --bg: #f0fdfc;
            --text-1: #134e4a; --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t: 0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card: 0 2px 12px rgba(0,0,0,.07);
            --r-sm: 8px; --r-md: 14px; --r-lg: 20px;
        }
        #booking-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        #booking-page { background: var(--bg); min-height: 100vh; }

        .booking-outer { max-width: 620px; margin: 0 auto; padding: 0 20px 64px; }

        /* Back */
        .back-btn { display: inline-flex; align-items: center; gap: 8px; color: var(--teal); font-weight: 600; font-size: .88rem; background: none; border: none; padding: 28px 0 0; cursor: pointer; transition: gap var(--t); text-decoration: none; }
        .back-btn:hover { gap: 12px; }

        /* Header */
        .booking-header { text-align: center; padding: 28px 0 24px; }
        .booking-header h1 { font-family: 'Fraunces', serif; font-size: 1.8rem; color: var(--text-1); margin-bottom: 8px; }
        .booking-header p { font-size: .9rem; color: var(--text-3); }

        /* Dest chip */
        .dest-chip {
            display: inline-flex; align-items: center; gap: 10px;
            padding: 10px 18px; background: #fff; border: 1.5px solid var(--border);
            border-radius: 99px; margin-bottom: 24px;
            box-shadow: var(--sh-card); text-decoration: none;
        }
        .chip-emoji { font-size: 1.4rem; }
        .chip-name { font-weight: 700; font-size: .88rem; color: var(--text-1); }
        .chip-loc  { font-size: .75rem; color: var(--text-3); }

        /* Summary box */
        .booking-summary {
            background: #f0fdfc; border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 16px 18px; margin-bottom: 22px;
        }
        .bs-row { display: flex; justify-content: space-between; font-size: .86rem; padding: 4px 0; }
        .bs-key { color: var(--text-3); }
        .bs-val { font-weight: 600; color: var(--text-1); }
        .bs-total { border-top: 1px solid var(--border); padding-top: 10px; margin-top: 8px; }
        .bs-total .bs-key { font-weight: 700; color: var(--text-1); }
        .status-pending { background: #fef3c7; color: #92400e; padding: 3px 10px; border-radius: 99px; font-size: .72rem; font-weight: 700; text-transform: uppercase; }

        /* Form card */
        .form-card { background: #fff; border-radius: var(--r-lg); padding: 28px; box-shadow: var(--sh-card); border: 1px solid #e5f6f4; }
        .form-section { margin-bottom: 20px; }
        .form-section:last-child { margin-bottom: 0; }
        .form-label { display: block; font-weight: 600; font-size: .83rem; color: var(--text-2); margin-bottom: 6px; }
        .form-label span { color: var(--rose); }
        .form-input {
            width: 100%; border: 1.5px solid #d1d5db; border-radius: var(--r-sm);
            padding: 11px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem; color: var(--text-2); outline: none;
            transition: border-color var(--t), box-shadow var(--t); background: #fff;
        }
        .form-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,148,136,.1); }
        .form-hint { font-size: .75rem; color: var(--text-4); margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media(max-width: 500px) { .form-row { grid-template-columns: 1fr; } }

        /* Stay range info */
        .stay-range-info {
            background: linear-gradient(135deg, #ecfdf5, #f0fdfc);
            border: 1.5px solid #6ee7b7; border-radius: var(--r-md);
            padding: 14px 16px; margin-bottom: 20px; font-size: .85rem; color: var(--teal-dark);
        }
        .stay-range-info .sri-title { font-weight: 800; margin-bottom: 4px; }
        .stay-range-info .sri-sub   { font-size: .78rem; opacity: .8; }

        /* Terms */
        .terms-box { background: #fffbeb; border: 1.5px solid #fcd34d; border-radius: var(--r-md); padding: 14px 18px; margin-bottom: 20px; font-size: .8rem; color: #92400e; }
        .terms-box p { font-weight: 700; margin-bottom: 6px; }
        .terms-box ul { list-style: disc; padding-left: 16px; }
        .terms-box li { margin-bottom: 3px; }

        /* Tourist info */
        .tourist-info { background: rgba(99,102,241,.05); border: 1.5px solid #c7d2fe; border-radius: var(--r-md); padding: 14px 16px; margin-bottom: 20px; }
        .ti-title { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #4338ca; margin-bottom: 10px; }
        .ti-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .ti-item .ti-label { font-size: .7rem; color: var(--text-4); }
        .ti-item .ti-value { font-weight: 700; color: var(--text-2); font-size: .88rem; }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 14px; border: none; border-radius: var(--r-md);
            font-size: 1rem; font-weight: 800;
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; box-shadow: 0 4px 20px rgba(13,148,136,.35);
            cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(13,148,136,.45); }
        .btn-cancel {
            width: 100%; padding: 11px; border: 1.5px solid #e5e7eb; border-radius: var(--r-md);
            font-size: .9rem; font-weight: 600; background: #fff; color: var(--text-3);
            margin-top: 10px; cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-cancel:hover { border-color: var(--rose); color: var(--rose); }

        .error-box { background: #fff1f2; border: 1.5px solid #fda4af; color: #9f1239; border-radius: var(--r-md); padding: 12px 16px; font-size: .84rem; margin-bottom: 18px; }
    </style>

    @php
        $preDate     = request('visit_date', old('visit_date'));
        $preDuration = max(1, min(10, (int) request('duration', 1)));
        $endDate     = $preDate ? \Carbon\Carbon::parse($preDate)->addDays($preDuration - 1) : null;
        $startFmt    = $preDate ? \Carbon\Carbon::parse($preDate)->format('M j, Y') : null;
        $endFmt      = $endDate ? $endDate->format('M j, Y') : null;

        $n = strtolower($destination->name);
        $emoji = '🌿';
        if (str_contains($n,'casas')||str_contains($n,'shrine')) $emoji='🏛️';
        elseif (str_contains($n,'rapids')||str_contains($n,'river')||str_contains($n,'gapo')) $emoji='🚣';
        elseif (str_contains($n,'lake')||str_contains($n,'maragang')) $emoji='🌊';
        elseif (str_contains($n,'falls')||str_contains($n,'nangan')) $emoji='💦';
    @endphp

    <div id="booking-page">
        <div class="booking-outer">

            {{-- Back --}}
            <a href="{{ route('destinations.show', $destination) }}" class="back-btn">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Destination
            </a>

            {{-- Header --}}
            <div class="booking-header">
                <h1>Confirm Your Visit 🎒</h1>
                <p>Review your details and submit your booking request below.</p>
                <div style="margin-top:16px;display:flex;justify-content:center;">
                    <a href="{{ route('destinations.show', $destination) }}" class="dest-chip">
                        <span class="chip-emoji">{{ $emoji }}</span>
                        <div>
                            <div class="chip-name">{{ $destination->name }}</div>
                            <div class="chip-loc">{{ $destination->location }}</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Errors --}}
            @if(session('error') || $errors->any())
            <div class="error-box">
                @if(session('error'))
                    <strong>⚠️ {{ session('error') }}</strong>
                @endif
                @foreach($errors->all() as $e)
                    <p>• {{ $e }}</p>
                @endforeach
            </div>
            @endif

            {{-- Stay range banner (multi-day) --}}
            @if($startFmt && $preDuration > 1)
            <div class="stay-range-info">
                <div class="sri-title">📌 {{ $preDuration }}-Day Stay: {{ $startFmt }} → {{ $endFmt }}</div>
                <div class="sri-sub">Your booking covers {{ $preDuration }} consecutive days. The visit date below is your start date.</div>
            </div>
            @endif

            {{-- Booking Summary --}}
            <div class="booking-summary">
                <div class="bs-row">
                    <span class="bs-key">📅 Visit Date</span>
                    <span class="bs-val">{{ $startFmt ?: '—' }}</span>
                </div>
                @if($preDuration > 1)
                <div class="bs-row">
                    <span class="bs-key">🗓️ Duration</span>
                    <span class="bs-val">{{ $preDuration }} Days (ends {{ $endFmt }})</span>
                </div>
                @endif
                <div class="bs-row">
                    <span class="bs-key">👥 Capacity / Day</span>
                    <span class="bs-val">{{ $destination->capacity }} visitors</span>
                </div>
                <div class="bs-row bs-total">
                    <span class="bs-key">Status after submission</span>
                    <span class="bs-val"><span class="status-pending">Pending Review</span></span>
                </div>
            </div>

            {{-- Tourist info --}}
            <div class="tourist-info">
                <div class="ti-title">👤 Your Details (from account)</div>
                <div class="ti-grid">
                    <div class="ti-item">
                        <div class="ti-label">Name</div>
                        <div class="ti-value">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="ti-item">
                        <div class="ti-label">Email</div>
                        <div class="ti-value" style="word-break:break-all;">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="form-card">
                <form action="{{ route('bookings.store', $destination) }}" method="POST">
                    @csrf

                    <div class="form-row" style="margin-bottom:20px;">
                        <div class="form-section" style="margin-bottom:0;">
                            <label class="form-label" for="visit_date">
                                Visit Date <span>*</span>
                                @if($preDuration > 1)
                                    <span style="font-weight:400;color:var(--text-4);font-size:.72rem;">(start date)</span>
                                @endif
                            </label>
                            <input class="form-input" type="date" id="visit_date" name="visit_date"
                                min="{{ now()->addDay()->toDateString() }}"
                                value="{{ $preDate }}"
                                required>
                            @if($preDuration > 1 && $startFmt)
                                <p class="form-hint" style="color:var(--teal-dark);font-weight:600;">📌 {{ $startFmt }} → {{ $endFmt }}</p>
                            @else
                                <p class="form-hint">At least 1 day in advance.</p>
                            @endif
                        </div>

                        <div class="form-section" style="margin-bottom:0;">
                            <label class="form-label">Duration</label>
                            <input class="form-input" type="text" readonly
                                value="{{ $preDuration }} Day{{ $preDuration > 1 ? 's' : '' }}"
                                style="background:#f9fafb;color:var(--text-3);">
                            <p class="form-hint">Selected from availability calendar.</p>
                        </div>
                    </div>

                    <div class="terms-box">
                        <p>📋 Important Booking Terms</p>
                        <ul>
                            <li>All bookings are submitted with <strong>Pending Review</strong> status.</li>
                            <li>The site's assigned staff will review and approve your slot.</li>
                            <li>Once approved, a unique QR ticket is issued to scan at the gate.</li>
                            @if($preDuration > 1)
                                <li>Multi-day bookings are registered by start date; you'll need to check in each day.</li>
                            @endif
                        </ul>
                    </div>

                    <button type="submit" class="btn-submit" id="submit-btn">
                        📨 Submit Booking Request
                    </button>
                </form>
                <a href="{{ route('destinations.show', $destination) }}" class="btn-cancel" style="display:block;text-align:center;text-decoration:none;">
                    ← Back to Destination
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
