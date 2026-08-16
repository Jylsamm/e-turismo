<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
        <style>
            .card-hover-effect {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            .card-hover-effect:hover {
                transform: translateY(-4px) !important;
                box-shadow: 0 14px 28px -6px rgba(0, 0, 0, 0.08), 0 10px 14px -6px rgba(0, 0, 0, 0.04) !important;
            }
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
        </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight flex items-center gap-2.5">
                    Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!
                    <span class="inline-block animate-bounce text-xl">👋</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5 font-medium">Manage your eco-tours, active entry passes, and upcoming adventures.</p>
            </div>
            <div>
                <a href="{{ route('destinations.index') }}"
                   class="inline-flex items-center gap-2 bg-emerald-700 hover:bg-emerald-800 text-white text-xs sm:text-sm font-bold px-4 py-2.5 rounded-xl shadow-xs hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    <i class="ti ti-compass text-base"></i>
                    <span>Explore Destinations</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div id="tourist-dashboard-root" x-data="touristDashboardModal()" class="pb-12 pt-2 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 relative">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-4 py-3 rounded-2xl shadow-xs flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i class="ti ti-circle-check text-lg"></i>
                </div>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Verification Alert Banner --}}
        @php
            $isVerified = auth()->user()->id_verification_status === 'verified';
            $verificationStatus = auth()->user()->id_verification_status;
        @endphp

        @if(!$isVerified)
            <div class="bg-gradient-to-r from-amber-50 to-orange-50/80 border border-amber-200/90 rounded-2xl p-5 shadow-xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center shrink-0 border border-amber-200">
                            <i class="ti ti-id-badge-2 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-amber-950">Identity Verification Pending</h3>
                            <p class="text-xs text-amber-800/90 mt-0.5 leading-relaxed">Your submitted ID is currently undergoing review. Direct destination bookings and ticket QR codes will activate once verified.</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('profile.edit') }}#verification" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 bg-amber-200/90 hover:bg-amber-300 px-4 py-2 rounded-xl border border-amber-300 transition-all duration-200 shadow-2xs">
                            <span>Check Status</span>
                            <i class="ti ti-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- 1. Unified Summary Metrics Rail (Eliminating Floating Stat Islands) --}}
        <div class="bg-white rounded-2xl border border-gray-200/90 shadow-sm grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 divide-y sm:divide-y-0 sm:divide-x divide-gray-100 overflow-hidden">
            <!-- Active Passes -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center shrink-0 border border-emerald-100">
                    <i class="ti ti-ticket text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Active Passes</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['confirmed'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">Ready</span>
                    </div>
                </div>
            </div>

            <!-- Pending Review -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center shrink-0 border border-amber-100">
                    <i class="ti ti-clock-hour-4 text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Pending Review</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['pending'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full">Review</span>
                    </div>
                </div>
            </div>

            <!-- Unpaid Bookings -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center shrink-0 border border-rose-100">
                    <i class="ti ti-credit-card-off text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Unpaid</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['unpaid'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-rose-700 bg-rose-50 px-2 py-0.5 rounded-full">Unpaid</span>
                    </div>
                </div>
            </div>

            <!-- Places Visited -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center shrink-0 border border-indigo-100">
                    <i class="ti ti-map-pin-check text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Places Visited</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['completed'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded-full">Visited</span>
                    </div>
                </div>
            </div>

            <!-- Total Bookings -->
            <div class="p-5 sm:p-6 flex items-center gap-4 hover:bg-gray-50/50 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100">
                    <i class="ti ti-folders text-xl"></i>
                </div>
                <div>
                    <span class="text-[11px] uppercase tracking-widest font-bold text-gray-400 block leading-relaxed">Total Bookings</span>
                    <div class="flex items-baseline gap-2 mt-1">
                        <span class="text-2xl font-black text-gray-900 font-mono leading-none">{{ $stats['total'] ?? 0 }}</span>
                        <span class="text-[10px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-full">History</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notifications Accordion / Box --}}
        @if($notifications->count())
            <div class="bg-white border border-gray-200/90 rounded-2xl p-5 shadow-sm card-hover-effect">
                <div class="flex items-center justify-between gap-3 mb-3 border-b border-gray-100 pb-2.5">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm">
                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <i class="ti ti-bell-ringing text-base"></i>
                        </span>
                        <span>Your Notifications</span>
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full font-mono">{{ $notifications->count() }}</span>
                    </h2>
                    <form action="{{ route('notifications.read-all') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-1 text-xs text-emerald-700 hover:text-emerald-900 font-bold hover:underline transition">
                            <i class="ti ti-checks text-emerald-600"></i> Mark all as read
                        </button>
                    </form>
                </div>
                <ul class="space-y-2">
                    @foreach($notifications as $notif)
                    <li class="text-sm text-gray-800 flex items-start gap-2.5 bg-gray-50/70 p-2.5 rounded-xl border border-gray-100">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0 mt-1.5 ring-2 ring-emerald-100"></span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-900">{{ $notif->message }}</p>
                            <span class="text-[10px] text-gray-500 mt-0.5 block font-mono">{{ $notif->created_at->diffForHumans() }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 2. Main Asymmetric 2-Column Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            {{-- Left Column (7 cols): My Bookings & Digital Passes --}}
            <div class="lg:col-span-7 bg-white rounded-3xl shadow-sm border border-gray-200/90 overflow-hidden flex flex-col h-full card-hover-effect">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/80 to-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center border border-emerald-100">
                            <i class="ti ti-calendar-event text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-sm sm:text-base">Recent Bookings</h2>
                            <p class="text-[11px] text-gray-400">Your reservation schedule and active passes</p>
                        </div>
                    </div>
                    @if($isVerified)
                        <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-900 hover:underline inline-flex items-center gap-1">
                            <span>View all</span>
                            <i class="ti ti-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="text-xs text-gray-400 font-medium">Locked 🔒</span>
                    @endif
                </div>

                <div class="flex-1 divide-y divide-gray-100">
                    @forelse($myBookings as $booking)
                        @php
                            $isConfirmed = $booking->status === 'confirmed';
                            $isCompleted = $booking->status === 'completed';
                            $isPending = $booking->status === 'pending';
                            $qrCodeToken = $booking->ticket?->qr_code ?? $booking->qr_token;
                            $ticketId = $booking->ticket?->id ?? $booking->id;

                            $badgeMap = [
                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-800', 'border' => 'border-amber-200/80'],
                                'confirmed' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200/80'],
                                'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-600', 'border' => 'border-gray-200'],
                                'declined' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-800', 'border' => 'border-rose-200/80'],
                                'completed' => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-800', 'border' => 'border-indigo-200/80'],
                            ];
                            $style = $badgeMap[$booking->status] ?? ['bg' => 'bg-gray-50', 'text' => 'text-gray-700', 'border' => 'border-gray-200'];
                        @endphp

                        <div class="p-5 hover:bg-emerald-50/20 transition-all duration-150 flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 {{ $isConfirmed ? 'bg-emerald-50/10' : '' }}">
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="font-bold text-gray-900 text-sm sm:text-base tracking-tight truncate">{{ $booking->destination?->name }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold border capitalize {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500 font-medium">
                                    <span class="inline-flex items-center gap-1 font-mono text-gray-700">
                                        <i class="ti ti-calendar text-xs text-emerald-600"></i>
                                        {{ date('M d, Y', strtotime($booking->visit_date)) }}
                                    </span>
                                    <span>•</span>
                                    <span class="text-[11px] text-gray-400 font-mono">Booked {{ $booking->created_at->diffForHumans() }}</span>
                                </div>

                                @if($qrCodeToken && $isVerified && $booking->status !== 'declined' && $booking->payment_status !== 'rejected')
                                    <!-- Hidden SVG Template for QR Download -->
                                    <div id="qr-svg-{{ $qrCodeToken }}" class="hidden">
                                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($qrCodeToken) !!}
                                    </div>
                                    <div class="pt-1">
                                        <button type="button" @click="openQrModal('{{ $qrCodeToken }}', '{{ e($booking->destination?->name) }}', '{{ e($booking->destination?->location) }}', '{{ date('M j, Y', strtotime($booking->visit_date)) }}', '{{ e($booking->tourist?->name ?? auth()->user()->name) }}', '{{ url('/tickets/' . $ticketId) }}')"
                                            class="text-emerald-800 font-mono font-bold hover:text-emerald-950 inline-flex items-center gap-1.5 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 px-3 py-1.5 rounded-xl text-xs transition-all duration-200 cursor-pointer shadow-2xs">
                                            <i class="ti ti-qrcode text-emerald-700 text-sm"></i>
                                            <span>Scan Pass: {{ $qrCodeToken }}</span>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="shrink-0 flex items-center gap-2">
                                <a href="{{ route('bookings.index') }}" class="text-xs font-bold text-gray-600 hover:text-emerald-800 bg-gray-50 hover:bg-emerald-50 border border-gray-200 hover:border-emerald-200 px-3 py-1.5 rounded-xl transition-all inline-flex items-center gap-1">
                                    <span>Details</span>
                                    <i class="ti ti-arrow-up-right text-xs"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mx-auto">
                                <i class="ti ti-calendar-off text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">No bookings yet</h4>
                                <p class="text-xs text-gray-500 mt-0.5">Ready for your next trip? Discover destinations and reserve your slot.</p>
                            </div>
                            <div class="pt-1">
                                <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3.5 py-2 rounded-xl hover:bg-emerald-100 transition-colors">
                                    <span>Browse Spots</span> &rarr;
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Right Column (5 cols): Suggested Destinations with Media-First Visual Cards & Most Visited UI --}}
            <div class="lg:col-span-5 bg-white rounded-3xl shadow-sm border border-gray-200/90 overflow-hidden flex flex-col h-full card-hover-effect {{ !$isVerified ? 'opacity-75' : '' }}">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-gray-50/80 to-white">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center border border-teal-100">
                            <i class="ti ti-compass text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-900 text-sm sm:text-base leading-snug">Suggested Destinations</h2>
                            <p class="text-[11px] text-gray-400 leading-relaxed mt-0.5">Top eco-tourism attractions in Tigbao</p>
                        </div>
                    </div>
                    <a href="{{ route('destinations.index') }}" class="text-xs font-bold text-teal-700 hover:text-teal-900 hover:underline inline-flex items-center gap-1">
                        <span>All Spots</span>
                        <i class="ti ti-chevron-right text-xs"></i>
                    </a>
                </div>

                <div class="flex-1 divide-y divide-gray-100">
                    @forelse($destinations as $dest)
                        @php
                            $isTopVisited = $loop->first && ($dest->visits_count > 0 || $loop->count > 1);
                        @endphp
                        <div class="p-4 sm:p-5 hover:bg-teal-50/20 transition-all duration-150 flex items-center gap-3.5 {{ $isTopVisited ? 'bg-gradient-to-r from-amber-50/40 via-emerald-50/20 to-transparent' : '' }}">
                            <!-- Visual Destination Thumbnail with Badge -->
                            <a href="{{ route('destinations.show', $dest) }}" class="w-16 h-16 sm:w-18 sm:h-18 rounded-2xl overflow-hidden shrink-0 bg-emerald-100 border {{ $isTopVisited ? 'border-amber-300 ring-2 ring-amber-400/20' : 'border-gray-200' }} shadow-2xs relative block group/img">
                                @if($dest->photos)
                                    <img src="{{ asset('storage/' . $dest->photos) }}" alt="{{ $dest->name }}" class="w-full h-full object-cover transition-transform duration-300 group-hover/img:scale-105">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white">
                                        <i class="ti ti-trees text-2xl opacity-80"></i>
                                    </div>
                                @endif

                                @if($isTopVisited)
                                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/80 to-transparent py-0.5 px-1 text-center">
                                        <span class="text-[9px] font-black text-amber-300 uppercase tracking-tighter">★ Top Pick</span>
                                    </div>
                                @endif
                            </a>

                            <!-- Destination Details -->
                            <div class="space-y-1 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    <a href="{{ route('destinations.show', $dest) }}" class="font-bold text-gray-900 text-sm sm:text-base tracking-tight truncate hover:text-emerald-700 transition-colors">
                                        {{ $dest->name }}
                                    </a>
                                    @if($isTopVisited)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-amber-800 bg-amber-100/80 border border-amber-300/80 px-2 py-0.5 rounded-full shadow-2xs">
                                            <span>🔥 Most Visited</span>
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 flex items-center gap-1 truncate">
                                    <i class="ti ti-map-pin text-xs text-emerald-600 shrink-0"></i>
                                    <span class="truncate">{{ $dest->location }}</span>
                                </p>
                                
                                <div class="flex flex-wrap items-center gap-2 pt-0.5">
                                    @if($dest->capacity > 0)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-600 bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-md font-mono">
                                            <i class="ti ti-users text-[10px] text-gray-500"></i> {{ $dest->capacity }} max/day
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Action -->
                            <div class="shrink-0">
                                @if($isVerified)
                                    <a href="{{ route('destinations.show', $dest) }}"
                                       class="text-xs bg-emerald-700 hover:bg-emerald-800 text-white px-3.5 py-2 rounded-xl font-bold shadow-xs hover:shadow transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 inline-flex items-center gap-1 cursor-pointer">
                                        <span>Book</span>
                                        <i class="ti ti-arrow-right text-xs"></i>
                                    </a>
                                @else
                                    <span class="text-xs bg-gray-100 text-gray-400 px-3 py-1.5 rounded-xl font-medium cursor-not-allowed pointer-events-none select-none">
                                        Locked 🔒
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-gray-400 text-sm">No destinations registered yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- In-Dashboard Quick QR View & Download Modal -->
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
                    <button type="button" @click="closeQrModal()" class="p-2 rounded-xl transition cursor-pointer" style="background: rgba(255, 255, 255, 0.15); color: #ffffff;">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>

                <!-- Modal Content Body (Scrolls internally if screen is small) -->
                <div class="overflow-y-auto flex-1 p-5 text-center space-y-4 custom-modal-scroll">
                    <!-- QR Frame Container -->
                    <div id="dashboard-modal-qr-frame" class="inline-block p-3.5 bg-slate-50 border-2 border-emerald-100 rounded-2xl shadow-inner relative group">
                        <div id="dashboard-modal-qr-render" class="bg-white p-1.5 rounded-xl"></div>
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
    </div>

    @push('scripts')
    <script>
    function touristDashboardModal() {
        return {
            showQrModal: false,
            qrData: {
                code: '',
                destination: '',
                location: '',
                visitDate: '',
                visitorName: ''
            },
            openQrModal(code, destination, location, visitDate, visitorName) {
                this.qrData = { code, destination, location, visitDate, visitorName };
                
                // Copy QR SVG from hidden element into modal
                const sourceSvg = document.querySelector('#qr-svg-' + code);
                const targetRender = document.getElementById('dashboard-modal-qr-render');
                if (sourceSvg && targetRender) {
                    targetRender.innerHTML = sourceSvg.innerHTML;
                }
                
                this.showQrModal = true;
            },
            closeQrModal() {
                this.showQrModal = false;
            },
            downloadModalFormattedQR() {
                const qrSvg = document.querySelector('#dashboard-modal-qr-render svg');
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
                ctx.fillText(this.qrData.destination || 'Tourism Destination', 300, 85);

                ctx.font = '13px sans-serif';
                ctx.fillStyle = '#bbf7d0';
                ctx.fillText('Scheduled Visit: ' + (this.qrData.visitDate || ''), 300, 120);

                // Convert SVG QR to Image Blob
                const svgData = new XMLSerializer().serializeToString(qrSvg);
                const svgBlob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                const URL = window.URL || window.webkitURL || window;
                const blobURL = URL.createObjectURL(svgBlob);

                const self = this;
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
                    ctx.fillText(self.qrData.code || '', 300, 515);

                    ctx.fillStyle = '#475569';
                    ctx.font = 'bold 12px sans-serif';
                    ctx.fillText('VISITOR: ' + (self.qrData.visitorName || '').toUpperCase(), 300, 545);

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

                    // Trigger Download
                    const a = document.createElement('a');
                    a.download = 'E-Ticket-' + (self.qrData.code || 'Pass') + '.png';
                    a.href = canvas.toDataURL('image/png');
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);

                    // Show Toast Alert Notification
                    if (window.renderEmergencyToast) {
                        window.renderEmergencyToast('dl-pass-modal', '[INFO] E-Ticket Downloaded! Saved to your downloads folder. Please keep it handy for entrance check-in.');
                    } else {
                        alert('E-Ticket downloaded successfully! Save it to your phone gallery for entrance scanning.');
                    }
                };
                img.src = blobURL;
            }
        };
    }
    </script>
    @endpush
</x-app-layout>
