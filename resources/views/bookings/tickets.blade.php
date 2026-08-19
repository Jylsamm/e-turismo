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
                <i class="ti ti-ticket text-green-700"></i>
                My Tickets
            </h2>
        </div>
    </x-slot>

>>>>>>> Stashed changes
    <style>

        :root {
            --teal: #0d9488; --teal-light: #14b8a6; --ocean: #0891b2; --purple: #7c3aed;
            --bg: #f0fdfc; --t: 0.22s cubic-bezier(0.4,0,0.2,1);
        }
<<<<<<< Updated upstream
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
=======
        #tickets-page * { box-sizing: border-box; }
>>>>>>> Stashed changes

        /* Ticket card */
        .ticket-card {
            background: #fff; border-radius: 24px; overflow: hidden;
            box-shadow: 0 4px 24px rgba(13,148,136,.12), 0 1px 4px rgba(0,0,0,.06);
            display: flex; flex-direction: column; transition: transform var(--t), box-shadow var(--t);
            border: 1.5px solid #e5f6f4;
        }
        .ticket-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(13,148,136,.18); }

        .tc-header {
            background: linear-gradient(135deg, #166534, #16a34a);
            padding: 22px 24px; color: #fff;
        }
        .tc-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
            padding: 5px 14px; border-radius: 99px; font-size: .82rem;
            font-weight: 800; text-transform: uppercase; letter-spacing: .5px; margin-bottom: 12px;
        }
        .tc-dest  { font-size: 1.45rem; font-weight: 800; margin-bottom: 6px; line-height: 1.25; }
        .tc-loc   { font-size: .95rem; color: rgba(255,255,255,.9); font-weight: 500; }

        /* QR section */
        .tc-qr-wrap {
            padding: 24px 20px; display: flex; flex-direction: column; align-items: center; gap: 12px;
            background: #f9fffe; border-bottom: 1.5px dashed #ccfbf1;
        }
        .tc-qr-frame {
            background: #fff; border: 2px solid #ccfbf1; border-radius: 18px;
            padding: 14px; box-shadow: 0 2px 12px rgba(13,148,136,.1);
        }
        .tc-qr-frame img { display: block; width: 160px; height: 160px; object-fit: contain; }
        .tc-qr-frame svg { display: block; } /* fallback for inline QR */
        .tc-qr-code { font-family: 'Courier New', monospace; font-size: .95rem; font-weight: 800; color: #374151; text-align: center; word-break: break-all; max-width: 240px; }

        /* Status chip */
        .tc-status { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 99px; font-size: .85rem; font-weight: 800; }
        .tc-status-active { background: #ecfdf5; color: #065f46; border: 1.5px solid #6ee7b7; }
        .tc-status-used   { background: #eef2ff; color: #3730a3; border: 1.5px solid #a5b4fc; }

        /* Info grid */
        .tc-info { padding: 20px 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .tc-info-item .ti-label { font-size: .78rem; text-transform: uppercase; letter-spacing: .5px; color: #64748b; margin-bottom: 3px; font-weight: 700; }
        .tc-info-item .ti-value { font-size: 1.05rem; font-weight: 800; color: #0f172a; }

        /* Actions */
        .tc-actions { padding: 18px 24px; background: #f9fffe; border-top: 1px solid #ccfbf1; display: flex; gap: 10px; }
        .tc-btn {
            flex: 1; text-align: center; padding: 12px 16px; border-radius: 14px;
            font-size: .95rem; font-weight: 800; text-decoration: none; transition: var(--t); cursor: pointer; border: none;
        }
        .tc-btn-view { background: #f0fdfc; color: #0d9488; border: 1.5px solid #99f6e4; }
        .tc-btn-view:hover { background: #ccfbf1; }
        .tc-btn-dl { background: linear-gradient(135deg, #166534, #16a34a); color: #fff; box-shadow: 0 3px 12px rgba(22,163,74,.25); }
        .tc-btn-dl:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(22,163,74,.35); }

<<<<<<< Updated upstream
        /* Empty */
        .empty-wrap { text-align: center; padding: 60px 24px; }
        .empty-illus {
            width: 110px; height: 110px; border-radius: 50%;
            background: linear-gradient(135deg, #ccfbf1, #bae6fd);
            display: flex; align-items: center; justify-content: center; font-size: 3.2rem;
            margin: 0 auto 24px; animation: float 3s ease-in-out infinite;
=======
        /* Redesigned Empty State */
        .empty-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, 0.6);
            border-radius: 24px;
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
            color: #134e4a;
            margin-bottom: 12px;
        }

        .empty-desc-premium {
            color: #6b7280;
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
            background: linear-gradient(135deg, #16a34a, #22c55e);
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
            color: #6b7280;
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
            color: #16a34a;
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
=======

            <!-- Quick QR Modal -->
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
                <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="showModal = false"></div>
                <div class="bg-white rounded-3xl w-full max-w-sm p-6 relative shadow-2xl" @click.away="showModal = false">
                    <div class="text-center">
                        <div class="text-sm text-gray-400 font-bold uppercase tracking-wider mb-1" x-text="modalDest"></div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6" x-text="modalLoc"></h2>
                        <div id="modal-qr-container" class="flex justify-center mb-6"></div>
                        <p class="text-sm font-mono text-gray-500 mb-8" x-text="modalToken"></p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <a :href="modalUrl" class="w-full text-center py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition">View Full Details</a>
                        <button @click="showModal = false" class="w-full text-center py-3 text-gray-500 font-bold hover:text-gray-800">Close</button>
                    </div>
                </div>
            </div>

            <!-- Simple Reminder Card -->
            <div class="mt-8 bg-amber-50/90 border border-amber-200/90 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-3 text-amber-900 font-bold text-base sm:text-lg">
                    <i class="ti ti-alert-triangle-filled text-amber-600 text-xl"></i>
                    <span>Entrance & QR Scanning Reminders</span>
                </div>
                <ul class="space-y-2.5 text-sm sm:text-base text-amber-800/95 font-medium leading-relaxed">
                    <li class="flex items-start gap-2.5">
                        <span class="text-amber-600 font-bold text-lg leading-none">•</span>
                        <span><strong>Save for Offline Access:</strong> Download or screenshot your QR ticket to your phone gallery so you can access it at the gate even with low signal.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-amber-600 font-bold text-lg leading-none">•</span>
                        <span><strong>Gate Verification:</strong> Present your QR code to destination staff at the entrance checkpoint for scanning.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="text-amber-600 font-bold text-lg leading-none">•</span>
                        <span><strong>Scheduled Visit:</strong> Valid for single entry on your confirmed visit date.</span>
                    </li>
                </ul>
            </div>
>>>>>>> Stashed changes
            
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
