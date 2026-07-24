<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --teal-light: #14b8a6; --ocean: #0891b2; --purple: #7c3aed;
            --bg: #f0fdfc; --t: 0.22s cubic-bezier(0.4,0,0.2,1);
        }
        #tickets-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        #tickets-page { background: var(--bg); min-height: 100vh; padding-bottom: 64px; }

        /* Hero */
        .tk-hero {
            background: linear-gradient(135deg, #0b3d2e 0%, #166534 50%, #16a34a 100%);
            padding: 40px 24px 72px; text-align: center; position: relative; overflow: hidden;
        }
        .tk-hero::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 70% 40%, rgba(255,255,255,.07) 0%, transparent 60%);
        }
        .tk-hero-inner { position: relative; z-index: 1; }
        .tk-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.3);
            color: rgba(255,255,255,.95); padding: 5px 16px; border-radius: 99px;
            font-size: .72rem; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; margin-bottom: 16px;
        }
        .tk-hero h1 { font-family: 'Fraunces', serif; font-size: clamp(1.7rem,4vw,2.4rem); color: #fff; margin-bottom: 8px; }
        .tk-hero p  { color: rgba(255,255,255,.8); font-size: .9rem; max-width: 440px; margin: 0 auto; }

        /* Stats strip */
        .tk-stats {
            display: flex; gap: 12px; justify-content: center; margin-top: 24px; flex-wrap: wrap;
        }
        .tk-stat {
            background: rgba(255,255,255,.18); border: 1px solid rgba(255,255,255,.25);
            border-radius: 12px; padding: 10px 20px; text-align: center; color: #fff;
        }
        .tk-stat-n { font-family: 'Fraunces', serif; font-size: 1.5rem; font-weight: 600; display: block; }
        .tk-stat-l { font-size: .7rem; opacity: .85; text-transform: uppercase; letter-spacing: .4px; }

        /* Wave divider */
        .tk-wave { margin-top: -2px; line-height: 0; }
        .tk-wave svg { display: block; width: 100%; }

        /* Grid */
        .tk-outer { max-width: 1100px; margin: -36px auto 0; padding: 0 20px; position: relative; z-index: 2; }
        .tk-grid  { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

        /* Ticket card */
        .ticket-card {
            background: #fff; border-radius: 24px; overflow: hidden;
            box-shadow: 0 4px 24px rgba(13,148,136,.12), 0 1px 4px rgba(0,0,0,.06);
            display: flex; flex-direction: column; transition: transform var(--t), box-shadow var(--t);
        }
        .ticket-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(13,148,136,.18); }

        .tc-header {
            background: linear-gradient(135deg, #166534, #16a34a);
            padding: 20px; color: #fff;
        }
        .tc-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
            padding: 3px 12px; border-radius: 99px; font-size: .68rem;
            font-weight: 700; text-transform: uppercase; letter-spacing: .4px; margin-bottom: 12px;
        }
        .tc-dest  { font-size: 1.15rem; font-weight: 800; margin-bottom: 4px; }
        .tc-loc   { font-size: .78rem; color: rgba(255,255,255,.75); }

        /* QR section */
        .tc-qr-wrap {
            padding: 20px; display: flex; flex-direction: column; align-items: center; gap: 10px;
            background: #f9fffe; border-bottom: 1.5px dashed #ccfbf1;
        }
        .tc-qr-frame {
            background: #fff; border: 2px solid #ccfbf1; border-radius: 16px;
            padding: 12px; box-shadow: 0 2px 12px rgba(13,148,136,.1);
        }
        .tc-qr-frame img { display: block; width: 160px; height: 160px; object-fit: contain; }
        .tc-qr-frame svg { display: block; } /* fallback for inline QR */
        .tc-qr-code { font-family: 'Courier New', monospace; font-size: .7rem; color: #6b7280; text-align: center; word-break: break-all; max-width: 200px; }

        /* Status chip */
        .tc-status { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 99px; font-size: .72rem; font-weight: 700; }
        .tc-status-active { background: #ecfdf5; color: #065f46; border: 1.5px solid #6ee7b7; }
        .tc-status-used   { background: #eef2ff; color: #3730a3; border: 1.5px solid #a5b4fc; }

        /* Info grid */
        .tc-info { padding: 16px 20px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .tc-info-item .ti-label { font-size: .68rem; text-transform: uppercase; letter-spacing: .4px; color: #9ca3af; margin-bottom: 2px; }
        .tc-info-item .ti-value { font-size: .88rem; font-weight: 700; color: #134e4a; }

        /* Actions */
        .tc-actions { padding: 14px 20px; background: #f9fffe; border-top: 1px solid #ccfbf1; display: flex; gap: 8px; }
        .tc-btn {
            flex: 1; text-align: center; padding: 9px 12px; border-radius: 12px;
            font-size: .78rem; font-weight: 800; text-decoration: none; transition: var(--t); cursor: pointer; border: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .tc-btn-view { background: #f0fdfc; color: #0d9488; border: 1.5px solid #99f6e4; }
        .tc-btn-view:hover { background: #ccfbf1; }
        .tc-btn-dl { background: linear-gradient(135deg, #166534, #16a34a); color: #fff; box-shadow: 0 3px 12px rgba(22,163,74,.25); }
        .tc-btn-dl:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(22,163,74,.35); }

        /* Empty */
        .empty-wrap { text-align: center; padding: 60px 24px; }
        .empty-illus {
            width: 110px; height: 110px; border-radius: 50%;
            background: linear-gradient(135deg, #ccfbf1, #bae6fd);
            display: flex; align-items: center; justify-content: center; font-size: 3.2rem;
            margin: 0 auto 24px; animation: float 3s ease-in-out infinite;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .empty-title { font-family: 'Fraunces', serif; font-size: 1.6rem; color: #134e4a; margin-bottom: 10px; }
        .empty-desc  { color: #6b7280; font-size: .9rem; max-width: 380px; margin: 0 auto 24px; }
        .btn-explore { background: linear-gradient(135deg,#7c3aed,#0d9488); color: #fff; border: none; padding: 11px 28px; border-radius: 99px; font-size: .9rem; font-weight: 800; text-decoration: none; display: inline-block; transition: var(--t); box-shadow: 0 4px 16px rgba(13,148,136,.3); font-family: 'Plus Jakarta Sans', sans-serif; }
        .btn-explore:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.4); }

        @media (max-width: 640px) {
            .tk-outer { padding: 0 12px; }
            .tk-grid  { grid-template-columns: 1fr; }
            .tc-info  { grid-template-columns: 1fr; }
        }
    </style>

    <div id="tickets-page">
        <div class="tk-hero">
            <div class="tk-hero-inner">
                <div class="tk-tag">🎟️ E-Turismo Pass</div>
                <h1>My QR Tickets</h1>
                <p>Your confirmed entry passes. Show the QR code to staff upon arrival for instant check-in.</p>
                @if($bookings->isNotEmpty())
                <div class="tk-stats">
                    <div class="tk-stat">
                        <span class="tk-stat-n">{{ $bookings->count() }}</span>
                        <span class="tk-stat-l">Active Pass{{ $bookings->count() !== 1 ? 'es' : '' }}</span>
                    </div>
                    <div class="tk-stat">
                        <span class="tk-stat-n">{{ $bookings->where('checked_in_at', null)->count() }}</span>
                        <span class="tk-stat-l">Not Yet Used</span>
                    </div>
                    <div class="tk-stat">
                        <span class="tk-stat-n">{{ $bookings->whereNotNull('checked_in_at')->count() }}</span>
                        <span class="tk-stat-l">Checked In</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="tk-wave">
            <svg viewBox="0 0 1440 54" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,0 C360,54 1080,54 1440,0 L1440,54 L0,54 Z" fill="#f0fdfc"/>
            </svg>
        </div>

        <div class="tk-outer">
            @if($bookings->isEmpty())
            <div class="empty-wrap">
                <div class="empty-illus">🎟️</div>
                <div class="empty-title">No Active Tickets Yet</div>
                <p class="empty-desc">Once your booking and GCash payment are verified by staff, your secure QR entry pass will appear here ready to use.</p>
                <a href="{{ route('destinations.index') }}" class="btn-explore">🗺️ Explore Destinations</a>
            </div>
            @else
            <div class="tk-grid">
                @foreach($bookings as $booking)
                <div class="ticket-card">
                    {{-- Header --}}
                    <div class="tc-header">
                        <div class="tc-badge">✈️ E-Ticket Pass</div>
                        <div class="tc-dest">{{ $booking->destination?->name }}</div>
                        <div class="tc-loc">📍 {{ $booking->destination?->location }}</div>
                    </div>

                    {{-- QR Code --}}
                    <div class="tc-qr-wrap">
                        @if($booking->qr_token)
                            <div class="tc-qr-frame" style="padding:12px;">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(140)->generate($booking->qr_token) !!}
                            </div>
                            <div class="tc-qr-code">{{ $booking->qr_token }}</div>
                        @endif

                        @if($booking->checked_in_at)
                            <span class="tc-status tc-status-used">
                                🎉 Used · {{ \Carbon\Carbon::parse($booking->checked_in_at)->format('M j h:i A') }}
                            </span>
                        @else
                            <span class="tc-status tc-status-active">
                                <span style="width:6px;height:6px;border-radius:50%;background:#10b981;display:inline-block;animation:pulse 1.5s infinite;"></span>
                                Active Pass
                            </span>
                        @endif
                    </div>

                    {{-- Info grid --}}
                    <div class="tc-info">
                        <div class="tc-info-item">
                            <div class="ti-label">Visit Date</div>
                            <div class="ti-value">{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}</div>
                        </div>
                        <div class="tc-info-item">
                            <div class="ti-label">Visitor</div>
                            <div class="ti-value">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="tc-info-item">
                            <div class="ti-label">Booking Ref</div>
                            <div class="ti-value" style="font-family:monospace;">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                        </div>
                        <div class="tc-info-item">
                            <div class="ti-label">Issued On</div>
                            <div class="ti-value">{{ $booking->qr_generated_at ? \Carbon\Carbon::parse($booking->qr_generated_at)->format('M j, Y') : 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="tc-actions">
                        @if($booking->ticket)
                            <a href="{{ route('tickets.show', $booking->ticket) }}" class="tc-btn tc-btn-view">🔍 View & Print</a>
                        @endif
                        @if(file_exists(public_path('storage/qr-tickets/' . $booking->id . '.svg')))
                            <a href="{{ asset('storage/qr-tickets/' . $booking->id . '.svg') }}"
                               download="E-Ticket-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}.svg"
                               class="tc-btn tc-btn-dl">💾 Download QR</a>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="margin-top: 24px;">
                {{ $bookings->links() }}
            </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.6;transform:scale(1.4)} }
    </style>
</x-app-layout>
