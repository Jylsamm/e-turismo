<x-app-layout>
    @push('title')
        Notifications — E-Turismo
    @endpush

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- Top Header & Mark All as Read Action --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-50 text-emerald-700 border border-emerald-100 shadow-sm">
                        <i class="ti ti-bell-ringing text-lg"></i>
                    </span>
                    Notifications
                </h1>
                <p class="text-xs text-gray-500 mt-1">Updates, booking approvals, reminders, and system advisories</p>
            </div>

            <div class="flex items-center gap-2.5">
                @if($unreadCount > 0)
                    <form action="{{ route('notifications.read-all') }}" method="POST" id="mark-all-read-form">
                        @csrf
                        <button type="submit" id="mark-all-read-btn"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-900 border border-emerald-200/80 shadow-sm hover:shadow transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <i class="ti ti-checks text-base text-emerald-600"></i>
                            <span>Mark all as read</span>
                            <span class="inline-flex items-center justify-center bg-emerald-600 text-white text-[10px] font-extrabold px-1.5 py-0.5 rounded-full min-w-[18px]">
                                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                            </span>
                        </button>
                    </form>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-gray-400 bg-gray-50 border border-gray-200">
                        <i class="ti ti-check text-xs text-emerald-500"></i> All caught up
                    </span>
                @endif
            </div>
        </div>

        {{-- Filter Pills --}}
        <div class="flex items-center justify-between border-b border-gray-200 pb-3">
            <div class="flex items-center gap-2">
                <a href="{{ route('notifications.index', ['filter' => 'all']) }}"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ $filter !== 'unread' ? 'bg-emerald-700 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100' }}">
                    All <span class="ml-1 opacity-80 text-[11px]">({{ $totalCount }})</span>
                </a>
                <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                    class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition-all duration-200 {{ $filter === 'unread' ? 'bg-emerald-700 text-white shadow-sm' : 'text-gray-600 hover:text-emerald-800 hover:bg-emerald-50' }}">
                    Unread <span class="ml-1 opacity-80 text-[11px]">({{ $unreadCount }})</span>
                </a>
            </div>

            <span class="text-xs text-gray-400">
                Showing {{ $notifications->firstItem() ?? 0 }}-{{ $notifications->lastItem() ?? 0 }} of {{ $notifications->total() }}
            </span>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 px-4 py-3 rounded-xl text-sm flex items-center gap-2 shadow-sm animate-fade-in">
                <i class="ti ti-circle-check text-emerald-600 text-base"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Notification Cards List --}}
        <div class="space-y-3" id="notification-cards-container">
            @forelse($notifications as $notif)
                @php
                    $isUnread = !$notif->is_read;
                    $isBroadcast = $notif->type === 'broadcast_alert';
                    $isBooking = $notif->type === 'booking_alert';
                    $isCapacity = $notif->type === 'capacity_alert';

                    $iconClass = 'ti ti-bell text-gray-500';
                    $iconBg = 'bg-gray-100 text-gray-600 border-gray-200';
                    
                    if ($isBroadcast) {
                        $iconClass = 'ti ti-alert-triangle text-red-600';
                        $iconBg = 'bg-red-50 text-red-700 border-red-200';
                    } elseif ($isBooking) {
                        $iconClass = 'ti ti-ticket text-emerald-600';
                        $iconBg = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    } elseif ($isCapacity) {
                        $iconClass = 'ti ti-users text-amber-600';
                        $iconBg = 'bg-amber-50 text-amber-700 border-amber-200';
                    }
                @endphp

                <div id="notif-card-{{ $notif->id }}"
                    class="rounded-2xl p-4 sm:p-5 border transition-all duration-200 relative group flex items-start justify-between gap-4 {{ $isUnread ? 'bg-white border-emerald-200/90 shadow-sm ring-1 ring-emerald-500/10 hover:shadow-md' : 'bg-gray-50/70 border-gray-200/80 text-gray-600 hover:bg-white hover:border-gray-300' }}">
                    
                    @if($isUnread)
                        <div class="absolute top-0 left-0 bottom-0 w-1.5 bg-emerald-600 rounded-l-2xl"></div>
                    @endif

                    <div class="flex items-start gap-3.5 flex-1 min-w-0 pl-1">
                        {{-- Icon Badge --}}
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl border shrink-0 {{ $iconBg }} shadow-sm">
                            <i class="{{ $iconClass }} text-lg"></i>
                        </div>

                        {{-- Message content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap mb-1">
                                @if($isBroadcast)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-red-100 text-red-800 border border-red-200">
                                        Broadcast Alert
                                    </span>
                                @elseif($isBooking)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Booking
                                    </span>
                                @elseif($isCapacity)
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200">
                                        Capacity
                                    </span>
                                @endif

                                @if($isUnread)
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></span>
                                @endif
                            </div>

                            <p class="text-sm leading-relaxed {{ $isUnread ? 'text-gray-900 font-semibold' : 'text-gray-700 font-normal' }} break-words">
                                {{ $notif->message }}
                            </p>

                            <div class="flex items-center gap-2 mt-2 text-xs text-gray-600">
                                <i class="ti ti-clock text-gray-600 text-xs"></i>
                                <span>{{ $notif->created_at->diffForHumans() }}</span>
                                <span class="text-gray-600">•</span>
                                <span class="text-[11px] text-gray-600">{{ $notif->created_at->format('M j, Y \a\t g:i A') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Single Mark-Read Action --}}
                    <div class="shrink-0 pt-0.5">
                        @if($isUnread)
                            <form action="{{ route('notifications.read', $notif) }}" method="POST" class="inline mark-single-read-form" data-id="{{ $notif->id }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold text-emerald-700 bg-emerald-50/80 hover:bg-emerald-100 hover:text-emerald-900 border border-emerald-200/60 transition duration-150 whitespace-nowrap shadow-2xs"
                                    title="Mark as read">
                                    <i class="ti ti-check text-xs"></i>
                                    <span class="hidden sm:inline">Mark read</span>
                                </button>
                            </form>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs text-gray-600 font-medium px-2 py-1">
                                <i class="ti ti-check text-gray-600"></i> Read
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-gray-200/80 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-4 border border-emerald-100 shadow-sm">
                        <i class="ti ti-bell-off text-2xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">No notifications</h3>
                    <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                        @if($filter === 'unread')
                            You're all caught up! There are no unread notifications at the moment.
                        @else
                            You don't have any notifications logged in your inbox yet.
                        @endif
                    </p>
                    @if($filter === 'unread' && $totalCount > 0)
                        <a href="{{ route('notifications.index', ['filter' => 'all']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 hover:text-emerald-800 mt-4">
                            <span>View all past notifications</span> <i class="ti ti-arrow-right"></i>
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="pt-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        (function () {
            // Live updates listener: reload when new unread notifications arrive
            let currentUnread = {{ $unreadCount }};
            window.addEventListener('notificationsUpdated', function(e) {
                if (e.detail && e.detail.unreadCount > currentUnread) {
                    window.location.reload();
                } else if (e.detail) {
                    currentUnread = e.detail.unreadCount;
                }
            });

            // Progressive enhancement: handle single mark-read via fetch
            document.querySelectorAll('.mark-single-read-form').forEach(form => {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    const notifId = this.dataset.id;
                    const card = document.getElementById('notif-card-' + notifId);
                    const token = this.querySelector('input[name="_token"]')?.value || document.querySelector('meta[name="csrf-token"]')?.content;

                    try {
                        const res = await fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({ _method: 'PATCH' })
                        });

                        if (res.ok) {
                            if (card) {
                                card.classList.remove('bg-white', 'border-emerald-200/90', 'ring-1', 'ring-emerald-500/10');
                                card.classList.add('bg-gray-50/70', 'border-gray-200/80', 'text-gray-600');
                                const leftBar = card.querySelector('.bg-emerald-600');
                                if (leftBar) leftBar.remove();
                                this.parentElement.innerHTML = '<span class="inline-flex items-center gap-1 text-xs text-gray-400 font-medium px-2 py-1"><i class="ti ti-check text-gray-400"></i> Read</span>';
                            }
                        } else {
                            form.submit();
                        }
                    } catch {
                        form.submit();
                    }
                });
            });
        })();
    </script>
    @endpush
</x-app-layout>
