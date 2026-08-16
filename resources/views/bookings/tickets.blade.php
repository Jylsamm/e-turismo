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
                <i class="ti ti-ticket text-green-700"></i>
                My Tickets
            </h2>
        </div>
    </x-slot>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --teal-light: #14b8a6; --ocean: #0891b2; --purple: #7c3aed;
            --bg: #f0fdfc; --t: 0.22s cubic-bezier(0.4,0,0.2,1);
        }
        #tickets-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

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
            font-family: 'Fraunces', serif;
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
        }

        @media (max-width: 640px) {
            .tk-outer { padding: 0 12px; }
            .tk-grid  { grid-template-columns: 1fr; }
            .tc-info  { grid-template-columns: 1fr; }
        }
    </style>

    <div class="py-6" id="tickets-page" x-data="myTicketsPortal()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">


            @if($bookings->isEmpty())
            <div class="empty-card">
                <div class="empty-glow-wrap">
                    <div class="empty-glow"></div>
                    <div class="empty-illus-premium">
                        <i class="ti ti-ticket text-green-700"></i>
                    </div>
                </div>
                <h3 class="empty-title-premium">No Active Tickets Yet</h3>
                <p class="empty-desc-premium">Once your booking and GCash payment are verified by staff, your secure QR entry pass will appear here ready to use.</p>
                <div class="empty-actions">
                    <a href="{{ route('destinations.index') }}" class="btn-explore-premium" onclick="showExploreLoading(event, this)">
                        <i class="ti ti-map-2 text-lg"></i>
                        <span>Explore Destinations</span>
                    </a>
                    <a href="#" class="btn-secondary-action" onclick="event.preventDefault(); window.location.reload();">
                        <i class="ti ti-refresh"></i> Check again
                    </a>
                </div>
            </div>
            @else
            <div class="tc-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($bookings as $booking)
                @php
                    $qrCodeToken = $booking->ticket?->qr_code ?? $booking->qr_token;
                    $ticketId = $booking->ticket?->id ?? $booking->id;
                @endphp
                <div class="ticket-card">
                    {{-- Header --}}
                    <div class="tc-header">
                        <div class="tc-badge"><i class="ti ti-plane"></i> E-Ticket Pass</div>
                        <div class="tc-dest">{{ $booking->destination?->name }}</div>
                        <div class="tc-loc"><i class="ti ti-map-pin"></i> {{ $booking->destination?->location }}</div>
                    </div>

                    {{-- QR section --}}
                    <div class="tc-qr-wrap">
                        @if($qrCodeToken && $booking->status !== 'declined' && $booking->payment_status !== 'rejected')
                            <div class="tc-qr-frame" id="ticket-qr-{{ $booking->id }}">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(140)->generate($qrCodeToken) !!}
                            </div>
                            <div class="tc-qr-code">{{ $qrCodeToken }}</div>
                        @endif

                        @if($booking->checked_in_at)
                            <span class="tc-status tc-status-used">
                                Used · {{ date('M j h:i A', strtotime($booking->checked_in_at)) }}
                            </span>
                        @elseif(\Carbon\Carbon::parse($booking->visit_date)->startOfDay()->isPast())
                            <span class="tc-status" style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;font-size:.7rem;font-weight:700;padding:4px 10px;border-radius:99px;display:inline-flex;align-items:center;gap:5px;">
                                <span style="width:6px;height:6px;border-radius:50%;background:#d97706;display:inline-block;"></span>
                                Expired
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
                            <div class="ti-value">{{ date('M j, Y', strtotime($booking->visit_date)) }}</div>
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
                            <div class="ti-value">{{ $booking->qr_generated_at ? date('M j, Y', strtotime($booking->qr_generated_at)) : 'N/A' }}</div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="tc-actions">
                        @if($qrCodeToken && $booking->status !== 'declined' && $booking->payment_status !== 'rejected')
                            <button type="button" @click="openQrModal('{{ $qrCodeToken }}', '{{ e($booking->destination?->name) }}', '{{ e($booking->destination?->location) }}', '{{ date('M j, Y', strtotime($booking->visit_date)) }}', '{{ e(auth()->user()->name) }}', '{{ url('/tickets/' . $ticketId) }}')"
                               class="tc-btn tc-btn-view">🔍 Quick View</button>
                            <button type="button" onclick="downloadFormattedTicketQR('ticket-qr-{{ $booking->id }}', '{{ e($booking->destination?->name) }}', '{{ $qrCodeToken }}', '{{ e(auth()->user()->name) }}', '{{ date('M j, Y', strtotime($booking->visit_date)) }}')"
                               class="tc-btn tc-btn-dl">💾 Download QR</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

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
            <div class="mt-8 bg-amber-50/90 border border-amber-200/90 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center gap-2 mb-2 text-amber-900 font-bold text-sm">
                    <i class="ti ti-alert-triangle-filled text-amber-600 text-lg"></i>
                    <span>Entrance & QR Scanning Reminders</span>
                </div>
                <ul class="space-y-1.5 text-xs text-amber-800/90 font-medium">
                    <li class="flex items-start gap-2">
                        <span class="text-amber-600 font-bold">•</span>
                        <span><strong>Save for Offline Access:</strong> Download or screenshot your QR ticket to your phone gallery so you can access it at the gate even with low signal.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-amber-600 font-bold">•</span>
                        <span><strong>Gate Verification:</strong> Present your QR code to destination staff at the entrance checkpoint for scanning.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-amber-600 font-bold">•</span>
                        <span><strong>Scheduled Visit:</strong> Valid for single entry on your confirmed visit date.</span>
                    </li>
                </ul>
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
    @push('scripts')
    <script>
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

    function downloadFormattedTicketQR(containerId, destName, ticketCode, visitorName, visitDate) {
        const qrSvg = document.querySelector('#' + containerId + ' svg');
        if (!qrSvg) {
            alert('QR Code image not ready.');
            return;
        }

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 600;
        canvas.height = 800;

        // Background
        ctx.fillStyle = '#ffffff';
        if (ctx.roundRect) {
            ctx.roundRect(0, 0, 600, 800, 32);
        } else {
            ctx.fillRect(0, 0, 600, 800);
        }
        ctx.fill();

        // Header Linear Gradient
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

        // Header Text
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 13px sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('E-TURISMO DIGITAL ENTRANCE PASS', 300, 45);

        ctx.font = 'bold 24px sans-serif';
        ctx.fillText(destName || 'Tourism Destination', 300, 85);

        ctx.font = '13px sans-serif';
        ctx.fillStyle = '#bbf7d0';
        ctx.fillText('Scheduled Visit: ' + (visitDate || ''), 300, 120);

        // Convert SVG QR to Image Blob
        const svgData = new XMLSerializer().serializeToString(qrSvg);
        const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
        const URL = window.URL || window.webkitURL || window;
        const blobURL = URL.createObjectURL(svgBlob);

        const img = new Image();
        img.onload = function () {
            // Draw White QR Frame
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

            // Draw QR Image
            ctx.drawImage(img, 190, 225, 220, 220);

            // Ticket Code Text
            ctx.fillStyle = '#0f172a';
            ctx.font = 'bold 20px monospace';
            ctx.textAlign = 'center';
            ctx.fillText(ticketCode || '', 300, 515);

            ctx.fillStyle = '#475569';
            ctx.font = 'bold 12px sans-serif';
            ctx.fillText('VISITOR: ' + (visitorName || '').toUpperCase(), 300, 545);

            // Dashed Divider
            ctx.strokeStyle = '#cbd5e1';
            ctx.setLineDash([6, 6]);
            ctx.beginPath();
            ctx.moveTo(40, 580);
            ctx.lineTo(560, 580);
            ctx.stroke();
            ctx.setLineDash([]);

            // Reminder Box at Bottom
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

            // Trigger Image Download
            const a = document.createElement('a');
            a.download = 'E-Ticket-' + (ticketCode || 'Pass') + '.png';
            a.href = canvas.toDataURL('image/png');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            // Show Toast Alert Notification
            if (window.renderEmergencyToast) {
                window.renderEmergencyToast('dl-pass', '[INFO] E-Ticket Downloaded! Saved to your downloads folder. Please keep it handy for entrance check-in.');
            } else {
                alert('E-Ticket downloaded successfully! Save it to your phone gallery for entrance scanning.');
            }
        };
        img.src = blobURL;
    }
    function myTicketsPortal() {
        return {
            showModal: false,
            modalToken: '',
            modalDest: '',
            modalLoc: '',
            modalUrl: '#',
            openQrModal(token, dest, loc, date, visitor, url) {
                this.modalToken = token;
                this.modalDest = dest;
                this.modalLoc = loc;
                this.modalUrl = url;
                this.showModal = true;
                
                const qrSvg = document.querySelector('#qr-svg-' + token);
                const container = document.getElementById('modal-qr-container');
                if (qrSvg && container) {
                    container.innerHTML = qrSvg.innerHTML;
                }
            }
        }
    }
    </script>
    @endpush
</x-app-layout>
