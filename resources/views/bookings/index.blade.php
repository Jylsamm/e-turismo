<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
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

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

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
        #bookings-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        /* ── Main wrap ── */
        .bk-outer { max-width: 1100px; margin: 0 auto; padding: 0 20px; }

        /* ── GCash Toast ── */
        .gcash-toast {
            position: fixed;
            bottom: 24px; right: 24px;   /* desktop: bottom-right */
            z-index: 99999;
            width: 320px; max-width: calc(100vw - 48px);
            background: #fffbeb;
            border: 1.5px solid #fcd34d;
            border-radius: 16px;
            padding: 18px 18px 16px;
            box-shadow: 0 8px 32px rgba(120,53,15,.18), 0 2px 8px rgba(0,0,0,.08);
            display: flex; align-items: flex-start; gap: 14px;
        }
        /* mobile: top-center */
        @media (max-width: 640px) {
            .gcash-toast {
                bottom: auto; right: auto;
                top: 16px;
                left: 16px; right: 16px;
                width: auto; max-width: 100%;
                border-radius: 14px;
            }
        }
        .gcash-toast-icon { font-size: 1.6rem; flex-shrink: 0; margin-top: 1px; }
        .gcash-toast-body { flex: 1; min-width: 0; }
        .gcash-title { font-weight: 800; font-size: .92rem; color: #92400e; margin-bottom: 3px; }
        .gcash-sub   { font-size: .75rem; color: #a16207; margin-bottom: 10px; line-height: 1.5; }
        .gcash-grid  { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .gcash-item { background: #fef3c7; border-radius: 8px; padding: 6px 10px; }
        .gcash-item .g-label { font-size: .65rem; color: #92400e; opacity: .75; text-transform: uppercase; letter-spacing: .4px; }
        .gcash-item .g-value { font-weight: 800; font-size: .82rem; color: #78350f; margin-top: 2px; font-family: 'Courier New', monospace; }
        .gcash-toast-close {
            flex-shrink: 0; background: none; border: none; cursor: pointer;
            color: #b45309; opacity: .6; padding: 2px; border-radius: 6px;
            transition: opacity .2s, background .2s; line-height: 1;
        }
        .gcash-toast-close:hover { opacity: 1; background: #fde68a; }

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
        .booking-card:not(.interactive-card):hover { box-shadow: var(--sh-md); }

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
        .badge-cancelled { background: #f3f4f6; color: #4b5563; border-color: #d1d5db; }
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
        .btn-cancel {
            background: linear-gradient(135deg, #be123c 0%, #9f1239 100%);
            color: #fff;
            border: 1.5px solid #9f1239;
            box-shadow: 0 3px 10px rgba(159, 18, 57, 0.32);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-cancel:hover {
            background: linear-gradient(135deg, #9f1239 0%, #881337 100%);
            color: #fff;
            border-color: #881337;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(159, 18, 57, 0.45);
        }
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
            font-family: 'Fraunces', serif;
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

        /* Flash messages */
        .flash { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: var(--r-md); font-size: .88rem; font-weight: 600; margin-bottom: 16px; }
        .flash-success { background: #ecfdf5; border: 1.5px solid #6ee7b7; color: #065f46; }
        .flash-error   { background: #fef2f2; border: 1.5px solid #fca5a5; color: #991b1b; }

        .custom-modal-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .custom-modal-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-modal-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }
        .custom-modal-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media (max-width: 640px) {
            .bc-main { grid-template-columns: auto 1fr; }
            .bk-hero { padding: 28px 16px 40px; }
            .bk-outer { padding: 0 14px; }
        }
    </style>

    <div class="pb-12 pt-0" id="bookings-page" x-data="bookingPortal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            {{-- GCash Toast (tourist only, only when they have pending unsubmitted bookings) --}}
            @if(auth()->user()->isTourist() && $bookings->whereNull('payment_status')->where('status','pending')->count() > 0)
                <div class="gcash-toast"
                     x-data="{ visible: true }"
                     x-show="visible"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     style="display:none;">
                    <div class="gcash-toast-icon"><i class="ti ti-credit-card text-amber-700"></i></div>
                    <div class="gcash-toast-body">
                        <div class="gcash-title">GCash Payment Required</div>
                        <div class="gcash-sub">Send your entrance fee via GCash and submit your transaction reference below to confirm your slot.</div>
                        <div class="gcash-grid">
                            <div class="gcash-item">
                                <div class="g-label">Account Name</div>
                                <div class="g-value" style="font-family:inherit;">E-TURISMO PAYMENTS</div>
                            </div>
                            <div class="gcash-item">
                                <div class="g-label">GCash Number</div>
                                <div class="g-value">0917-555-1234</div>
                            </div>
                        </div>
                    </div>
                    <button class="gcash-toast-close" @click="visible = false" aria-label="Dismiss">
                        <i class="ti ti-x text-base"></i>
                    </button>
                </div>
            @endif



            @if($bookings->isEmpty())
                <div class="empty-card">
                    <div class="empty-glow-wrap">
                        <div class="empty-glow"></div>
                        <div class="empty-illus-premium">
                            <i class="ti ti-clipboard-x text-emerald-700"></i>
                        </div>
                    </div>
                    <h3 class="empty-title-premium">No Bookings Yet</h3>
                    <p class="empty-desc-premium">
                        @if(auth()->user()->isTourist())
                            You haven't submitted any booking requests. Explore our destinations and plan your visit!
                        @else
                            No bookings have been submitted to your assigned destination yet.
                        @endif
                    </p>
                    <div class="empty-actions">
                        @if(auth()->user()->isTourist())
                            <a href="{{ route('destinations.index') }}" class="btn-explore-premium" onclick="showExploreLoading(event, this)">
                                <i class="ti ti-compass text-lg"></i>
                                <span>Explore Destinations</span>
                            </a>
                        @else
                            <button onclick="window.location.reload()" class="btn-explore-premium">
                                <i class="ti ti-refresh text-lg"></i>
                                <span>Refresh Page</span>
                            </button>
                        @endif
                        <a href="#" class="btn-secondary-action" onclick="event.preventDefault(); window.location.reload();">
                            <i class="ti ti-refresh"></i> Check again
                        </a>
                    </div>
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
                            <span class="badge badge-pending" style="margin-left:auto;"><i class="ti ti-clock"></i> Awaiting Your Review</span>
                        @endif
                    </div>
                    @endif

                    <div class="bc-main">
                        <div class="bc-accent {{ $accentCls }}"></div>
                        <div class="bc-body">
                            <div class="bc-top">
                                <div>
                                    <div class="bc-dest">{{ $booking->destination?->name }}</div>
                                    <div class="bc-loc"><i class="ti ti-map-pin text-teal-600"></i> {{ $booking->destination?->location }}</div>
                                </div>
                                <div class="bc-badges">
                                    {{-- Booking status badge --}}
                                    <span class="badge badge-{{ $booking->status }}">
                                        @switch($booking->status)
                                            @case('pending') <i class="ti ti-clock"></i> Pending @break
                                            @case('confirmed') <i class="ti ti-circle-check"></i> Confirmed @break
                                            @case('declined') <i class="ti ti-circle-x"></i> Declined @break
                                            @case('cancelled') <i class="ti ti-ban"></i> Cancelled @break
                                            @case('completed') <i class="ti ti-confetti"></i> Completed @break
                                            @default {{ ucfirst($booking->status) }}
                                        @endswitch
                                    </span>
                                    {{-- Payment status badge --}}
                                    @if(in_array($booking->status, ['declined', 'cancelled']))
                                        @if(in_array($payStatus, ['refund_pending', 'pending_verification', 'approved']))
                                            <span class="badge badge-pay-rejected"><i class="ti ti-rotate-clockwise-2"></i> Refund Pending</span>
                                        @else
                                            <span class="badge badge-pay-none"><i class="ti ti-info-circle"></i> No Charge</span>
                                        @endif
                                    @else
                                        @if($payStatus === 'pending_verification')
                                            <span class="badge badge-pay-pending"><i class="ti ti-credit-card"></i> Verifying Payment</span>
                                        @elseif($payStatus === 'approved')
                                            <span class="badge badge-pay-approved"><i class="ti ti-circle-check"></i> Payment Approved</span>
                                        @elseif($payStatus === 'rejected')
                                            <span class="badge badge-pay-rejected"><i class="ti ti-circle-x"></i> Payment Rejected</span>
                                        @elseif($payStatus === 'refund_pending')
                                            <span class="badge badge-pay-rejected"><i class="ti ti-rotate-clockwise-2"></i> Refund Pending</span>
                                        @elseif($payStatus === 'not_charged')
                                            <span class="badge badge-pay-none"><i class="ti ti-info-circle"></i> No Charge</span>
                                        @elseif(empty($payStatus) && $booking->status === 'pending')
                                            <span class="badge badge-pay-none"><i class="ti ti-info-circle"></i> No Payment Submitted</span>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="bc-meta">
                                <span><i class="ti ti-calendar text-teal-600"></i> <strong>{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}</strong></span>
                                @if($booking->gcash_reference_number)
                                    <span><i class="ti ti-receipt-2 text-teal-600"></i> Ref: <strong style="font-family:monospace;">{{ $booking->gcash_reference_number }}</strong></span>
                                @endif
                                @if($booking->payment_submitted_at)
                                    <span><i class="ti ti-clock text-teal-600"></i> Submitted {{ \Carbon\Carbon::parse($booking->payment_submitted_at)->diffForHumans() }}</span>
                                @endif
                                @if($booking->checked_in_at)
                                    <span><i class="ti ti-circle-check text-emerald-600"></i> Checked in {{ \Carbon\Carbon::parse($booking->checked_in_at)->format('M j h:i A') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action bar --}}
                    <div class="bc-actions">
                        {{-- QR ticket link --}}
                        @php
                            $qrCodeToken = $booking->ticket?->qr_code ?? $booking->qr_token;
                            $ticketId = $booking->ticket?->id ?? $booking->id;
                        @endphp
                        @if($qrCodeToken && !in_array($booking->status, ['declined', 'cancelled']) && $booking->payment_status !== 'rejected')
                            <div id="qr-svg-{{ $qrCodeToken }}" class="hidden">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qrCodeToken) !!}
                            </div>
                            <button type="button" @click="openQrModal('{{ $qrCodeToken }}', '{{ e($booking->destination?->name) }}', '{{ e($booking->destination?->location) }}', '{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}', '{{ e($booking->tourist?->name ?? auth()->user()->name) }}', '{{ url('/tickets/' . $ticketId) }}')"
                                class="bc-action-btn btn-ticket cursor-pointer">
                                <i class="ti ti-qrcode text-base"></i> View QR Ticket
                            </button>
                        @endif

                        {{-- Tourist actions --}}
                        @if(auth()->user()->isTourist())
                            <button type="button" @click="viewDetails({{ $booking->id }})" class="bc-action-btn btn-ticket">
                                <i class="ti ti-search text-base"></i> View Details
                            </button>
                            @if($booking->status === 'declined')
                                <div class="rejection-reason-box" style="width:100%; margin-bottom: 0.5rem;">
                                    <div class="rr-title"><i class="ti ti-circle-x"></i> Booking Declined</div>
                                    <div>{{ $booking->decline_reason ?: ($booking->rejection_reason ?: 'No reason provided.') }}</div>
                                </div>
                                <span style="font-size:.8rem;color:var(--text-3);font-style:italic;display:block;width:100%;">
                                    <i class="ti ti-info-circle"></i>
                                    @if(in_array($payStatus, ['refund_pending', 'pending_verification', 'approved']))
                                        Refund pending
                                    @elseif($payStatus === 'refunded')
                                        Refund initiated
                                    @else
                                        No charge was made
                                    @endif
                                </span>
                            @elseif($booking->status === 'cancelled')
                                <span style="font-size:.8rem;color:var(--text-4);font-style:italic;">
                                    <i class="ti ti-ban text-gray-400"></i> Reservation Cancelled
                                </span>
                            @elseif(empty($payStatus) && $booking->status === 'pending')
                                <button type="button"
                                    onclick="togglePanel('pay-{{ $booking->id }}')"
                                    class="bc-action-btn btn-pay">
                                    <i class="ti ti-upload text-base"></i> Submit GCash Payment Proof
                                </button>
                            @elseif($payStatus === 'rejected')
                                {{-- Show rejection reason inline --}}
                                <div class="rejection-reason-box" style="width:100%;">
                                    <div class="rr-title"><i class="ti ti-circle-x"></i> Payment Rejected by Staff</div>
                                    <div>{{ $booking->rejection_reason }}</div>
                                </div>
                            @elseif($payStatus === 'pending_verification')
                                <span style="font-size:.8rem;color:var(--text-3);font-style:italic;"><i class="ti ti-clock"></i> Awaiting staff review…</span>
                            @endif

                            @if(in_array($booking->status, ['pending', 'confirmed']) && !$booking->checked_in_at && !now()->startOfDay()->isAfter(\Carbon\Carbon::parse($booking->visit_date)))
                                <button type="button"
                                    @click="openCancelModal({{ $booking->id }}, '{{ e($booking->destination?->name) }}', '{{ date('M j, Y', strtotime($booking->visit_date)) }}', '{{ route('bookings.cancel', $booking) }}')"
                                    class="bc-action-btn btn-cancel">
                                    <i class="ti ti-ban text-base"></i> Cancel Reservation
                                </button>
                            @endif
                        @endif

                        {{-- Staff actions --}}
                        @if(auth()->user()->isStaff())
                            @if($payStatus === 'pending_verification')
                                <button type="button"
                                    onclick="togglePanel('verify-{{ $booking->id }}')"
                                    class="bc-action-btn btn-review">
                                    <i class="ti ti-search text-base"></i> Review Payment
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
                            <i class="ti ti-credit-card text-teal-600 text-lg"></i> Submit GCash Payment Proof
                            <button type="button" onclick="togglePanel('pay-{{ $booking->id }}')" aria-label="Close" style="margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text-4);font-size:1.2rem;">✕</button>
                        </div>
                        <form action="{{ route('bookings.submit-payment', $booking) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="pp-form-grid">
                                <div>
                                    <label class="pp-label" for="gcash_ref_{{ $booking->id }}">GCash Reference / Transaction # <span style="color:#f43f5e;">*</span></label>
                                    <input type="text" name="gcash_reference_number" id="gcash_ref_{{ $booking->id }}" required
                                        inputmode="numeric"
                                        pattern="[0-9]+"
                                        maxlength="50"
                                        oninput="this.value = this.value.replace(/\D/g, '')"
                                        title="GCash reference number must strictly contain digits (0-9) only."
                                        placeholder="e.g. 9012345678"
                                        class="pp-input" autocomplete="off">
                                </div>
                                <div>
                                    <label class="pp-label" for="screenshot_{{ $booking->id }}">Receipt Screenshot <span style="color:#f43f5e;">*</span></label>
                                    <input type="file" name="payment_screenshot" id="screenshot_{{ $booking->id }}" accept="image/*" required
                                        oninvalid="this.setCustomValidity('Payment receipt is required to submit your booking.')"
                                        oninput="this.setCustomValidity('')"
                                        style="width:100%;font-size:.8rem;color:var(--text-3);">
                                    @error('payment_screenshot')
                                        <span style="font-size: 0.75rem; color: #f43f5e; display: block; margin-top: 0.25rem;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn-submit-payment"><i class="ti ti-send text-base mr-1"></i> Submit Payment Proof</button>
                        </form>
                    </div>
                    @endif

                    {{-- Staff: Verification panel --}}
                    @if(auth()->user()->isStaff() && $payStatus === 'pending_verification')
                    <div id="verify-{{ $booking->id }}" class="verify-panel" style="display:none;">
                        <div class="pp-title">
                            <i class="ti ti-shield-check text-amber-700 text-lg"></i> GCash Payment Verification
                            <button type="button" onclick="togglePanel('verify-{{ $booking->id }}')" aria-label="Close" style="margin-left:auto;background:none;border:none;cursor:pointer;color:var(--text-4);font-size:1.2rem;">✕</button>
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
                                <button type="submit" class="btn-approve-big"><i class="ti ti-circle-check text-lg"></i> Approve Booking</button>
                            </form>
                            <button type="button" onclick="togglePanel('reject-{{ $booking->id }}')" class="btn-reject-big"><i class="ti ti-circle-x text-lg"></i> Reject Payment</button>
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

        {{-- Tourist: Booking Details Modal --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-50 flex items-center justify-center p-4 sm:p-6"
             x-show="showDetailsModal"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">
            <div class="bg-white rounded-3xl max-w-md sm:max-w-lg w-full h-full max-h-[550px] flex flex-col shadow-2xl border border-slate-200 overflow-hidden transform transition-all duration-300"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 @click.away="showDetailsModal = false">
                {{-- Modal Header --}}
                <div class="shrink-0 px-6 py-4 flex items-center justify-between relative overflow-hidden rounded-t-3xl border-b border-emerald-900/20" style="background: linear-gradient(135deg, #052e16 0%, #14532d 50%, #047857 100%); color: #ffffff;">
                    <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full pointer-events-none" style="background: rgba(255, 255, 255, 0.1); filter: blur(16px);"></div>
                    <div>
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                            <i class="ti ti-file-invoice text-xs" style="color: #a7f3d0;"></i> Verified Booking Receipt
                        </span>
                        <h3 class="text-lg sm:text-xl font-black tracking-tight mt-1" style="color: #ffffff;">
                            Booking Receipt #<span x-text="details.id" style="color: #a7f3d0;"></span>
                        </h3>
                    </div>
                    <button type="button" @click="showDetailsModal = false" aria-label="Close" class="p-2 rounded-xl transition cursor-pointer" style="background: rgba(255, 255, 255, 0.15); color: #ffffff;">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-5 sm:p-6 space-y-5 text-sm overflow-y-auto flex-1 min-h-0 custom-modal-scroll">
                    {{-- Destination info with gradient bg --}}
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50/40 border border-emerald-100 rounded-2xl p-4 shadow-inner">
                        <div class="text-[10px] font-bold text-emerald-800 uppercase tracking-widest">Selected Spot</div>
                        <h4 class="font-extrabold text-gray-900 text-base mt-1" x-text="details.spot"></h4>
                        <div class="text-xs text-gray-500 mt-1.5 flex items-center gap-1.5 font-medium">
                            <i class="ti ti-map-pin text-emerald-600"></i> <span x-text="details.location"></span>
                        </div>
                    </div>

                    {{-- Schedule details --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-gray-50/80 border border-gray-100 rounded-2xl p-3.5 transition hover:bg-gray-50">
                            <span class="text-gray-400 text-[10px] font-semibold block uppercase tracking-wider">Visit Date</span>
                            <span class="font-extrabold text-gray-800 text-xs sm:text-sm mt-1 block" x-text="details.visit_date"></span>
                        </div>
                        <div class="bg-gray-50/80 border border-gray-100 rounded-2xl p-3.5 transition hover:bg-gray-50">
                            <span class="text-gray-400 text-[10px] font-semibold block uppercase tracking-wider">Status</span>
                            <span class="font-extrabold text-xs sm:text-sm mt-1 inline-flex items-center gap-1.5 capitalize"
                                  :class="details.status === 'confirmed' || details.status === 'completed' ? 'text-emerald-700' : (details.status === 'pending' ? 'text-amber-700' : 'text-rose-700')">
                                <span class="w-2 h-2 rounded-full inline-block" :class="details.status === 'confirmed' || details.status === 'completed' ? 'bg-emerald-500 animate-pulse' : (details.status === 'pending' ? 'bg-amber-500' : 'bg-rose-500')"></span>
                                <span x-text="details.status"></span>
                            </span>
                        </div>
                    </div>

                    {{-- Tourist details --}}
                    <div class="border border-gray-100 rounded-2xl p-4 space-y-3 bg-white shadow-xs">
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ti ti-user-circle text-emerald-600 text-base"></i> Tourist Account Info
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div>
                                <span class="text-gray-400 block font-medium">Name</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm" x-text="details.tourist ? details.tourist.name : 'Unknown'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block font-medium">Email</span>
                                <span class="font-bold text-gray-800 text-xs sm:text-sm break-all" x-text="details.tourist ? details.tourist.email : 'N/A'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Details --}}
                    <div class="border border-gray-100 rounded-2xl p-4 space-y-3 bg-white shadow-xs">
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                            <i class="ti ti-credit-card text-emerald-600 text-base"></i> GCash Payment
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500 font-medium">Status</span>
                            <span class="font-bold px-2.5 py-0.5 rounded-full capitalize text-xs"
                                  :class="details.payment_status === 'approved' ? 'text-emerald-700 bg-emerald-50 border border-emerald-200' : (details.payment_status === 'pending_verification' ? 'text-amber-700 bg-amber-50 border border-amber-200' : (details.payment_status === 'refund_pending' ? 'text-blue-700 bg-blue-50 border border-blue-200' : (details.payment_status === 'not_charged' ? 'text-gray-700 bg-gray-50 border border-gray-200' : 'text-rose-700 bg-rose-50 border border-rose-200')))">
                                <span x-text="details.payment_status ? details.payment_status.replace('_', ' ') : 'unpaid'"></span>
                            </span>
                        </div>
                        <template x-if="details.gcash_reference_number">
                            <div class="flex justify-between items-center text-xs pt-2.5 border-t border-gray-50">
                                <span class="text-gray-500 font-medium">Reference No</span>
                                <span class="font-mono font-bold text-gray-800 text-xs sm:text-sm" x-text="details.gcash_reference_number"></span>
                            </div>
                        </template>

                        {{-- Payment Screenshot --}}
                        <template x-if="details.payment_receipt">
                            <div class="pt-2.5 border-t border-gray-50 flex flex-col items-center">
                                <span class="text-gray-400 text-[11px] block self-start mb-1.5 font-medium">Receipt Screenshot</span>
                                <a :href="details.payment_receipt" target="_blank" class="block w-full max-h-36 overflow-hidden rounded-xl border border-gray-100 bg-gray-50/50 p-2 flex justify-center hover:shadow-md transition duration-300">
                                    <img :src="details.payment_receipt" class="max-h-32 object-contain hover:scale-[1.03] transition duration-300">
                                </a>
                            </div>
                        </template>
                    </div>

                    {{-- Ticket section --}}
                    <template x-if="details.qr_token && details.status !== 'declined' && details.payment_status !== 'rejected'">
                        <div class="border border-emerald-200 bg-emerald-50/20 rounded-2xl p-4 flex flex-col items-center text-center space-y-3">
                            <div class="text-[10px] font-bold text-emerald-800 uppercase tracking-widest">Scannable QR Pass</div>
                            <div class="bg-white border border-emerald-100 rounded-2xl p-3 shadow-md">
                                <img :src="details.qr_ticket" class="w-32 h-32 object-contain" alt="QR Ticket">
                            </div>
                            <div class="text-center">
                                <span class="text-[10px] uppercase text-gray-400 font-bold tracking-wider block">Ticket Token</span>
                                <span class="text-xs font-mono font-bold text-emerald-900 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100 mt-1 inline-block" x-text="details.qr_token"></span>
                            </div>
                        </div>
                    </template>

                    {{-- Rejection / Decline Reasons --}}
                    <template x-if="details.status === 'declined' && details.decline_reason">
                        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-rose-900 shadow-inner">
                            <div class="font-bold text-xs uppercase tracking-wider mb-1.5 flex items-center gap-1.5 text-rose-800">
                                <i class="ti ti-circle-x"></i> Booking Rejection Reason
                            </div>
                            <p class="text-xs font-medium leading-relaxed" x-text="details.decline_reason"></p>
                        </div>
                    </template>
                    <template x-if="details.payment_status === 'rejected' && details.rejection_reason">
                        <div class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-rose-900 shadow-inner">
                            <div class="font-bold text-xs uppercase tracking-wider mb-1.5 flex items-center gap-1.5 text-rose-800">
                                <i class="ti ti-circle-x"></i> Payment Rejection Reason
                            </div>
                            <p class="text-xs font-medium leading-relaxed" x-text="details.rejection_reason"></p>
                        </div>
                    </template>
                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-3.5 border-t border-gray-100 bg-gray-50 flex justify-end shrink-0">
                    <button class="bg-white hover:bg-gray-100 border border-gray-300 text-gray-700 font-bold rounded-xl px-5 py-2 transition text-xs shadow-xs cursor-pointer" @click="showDetailsModal = false">
                        Close Details
                    </button>
                </div>
            </div>
        </div>

        <!-- In-Page Quick QR View & Download Modal -->
        <div x-show="showQrModal" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-900/75 backdrop-blur-md overflow-hidden"
            style="display: none;">
            
            <div @click.away="closeQrModal()" class="relative w-full max-w-md sm:max-w-lg h-full max-h-[550px] flex flex-col bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-200">
                <!-- Modal Header (Pinned top) -->
                <div class="shrink-0 px-5 py-4 flex items-center justify-between relative overflow-hidden rounded-t-3xl border-b border-emerald-900/20" style="background: linear-gradient(135deg, #052e16 0%, #14532d 50%, #047857 100%); color: #ffffff;">
                    <div class="absolute -top-8 -right-8 w-28 h-28 rounded-full pointer-events-none" style="background: rgba(255, 255, 255, 0.1); filter: blur(16px);"></div>
                    <div>
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                            <i class="ti ti-shield-check text-xs" style="color: #a7f3d0;"></i> Digital Entry Pass
                        </span>
                        <h3 class="text-lg sm:text-xl font-black tracking-tight mt-1" style="color: #ffffff;" x-text="qrData.destination"></h3>
                        <p class="text-[11px] flex items-center gap-1 mt-0.5" style="color: #d1fae5;">
                            <i class="ti ti-map-pin" style="color: #6ee7b7;"></i>
                            <span x-text="qrData.location"></span>
                        </p>
                    </div>
                    <button type="button" @click="closeQrModal()" aria-label="Close" class="p-2 rounded-xl transition cursor-pointer" style="background: rgba(255, 255, 255, 0.15); color: #ffffff;">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <!-- Modal Content Body -->
                <div class="overflow-y-auto flex-1 min-h-0 p-5 text-center space-y-4 custom-modal-scroll">
                    <!-- QR Frame Container -->
                    <div id="booking-modal-qr-frame" class="inline-block p-3.5 bg-slate-50 border-2 border-emerald-100 rounded-2xl shadow-inner relative group">
                        <div id="booking-modal-qr-render" class="bg-white p-1.5 rounded-xl"></div>
                    </div>

                    <div>
                        <p class="text-[10px] uppercase text-gray-400 font-extrabold tracking-wider">Pass Reference Code</p>
                        <p class="text-2xl font-mono font-black text-emerald-950 tracking-wider mt-0.5" x-text="qrData.code"></p>
                    </div>

                    <!-- Metadata Grid -->
                    <div class="grid grid-cols-2 gap-2.5 text-left bg-slate-50/80 p-3 rounded-2xl border border-slate-150">
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Visitor</span>
                            <p class="text-xs font-black text-slate-900 truncate mt-0.5" x-text="qrData.visitorName"></p>
                        </div>
                        <div>
                            <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider block">Scheduled Visit</span>
                            <p class="text-xs font-black text-slate-900 mt-0.5" x-text="qrData.visitDate"></p>
                        </div>
                    </div>

                    <!-- Simple Entrance Reminders Box -->
                    <div class="text-left bg-amber-50/90 border border-amber-200/90 rounded-2xl p-3.5 shadow-xs">
                        <div class="flex items-center gap-1.5 mb-1 text-amber-950 font-bold text-xs">
                            <i class="ti ti-alert-triangle-filled text-amber-600 text-sm"></i>
                            <span>Entrance Check-in Reminders</span>
                        </div>
                        <ul class="space-y-1 text-[11px] text-amber-900/90 font-medium leading-relaxed">
                            <li class="flex items-start gap-1.5">
                                <span class="text-amber-600 font-bold">•</span>
                                <span>Present this QR code to staff at the entrance checkpoint.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-amber-600 font-bold">•</span>
                                <span>Download or screenshot this pass for offline gate entry.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Modal Actions Footer (Pinned bottom) -->
                <div class="shrink-0 bg-gray-50 px-5 py-3.5 flex items-center gap-3 border-t border-gray-150">
                    <button type="button" @click="downloadModalFormattedQR()"
                        class="flex-1 inline-flex items-center justify-center gap-1.5 font-bold py-2.5 px-4 rounded-xl text-xs uppercase tracking-wider transition shadow-md cursor-pointer" style="background: linear-gradient(135deg, #059669 0%, #16a34a 100%); color: #ffffff;">
                        <i class="ti ti-download text-sm" style="color: #ffffff;"></i>
                        <span style="color: #ffffff;">Download QR Pass</span>
                    </button>
                    <button type="button" @click="closeQrModal()" class="px-4 py-2.5 bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold text-xs rounded-xl transition cursor-pointer">
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Custom Cancellation Confirmation Modal -->
        <div x-show="showCancelModal" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="fixed inset-0 z-[999999] flex items-center justify-center p-4 sm:p-6 bg-slate-950/75 backdrop-blur-md overflow-hidden"
            style="display: none;">
            
            <div @click.away="closeCancelModal()" class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl overflow-hidden border border-rose-100 flex flex-col">
                <!-- Modal Top Accent Banner -->
                <div class="px-6 pt-6 pb-4 bg-gradient-to-b from-rose-50/80 to-white flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 border border-rose-200 text-rose-600 flex items-center justify-center shrink-0 shadow-xs">
                        <i class="ti ti-alert-triangle text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold uppercase tracking-wider text-rose-700 bg-rose-100/70 border border-rose-200/80 px-2.5 py-0.5 rounded-full mb-1">
                            Booking Cancellation
                        </span>
                        <h3 class="text-lg font-extrabold text-gray-900 tracking-tight">Cancel Reservation</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">
                            Are you sure you want to cancel this booking? This will release your reserved slot and update your reservation status.
                        </p>
                    </div>
                    <button type="button" @click="closeCancelModal()" aria-label="Close" class="text-gray-400 hover:text-gray-600 transition p-1 rounded-lg">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <!-- Booking Details Card -->
                <div class="px-6 py-3">
                    <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-3.5 space-y-2.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Destination</span>
                            <span class="font-bold text-gray-900 truncate max-w-[200px]" x-text="cancelData.destination"></span>
                        </div>
                        <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-200/60">
                            <span class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Scheduled Visit</span>
                            <span class="font-bold text-emerald-800" x-text="cancelData.visitDate"></span>
                        </div>
                        <div class="flex items-center justify-between text-xs pt-2 border-t border-slate-200/60">
                            <span class="text-gray-400 font-semibold uppercase text-[10px] tracking-wider">Reference ID</span>
                            <span class="font-mono font-bold text-gray-700" x-text="'#' + cancelData.id"></span>
                        </div>
                    </div>

                    <div class="mt-3 p-3 rounded-xl bg-amber-50/80 border border-amber-200/70 text-[11px] text-amber-900 flex items-start gap-2">
                        <i class="ti ti-info-circle text-amber-600 text-sm shrink-0 mt-0.5"></i>
                        <span>If payment proof was previously uploaded, your transaction will be marked for staff refund review.</span>
                    </div>
                </div>

                <form :action="cancelData.url" method="POST" class="px-6 pb-6 pt-2 flex items-center gap-3">
                    @csrf
                    <button type="button" @click="closeCancelModal()"
                        class="flex-1 py-3 px-4 rounded-2xl border-2 border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-700 font-bold text-sm transition-all duration-200 cursor-pointer text-center tracking-tight"
                        style="box-shadow: 0 1px 3px rgba(0,0,0,0.04);">
                        Keep Booking
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 px-4 rounded-2xl text-white font-extrabold text-sm tracking-tight cursor-pointer flex items-center justify-center gap-2 transition-all duration-200"
                        style="background: linear-gradient(135deg, #be123c 0%, #9f1239 100%); box-shadow: 0 4px 14px rgba(159,18,57,0.45); border: 1.5px solid #9f1239;"
                        onmouseover="this.style.boxShadow='0 6px 20px rgba(159,18,57,0.55)'; this.style.transform='translateY(-1px)';"
                        onmouseout="this.style.boxShadow='0 4px 14px rgba(159,18,57,0.45)'; this.style.transform='translateY(0)';">
                        <i class="ti ti-ban text-base"></i>
                        <span>Yes, Cancel Booking</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>

    @push('scripts')
    <script>
    function bookingPortal() {
        return {
            showDetailsModal: false,
            showQrModal: false,
            showCancelModal: false,
            details: {},
            cancelData: {
                id: null,
                destination: '',
                visitDate: '',
                url: ''
            },
            qrData: {
                code: '',
                destination: '',
                location: '',
                visitDate: '',
                visitorName: '',
                ticketUrl: ''
            },
            openCancelModal(id, destination, visitDate, url) {
                this.cancelData = { id, destination, visitDate, url };
                this.showCancelModal = true;
            },
            closeCancelModal() {
                this.showCancelModal = false;
            },
            openQrModal(code, destination, location, visitDate, visitorName, ticketUrl = '') {
                this.qrData = { code, destination, location, visitDate, visitorName, ticketUrl };
                
                const sourceSvg = document.querySelector('#qr-svg-' + code);
                const targetRender = document.getElementById('booking-modal-qr-render');
                if (sourceSvg && targetRender) {
                    targetRender.innerHTML = sourceSvg.innerHTML;
                }
                
                this.showQrModal = true;
            },
            closeQrModal() {
                this.showQrModal = false;
            },
            downloadModalFormattedQR() {
                const qrSvg = document.querySelector('#booking-modal-qr-render svg');
                if (!qrSvg) {
                    alert('QR Code image not ready.');
                    return;
                }

                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                canvas.width = 600;
                canvas.height = 800;

                ctx.fillStyle = '#ffffff';
                if (ctx.roundRect) {
                    ctx.roundRect(0, 0, 600, 800, 32);
                } else {
                    ctx.fillRect(0, 0, 600, 800);
                }
                ctx.fill();

                const gradient = ctx.createLinearGradient(0, 0, 600, 160);
                gradient.addColorStop(0, '#14532d');
                gradient.addColorStop(1, '#15803d');
                ctx.fillStyle = gradient;
                ctx.beginPath();
                if (ctx.roundRect) {
                    ctx.roundRect(0, 0, 600, 160, [32, 32, 0, 0]);
                } else {
                    ctx.fillRect(0, 0, 600, 160);
                }
                ctx.fill();

                ctx.fillStyle = '#ffffff';
                ctx.font = 'bold 13px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText('E-TURISMO DIGITAL ENTRANCE PASS', 300, 45);

                ctx.font = 'bold 24px sans-serif';
                ctx.fillText(this.qrData.destination || 'Tourism Destination', 300, 85);

                ctx.font = '13px sans-serif';
                ctx.fillStyle = '#bbf7d0';
                ctx.fillText('Scheduled Visit: ' + (this.qrData.visitDate || ''), 300, 120);

                const svgData = new XMLSerializer().serializeToString(qrSvg);
                const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                const URL = window.URL || window.webkitURL || window;
                const blobURL = URL.createObjectURL(svgBlob);

                const self = this;
                const img = new Image();
                img.onload = function () {
                    ctx.fillStyle = '#f8fafc';
                    ctx.strokeStyle = '#cbd5e1';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    if (ctx.roundRect) {
                        ctx.roundRect(160, 195, 280, 280, 20);
                    } else {
                        ctx.fillRect(160, 195, 280, 280);
                    }
                    ctx.fill();
                    ctx.stroke();

                    ctx.drawImage(img, 190, 225, 220, 220);

                    ctx.fillStyle = '#0f172a';
                    ctx.font = 'bold 20px monospace';
                    ctx.textAlign = 'center';
                    ctx.fillText(self.qrData.code || '', 300, 515);

                    ctx.fillStyle = '#475569';
                    ctx.font = 'bold 12px sans-serif';
                    ctx.fillText('VISITOR: ' + (self.qrData.visitorName || '').toUpperCase(), 300, 545);

                    ctx.strokeStyle = '#cbd5e1';
                    ctx.setLineDash([6, 6]);
                    ctx.beginPath();
                    ctx.moveTo(40, 580);
                    ctx.lineTo(560, 580);
                    ctx.stroke();
                    ctx.setLineDash([]);

                    ctx.fillStyle = '#fffbeb';
                    ctx.strokeStyle = '#fde68a';
                    ctx.lineWidth = 1.5;
                    ctx.beginPath();
                    if (ctx.roundRect) {
                        ctx.roundRect(40, 610, 520, 145, 16);
                    } else {
                        ctx.fillRect(40, 610, 520, 145);
                    }
                    ctx.fill();
                    ctx.stroke();

                    ctx.fillStyle = '#92400e';
                    ctx.font = 'bold 14px sans-serif';
                    ctx.textAlign = 'left';
                    ctx.fillText('📌 ENTRANCE REMINDER', 60, 640);

                    ctx.fillStyle = '#78350f';
                    ctx.font = '12px sans-serif';
                    ctx.fillText('• Present this QR code to destination staff at the entrance checkpoint.', 60, 670);
                    ctx.fillText('• Save this image to your phone gallery for offline entry access.', 60, 695);
                    ctx.fillText('• Valid for single-day entry on your confirmed visit date.', 60, 720);

                    const a = document.createElement('a');
                    a.download = 'E-Ticket-' + (self.qrData.code || 'Pass') + '.png';
                    a.href = canvas.toDataURL('image/png');
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                    if (window.renderEmergencyToast) {
                        window.renderEmergencyToast('dl-pass-bk-modal', '[INFO] E-Ticket Downloaded! Saved to your downloads folder. Please keep it handy for entrance check-in.');
                    } else {
                        alert('E-Ticket downloaded successfully! Save it to your phone gallery for entrance scanning.');
                    }
                };
                img.src = blobURL;
            },
            viewDetails(id) {
                fetch(`{{ url('/bookings') }}/${id}`, {
                    headers: { 
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP error ' + r.status);
                    return r.json();
                })
                .then(data => {
                    this.details = data;
                    this.showDetailsModal = true;
                })
                .catch(err => {
                    console.error('Fetch error:', err);
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
    function showExploreLoading(event, btn) {
        event.preventDefault();
        const icon = btn.querySelector('i');
        const text = btn.querySelector('span');
        if (icon) {
            icon.className = 'ti ti-loader-3 animate-spin text-lg';
        }
        if (text) {
            text.textContent = 'Redirecting...';
        }
        btn.style.opacity = '0.8';
        btn.style.pointerEvents = 'none';
        setTimeout(() => {
            window.location.href = btn.getAttribute('href');
        }, 800);
    }
    </script>
    @endpush
</x-app-layout>
