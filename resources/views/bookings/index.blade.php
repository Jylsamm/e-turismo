<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --teal-light: #14b8a6; --teal-dark: #0f766e;
            --ocean: #0891b2; --emerald: #10b981; --rose: #f43f5e;
            --amber: #f59e0b; --indigo: #6366f1; --purple: #8b5cf6;
            --bg: #f0fdfc; --border: #ccfbf1;
            --text-1: #134e4a; --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t: 0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card: 0 2px 12px rgba(0,0,0,.07);
            --sh-md: 0 4px 24px rgba(13,148,136,.14);
            --r-md: 14px; --r-lg: 20px; --r-xl: 28px;
        }
        #bookings-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        #bookings-page { background: var(--bg); min-height: 100vh; padding-bottom: 64px; }

        /* ── Hero ── */
        .bk-hero {
            background: linear-gradient(135deg, #0d9488 0%, #0891b2 55%, #6366f1 100%);
            padding: 36px 24px 48px; text-align: center; position: relative; overflow: hidden;
        }
        .bk-hero::before {
            content: ''; position: absolute; inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='52' height='52' viewBox='0 0 52 52' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='26' cy='26' r='18' fill='none' stroke='%23ffffff' stroke-opacity='.04' stroke-width='1'/%3E%3C/svg%3E");
        }
        .bk-hero-inner { position: relative; z-index: 1; }
        .bk-hero-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.15); border: 1px solid rgba(255,255,255,.25);
            color: rgba(255,255,255,.9); padding: 4px 14px; border-radius: 99px;
            font-size: .72rem; font-weight: 700; letter-spacing: .5px;
            text-transform: uppercase; margin-bottom: 14px;
        }
        .bk-hero h1 { font-family: 'Fraunces', serif; font-size: clamp(1.4rem,4vw,2rem); color: #fff; margin-bottom: 6px; }
        .bk-hero p { color: rgba(255,255,255,.8); font-size: .88rem; }
        .bk-hero-actions { display: flex; gap: 10px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 20px; border-radius: 99px; font-size: .82rem; font-weight: 700;
            text-decoration: none; transition: var(--t); cursor: pointer; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-hero-primary { background: #fff; color: var(--teal-dark); box-shadow: 0 4px 16px rgba(0,0,0,.15); }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.2); }
        .btn-hero-outline { background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.4); color: #fff; }
        .btn-hero-outline:hover { background: rgba(255,255,255,.25); }

        /* ── Main wrap ── */
        .bk-outer { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* ── GCash Banner ── */
        .gcash-banner {
            background: linear-gradient(135deg, #fffbeb, #fef3c7);
            border: 1.5px solid #fcd34d; border-radius: var(--r-lg);
            padding: 20px 22px; margin: 24px 0;
            display: flex; align-items: flex-start; gap: 16px;
        }
        .gcash-icon { font-size: 2rem; flex-shrink: 0; }
        .gcash-title { font-weight: 800; font-size: 1rem; color: #92400e; margin-bottom: 4px; }
        .gcash-sub   { font-size: .8rem; color: #a16207; margin-bottom: 12px; }
        .gcash-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .gcash-item .g-label { font-size: .7rem; color: #92400e; opacity: .75; text-transform: uppercase; letter-spacing: .4px; }
        .gcash-item .g-value { font-weight: 800; font-size: .95rem; color: #78350f; margin-top: 2px; font-family: 'Courier New', monospace; }

        /* ── Section header ── */
        .section-hdr { display: flex; align-items: center; justify-content: space-between; margin: 28px 0 16px; gap: 12px; }
        .section-hdr-title { font-weight: 700; font-size: 1rem; color: var(--text-1); }
        .section-hdr-count { font-size: .78rem; color: var(--text-3); }

        /* ── Booking Card (card-based instead of table) ── */
        .booking-card {
            background: #fff; border-radius: var(--r-lg); border: 1.5px solid #e5f6f4;
            margin-bottom: 14px; overflow: hidden; box-shadow: var(--sh-card);
            transition: box-shadow var(--t);
        }
        .booking-card:hover { box-shadow: var(--sh-md); }

        .bc-main { display: grid; grid-template-columns: auto 1fr; gap: 0; }
        .bc-accent { width: 5px; flex-shrink: 0; }
        .bc-accent.status-pending   { background: #f59e0b; }
        .bc-accent.status-confirmed { background: #10b981; }
        .bc-accent.status-declined  { background: #f43f5e; }
        .bc-accent.status-completed { background: #6366f1; }

        .bc-body { padding: 18px 20px; display: flex; flex-direction: column; gap: 10px; }
        .bc-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex-wrap: wrap; }
        .bc-dest { font-weight: 800; font-size: .95rem; color: var(--text-1); }
        .bc-loc  { font-size: .78rem; color: var(--text-3); margin-top: 2px; }
        .bc-badges { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }

        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 99px; font-size: .7rem; font-weight: 700;
            border: 1.5px solid transparent; white-space: nowrap;
        }
        .badge-open    { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
        .badge-pending { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
        .badge-confirmed { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
        .badge-declined  { background: #fef2f2; color: #991b1b; border-color: #fca5a5; }
        .badge-completed { background: #eef2ff; color: #3730a3; border-color: #a5b4fc; }
        .badge-pay-pending { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
        .badge-pay-approved { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
        .badge-pay-rejected { background: #fef2f2; color: #991b1b; border-color: #fca5a5; }
        .badge-pay-none { background: #f9fafb; color: #6b7280; border-color: #e5e7eb; }

        .bc-meta { display: flex; flex-wrap: wrap; gap: 16px; font-size: .8rem; color: var(--text-3); }
        .bc-meta span { display: flex; align-items: center; gap: 5px; }
        .bc-meta strong { color: var(--text-2); font-weight: 600; }

        /* Tourist info row (staff view) */
        .bc-tourist { display: flex; align-items: center; gap: 10px; padding: 10px 20px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
        .bc-tourist-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--teal), var(--ocean)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: .78rem; flex-shrink: 0; }
        .bc-tourist-name { font-weight: 700; font-size: .85rem; color: var(--text-1); }
        .bc-tourist-email { font-size: .72rem; color: var(--text-4); }

        /* Action footer */
        .bc-actions { padding: 12px 20px; background: #fafffe; border-top: 1px solid #f0fdfc; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .bc-action-btn {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 14px; border-radius: 99px; font-size: .77rem; font-weight: 700;
            border: 1.5px solid; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif; text-decoration: none;
        }
        .btn-pay { background: linear-gradient(135deg,var(--teal),var(--ocean)); color: #fff; border-color: transparent; box-shadow: 0 3px 12px rgba(13,148,136,.3); }
        .btn-pay:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(13,148,136,.4); }
        .btn-ticket { background: #eef2ff; color: #3730a3; border-color: #c7d2fe; }
        .btn-ticket:hover { background: #e0e7ff; }
        .btn-review { background: #fffbeb; color: #92400e; border-color: #fcd34d; }
        .btn-review:hover { background: #fef3c7; }
        .btn-approve { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; }
        .btn-approve:hover { background: #d1fae5; }
        .btn-reject  { background: #fef2f2; color: #991b1b; border-color: #fca5a5; }
        .btn-reject:hover  { background: #fee2e2; }

        /* Payment Panel (expandable) */
        .payment-panel {
            padding: 20px; background: #f8fafc;
            border-top: 1px solid #e5f6f4; animation: slideDown .2s ease;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .pp-title { font-weight: 700; font-size: .85rem; color: var(--text-1); margin-bottom: 14px; display: flex; align-items: center; gap: 6px; }
        .pp-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; max-width: 600px; }
        @media (max-width: 560px) { .pp-form-grid { grid-template-columns: 1fr; } }
        .pp-label { display: block; font-size: .72rem; font-weight: 700; color: var(--text-2); margin-bottom: 4px; }
        .pp-input {
            width: 100%; border: 1.5px solid #d1d5db; border-radius: var(--r-md);
            padding: 10px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem; color: var(--text-2); outline: none;
            transition: border-color var(--t), box-shadow var(--t);
        }
        .pp-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,148,136,.1); }
        .btn-submit-payment {
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; border: none; padding: 10px 22px; border-radius: 99px;
            font-size: .82rem; font-weight: 800; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif; margin-top: 14px;
        }
        .btn-submit-payment:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(13,148,136,.35); }

        /* Staff verification panel */
        .verify-panel { padding: 20px; background: #fffbeb; border-top: 1.5px solid #fcd34d; animation: slideDown .2s ease; }
        .vp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; max-width: 560px; margin-bottom: 14px; font-size: .82rem; }
        .vp-label { color: var(--text-4); font-size: .7rem; text-transform: uppercase; letter-spacing: .4px; }
        .vp-value { font-weight: 700; color: var(--text-1); font-family: 'Courier New', monospace; word-break: break-all; }
        .vp-img-wrap { margin-top: 10px; }
        .vp-screenshot { max-height: 160px; object-fit: contain; border-radius: var(--r-md); border: 1px solid #e5e7eb; }
        .vp-actions { display: flex; gap: 10px; margin-top: 16px; flex-wrap: wrap; }
        .btn-approve-big {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 24px;
            background: #059669; color: #fff; font-weight: 800; font-size: .88rem;
            border: none; border-radius: 12px; cursor: pointer; transition: var(--t);
            box-shadow: 0 4px 14px rgba(5,150,105,.3); font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-approve-big:hover { background: #047857; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(5,150,105,.4); }
        .btn-reject-big {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 24px;
            background: #fff; color: #991b1b; font-weight: 800; font-size: .88rem;
            border: 2px solid #fca5a5; border-radius: 12px; cursor: pointer; transition: var(--t);
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-reject-big:hover { background: #fef2f2; }
        .reject-form { background: #fff; border: 1.5px solid #fca5a5; border-radius: var(--r-md); padding: 14px; margin-top: 12px; }
        .reject-textarea { width: 100%; border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 8px 12px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: .82rem; outline: none; resize: vertical; }
        .reject-textarea:focus { border-color: #f43f5e; box-shadow: 0 0 0 2px rgba(244,63,94,.1); }
        .btn-reject-submit { background: #dc2626; color: #fff; border: none; padding: 7px 18px; border-radius: 8px; font-size: .8rem; font-weight: 700; cursor: pointer; margin-top: 8px; font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Rejection reason box for tourist */
        .rejection-reason-box { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: var(--r-md); padding: 12px 14px; font-size: .8rem; color: #991b1b; }
        .rejection-reason-box .rr-title { font-weight: 700; margin-bottom: 4px; }

        /* Empty state */
        .empty-state { text-align: center; padding: 60px 24px; }
        .empty-illus { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg,#ccfbf1,#bae6fd); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .empty-title { font-family: 'Fraunces', serif; font-size: 1.4rem; color: var(--text-1); margin-bottom: 8px; }
        .empty-desc  { color: var(--text-3); font-size: .88rem; max-width: 340px; margin: 0 auto 20px; }
        .btn-explore { background: linear-gradient(135deg,var(--teal),var(--ocean)); color: #fff; border: none; padding: 10px 24px; border-radius: 99px; font-size: .88rem; font-weight: 700; text-decoration: none; display: inline-block; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 4px 16px rgba(13,148,136,.3); }
        .btn-explore:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.4); }

        /* Flash messages */
        .flash { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: var(--r-md); font-size: .88rem; font-weight: 600; margin-bottom: 16px; }
        .flash-success { background: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; }
        .flash-error   { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }

        @media (max-width: 640px) {
            .bc-main { grid-template-columns: auto 1fr; }
            .bk-hero { padding: 28px 16px 40px; }
            .bk-outer { padding: 0 14px; }
        }
    </style>

    <div id="bookings-page">
        {{-- Hero --}}
        <div class="bk-hero">
            <div class="bk-hero-inner">
                <div class="bk-hero-tag">
                    @if(auth()->user()->isStaff()) 🗂️ Staff Management @else 🎒 Tourist Portal @endif
                </div>
                <h1>
                    @if(auth()->user()->isStaff()) Booking & Payment Management @else My Bookings @endif
                </h1>
                <p>
                    @if(auth()->user()->isStaff())
                        Review GCash payment submissions, approve or reject with one click, and manage visitor bookings.
                    @else
                        Track your reservations, submit payment proof, and access your QR entry tickets.
                    @endif
                </p>
                <div class="bk-hero-actions">
                    @if(auth()->user()->isTourist())
                        <a href="{{ route('destinations.index') }}" class="btn-hero btn-hero-primary">🗺️ Find Destinations</a>
                        <a href="{{ route('bookings.my-tickets') }}" class="btn-hero btn-hero-outline">🎟️ My Tickets</a>
                    @endif
                    @if(auth()->user()->isStaff())
                        <a href="{{ route('checkins.create') }}" class="btn-hero btn-hero-primary">📷 Camera Check-In Scanner</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="bk-outer">
            {{-- Flash messages --}}
            @if(session('success'))
                <div class="flash flash-success" style="margin-top:20px;">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash flash-error" style="margin-top:20px;">⚠️ {{ session('error') }}</div>
            @endif

            {{-- GCash Banner (tourist only, only when they have pending unsubmitted bookings) --}}
            @if(auth()->user()->isTourist() && $bookings->whereNull('payment_status')->where('status','pending')->count() > 0)
                <div class="gcash-banner" style="margin-top:20px;">
                    <div class="gcash-icon">💳</div>
                    <div style="flex:1;">
                        <div class="gcash-title">GCash Payment Required</div>
                        <div class="gcash-sub">Send your entrance fee via GCash and submit your transaction reference below to confirm your slot.</div>
                        <div class="gcash-grid">
                            <div class="gcash-item">
                                <div class="g-label">Account Name</div>
                                <div class="g-value" style="font-family:inherit;font-size:.88rem;">E-TURISMO PAYMENTS</div>
                            </div>
                            <div class="gcash-item">
                                <div class="g-label">GCash Number</div>
                                <div class="g-value">0917-555-1234</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Section header --}}
            <div class="section-hdr">
                <div>
                    <div class="section-hdr-title">
                        @if(auth()->user()->isStaff()) All Bookings at Your Destination @else Your Booking Requests @endif
                    </div>
                    <div class="section-hdr-count">{{ $bookings->count() }} booking{{ $bookings->count() !== 1 ? 's' : '' }}</div>
                </div>
            </div>

            @if($bookings->isEmpty())
                <div class="empty-state">
                    <div class="empty-illus">📋</div>
                    <div class="empty-title">No Bookings Yet</div>
                    <p class="empty-desc">
                        @if(auth()->user()->isTourist())
                            You haven't submitted any booking requests. Explore our destinations and plan your visit!
                        @else
                            No bookings have been submitted to your assigned destination yet.
                        @endif
                    </p>
                    @if(auth()->user()->isTourist())
                        <a href="{{ route('destinations.index') }}" class="btn-explore">🗺️ Explore Destinations</a>
                    @endif
                </div>
            @else
                @foreach($bookings as $booking)
                @php
                    $accentCls = 'status-' . $booking->status;
                    $payStatus = $booking->payment_status;
                @endphp
                <div class="booking-card">
                    {{-- Staff: Tourist info header --}}
                    @if(auth()->user()->isStaff())
                    <div class="bc-tourist">
                        <div class="bc-tourist-avatar">{{ strtoupper(substr($booking->tourist?->name ?? '?', 0, 1)) }}</div>
                        <div>
                            <div class="bc-tourist-name">{{ $booking->tourist?->name }}</div>
                            <div class="bc-tourist-email">{{ $booking->tourist?->email }}</div>
                        </div>
                        @if($payStatus === 'pending_verification')
                            <span class="badge badge-pending" style="margin-left:auto;">⏳ Awaiting Your Review</span>
                        @endif
                    </div>
                    @endif

                    <div class="bc-main">
                        <div class="bc-accent {{ $accentCls }}"></div>
                        <div class="bc-body">
                            <div class="bc-top">
                                <div>
                                    <div class="bc-dest">{{ $booking->destination?->name }}</div>
                                    <div class="bc-loc">📍 {{ $booking->destination?->location }}</div>
                                </div>
                                <div class="bc-badges">
                                    {{-- Booking status badge --}}
                                    <span class="badge badge-{{ $booking->status }}">
                                        @switch($booking->status)
                                            @case('pending') ⏳ Pending @break
                                            @case('confirmed') ✅ Confirmed @break
                                            @case('declined') ❌ Declined @break
                                            @case('completed') 🎉 Completed @break
                                            @default {{ ucfirst($booking->status) }}
                                        @endswitch
                                    </span>
                                    {{-- Payment status badge --}}
                                    @if($payStatus === 'pending_verification')
                                        <span class="badge badge-pay-pending">💳 Verifying Payment</span>
                                    @elseif($payStatus === 'approved')
                                        <span class="badge badge-pay-approved">💰 Payment Approved</span>
                                    @elseif($payStatus === 'rejected')
                                        <span class="badge badge-pay-rejected">🚫 Payment Rejected</span>
                                    @elseif(empty($payStatus) && $booking->status === 'pending')
                                        <span class="badge badge-pay-none">No Payment Submitted</span>
                                    @endif
                                </div>
                            </div>

                            <div class="bc-meta">
                                <span>📅 <strong>{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}</strong></span>
                                @if($booking->gcash_reference_number)
                                    <span>💳 Ref: <strong style="font-family:monospace;">{{ $booking->gcash_reference_number }}</strong></span>
                                @endif
                                @if($booking->payment_submitted_at)
                                    <span>🕐 Submitted {{ \Carbon\Carbon::parse($booking->payment_submitted_at)->diffForHumans() }}</span>
                                @endif
                                @if($booking->checked_in_at)
                                    <span>✅ Checked in {{ \Carbon\Carbon::parse($booking->checked_in_at)->format('M j h:i A') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action bar --}}
                    <div class="bc-actions">
                        {{-- QR ticket link --}}
                        @if($booking->qr_token && $booking->ticket)
                            <a href="{{ route('tickets.show', $booking->ticket) }}" class="bc-action-btn btn-ticket">🎟️ View QR Ticket</a>
                        @endif

                        {{-- Tourist actions --}}
                        @if(auth()->user()->isTourist())
                            @if(empty($payStatus) && $booking->status === 'pending')
                                <button type="button"
                                    onclick="togglePanel('pay-{{ $booking->id }}')"
                                    class="bc-action-btn btn-pay">
                                    💸 Submit GCash Payment Proof
                                </button>
                            @elseif($payStatus === 'rejected')
                                {{-- Show rejection reason inline --}}
                                <div class="rejection-reason-box" style="width:100%;">
                                    <div class="rr-title">❌ Payment Rejected by Staff</div>
                                    <div>{{ $booking->rejection_reason }}</div>
                                </div>
                            @elseif($payStatus === 'pending_verification')
                                <span style="font-size:.8rem;color:var(--text-3);font-style:italic;">⏳ Awaiting staff review…</span>
                            @endif
                        @endif

                        {{-- Staff actions --}}
                        @if(auth()->user()->isStaff())
                            @if($payStatus === 'pending_verification')
                                <button type="button"
                                    onclick="togglePanel('verify-{{ $booking->id }}')"
                                    class="bc-action-btn btn-review">
                                    🔍 Review Payment
                                </button>
                            @endif
                        @endif

                        @if(!$booking->qr_token && empty($payStatus) && $booking->status === 'pending' && auth()->user()->isTourist())
                            {{-- nothing extra --}}
                        @endif
                    </div>

                    {{-- Tourist: Payment submission panel --}}
                    @if(auth()->user()->isTourist() && empty($payStatus) && $booking->status === 'pending')
                    <div id="pay-{{ $booking->id }}" class="payment-panel" style="display:none;">
                        <div class="pp-title">
                            💳 Submit GCash Payment Proof
                            <button type="button" onclick="togglePanel('pay-{{ $booking->id }}')" style="margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text-4);font-size:1.2rem;">✕</button>
                        </div>
                        <form action="{{ route('bookings.submit-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="pp-form-grid">
                                <div>
                                    <label class="pp-label" for="gcash_ref_{{ $booking->id }}">GCash Reference / Transaction # <span style="color:#f43f5e;">*</span></label>
                                    <input type="text" name="gcash_reference_number" id="gcash_ref_{{ $booking->id }}" required
                                        placeholder="e.g. 9012345678"
                                        class="pp-input" autocomplete="off">
                                </div>
                                <div>
                                    <label class="pp-label" for="screenshot_{{ $booking->id }}">Receipt Screenshot (optional)</label>
                                    <input type="file" name="payment_screenshot" id="screenshot_{{ $booking->id }}" accept="image/*"
                                        style="width:100%;font-size:.8rem;color:var(--text-3);">
                                </div>
                            </div>
                            <button type="submit" class="btn-submit-payment">📤 Submit Payment Proof</button>
                        </form>
                    </div>
                    @endif

                    {{-- Staff: Verification panel --}}
                    @if(auth()->user()->isStaff() && $payStatus === 'pending_verification')
                    <div id="verify-{{ $booking->id }}" class="verify-panel" style="display:none;">
                        <div class="pp-title">
                            🔍 GCash Payment Verification
                            <button type="button" onclick="togglePanel('verify-{{ $booking->id }}')" style="margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text-4);font-size:1.2rem;">✕</button>
                        </div>
                        <div class="vp-grid">
                            <div>
                                <div class="vp-label">GCash Reference No.</div>
                                <div class="vp-value">{{ $booking->gcash_reference_number }}</div>
                            </div>
                            <div>
                                <div class="vp-label">Submitted At</div>
                                <div class="vp-value" style="font-family:inherit;font-size:.82rem;">{{ $booking->payment_submitted_at ? \Carbon\Carbon::parse($booking->payment_submitted_at)->format('M j, Y g:i A') : 'N/A' }}</div>
                            </div>
                            <div>
                                <div class="vp-label">Tourist</div>
                                <div class="vp-value" style="font-family:inherit;">{{ $booking->tourist?->name }}</div>
                            </div>
                            <div>
                                <div class="vp-label">Visit Date</div>
                                <div class="vp-value" style="font-family:inherit;">{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}</div>
                            </div>
                        </div>

                        @if($booking->payment_screenshot_path)
                        <div class="vp-img-wrap">
                            <div class="vp-label" style="margin-bottom:6px;">Receipt Screenshot:</div>
                            <a href="{{ Storage::url($booking->payment_screenshot_path) }}" target="_blank" style="display:inline-block;">
                                <img src="{{ Storage::url($booking->payment_screenshot_path) }}" alt="GCash Receipt" class="vp-screenshot">
                            </a>
                        </div>
                        @else
                            <p style="font-size:.78rem;color:var(--text-4);font-style:italic;margin-top:8px;">No screenshot uploaded.</p>
                        @endif

                        <div class="vp-actions">
                            <form action="{{ route('bookings.approve-payment', $booking) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit" class="btn-approve-big">✅ Approve Booking</button>
                            </form>
                            <button type="button" onclick="togglePanel('reject-{{ $booking->id }}')" class="btn-reject-big">❌ Reject Payment</button>
                        </div>

                        <div id="reject-{{ $booking->id }}" class="reject-form" style="display:none;">
                            <form action="{{ route('bookings.reject-payment', $booking) }}" method="POST">
                                @csrf
                                <label style="font-size:.8rem;font-weight:700;color:#991b1b;display:block;margin-bottom:6px;">Rejection Reason <span style="color:#f43f5e;">*</span></label>
                                <textarea name="rejection_reason" rows="2" required
                                    placeholder="e.g. GCash reference doesn't match system records…"
                                    class="reject-textarea"></textarea>
                                <button type="submit" class="btn-reject-submit">Submit Rejection</button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                @endforeach
            @endif
        </div>
    </div>

    <script>
    function togglePanel(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const isHidden = el.style.display === 'none' || !el.style.display;
        el.style.display = isHidden ? 'block' : 'none';
    }
    </script>
</x-app-layout>
