<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Booking Management</h1>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .period-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            border: 1px solid #e5e7eb;
            background: #fff;
            color: #6b7280;
            transition: all 0.2s ease;
        }
        .period-btn:hover {
            border-color: #2d7a4a;
            color: #2d7a4a;
            background: #f0fdf4;
        }
        .period-btn.active {
            background: #2d7a4a;
            color: #fff;
            border-color: #2d7a4a;
        }
        .tab-btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.15s;
        }
        .tab-btn:hover {
            color: #2d7a4a;
        }
        .tab-btn.active {
            color: #2d7a4a;
            border-bottom-color: #2d7a4a;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 7px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.15s;
            text-decoration: none;
        }
        .action-btn-view    { background: #eff6ff; color: #3b82f6; }
        .action-btn-view:hover { background: #dbeafe; }
        .action-btn-confirm { background: #f0fdf4; color: #16a34a; }
        .action-btn-confirm:hover { background: #dcfce7; }
        .action-btn-decline { background: #fef2f2; color: #dc2626; }
        .action-btn-decline:hover { background: #fee2e2; }
        .action-btn-cancel  { background: #f3f4f6; color: #4b5563; }
        .action-btn-cancel:hover { background: #e5e7eb; }
        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid #d1d5db;
            border-top-color: #2d7a4a;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="bookingManager()">

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="ti ti-circle-check" style="font-size:18px;"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="ti ti-circle-x" style="font-size:18px;"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- Filter Row --}}
        <div class="flex items-center justify-between flex-wrap gap-4">
            {{-- Tabs --}}
            <div class="flex border-b border-gray-200">
                <button class="tab-btn" :class="{ 'active': activeTab === 'pending' }" @click="setTab('pending')">
                    <i class="ti ti-clock"></i> Pending
                </button>
                <button class="tab-btn" :class="{ 'active': activeTab === 'confirmed' }" @click="setTab('confirmed')">
                    <i class="ti ti-check"></i> Confirmed
                </button>
                <button class="tab-btn" :class="{ 'active': activeTab === 'completed' }" @click="setTab('completed')">
                    <i class="ti ti-user-check"></i> Completed
                </button>
                <button class="tab-btn" :class="{ 'active': activeTab === 'cancelled' }" @click="setTab('cancelled')">
                    <i class="ti ti-ban"></i> Cancelled
                </button>
            </div>

            {{-- Period Selector --}}
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-500 flex items-center gap-1.5 shrink-0">
                    <i class="ti ti-filter" style="font-size:15px;"></i> Filter:
                </span>
                <div class="flex items-center gap-2">
                    <button class="period-btn" :class="{ 'active': period === 'all' }" @click="setPeriod('all')">
                        <i class="ti ti-inbox"></i> All
                    </button>
                    <button class="period-btn" :class="{ 'active': period === 'today' }" @click="setPeriod('today')">
                        Today
                    </button>
                    <button class="period-btn" :class="{ 'active': period === 'week' }" @click="setPeriod('week')">
                        This week
                    </button>
                    <button class="period-btn" :class="{ 'active': period === 'month' }" @click="setPeriod('month')">
                        This month
                    </button>
                    <button class="period-btn" :class="{ 'active': period === 'year' }" @click="setPeriod('year')">
                        This year
                    </button>
                </div>
                <div class="spinner" id="table-spinner"></div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="interactive-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Booking ID</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Visitor Name</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Tourist Spot</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Visit Date</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wide">Guests</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Payment</th>
                            <th class="px-5 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">Booking Status</th>
                            <th class="px-5 py-3 text-center text-xs font-semibold text-gray-400 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <template x-for="b in getActiveList()" :key="b.id">
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-3 font-semibold text-gray-700">#<span x-text="b.id"></span></td>
                                <td class="px-5 py-3 font-medium text-gray-900" x-text="b.tourist ? b.tourist.name : 'Unknown'"></td>
                                <td class="px-5 py-3 text-gray-600" x-text="b.destination ? b.destination.name : '—'"></td>
                                <td class="px-5 py-3 text-gray-500" x-text="formatDate(b.visit_date)"></td>
                                <td class="px-5 py-3 text-center text-gray-700">1</td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full"
                                          :class="b.payment_status === 'approved' ? 'text-green-700 bg-green-50' : (b.payment_status === 'pending_verification' ? 'text-amber-700 bg-amber-50' : 'text-red-700 bg-red-50')">
                                        <i class="ti" :class="b.payment_status === 'approved' ? 'ti-circle-check-filled' : 'ti-clock'"></i>
                                        <span x-text="b.payment_status ? b.payment_status.replace('_', ' ') : 'unpaid'"></span>
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full"
                                          :class="b.status === 'completed' || b.status === 'confirmed' ? 'text-green-700 bg-green-50' : (b.status === 'pending' ? 'text-amber-700 bg-amber-50' : 'text-red-700 bg-red-50')">
                                        <i class="ti" :class="b.status === 'completed' || b.status === 'confirmed' ? 'ti-circle-check-filled' : 'ti-clock'"></i>
                                        <span x-text="b.status"></span>
                                    </span>
                                </td>
                                <td class="px-5 py-3">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button class="action-btn action-btn-view" title="View Details" @click="viewDetails(b.id)">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <template x-if="b.status === 'pending'">
                                            <div class="flex gap-1.5">
                                                <form :action="confirmUrl(b.id)" method="POST" class="inline">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="action-btn action-btn-confirm" title="Approve">
                                                        <i class="ti ti-check"></i>
                                                    </button>
                                                </form>
                                                <button class="action-btn action-btn-decline" title="Reject" @click="rejectBooking(b.id)">
                                                    <i class="ti ti-x"></i>
                                                </button>
                                            </div>
                                        </template>
                                        <template x-if="b.status === 'confirmed'">
                                            <button class="action-btn action-btn-cancel" title="Cancel" @click="cancelBooking(b.id)">
                                                <i class="ti ti-ban"></i>
                                            </button>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="getActiveList().length === 0">
                            <td colspan="8" class="px-5 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i class="ti ti-inbox" style="font-size:28px;"></i>
                                    <span class="text-sm">No bookings in this tab for the selected period</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Booking Details Modal --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4"
             x-show="showModal"
             x-transition
             style="display: none;">
            <div class="bg-white border border-gray-200 rounded-2xl max-w-4xl w-[90vw] max-h-[90vh] flex flex-col shadow-xl"
                 @click.away="showModal = false">
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-gray-150 flex items-center justify-between shrink-0">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                        <i class="ti ti-file-invoice text-green-700"></i> Booking Details #<span x-text="details.id"></span>
                    </h3>
                    <button class="text-gray-400 hover:text-gray-600 transition" @click="showModal = false">
                        <i class="ti ti-x" style="font-size:20px;"></i>
                    </button>
                </div>

                {{-- Modal Body (Scrollable container with visual scrollbar indicator) --}}
                <div class="p-6 space-y-6 text-sm overflow-y-auto flex-1 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    {{-- Visitor Info --}}
                    <div class="space-y-2">
                        <h4 class="font-semibold text-gray-500 uppercase tracking-wide text-xs">Visitor Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-150">
                            <div>
                                <span class="text-gray-400 text-xs block">Full Name</span>
                                <span class="font-medium text-gray-800" x-text="details.tourist ? details.tourist.name : 'Unknown'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Email Address</span>
                                <span class="font-medium text-gray-800" x-text="details.tourist ? details.tourist.email : 'N/A'"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Phone Number</span>
                                <span class="font-medium text-gray-800" x-text="details.tourist ? details.tourist.phone : 'N/A'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Booking Info --}}
                    <div class="space-y-2">
                        <h4 class="font-semibold text-gray-500 uppercase tracking-wide text-xs">Booking Information</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-xl border border-gray-150">
                            <div>
                                <span class="text-gray-400 text-xs block">Tourist Spot</span>
                                <span class="font-medium text-gray-800" x-text="details.spot"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Scheduled Visit Date</span>
                                <span class="font-medium text-gray-800" x-text="details.visit_date"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 text-xs block">Number of Guests</span>
                                <span class="font-medium text-gray-800">1 Guest</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment & Ticket side-by-side --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        {{-- Receipt --}}
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-500 uppercase tracking-wide text-xs flex items-center gap-1">
                                <i class="ti ti-file-invoice"></i> Payment Receipt
                            </h4>
                            <div class="border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center bg-gray-50 h-56 overflow-hidden">
                                <template x-if="details.payment_receipt">
                                    <div class="w-full h-full flex flex-col justify-between items-center">
                                        <a :href="details.payment_receipt" target="_blank" class="block w-full h-40 overflow-hidden">
                                            <img :src="details.payment_receipt" class="w-full h-full object-contain hover:scale-105 transition duration-300">
                                        </a>
                                        <a :href="details.payment_receipt" download class="mt-2 text-xs font-semibold text-green-700 hover:text-green-800 flex items-center gap-1">
                                            <i class="ti ti-download"></i> Download Receipt
                                        </a>
                                    </div>
                                </template>
                                <template x-if="!details.payment_receipt">
                                    <div class="text-center text-gray-400">
                                        <i class="ti ti-photo-off" style="font-size:32px;"></i>
                                        <p class="text-xs mt-1">No receipt uploaded</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- QR Ticket --}}
                        <div class="space-y-2">
                            <h4 class="font-semibold text-gray-500 uppercase tracking-wide text-xs flex items-center gap-1">
                                <i class="ti ti-qrcode"></i> QR Ticket
                            </h4>
                            <div class="border border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center bg-gray-50 h-56 overflow-hidden">
                                <template x-if="details.qr_ticket">
                                    <div class="w-full h-full flex flex-col justify-between items-center">
                                        <a :href="details.qr_ticket" target="_blank" class="block w-full h-40 overflow-hidden flex justify-center">
                                            <img :src="details.qr_ticket" class="h-full object-contain">
                                        </a>
                                        <a :href="details.qr_ticket" download class="mt-2 text-xs font-semibold text-green-700 hover:text-green-800 flex items-center gap-1">
                                            <i class="ti ti-download"></i> Download QR
                                        </a>
                                    </div>
                                </template>
                                <template x-if="!details.qr_ticket">
                                    <div class="text-center text-gray-400">
                                        <i class="ti ti-qrcode" style="font-size:32px;"></i>
                                        <p class="text-xs mt-1">Ticket not generated</p>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="space-y-1">
                        <label class="font-semibold text-gray-500 uppercase tracking-wide text-xs block">Operational Notes</label>
                        <textarea class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 outline-none resize-none" rows="2" readonly x-text="details.notes"></textarea>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="px-6 py-4 border-t border-gray-150 bg-gray-50 flex justify-end shrink-0">
                    <button class="bg-gray-250 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl px-5 py-2.5 transition text-sm" @click="showModal = false">
                        Close
                    </button>
                </div>
            </div>
        </div>

        {{-- Decline Action Dialog Modal --}}
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" x-show="declineModal" x-transition style="display: none;">
            <div class="bg-white border border-gray-200 rounded-2xl max-w-lg w-full shadow-xl p-6" @click.away="declineModal = false" x-data="{ reasonCategory: 'Spot at capacity' }">
                <h3 class="font-bold text-gray-800 text-lg mb-3">Reject Booking Request</h3>
                <form :action="declineUrl(rejectId)" method="POST" class="space-y-4">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    
                    {{-- Predefined Rejection Reasons --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 flex items-center gap-1">
                            <i class="ti ti-alert-circle text-red-500"></i> Select Rejection Reason
                        </label>
                        <select name="reason_category" x-model="reasonCategory" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                            <option value="Spot at capacity">Spot at capacity</option>
                            <option value="Invalid visitor information">Invalid visitor information</option>
                            <option value="Payment issue">Payment issue</option>
                            <option value="Duplicate booking">Duplicate booking</option>
                            <option value="Schedule conflict">Schedule conflict</option>
                            <option value="Other">Other (specify below)</option>
                        </select>
                    </div>

                    {{-- Additional Details textarea --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Additional Details <span x-show="reasonCategory === 'Other'" class="text-red-500">*</span>
                        </label>
                        <textarea name="decline_reason" :required="reasonCategory === 'Other'" placeholder="Add specific notes..." class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-green-400 outline-none h-[120px]" style="min-height: 120px;"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl px-5 py-2.5 text-sm transition" @click="declineModal = false">Cancel</button>
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl px-5 py-2.5 text-sm transition flex items-center gap-1.5 shadow-sm">
                            <i class="ti ti-x"></i> Reject Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function bookingManager() {
                return {
                    activeTab: 'pending',
                    period: '{{ $period }}',
                    showModal: false,
                    declineModal: false,
                    rejectId: null,
                    details: {},
                    CONFIRM_BASE: '{{ url('/bookings') }}',
                    DECLINE_BASE: '{{ url('/bookings') }}',
                    SHOW_BASE: '{{ url('/staff/bookings') }}',
                    lists: {
                        pending: @json($pending),
                        confirmed: @json($confirmed),
                        completed: @json($completed),
                        cancelled: @json($cancelled)
                    },

                    init() {
                        const urlParams = new URLSearchParams(window.location.search);
                        const p = urlParams.get('period');
                        if (p && p !== this.period) {
                            this.setPeriod(p);
                        }
                    },

                    getActiveList() {
                        return this.lists[this.activeTab] || [];
                    },

                    setTab(tab) {
                        this.activeTab = tab;
                    },

                    setPeriod(period) {
                        this.period = period;
                        
                        // Update URL parameter
                        const url = new URL(window.location);
                        url.searchParams.set('period', period);
                        window.history.pushState({}, '', url);

                        const spinner = document.getElementById('table-spinner');
                        spinner.style.display = 'block';

                        fetch(`{{ route('staff.bookings.index') }}?period=${period}`, {
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.lists.pending = data.pending;
                            this.lists.confirmed = data.confirmed;
                            this.lists.completed = data.completed;
                            this.lists.cancelled = data.cancelled;
                        })
                        .finally(() => {
                            spinner.style.display = 'none';
                        });
                    },

                    confirmUrl(id) { return `${this.CONFIRM_BASE}/${id}/confirm`; },
                    declineUrl(id) { return `${this.DECLINE_BASE}/${id}/decline`; },

                    viewDetails(id) {
                        fetch(`${this.SHOW_BASE}/${id}`, {
                            headers: { 'Accept': 'application/json' }
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.details = data;
                            this.showModal = true;
                        });
                    },

                    rejectBooking(id) {
                        this.rejectId = id;
                        this.declineModal = true;
                    },

                    cancelBooking(id) {
                        this.rejectId = id;
                        this.declineModal = true;
                    },

                    formatDate(dateStr) {
                        if (!dateStr) return '';
                        const date = new Date(dateStr);
                        return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
