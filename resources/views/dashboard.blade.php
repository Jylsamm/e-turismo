@php
    $destinations = \App\Models\Destination::select('id', 'name')->get();
@endphp
<x-app-layout>
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
        .broadcast-btn-hover {
            transition: all 0.25s ease-in-out !important;
        }
        .broadcast-btn-hover:hover {
            transform: translateY(-2px) !important;
            background-color: #dc2626 !important; /* red-600 */
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.35) !important;
        }
    </style>
    @endpush
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Admin Analytics Overview') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Tigbao, Zamboanga del Sur - E-Turismo Operations</p>
            </div>
        </div>
    </x-slot>

    <!-- Alpine Component Initialization -->
    <div x-data="analyticsDashboard(@js($initialAnalytics ?? null))" x-init="initCharts()" class="pt-0 pb-12 relative">
        <!-- Toast Notification -->
        <div x-show="toastMessage" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-5 right-5 z-50 max-w-sm bg-emerald-600 text-white px-4 py-3 rounded-xl shadow-lg border border-emerald-500 flex items-center space-x-3"
            style="display: none;">
            <svg class="h-5 w-5 text-white flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm font-medium" x-text="toastMessage"></div>
            <button @click="toastMessage = ''" class="text-emerald-200 hover:text-white transition-colors">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- 2.1 Global Controls -->
            <div
                class="mb-6 flex flex-col sm:flex-row justify-between items-stretch sm:items-center bg-white p-3.5 sm:p-4 rounded-xl shadow-sm border border-gray-100 relative z-30 admin-card-hover gap-3 sm:gap-4">
                <div class="flex items-center justify-between sm:justify-start w-full sm:w-auto gap-2.5 sm:gap-3">
                    <span class="text-xs sm:text-sm font-semibold text-gray-600 shrink-0">Date Range:</span>
                    <div class="relative z-50 flex-1 sm:flex-initial" x-data="{ showRangeDropdown: false }" @click.away="showRangeDropdown = false">
                        <button type="button" @click="showRangeDropdown = !showRangeDropdown"
                            class="flex justify-between items-center w-full sm:w-48 rounded-xl border border-gray-200 shadow-xs bg-white px-3.5 py-2 text-xs sm:text-sm text-gray-700 hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <span class="font-semibold text-gray-800 truncate" x-text="getDateRangeLabel()"></span>
                            <svg class="h-4 w-4 text-gray-400 transform transition-transform duration-200 shrink-0 ml-1.5"
                                :class="showRangeDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
 
                        <!-- Dropdown List with transitions -->
                        <div x-show="showRangeDropdown" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute z-50 mt-2 left-0 sm:left-auto right-0 sm:right-auto w-full sm:w-48 rounded-xl bg-white border border-gray-200 shadow-2xl py-1 overflow-hidden"
                            style="display: none;">

                            <button type="button" @click="setDateRange('today'); showRangeDropdown = false"
                                :class="dateRange === 'today' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between border-b border-gray-50 last:border-0 cursor-pointer">
                                <span>Today</span>
                                <svg x-show="dateRange === 'today'" class="h-4 w-4 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <button type="button" @click="setDateRange('7days'); showRangeDropdown = false"
                                :class="dateRange === '7days' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between border-b border-gray-50 last:border-0 cursor-pointer">
                                <span>Last 7 Days</span>
                                <svg x-show="dateRange === '7days'" class="h-4 w-4 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <button type="button" @click="setDateRange('month'); showRangeDropdown = false"
                                :class="dateRange === 'month' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between border-b border-gray-50 last:border-0 cursor-pointer">
                                <span>This Month</span>
                                <svg x-show="dateRange === 'month'" class="h-4 w-4 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <button type="button" @click="setDateRange('ytd'); showRangeDropdown = false"
                                :class="dateRange === 'ytd' ? 'bg-emerald-50 text-emerald-800 font-bold' : 'text-gray-700 hover:bg-gray-50'"
                                class="w-full text-left px-4 py-2.5 text-sm transition-colors flex items-center justify-between border-b border-gray-50 last:border-0 cursor-pointer">
                                <span>Year-to-Date</span>
                                <svg x-show="dateRange === 'ytd'" class="h-4 w-4 text-emerald-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 w-full sm:w-auto relative z-10">
                    <button @click="openBroadcastModal()"
                        class="w-full sm:w-auto inline-flex items-center justify-center rounded-xl border border-transparent bg-red-600 hover:bg-red-700 px-4 py-2 text-sm font-bold text-white shadow-xs focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 hover:shadow-md cursor-pointer broadcast-btn-hover">
                        <svg class="mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        <span>Broadcast Alert</span>
                    </button>
                </div>
            </div>

            <!-- Global Error State -->
            <div x-show="globalError" class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-md"
                style="display: none;">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700" x-text="globalError"></p>
                    </div>
                </div>
            </div>

            <!-- Tier 1: Executive Summary Metrics -->
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Executive Summary</h3>
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
                <!-- Active Tourists -->
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col relative admin-card-hover">
                    <div x-show="isLoadingKpis"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center">
                        <div class="w-5 h-5 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin">
                        </div>
                    </div>
                    <div class="p-5 flex-grow">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 bg-emerald-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-500 leading-tight">Active Tourists</p>
                                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5" x-text="kpis.activeTourists">...</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border-t border-gray-100 p-0 h-[40px] w-full" id="sparkline-tourists"></div>
                </div>

                <!-- Pending Booking Requests -->
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col relative admin-card-hover">
                    <div x-show="isLoadingKpis"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center">
                        <div class="w-5 h-5 border-2 border-amber-500 border-t-transparent rounded-full animate-spin">
                        </div>
                    </div>
                    <div class="p-5 flex-grow">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 bg-amber-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-500 leading-tight">Pending Bookings</p>
                                <p class="text-2xl font-bold text-amber-600 leading-tight mt-0.5" x-text="kpis.pendingRequests">...</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-amber-50/50 border-t border-gray-100 p-0 h-[40px] w-full cursor-pointer hover:bg-amber-50 transition-colors"
                        id="sparkline-pending" onclick="window.location.href='/bookings'"></div>
                </div>

                <!-- Destination Capacity Health -->
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col relative admin-card-hover">
                    <div x-show="isLoadingKpis"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center">
                        <div class="w-5 h-5 border-2 border-teal-500 border-t-transparent rounded-full animate-spin">
                        </div>
                    </div>
                    <div class="p-5 flex-grow">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 bg-teal-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-500 leading-tight">Capacity Health</p>
                                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5" x-text="kpis.capacityHealth + '%'">...</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border-t border-gray-100 p-0 h-[40px] w-full" id="sparkline-capacity"></div>
                </div>

                <!-- QR Scans -->
                <div
                    class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-100 flex flex-col relative admin-card-hover">
                    <div x-show="isLoadingKpis"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center">
                        <div class="w-5 h-5 border-2 border-emerald-500 border-t-transparent rounded-full animate-spin">
                        </div>
                    </div>
                    <div class="p-5 flex-grow">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0 bg-emerald-100 rounded-md p-3">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-500 leading-tight">QR Check-ins</p>
                                <p class="text-2xl font-bold text-gray-900 leading-tight mt-0.5" x-text="kpis.qrScans">...</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 border-t border-gray-100 p-0 h-[40px] w-full" id="sparkline-qr"></div>
                </div>
            </div>

            <!-- Tier 2: Core Charts -->
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Core Analytics</h3>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Dual-Axis Area Chart: Check-ins vs Bookings -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative admin-card-hover">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Check-ins vs Bookings</h3>

                    <div x-show="isLoadingCore"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center rounded-xl"
                        style="display: none;">
                        <svg class="animate-spin h-8 w-8 text-emerald-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <div id="trendChart" class="w-full h-80"></div>
                </div>

                <!-- Donut Chart with Tabs -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative flex flex-col admin-card-hover">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-base font-semibold text-gray-900"
                            x-text="donutTab === 'demographics' ? 'Visitor Demographics' : 'Booking Status'"></h3>
                        <!-- Tabs -->
                        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg">
                            <button @click="setDonutTab('demographics')"
                                :class="donutTab === 'demographics' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'"
                                class="px-2 py-1 text-xs font-medium rounded-md transition-all">Demo</button>
                            <button @click="setDonutTab('status')"
                                :class="donutTab === 'status' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-700'"
                                class="px-2 py-1 text-xs font-medium rounded-md transition-all">Status</button>
                        </div>
                    </div>

                    <div x-show="isLoadingCore"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center rounded-xl"
                        style="display: none;">
                        <svg class="animate-spin h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <div id="donutChart" class="w-full flex-grow flex items-center justify-center min-h-[300px]"></div>
                </div>
            </div>

            <!-- Tier 2.5: Advanced Charts -->
            <!-- Tier 2.5: Site Capacity Monitoring -->
            <div class="mb-8">
                <!-- Capacity Gauges -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative admin-card-hover">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Site Capacity Monitoring</h3>

                    <div x-show="isLoadingAdvanced"
                        class="absolute inset-0 z-10 bg-white/80 flex items-center justify-center rounded-xl"
                        style="display: none;">
                        <svg class="animate-spin h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="gaugesContainer">
                        <!-- Gauges will be rendered here dynamically, or empty state -->
                        <div x-show="!isLoadingAdvanced && (!advancedData || !advancedData.gauges || advancedData.gauges.length === 0)"
                            class="col-span-full py-12 flex flex-col items-center justify-center text-gray-400">
                            <svg class="h-12 w-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="text-sm">No capacity data available</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tier 3: Audit Log Table -->
            <h3 class="text-lg font-semibold text-gray-900 mb-4">System Health & Staff Activity</h3>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8 relative admin-card-hover">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium tracking-wider">Timestamp</th>
                                <th class="px-6 py-3 text-left font-medium tracking-wider">User</th>
                                <th class="px-6 py-3 text-left font-medium tracking-wider">Severity</th>
                                <th class="px-6 py-3 text-left font-medium tracking-wider">Audience</th>
                                <th class="px-6 py-3 text-left font-medium tracking-wider">Message Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <template x-for="log in auditLogs" :key="log.timestamp + log.message">
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-mono text-xs"
                                        x-text="log.timestamp"></td>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-950" x-text="log.user">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span x-show="log.severity === 'info'"
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 capitalize">Info</span>
                                        <span x-show="log.severity === 'warning'"
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700 capitalize">Warning</span>
                                        <span x-show="log.severity === 'critical'"
                                            class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 capitalize">Critical</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-650 font-medium"
                                        x-text="log.audience"></td>
                                    <td class="px-6 py-4 text-gray-700 max-w-xs truncate" :title="log.message"
                                        x-text="log.message"></td>
                                </tr>
                            </template>
                            <tr x-show="auditLogs.length === 0">
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span class="text-sm">No activity logs recorded.</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Broadcast Alert Modal Wrapper -->
        <div x-show="showBroadcastModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
            style="display: none;" role="dialog" aria-modal="true" x-cloak>
            <!-- Backdrop with blur -->
            <div x-show="showBroadcastModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" @click="closeBroadcastModal()"
                class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

            <!-- Dialog Box -->
            <div x-show="showBroadcastModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                @keydown.escape.window="closeBroadcastModal()"
                class="bg-white border border-gray-150 rounded-2xl max-w-lg w-full p-6 shadow-2xl relative z-10 transition-all">

                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="text-lg font-bold text-gray-950 flex items-center gap-2">
                        <svg class="h-5 w-5 text-red-650" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Broadcast Emergency Alert
                    </h3>
                    <button @click="closeBroadcastModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Step -->
                <div x-show="broadcastStep === 'form'" class="space-y-4">
                    <!-- Premade Message -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Premade Message (Optional)</label>
                        <div class="relative" x-data="{ showDropdown: false }" @click.away="showDropdown = false">
                            <button type="button" @click="showDropdown = !showDropdown"
                                class="flex justify-between items-center w-full rounded-xl border border-gray-200 shadow-sm bg-white px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <span class="font-medium text-gray-800"
                                    x-text="getSelectedPremadeLabel() || 'Select Premade Template...'"></span>
                                <svg class="h-5 w-5 text-gray-400 transform transition-transform duration-200"
                                    :class="showDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown List with transitions -->
                            <div x-show="showDropdown" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                class="absolute z-30 mt-1 w-full rounded-xl bg-white border border-gray-200 shadow-xl h-56 overflow-y-auto py-1"
                                style="display: none;">

                                <button type="button" @click="selectPremade(''); showDropdown = false"
                                    class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50 font-semibold border-b border-gray-100">
                                    -- Clear Selection --
                                </button>

                                <template x-for="msg in premadeMessages" :key="msg.id">
                                    <button type="button" @click="selectPremade(msg.id); showDropdown = false"
                                        class="w-full text-left px-4 py-3 hover:bg-emerald-50/40 hover:text-emerald-950 transition-colors border-b border-gray-50 last:border-0 flex flex-col gap-0.5">
                                        <div class="flex justify-between items-center w-full">
                                            <span class="font-bold text-sm text-gray-900" x-text="msg.label"></span>
                                            <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded-full"
                                                :class="msg.suggestedSeverity === 'critical' ? 'bg-red-100 text-red-700' : (msg.suggestedSeverity === 'warning' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700')"
                                                x-text="msg.suggestedSeverity"></span>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate w-full" x-text="msg.message"></p>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Message text -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-semibold text-gray-700">Message Content</label>
                            <span class="text-xs text-gray-455"
                                :class="broadcastForm.message.length > 280 ? 'text-red-500' : ''"
                                x-text="broadcastForm.message.length + ' / 280'"></span>
                        </div>
                        <textarea x-model="broadcastForm.message" maxlength="280" required rows="3"
                            placeholder="Enter alert message details..."
                            class="block w-full rounded-xl border-gray-250 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm text-gray-700 bg-white px-3 py-2 border"></textarea>
                    </div>

                    <!-- Severity -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Severity Level</label>
                        <div class="flex items-center gap-2">
                            <!-- Info -->
                            <button type="button" @click="broadcastForm.severity = 'info'"
                                :class="broadcastForm.severity === 'info' ? 'border-blue-500 bg-blue-50 text-blue-700 ring-2 ring-blue-500/20' : 'border-gray-200 hover:bg-gray-50 text-gray-700'"
                                class="flex items-center justify-center gap-1.5 py-1 px-3 rounded-lg border text-center transition-all duration-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-bold">Info</span>
                            </button>
                            <!-- Warning -->
                            <button type="button" @click="broadcastForm.severity = 'warning'"
                                :class="broadcastForm.severity === 'warning' ? 'border-amber-500 bg-amber-50 text-amber-700 ring-2 ring-amber-500/20' : 'border-gray-200 hover:bg-gray-50 text-gray-700'"
                                class="flex items-center justify-center gap-1.5 py-1 px-3 rounded-lg border text-center transition-all duration-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-xs font-bold">Warning</span>
                            </button>
                            <!-- Critical -->
                            <button type="button" @click="broadcastForm.severity = 'critical'"
                                :class="broadcastForm.severity === 'critical' ? 'border-red-500 bg-red-50 text-red-750 ring-2 ring-red-500/20' : 'border-gray-200 hover:bg-gray-50 text-gray-700'"
                                class="flex items-center justify-center gap-1.5 py-1 px-3 rounded-lg border text-center transition-all duration-200">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span class="text-xs font-bold">Critical</span>
                            </button>
                        </div>
                    </div>

                    <!-- Audience -->
                    <div x-data="{ showAudienceDropdown: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Target Audience</label>
                        <div class="relative">
                            <!-- Dropdown Trigger Button -->
                            <button type="button" @click="showAudienceDropdown = !showAudienceDropdown" @click.away="showAudienceDropdown = false" class="flex justify-between items-center w-full rounded-xl border border-gray-250 bg-white px-3 py-2.5 text-sm text-gray-700 font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm">
                                <span x-text="
                                    broadcastForm.audience === 'all' ? 'All Active Users' : 
                                    (broadcastForm.audience === 'active_bookings' ? 'Users with Active Bookings' : 
                                    (broadcastForm.audience === 'destination' ? 'Specific Destination' : 'Select Audience'))
                                "></span>
                                <svg class="h-4 w-4 text-gray-450 transform transition-transform duration-200 shrink-0 ml-1" :class="showAudienceDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="showAudienceDropdown" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-1.5 z-50 w-full rounded-xl bg-white border border-gray-200 shadow-xl py-1 max-h-48 overflow-y-auto"
                                 style="display: none;">
                                <button type="button" @click="broadcastForm.audience = 'all'; showAudienceDropdown = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                    All Active Users
                                </button>
                                <button type="button" @click="broadcastForm.audience = 'active_bookings'; showAudienceDropdown = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                    Users with Active Bookings
                                </button>
                                <button type="button" @click="broadcastForm.audience = 'destination'; showAudienceDropdown = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                    Specific Destination
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Conditional Destination Dropdown -->
                    <div x-show="broadcastForm.audience === 'destination'" x-transition x-data="{ showDestDropdown: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1 mt-4">Select Destination</label>
                        <div class="relative">
                            <!-- Dropdown Trigger Button -->
                            <button type="button" @click="showDestDropdown = !showDestDropdown" @click.away="showDestDropdown = false" class="flex justify-between items-center w-full rounded-xl border border-gray-250 bg-white px-3 py-2.5 text-sm text-gray-700 font-semibold hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-sm">
                                <span x-text="
                                    broadcastForm.destination ? (destinationsList.find(d => d.id == broadcastForm.destination)?.name || 'Select Destination') : '-- Select Destination Spot --'
                                "></span>
                                <svg class="h-4 w-4 text-gray-450 transform transition-transform duration-200 shrink-0 ml-1" :class="showDestDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="showDestDropdown" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 mt-1.5 z-50 w-full rounded-xl bg-white border border-gray-200 shadow-xl py-1 max-h-48 overflow-y-auto"
                                 style="display: none;">
                                <button type="button" @click="broadcastForm.destination = ''; showDestDropdown = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                    -- Select Destination Spot --
                                </button>
                                <template x-for="dest in destinationsList" :key="dest.id">
                                    <button type="button" @click="broadcastForm.destination = dest.id; showDestDropdown = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-green-50/40 hover:text-green-950 transition-colors" x-text="dest.name"></button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Action -->
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="closeBroadcastModal()"
                            class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-sm transition">
                            Cancel
                        </button>
                        <button type="button" @click="goToConfirmStep()"
                            :disabled="!broadcastForm.message || (broadcastForm.audience === 'destination' && !broadcastForm.destination)"
                            class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition disabled:opacity-50">
                            Next
                        </button>
                    </div>
                </div>

                <!-- Confirmation Step -->
                <div x-show="broadcastStep === 'confirm'" class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-xl space-y-3">
                        <h4 class="text-sm font-bold text-gray-800 uppercase tracking-wider">Confirm Alert Details</h4>

                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <span class="text-gray-500">Severity:</span>
                            <span class="col-span-2 font-semibold capitalize flex items-center gap-1.5"
                                :class="broadcastForm.severity === 'critical' ? 'text-red-600' : (broadcastForm.severity === 'warning' ? 'text-amber-600' : 'text-blue-600')">
                                <!-- Severity Icons -->
                                <svg x-show="broadcastForm.severity === 'info'" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <svg x-show="broadcastForm.severity === 'warning'" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <svg x-show="broadcastForm.severity === 'critical'" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <span x-text="broadcastForm.severity"></span>
                            </span>

                            <span class="text-gray-500">Audience:</span>
                            <span class="col-span-2 font-semibold"
                                x-text="broadcastForm.audience === 'all' ? 'All Active Users' : (broadcastForm.audience === 'active_bookings' ? 'Users with Active Bookings' : 'Specific Destination: ' + getDestinationName(broadcastForm.destination))"></span>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <span
                                class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Message
                                Preview</span>
                            <p class="text-sm text-gray-700 bg-white border border-gray-150 p-3 rounded-lg leading-relaxed whitespace-pre-wrap font-sans"
                                x-text="broadcastForm.message"></p>
                        </div>
                    </div>

                    <!-- Inline Error State inside Modal -->
                    <div x-show="broadcastError"
                        class="bg-red-50 border-l-4 border-red-400 p-3 rounded-md text-sm text-red-700"
                        x-text="broadcastError"></div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="broadcastStep = 'form'" :disabled="isSending"
                            class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-sm transition">
                            Edit
                        </button>
                        <button type="button" @click="submitBroadcast()" :disabled="isSending"
                            class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition flex items-center gap-1.5">
                            <svg x-show="isSending" class="animate-spin h-4 w-4 text-white" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span x-text="isSending ? 'Sending...' : 'Confirm & Send'"></span>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Ensure ApexCharts is loaded -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('analyticsDashboard', (initData = null) => ({
                dateRange: 'today',

                // Loading States
                isLoadingKpis: !initData,
                isLoadingCore: !initData,
                isLoadingDestinations: !initData,
                isLoadingAdvanced: !initData,

                globalError: '',
                toastMessage: '',

                // State Data
                kpis: initData && initData.kpis ? {
                    activeTourists: initData.kpis.activeTourists,
                    pendingRequests: initData.kpis.pendingRequests,
                    capacityHealth: initData.kpis.capacityHealth,
                    qrScans: initData.kpis.qrScans
                } : {
                    activeTourists: 0,
                    pendingRequests: 0,
                    capacityHealth: 0,
                    qrScans: 0
                },
                sparklineData: initData && initData.kpis ? (initData.kpis.sparklines || {}) : {},

                coreData: initData ? initData.trends : null,
                donutTab: 'demographics', // 'demographics' or 'status'

                destinationsData: null,
                advancedData: initData ? initData.advanced : null,

                // Broadcast Modal State
                showBroadcastModal: false,
                broadcastStep: 'form',
                isSending: false,
                broadcastError: '',
                destinationsList: @json($destinations ?? []),
                broadcastForm: {
                    premadeSelection: '',
                    message: '',
                    severity: 'info',
                    audience: 'all',
                    destination: ''
                },
                premadeMessages: [
                    { id: 'typhoon', label: 'Severe Weather Warning', message: '[CRITICAL] Severe Weather Warning: Heavy rainfall and high winds expected. Please avoid mountain trails and coastal areas.', suggestedSeverity: 'critical' },
                    { id: 'maintenance', label: 'Spot Maintenance Closure', message: 'Facility Maintenance Notice: The destination spot is temporarily closed today for scheduled facility maintenance.', suggestedSeverity: 'warning' },
                    { id: 'sys_maintenance', label: 'Booking System Scheduled Downtime', message: 'System Maintenance: The booking portal will undergo scheduled maintenance tonight from 10:00 PM to 12:00 AM.', suggestedSeverity: 'info' },
                    { id: 'capacity', label: 'Capacity Limit Reached', message: 'Capacity Limit Reached: Tigbao environmental limit has been reached. Walk-in and booking entries are paused.', suggestedSeverity: 'critical' },
                    { id: 'road_block', label: 'Road Closure / Access Alert', message: 'Traffic Advisory: Local road construction near the destination entrance may cause delays. Please follow detour signs.', suggestedSeverity: 'warning' },
                    { id: 'holiday', label: 'Holiday Operations Notice', message: 'Holiday Schedule: Operations will close early at 3:00 PM tomorrow in observance of the upcoming public holiday.', suggestedSeverity: 'info' },
                    { id: 'health_safety', label: 'Safety Guidelines Reminder', message: 'Safety Reminder: Please wear appropriate safety gear and stay within marked trail zones during your visit.', suggestedSeverity: 'info' }
                ],
                auditLogs: [
                    { timestamp: '2026-07-19 18:00:00', user: 'Admin User', severity: 'info', audience: 'All Active Users', message: 'System performance check completed.' },
                    { timestamp: '2026-07-19 17:30:00', user: 'Admin User', severity: 'warning', audience: 'Users with Active Bookings', message: 'Eco Park closed early due to light rain.' }
                ],

                // Chart Instances
                charts: {
                    sparklines: {},
                    trend: null,
                    donut: null,
                    destinations: null,
                    gauges: []
                },

                getDateRangeLabel() {
                    const labels = {
                        'today': 'Today',
                        '7days': 'Last 7 Days',
                        'month': 'This Month',
                        'ytd': 'Year-to-Date'
                    };
                    return labels[this.dateRange] || 'Select Range';
                },
                setDateRange(range) {
                    this.dateRange = range;
                    this.fetchData();
                },
                initCharts() {
                    if (initData) {
                        this.renderSparklines();
                        if (initData.trends) {
                            this.renderTrendChart(initData.trends.trends);
                            this.renderDonutChart();
                        }
                        if (initData.advanced) {
                            this.renderGauges(initData.advanced.gauges);
                        }
                    } else {
                        this.fetchData();
                    }
                },

                fetchData() {
                    this.globalError = '';
                    this.isLoadingKpis = true;
                    this.isLoadingCore = true;
                    this.isLoadingAdvanced = true;

                    Promise.all([
                        fetch(`{{ route('admin.analytics.kpis') }}?range=${this.dateRange}`).then(r => { if (!r.ok) throw new Error('KPI network error'); return r.json(); }),
                        fetch(`{{ route('admin.analytics.trends') }}?range=${this.dateRange}`).then(r => { if (!r.ok) throw new Error('Trends network error'); return r.json(); }),
                        fetch(`{{ route('admin.analytics.advanced') }}?range=${this.dateRange}`).then(r => { if (!r.ok) throw new Error('Advanced network error'); return r.json(); })
                    ]).then(([kpisData, trendsData, advancedData]) => {
                        // KPIs
                        this.kpis = {
                            activeTourists: kpisData.activeTourists,
                            pendingRequests: kpisData.pendingRequests,
                            capacityHealth: kpisData.capacityHealth,
                            qrScans: kpisData.qrScans
                        };
                        this.sparklineData = kpisData.sparklines || {};
                        this.renderSparklines();
                        this.isLoadingKpis = false;

                        // Core Trends & Donut
                        this.coreData = trendsData;
                        this.renderTrendChart(trendsData.trends);
                        this.renderDonutChart();
                        this.isLoadingCore = false;

                        // Advanced Gauges
                        this.advancedData = advancedData;
                        this.renderGauges(advancedData.gauges);
                        this.isLoadingAdvanced = false;
                    }).catch(err => {
                        console.error('Error fetching analytics:', err);
                        this.isLoadingKpis = false;
                        this.isLoadingCore = false;
                        this.isLoadingAdvanced = false;
                    });
                },

                openBroadcastModal() {
                    this.showBroadcastModal = true;
                    this.broadcastStep = 'form';
                    this.broadcastError = '';
                },
                closeBroadcastModal() {
                    this.showBroadcastModal = false;
                    this.resetBroadcastForm();
                },
                applyPremadeMessage() {
                    const selection = this.broadcastForm.premadeSelection;
                    if (selection) {
                        const pm = this.premadeMessages.find(m => m.id === selection);
                        if (pm) {
                            this.broadcastForm.message = pm.message;
                            this.broadcastForm.severity = pm.suggestedSeverity;
                        }
                    } else {
                        this.broadcastForm.message = '';
                    }
                },
                getSelectedPremadeLabel() {
                    const pm = this.premadeMessages.find(m => m.id === this.broadcastForm.premadeSelection);
                    return pm ? pm.label : '';
                },
                selectPremade(id) {
                    this.broadcastForm.premadeSelection = id;
                    this.applyPremadeMessage();
                },
                goToConfirmStep() {
                    this.broadcastError = '';
                    if (!this.broadcastForm.message) {
                        this.broadcastError = 'Message content is required.';
                        return;
                    }
                    this.broadcastStep = 'confirm';
                },
                getDestinationName(id) {
                    const dest = this.destinationsList.find(d => d.id == id);
                    return dest ? dest.name : 'Unknown Spot';
                },
                submitBroadcast() {
                    this.isSending = true;
                    this.broadcastError = '';

                    fetch('{{ route('admin.analytics.broadcast-alert') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            message: this.broadcastForm.message,
                            severity: this.broadcastForm.severity,
                            audience: this.broadcastForm.audience,
                            destination_id: this.broadcastForm.audience === 'destination' ? this.broadcastForm.destination : null
                        })
                    })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                this.showToast(`In-app alert sent to ${this.broadcastForm.audience === 'destination' ? 'Destination' : this.broadcastForm.audience}.`);

                                // Log the broadcast in the audit table (prepend to auditLogs)
                                this.auditLogs.unshift({
                                    timestamp: data.sentAt || new Date().toISOString().replace('T', ' ').substring(0, 19),
                                    user: 'Admin User',
                                    severity: this.broadcastForm.severity,
                                    audience: this.broadcastForm.audience === 'destination'
                                        ? 'Destination (' + this.getDestinationName(this.broadcastForm.destination) + ')'
                                        : (this.broadcastForm.audience === 'active_bookings' ? 'Active Bookings' : 'All Users'),
                                    message: this.broadcastForm.message
                                });

                                this.closeBroadcastModal();
                            } else {
                                this.broadcastError = data.message || 'Failed to send broadcast alert. Please try again.';
                            }
                            this.isSending = false;
                        })
                        .catch(err => {
                            console.error('Error sending broadcast:', err);
                            this.broadcastError = 'Network error. Failed to send broadcast.';
                            this.isSending = false;
                        });
                },
                resetBroadcastForm() {
                    this.broadcastForm = {
                        premadeSelection: '',
                        message: '',
                        severity: 'info',
                        audience: 'all',
                        destination: ''
                    };
                },

                showToast(message) {
                    this.toastMessage = message;
                    setTimeout(() => {
                        if (this.toastMessage === message) {
                            this.toastMessage = '';
                        }
                    }, 5000);
                },

                setDonutTab(tab) {
                    this.donutTab = tab;
                    this.renderDonutChart();
                },

                // --- Chart Renderers ---

                // --- Chart Renderers (optimized with rAF to eliminate forced reflow) ---

                renderSparklines() {
                    const sparklineConfig = {
                        chart: { type: 'line', width: '100%', height: 40, sparkline: { enabled: true } },
                        stroke: { curve: 'smooth', width: 2 },
                        tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function (seriesName) { return '' } } }, marker: { show: false } }
                    };

                    requestAnimationFrame(() => {
                        const createOrUpdateSparkline = (id, data, color) => {
                            if (!data || data.length === 0) return;
                            if (this.charts.sparklines[id]) {
                                this.charts.sparklines[id].updateSeries([{ data }]);
                            } else {
                                const el = document.querySelector(`#${id}`);
                                if (el) {
                                    this.charts.sparklines[id] = new ApexCharts(el, { ...sparklineConfig, series: [{ data }], colors: [color] });
                                    this.charts.sparklines[id].render();
                                }
                            }
                        };

                        createOrUpdateSparkline('sparkline-tourists', this.sparklineData.activeTourists, '#059669');
                        createOrUpdateSparkline('sparkline-pending', this.sparklineData.pendingRequests, '#d97706'); // amber-600
                        createOrUpdateSparkline('sparkline-capacity', this.sparklineData.capacityHealth, '#0d9488'); // teal-600
                        createOrUpdateSparkline('sparkline-qr', this.sparklineData.qrScans, '#059669'); // emerald-600
                    });
                },

                renderTrendChart(trendData) {
                    if (!trendData) return;
                    var options = {
                        series: [{ name: 'Bookings Created', data: trendData.bookings }, { name: 'Actual Check-ins', data: trendData.checkins }],
                        chart: { height: 320, type: 'area', fontFamily: 'inherit', toolbar: { show: false } },
                        colors: ['#047857', '#14b8a6'],
                        dataLabels: { enabled: false },
                        stroke: { curve: 'smooth', width: 2 },
                        xaxis: { categories: trendData.categories },
                        tooltip: { theme: 'light' },
                        legend: { position: 'top' }
                    };

                    requestAnimationFrame(() => {
                        if (this.charts.trend) {
                            this.charts.trend.updateOptions(options);
                        } else {
                            const container = document.querySelector("#trendChart");
                            if (container) {
                                this.charts.trend = new ApexCharts(container, options);
                                this.charts.trend.render();
                            }
                        }
                    });
                },

                renderDonutChart() {
                    if (!this.coreData) return;

                    const data = this.donutTab === 'demographics' ? this.coreData.demographics : this.coreData.status;
                    if (!data) return;

                    var options = {
                        series: data.values,
                        chart: { type: 'donut', height: 300, fontFamily: 'inherit' },
                        labels: data.labels,
                        colors: this.donutTab === 'demographics'
                            ? ['#059669', '#10b981', '#34d399', '#6ee7b7'] // Emeralds for demo
                            : ['#14b8a6', '#f59e0b', '#ef4444'], // Teal (approved), Amber (pending), Red (cancelled)
                        dataLabels: { enabled: false },
                        legend: { position: 'bottom' },
                        plotOptions: { pie: { donut: { size: '65%' } } }
                    };

                    requestAnimationFrame(() => {
                        if (this.charts.donut) {
                            this.charts.donut.updateOptions(options);
                        } else {
                            const container = document.querySelector("#donutChart");
                            if (container) {
                                this.charts.donut = new ApexCharts(container, options);
                                this.charts.donut.render();
                            }
                        }
                    });
                },

                renderDestinationsChart(data) {
                    if (!data || !data.series) return;

                    var options = {
                        series: [{ name: 'Visits', data: data.series }],
                        chart: { type: 'bar', height: 280, fontFamily: 'inherit', toolbar: { show: false } },
                        plotOptions: { bar: { horizontal: true, borderRadius: 4, distributed: true } },
                        colors: ['#047857', '#059669', '#10b981', '#34d399', '#6ee7b7'], // Gradient emeralds
                        dataLabels: { enabled: true, textAnchor: 'start', style: { colors: ['#fff'] }, formatter: function (val, opt) { return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val }, offsetX: 0, dropShadow: { enabled: false } },
                        xaxis: { categories: data.categories },
                        yaxis: { labels: { show: false } }, // Hide Y labels since they are in the bar
                        tooltip: { theme: 'light' },
                        legend: { show: false }
                    };

                    requestAnimationFrame(() => {
                        if (this.charts.destinations) {
                            this.charts.destinations.updateOptions(options);
                        } else {
                            const container = document.querySelector("#destinationsChart");
                            if (container) {
                                this.charts.destinations = new ApexCharts(container, options);
                                this.charts.destinations.render();
                            }
                        }
                    });
                },

                renderGauges(gaugesData) {
                    if (!gaugesData || gaugesData.length === 0) return;

                    const container = document.querySelector("#gaugesContainer");
                    if (!container) return;

                    if (this.charts.gauges.length > 0) {
                        this.charts.gauges.forEach(chart => chart.destroy());
                        this.charts.gauges = [];
                        container.innerHTML = '';
                    }

                    requestAnimationFrame(() => {
                        gaugesData.forEach((gauge, index) => {
                            const divId = `gauge-chart-${index}`;
                            const div = document.createElement('div');
                            div.id = divId;
                            div.className = 'w-full h-48';
                            container.appendChild(div);

                            var options = {
                                series: [gauge.percentage],
                                chart: { type: 'radialBar', height: 220, fontFamily: 'inherit' },
                                plotOptions: {
                                    radialBar: {
                                        startAngle: -90, endAngle: 90, track: { background: "#e7e7e7", strokeWidth: '97%', margin: 5 },
                                        dataLabels: { name: { show: false }, value: { offsetY: -2, fontSize: '22px' } }
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'light', shadeIntensity: 0.4, inverseColors: false, opacityFrom: 1, opacityTo: 1,
                                        stops: [0, 50, 53, 91],
                                        colorStops: [
                                            { offset: 0, color: '#10b981', opacity: 1 }, // Green
                                            { offset: 70, color: '#f59e0b', opacity: 1 }, // Yellow
                                            { offset: 90, color: '#ef4444', opacity: 1 }  // Red
                                        ]
                                    }
                                },
                                labels: [gauge.name],
                                title: { text: gauge.name, align: 'center', margin: 0, style: { fontSize: '13px', fontWeight: 'bold', color: '#374151' } }
                            };

                            const chart = new ApexCharts(document.querySelector(`#${divId}`), options);
                            chart.render();
                            this.charts.gauges.push(chart);
                        });
                    });
                }
            }));
        });
    </script>
</x-app-layout>