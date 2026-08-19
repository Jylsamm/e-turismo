<x-app-layout>
<<<<<<< Updated upstream
=======
    @push('head')
        <style>
            .admin-card-hover {
                transition: all 0.3s ease-in-out !important;
            }
            .admin-card-hover:hover {
                transform: translateY(-4px) !important;
                box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1) !important;
                border-color: #bbf7d0 !important;
            }
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-calendar text-green-700"></i>
                @if(auth()->user()->isStaff()) Booking Management @else My Bookings @endif
            </h2>
        </div>
    </x-slot>

>>>>>>> Stashed changes
    <style>

        :root {
            --teal:       #16a34a; --teal-light: #4ade80; --teal-dark: #166534;
            --ocean:      #22c55e; --emerald: #10b981; --rose: #f43f5e;
            --amber:      #f59e0b; --indigo: #0b3d2e; --purple: #8b5cf6;
            --bg:         #f0fdf4; --border: #dcfce7;
            --text-1:     #0B3D2E; --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t:          0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card:    0 2px 12px rgba(0,0,0,.07);
            --sh-md:      0 4px 24px rgba(22,197,94,.14);
            --r-md: 14px; --r-lg: 20px; --r-xl: 28px;
        }
<<<<<<< Updated upstream
        #bookings-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        #bookings-page { background: var(--bg); min-height: 100vh; padding-bottom: 64px; }

        /* ── Hero ── */
        .bk-hero {
            background: linear-gradient(135deg, #0B3D2E 0%, #166534 40%, #16a34a 70%, #4ADE80 100%);
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
=======
        #bookings-page * { box-sizing: border-box; }
>>>>>>> Stashed changes

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
        .section-hdr { display: flex; align-items: center; justify-content: space-between; margin: 32px 0 18px; gap: 14px; }
        .section-hdr-title { font-weight: 800; font-size: 1.35rem; color: var(--text-1); }
        .section-hdr-count { font-size: .95rem; color: var(--text-3); font-weight: 600; }

        /* ── Booking Card (card-based instead of table) ── */
        .booking-card {
            background: #fff; border-radius: var(--r-lg); border: 1.5px solid #e5f6f4;
            margin-bottom: 18px; overflow: hidden; box-shadow: var(--sh-card);
            transition: box-shadow var(--t);
        }
        .booking-card:not(.interactive-card):hover { box-shadow: var(--sh-md); }

        .bc-main { display: grid; grid-template-columns: auto 1fr; gap: 0; }
        .bc-accent { width: 6px; flex-shrink: 0; }
        .bc-accent.status-pending   { background: #f59e0b; }
        .bc-accent.status-confirmed { background: #10b981; }
        .bc-accent.status-declined  { background: #f43f5e; }
        .bc-accent.status-completed { background: #6366f1; }

        .bc-body { padding: 22px 24px; display: flex; flex-direction: column; gap: 12px; }
        .bc-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 14px; flex-wrap: wrap; }
        .bc-dest { font-weight: 800; font-size: 1.35rem; color: var(--text-1); }
        .bc-loc  { font-size: .95rem; color: var(--text-3); margin-top: 4px; line-height: 1.5; }
        .bc-badges { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }

        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 12px; border-radius: 99px; font-size: .85rem; font-weight: 700;
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

        .bc-meta { display: flex; flex-wrap: wrap; gap: 20px; font-size: .95rem; color: var(--text-3); font-weight: 500; }
        .bc-meta span { display: flex; align-items: center; gap: 6px; }
        .bc-meta strong { color: var(--text-2); font-weight: 700; }

        /* Tourist info row (staff view) */
        .bc-tourist { display: flex; align-items: center; gap: 12px; padding: 12px 24px; background: #f8fafc; border-bottom: 1px solid #f1f5f9; }
        .bc-tourist-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--teal), var(--ocean)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: .92rem; flex-shrink: 0; }
        .bc-tourist-name { font-weight: 800; font-size: .98rem; color: var(--text-1); }
        .bc-tourist-email { font-size: .85rem; color: var(--text-4); }

        /* Action footer */
        .bc-actions { padding: 16px 24px; background: #fafffe; border-top: 1px solid #f0fdfc; display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .bc-action-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 9px 18px; border-radius: 12px; font-size: .92rem; font-weight: 700;
            border: 1.5px solid; cursor: pointer; transition: var(--t);
            text-decoration: none;
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
            padding: 24px; background: #f8fafc;
            border-top: 1px solid #e5f6f4; animation: slideDown .2s ease;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
        .pp-title { font-weight: 800; font-size: 1.05rem; color: var(--text-1); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .pp-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 650px; }
        @media (max-width: 560px) { .pp-form-grid { grid-template-columns: 1fr; } }
        .pp-label { display: block; font-size: .88rem; font-weight: 700; color: var(--text-2); margin-bottom: 6px; }
        .pp-input {
            width: 100%; border: 1.5px solid #d1d5db; border-radius: var(--r-md);
            padding: 12px 16px;
            font-size: .98rem; color: var(--text-2); outline: none;
            transition: border-color var(--t), box-shadow var(--t);
        }
        .pp-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,148,136,.1); }
        .btn-submit-payment {
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; border: none; padding: 12px 26px; border-radius: 99px;
            font-size: .95rem; font-weight: 800; cursor: pointer; transition: var(--t);
            margin-top: 16px;
        }
        .btn-submit-payment:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(13,148,136,.35); }

        /* Staff verification panel */
        .verify-panel { padding: 24px; background: #fffbeb; border-top: 1.5px solid #fcd34d; animation: slideDown .2s ease; }
        .vp-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; max-width: 600px; margin-bottom: 16px; font-size: .95rem; }
        .vp-label { color: var(--text-4); font-size: .78rem; text-transform: uppercase; letter-spacing: .5px; }
        .vp-value { font-weight: 800; color: var(--text-1); font-family: 'Courier New', monospace; word-break: break-all; }
        .vp-img-wrap { margin-top: 12px; }
        .vp-screenshot { max-height: 180px; object-fit: contain; border-radius: var(--r-md); border: 1px solid #e5e7eb; }
        .vp-actions { display: flex; gap: 12px; margin-top: 18px; flex-wrap: wrap; }
        .btn-approve-big {
            display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px;
            background: #059669; color: #fff; font-weight: 800; font-size: .98rem;
            border: none; border-radius: 14px; cursor: pointer; transition: var(--t);
            box-shadow: 0 4px 14px rgba(5,150,105,.3);
        }
        .btn-approve-big:hover { background: #047857; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(5,150,105,.4); }
        .btn-reject-big {
            display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px;
            background: #fff; color: #991b1b; font-weight: 800; font-size: .98rem;
            border: 2px solid #fca5a5; border-radius: 14px; cursor: pointer; transition: var(--t);
        }
        .btn-reject-big:hover { background: #fef2f2; }
        .reject-form { background: #fff; border: 1.5px solid #fca5a5; border-radius: var(--r-md); padding: 16px; margin-top: 14px; }
        .reject-textarea { width: 100%; border: 1.5px solid #e5e7eb; border-radius: 10px; padding: 10px 14px; font-size: .92rem; outline: none; resize: vertical; }
        .reject-textarea:focus { border-color: #f43f5e; box-shadow: 0 0 0 2px rgba(244,63,94,.1); }
        .btn-reject-submit { background: #dc2626; color: #fff; border: none; padding: 9px 22px; border-radius: 10px; font-size: .88rem; font-weight: 700; cursor: pointer; margin-top: 10px; }

        /* Rejection reason box for tourist */
        .rejection-reason-box { background: #fef2f2; border: 1.5px solid #fca5a5; border-radius: var(--r-md); padding: 12px 14px; font-size: .8rem; color: #991b1b; }
        .rejection-reason-box .rr-title { font-weight: 700; margin-bottom: 4px; }

<<<<<<< Updated upstream
        /* Empty state */
        .empty-state { text-align: center; padding: 60px 24px; }
        .empty-illus { width: 90px; height: 90px; border-radius: 50%; background: linear-gradient(135deg,#ccfbf1,#bae6fd); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 20px; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .empty-title { font-family: 'Fraunces', serif; font-size: 1.4rem; color: var(--text-1); margin-bottom: 8px; }
        .empty-desc  { color: var(--text-3); font-size: .88rem; max-width: 340px; margin: 0 auto 20px; }
        .btn-explore { background: linear-gradient(135deg,var(--teal),var(--ocean)); color: #fff; border: none; padding: 10px 24px; border-radius: 99px; font-size: .88rem; font-weight: 700; text-decoration: none; display: inline-block; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif; box-shadow: 0 4px 16px rgba(13,148,136,.3); }
        .btn-explore:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.4); }
=======
        /* Redesigned Empty State */
        .empty-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            border-radius: var(--r-xl);
            padding: 56px 40px;
            box-shadow: 0 20px 40px rgba(22, 163, 74, 0.03), 0 1px 3px rgba(0, 0, 0, 0.01);
            max-width: 520px;
            margin: 40px auto;
            text-align: center;
            opacity: 0;
            transform: translateY(20px);
            animation: emptyFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes emptyFadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-glow-wrap {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 28px;
        }

        .empty-glow {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(74, 222, 128, 0.35) 0%, rgba(22, 163, 74, 0) 70%);
            animation: emptyPulse 2.5s ease-in-out infinite;
        }

        @keyframes emptyPulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 0.9; }
        }

        .empty-illus-premium {
            position: absolute;
            top: 10px; left: 10px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid rgba(22, 163, 74, 0.15);
            display: flex; align-items: center; justify-content: center;
            font-size: 2.2rem;
            color: #16a34a;
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.06);
            animation: emptyFloat 3s ease-in-out infinite;
        }

        @keyframes emptyFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        .empty-title-premium {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-1);
            margin-bottom: 12px;
        }

        .empty-desc-premium {
            color: var(--text-3);
            font-size: 0.9rem;
            line-height: 1.6;
            max-width: 380px;
            margin: 0 auto 32px;
        }

        .empty-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .btn-explore-premium {
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff;
            border: none;
            padding: 12px 32px;
            border-radius: 99px;
            font-size: 0.88rem;
            font-weight: 800;
            letter-spacing: 0.2px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.3);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-explore-premium:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 8px 20px rgba(22, 163, 74, 0.4);
        }

        .btn-explore-premium:active {
            transform: translateY(0) scale(0.98);
        }

        .btn-secondary-action {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-3);
            background: none;
            border: none;
            cursor: pointer;
            transition: color var(--t);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-secondary-action:hover {
            color: var(--teal);
        }
>>>>>>> Stashed changes

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

    <div id="bookings-page" x-data="bookingPortal()">
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
                <div class="booking-card {{ auth()->user()->isStaff() ? 'interactive-card' : '' }}">
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
                            <button type="button" @click="viewDetails({{ $booking->id }})" class="bc-action-btn btn-ticket">
                                🔍 View Details
                            </button>
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
                
                <div style="margin-top: 24px;">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>

        {{-- Tourist: Booking Details Modal --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
             x-show="showDetailsModal"
             x-transition
             style="display: none;">
            <div class="bg-white border border-gray-200 rounded-2xl max-w-lg w-full max-h-[90vh] flex flex-col shadow-xl"
                 @click.away="showDetailsModal = false">
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-gray-150 flex items-center justify-between shrink-0">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <i class="ti ti-file-invoice text-green-700"></i> Booking Details #<span x-text="details.id"></span>
                    </h3>
                    <button class="text-gray-400 hover:text-gray-600 transition" @click="showDetailsModal = false">
                        <i class="ti ti-x" style="font-size:20px;"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 space-y-5 text-sm overflow-y-auto flex-1 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    {{-- Destination info with gradient bg --}}
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-xl p-4">
                        <div class="text-xs font-semibold text-green-700 uppercase tracking-wide">Destination</div>
                        <h4 class="font-bold text-gray-800 text-base mt-0.5" x-text="details.spot"></h4>
                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <i class="ti ti-map-pin"></i> <span x-text="details.location"></span>
                        </div>
                    </div>

                    {{-- Schedule details --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 border border-gray-150 rounded-xl p-3.5">
                            <span class="text-gray-400 text-xs block">Visit Date</span>
                            <span class="font-bold text-gray-800 text-sm mt-0.5 block" x-text="details.visit_date"></span>
                        </div>
                        <div class="bg-gray-50 border border-gray-150 rounded-xl p-3.5">
                            <span class="text-gray-400 text-xs block">Status</span>
                            <span class="font-bold text-sm mt-0.5 inline-flex items-center gap-1 capitalize"
                                  :class="details.status === 'confirmed' || details.status === 'completed' ? 'text-green-700' : (details.status === 'pending' ? 'text-amber-700' : 'text-red-700')">
                                <span class="w-2 h-2 rounded-full inline-block" :class="details.status === 'confirmed' || details.status === 'completed' ? 'bg-green-500 animate-pulse' : (details.status === 'pending' ? 'bg-amber-500' : 'bg-red-500')"></span>
                                <span x-text="details.status"></span>
                            </span>
                        </div>
                    </div>

                    {{-- Payment Details --}}
                    <div class="border border-gray-150 rounded-xl p-4 space-y-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">GCash Payment Status</div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500">Payment Status:</span>
                            <span class="font-bold px-2 py-0.5 rounded-full capitalize"
                                  :class="details.payment_status === 'approved' ? 'text-green-700 bg-green-50 border border-green-200' : (details.payment_status === 'pending_verification' ? 'text-amber-700 bg-amber-50 border border-amber-200' : 'text-red-700 bg-red-50 border border-red-200')">
                                <span x-text="details.payment_status ? details.payment_status.replace('_', ' ') : 'unpaid'"></span>
                            </span>
                        </div>
                        <template x-if="details.gcash_reference_number">
                            <div class="flex justify-between items-center text-xs pt-1 border-t border-gray-100">
                                <span class="text-gray-500">Reference No:</span>
                                <span class="font-mono font-bold text-gray-800 text-sm" x-text="details.gcash_reference_number"></span>
                            </div>
                        </template>

                        {{-- Payment Screenshot --}}
                        <template x-if="details.payment_receipt">
                            <div class="pt-3 border-t border-gray-100 flex flex-col items-center">
                                <span class="text-gray-400 text-xs block self-start mb-2">Receipt Screenshot:</span>
                                <a :href="details.payment_receipt" target="_blank" class="block w-full max-h-48 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 p-2 flex justify-center">
                                    <img :src="details.payment_receipt" class="max-h-40 object-contain hover:scale-105 transition duration-300">
                                </a>
                            </div>
                        </template>
                    </div>

                    {{-- Ticket section --}}
                    <template x-if="details.qr_token">
                        <div class="border border-green-200 bg-green-50/30 rounded-xl p-4 flex flex-col items-center text-center space-y-3">
                            <div class="text-xs font-semibold text-green-700 uppercase tracking-wide">Scannable QR Ticket</div>
                            <div class="bg-white border border-green-100 rounded-2xl p-3 shadow-inner">
                                <img :src="'/storage/qr-tickets/' + details.id + '.svg'" class="w-36 h-36 object-contain" alt="QR Ticket">
                            </div>
                            <div class="text-center">
                                <span class="text-xs uppercase text-gray-400 font-semibold tracking-wider block">Ticket Token</span>
                                <span class="text-sm font-mono font-bold text-green-800" x-text="details.qr_token"></span>
                            </div>
                        </div>
                    </template>

                    {{-- Rejection / Decline Reasons --}}
                    <template x-if="details.status === 'declined' && details.decline_reason">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-800">
                            <div class="font-bold text-xs uppercase tracking-wide mb-1">Decline Reason</div>
                            <p class="text-xs" x-text="details.decline_reason"></p>
                        </div>
                    </template>
                    <template x-if="details.payment_status === 'rejected' && details.rejection_reason">
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-red-800">
                            <div class="font-bold text-xs uppercase tracking-wide mb-1">Payment Rejection Reason</div>
                            <p class="text-xs" x-text="details.rejection_reason"></p>
                        </div>
                    </template>
                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 border-t border-gray-150 bg-gray-50 flex justify-end shrink-0">
                    <button class="bg-gray-250 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl px-5 py-2.5 transition text-sm" @click="showDetailsModal = false">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function bookingPortal() {
        return {
            showDetailsModal: false,
            details: {},
            viewDetails(id) {
                fetch(`/bookings/${id}`, {
                    headers: { 'Accept': 'application/json' }
                })
                .then(r => r.json())
                .then(data => {
                    this.details = data;
                    this.showDetailsModal = true;
                });
            }
        }
    }
    function togglePanel(id) {
        const el = document.getElementById(id);
        if (!el) return;
        const isHidden = el.style.display === 'none' || !el.style.display;
        el.style.display = isHidden ? 'block' : 'none';
    }
    </script>
    @endpush
</x-app-layout>
