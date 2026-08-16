<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-black text-gray-800 flex items-center gap-2 tracking-tight">
            <i class="ti ti-ticket text-emerald-700"></i>
            <span>Your E-Ticket Pass</span>
        </h1>
    </x-slot>

    <div class="py-10 max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Ticket Card Container -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200/80 print:shadow-none print:border-none">
            <!-- Header Banner -->
            <div class="px-6 py-8 text-center relative overflow-hidden rounded-t-3xl" style="background: linear-gradient(135deg, #052e16 0%, #14532d 50%, #047857 100%); color: #ffffff;">
                <div class="absolute -top-12 -right-12 w-36 h-36 rounded-full pointer-events-none" style="background: rgba(255, 255, 255, 0.1); filter: blur(24px);"></div>
                
                <div class="inline-flex items-center justify-center gap-1.5 text-[11px] font-black uppercase tracking-widest px-3.5 py-1.5 rounded-full shadow-sm mb-3.5 mt-1" style="background: rgba(255, 255, 255, 0.2); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff;">
                    <i class="ti ti-shield-check text-xs" style="color: #a7f3d0;"></i>
                    <span>E-Turismo Official Digital Pass</span>
                </div>
                
                <h2 class="text-2xl sm:text-3xl font-black tracking-tight leading-tight mb-1.5" style="color: #ffffff;">
                    {{ $booking->destination?->name }}
                </h2>
                
                <p class="text-xs sm:text-sm font-medium flex items-center justify-center gap-1.5" style="color: #d1fae5;">
                    <i class="ti ti-map-pin" style="color: #6ee7b7;"></i>
                    <span>{{ $booking->destination?->location }}</span>
                </p>
            </div>

            <!-- Ticket Body Content -->
            <div class="p-6 sm:p-8 space-y-6 text-center">
                @if($booking->status === 'declined' || $booking->payment_status === 'rejected')
                    <div class="p-6 bg-red-50 border border-red-200 text-red-800 rounded-2xl text-center">
                        <i class="ti ti-circle-x text-3xl text-red-600 mb-2 inline-block"></i>
                        <h4 class="font-bold text-base">Booking Declined</h4>
                        <p class="text-xs text-red-700 mt-1">This booking request was declined. QR code entry pass is permanently disabled.</p>
                    </div>
                @else
                    <!-- QR Code Frame -->
                    <div class="inline-block p-4 sm:p-5 bg-slate-50 border-2 border-emerald-100 rounded-3xl shadow-inner relative group">
                        <div id="ticket-qr-container" class="bg-white p-2 rounded-xl shadow-xs">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(210)->generate($ticket->qr_code) !!}
                        </div>
                    </div>
                    
                    <div class="space-y-1 pt-1">
                        <span class="text-[11px] uppercase text-slate-400 font-black tracking-wider block">Pass Reference Code</span>
                        <span class="text-2xl sm:text-3xl font-mono font-black text-emerald-950 tracking-wider block">{{ $ticket->qr_code }}</span>
                    </div>
                @endif

                <div class="border-t border-dashed border-slate-200 my-4"></div>

                <!-- Info Fields Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-left bg-slate-50/80 p-4 sm:p-5 rounded-2xl border border-slate-200/60 shadow-inner">
                    <div class="bg-white p-3.5 rounded-xl border border-slate-150">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block mb-0.5">Visitor Name</span>
                        <p class="text-sm font-black text-slate-900 truncate">{{ $booking->tourist?->name }}</p>
                    </div>
                    
                    <div class="bg-white p-3.5 rounded-xl border border-slate-150">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block mb-0.5">Visitor Category</span>
                        <p class="text-sm font-black text-slate-900">{{ $booking->tourist?->classification ?? 'Local' }} Tourist</p>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-150">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block mb-0.5">Scheduled Visit</span>
                        <p class="text-sm font-black text-slate-900">{{ \Carbon\Carbon::parse($booking->visit_date)->format('F j, Y') }}</p>
                    </div>

                    <div class="bg-white p-3.5 rounded-xl border border-slate-150">
                        <span class="text-[10px] font-black uppercase text-slate-400 tracking-wider block mb-0.5">Pass Status</span>
                        <p class="text-sm font-black text-emerald-600 flex items-center gap-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                            <span>Active / Ready</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="bg-slate-50/90 px-6 py-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-200/80 print:hidden">
                <a href="{{ route('bookings.index') }}" class="w-full sm:w-auto flex-1 inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-100 text-slate-700 font-bold py-3 px-5 rounded-xl text-xs uppercase tracking-wider border border-slate-300 transition shadow-sm">
                    <i class="ti ti-arrow-left text-sm"></i>
                    <span>Back to Bookings</span>
                </a>
                
                @if($booking->status !== 'declined' && $booking->payment_status !== 'rejected')
                    <button type="button" onclick="downloadFormattedTicketQR('ticket-qr-container', '{{ e($booking->destination?->name) }}', '{{ $ticket->qr_code }}', '{{ e($booking->tourist?->name) }}', '{{ \Carbon\Carbon::parse($booking->visit_date)->format('M j, Y') }}')"
                        class="w-full sm:w-auto flex-1 inline-flex items-center justify-center gap-2 font-extrabold py-3 px-5 rounded-xl text-xs uppercase tracking-wider transition shadow-md cursor-pointer transform hover:-translate-y-0.5 active:translate-y-0" style="background: linear-gradient(135deg, #059669 0%, #16a34a 100%); color: #ffffff;">
                        <i class="ti ti-download text-sm" style="color: #ffffff;"></i>
                        <span style="color: #ffffff;">Download QR Pass</span>
                    </button>
                    
                    <button type="button" onclick="window.print()" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 bg-slate-900 hover:bg-black text-white font-bold py-3 px-4 rounded-xl text-xs uppercase tracking-wider transition shadow-sm" title="Print Paper Ticket">
                        <i class="ti ti-printer text-sm"></i>
                        <span class="sm:hidden">Print Pass</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Entrance & Check-in Reminders Card -->
        <div class="mt-6 bg-gradient-to-br from-amber-50/90 via-orange-50/80 to-amber-100/60 border border-amber-200/90 rounded-3xl p-5 sm:p-6 shadow-sm print:hidden">
            <div class="flex items-center gap-2 mb-3 text-amber-950 font-black text-sm tracking-tight">
                <div class="p-1.5 bg-amber-500/20 rounded-xl text-amber-700">
                    <i class="ti ti-alert-triangle-filled text-base"></i>
                </div>
                <span>Entrance & Check-in Reminders</span>
            </div>
            
            <ul class="space-y-2.5 text-xs text-amber-900/90 font-medium">
                <li class="flex items-start gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                    <span><strong class="font-bold text-amber-950">Save to Phone:</strong> Download or screenshot this QR code to your mobile gallery for instant scanning even if cellular signal is weak at destination gates.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                    <span><strong class="font-bold text-amber-950">Gate Scanning:</strong> Present this QR code to destination staff at the entrance checkpoint for scanning.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mt-1.5 shrink-0"></span>
                    <span><strong class="font-bold text-amber-950">Visit Date:</strong> Valid for single-day entry on your scheduled visit date ({{ \Carbon\Carbon::parse($booking->visit_date)->format('F j, Y') }}).</span>
                </li>
            </ul>
        </div>
    </div>

    @push('scripts')
    <script>
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
    </script>
    @endpush
</x-app-layout>
