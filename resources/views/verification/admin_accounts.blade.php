<x-app-layout>
    @push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.4s ease-out forwards;
        }
        .admin-card-hover {
            transition: all 0.3s ease-in-out !important;
        }
        .admin-card-hover:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.03) !important;
            border-color: #cbd5e1 !important;
        }

        /* Prevent printing and screen-capture of protected ID documents */
        @media print {
            .id-protected-media,
            .id-viewport-container,
            .id-watermark-overlay,
            img[alt*="ID Photo"],
            img[alt*="ID Document"],
            img[alt*="Uploaded ID"] {
                display: none !important;
                visibility: hidden !important;
            }
        }

        .id-protected-media {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            -webkit-user-drag: none !important;
            -khtml-user-drag: none !important;
            -moz-user-drag: none !important;
            -o-user-drag: none !important;
            user-drag: none !important;
            -webkit-touch-callout: none !important;
            pointer-events: none !important;
        }

        .id-watermark-overlay {
            background-image: repeating-linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.025),
                rgba(255, 255, 255, 0.025) 45px,
                rgba(0, 0, 0, 0.06) 45px,
                rgba(0, 0, 0, 0.06) 90px
            );
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
<<<<<<< Updated upstream
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-shield-check text-2xl text-green-700"></i>
                Verify Tourists
=======
            <h2 class="font-display font-normal text-2xl sm:text-3xl text-slate-900 tracking-wide flex items-center gap-3">
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </span>
                <span>Verify Tourists</span>
>>>>>>> Stashed changes
            </h2>
        </div>
    </x-slot>

<<<<<<< Updated upstream
    <div class="pb-12 pt-0 animate-fade-in-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
=======
    <div class="pb-12 pt-4">
        <div class="max-w-full 2xl:max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
>>>>>>> Stashed changes

            {{-- Error Alerts --}}
            @if ($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 rounded-2xl px-4 py-3 text-sm shadow-sm flex items-start gap-2">
                <svg class="w-5 h-5 text-rose-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <!-- Sub-Navigation Tabs -->
            <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-2 -mb-2 border-b border-slate-200 no-scrollbar whitespace-nowrap">
                <a href="{{ route('verification.reviews') }}" aria-label="ID Verification Reviews"
<<<<<<< Updated upstream
                   class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.reviews') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-checklist md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">ID Verification Reviews</span>
                </a>
                <a href="{{ route('verification.accounts') }}" aria-label="Verify Tourists"
                   class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.accounts') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-users md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                   class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.staff') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-cog md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                   class="flex items-center justify-center h-11 px-4 py-2 md:h-auto md:w-auto text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('verification.add_account') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-user-plus md:mr-1 text-lg md:text-base"></i> <span class="hidden md:inline">Add Account</span>
=======
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.reviews') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    <span>ID Verification Reviews</span>
                </a>
                <a href="{{ route('verification.accounts') }}" aria-label="Verify Tourists"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.accounts') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.staff') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.add_account') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Add Account</span>
>>>>>>> Stashed changes
                </a>
            </div>

            <div class="space-y-6" x-data="{
                searchQuery: '',
                statusFilter: 'all',
                compareModalOpen: false,
                selectedTourist: null,
                zoomLevel: 1,
                rotation: 0,
                panX: 0,
                panY: 0,
                isDragging: false,
                startX: 0,
                startY: 0,
                initialTouchDist: null,
                initialZoom: 1,
                copied: false,
                windowBlurred: false,
                screenshotAlert: false,
                openCompareModal(tourist) {
                    this.selectedTourist = tourist;
                    this.zoomLevel = 1;
                    this.rotation = 0;
                    this.panX = 0;
                    this.panY = 0;
                    this.isDragging = false;
                    this.copied = false;
                    this.windowBlurred = false;
                    this.screenshotAlert = false;
                    this.compareModalOpen = true;
                    document.body.style.overflow = 'hidden';
                },
                closeCompareModal() {
                    this.compareModalOpen = false;
                    this.selectedTourist = null;
                    this.panX = 0;
                    this.panY = 0;
                    this.isDragging = false;
                    this.windowBlurred = false;
                    this.screenshotAlert = false;
                    document.body.style.overflow = '';
                },
                zoomIn() {
                    if (this.zoomLevel < 4.5) this.zoomLevel = +(this.zoomLevel + 0.25).toFixed(2);
                },
                zoomOut() {
                    if (this.zoomLevel > 0.5) {
                        this.zoomLevel = +(this.zoomLevel - 0.25).toFixed(2);
                        if (this.zoomLevel <= 1) {
                            this.panX = 0;
                            this.panY = 0;
                        }
                    }
                },
                resetZoom() {
                    this.zoomLevel = 1;
                    this.rotation = 0;
                    this.panX = 0;
                    this.panY = 0;
                },
                rotate() {
                    this.rotation = (this.rotation + 90) % 360;
                },
                handleWheel(e) {
                    const delta = e.deltaY > 0 ? -0.15 : 0.15;
                    const newZoom = Math.min(4.5, Math.max(0.5, +(this.zoomLevel + delta).toFixed(2)));
                    this.zoomLevel = newZoom;
                    if (this.zoomLevel <= 1) {
                        this.panX = 0;
                        this.panY = 0;
                    }
                },
                startDrag(e) {
                    if (e.button !== 0) return;
                    this.isDragging = true;
                    this.startX = e.clientX - this.panX;
                    this.startY = e.clientY - this.panY;
                },
                onDrag(e) {
                    if (!this.isDragging) return;
                    this.panX = e.clientX - this.startX;
                    this.panY = e.clientY - this.startY;
                },
                endDrag() {
                    this.isDragging = false;
                },
                startTouch(e) {
                    if (e.touches.length === 1) {
                        this.isDragging = true;
                        this.startX = e.touches[0].clientX - this.panX;
                        this.startY = e.touches[0].clientY - this.panY;
                    } else if (e.touches.length === 2) {
                        this.isDragging = false;
                        const dx = e.touches[0].clientX - e.touches[1].clientX;
                        const dy = e.touches[0].clientY - e.touches[1].clientY;
                        this.initialTouchDist = Math.hypot(dx, dy);
                        this.initialZoom = this.zoomLevel;
                    }
                },
                onTouchMove(e) {
                    if (e.touches.length === 1 && this.isDragging) {
                        this.panX = e.touches[0].clientX - this.startX;
                        this.panY = e.touches[0].clientY - this.startY;
                    } else if (e.touches.length === 2 && this.initialTouchDist) {
                        const dx = e.touches[0].clientX - e.touches[1].clientX;
                        const dy = e.touches[0].clientY - e.touches[1].clientY;
                        const currentDist = Math.hypot(dx, dy);
                        const factor = currentDist / this.initialTouchDist;
                        this.zoomLevel = Math.min(4.5, Math.max(0.5, +(this.initialZoom * factor).toFixed(2)));
                    }
                },
                endTouch() {
                    this.isDragging = false;
                    this.initialTouchDist = null;
                },
                copyIdNumber() {
                    if (this.selectedTourist && this.selectedTourist.id_number) {
                        navigator.clipboard.writeText(this.selectedTourist.id_number);
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                    }
                },
                initAntiCapture() {
                    const blockCapture = (e) => {
                        const key = (e.key || '').toLowerCase();
                        const isCaptureKey = 
                            e.key === 'PrintScreen' || 
                            e.keyCode === 44 || 
                            e.code === 'PrintScreen' ||
                            ((e.ctrlKey || e.metaKey) && e.shiftKey && (key === 's' || key === 'i' || key === 'c' || key === 'p' || key === '3' || key === '4' || key === '5')) ||
                            ((e.ctrlKey || e.metaKey) && (key === 'p' || key === 's' || key === 'u')) ||
                            (e.altKey && (key === 'printscreen' || key === 's'));

                        if (isCaptureKey) {
                            e.preventDefault();
                            e.stopPropagation();
                            e.stopImmediatePropagation();
                            if (this.compareModalOpen) {
                                this.windowBlurred = true;
                                setTimeout(() => {
                                    if (document.hasFocus()) this.windowBlurred = false;
                                }, 2000);
                            }
                            if (navigator.clipboard && navigator.clipboard.writeText) {
                                try { navigator.clipboard.writeText(''); } catch (_) {}
                            }
                            this.screenshotAlert = true;
                            setTimeout(() => { this.screenshotAlert = false; }, 4000);
                            return false;
                        }
                    };

                    window.addEventListener('keydown', blockCapture, { capture: true });
                    window.addEventListener('keyup', blockCapture, { capture: true });

                    document.addEventListener('visibilitychange', () => {
                        if (this.compareModalOpen && (document.hidden || document.visibilityState !== 'visible')) {
                            this.windowBlurred = true;
                        }
                    });

                    window.addEventListener('blur', () => {
                        if (this.compareModalOpen) {
                            this.windowBlurred = true;
                        }
                    });

                    window.addEventListener('focus', () => {
                        this.windowBlurred = false;
                    });
                }
            }"
            x-init="initAntiCapture()"
            @keydown.window.escape="closeCompareModal()">
                <div class="seamless-table-card">

                    <!-- Seamless Ledger Header -->
                    <div class="seamless-table-header">
                        <div class="seamless-table-title-group">
                            <div class="seamless-table-icon">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="seamless-table-title">Registered Accounts & Identity Roster</div>
                                <div class="seamless-table-subtitle">{{ count($allUsers) }} user records in ledger</div>
                            </div>
                        </div>

<<<<<<< Updated upstream
                        <!-- Status Filter Pill Buttons -->
                        <div class="flex items-center gap-2 flex-wrap justify-end">
                            <span class="text-xs font-semibold text-gray-400 mr-0.5">Filter:</span>

                            <button type="button" @click="statusFilter = 'all'"
                                :class="statusFilter === 'all' ? 'bg-gray-700 text-white shadow-sm' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-list text-xs"></i> All
                            </button>

                            <button type="button" @click="statusFilter = 'verified'"
                                :class="statusFilter === 'verified' ? 'bg-green-600 text-white shadow-sm' : 'bg-white text-green-700 border border-green-200 hover:bg-green-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-discount-check text-xs"></i> Verified
                            </button>

                            <button type="button" @click="statusFilter = 'pending'"
                                :class="statusFilter === 'pending' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-amber-600 border border-amber-200 hover:bg-amber-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-clock-hour-4 text-xs"></i> Pending
                            </button>

                            <button type="button" @click="statusFilter = 'rejected'"
                                :class="statusFilter === 'rejected' ? 'bg-red-600 text-white shadow-sm' : 'bg-white text-red-600 border border-red-200 hover:bg-red-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-circle-x text-xs"></i> Rejected
                            </button>

                            <button type="button" @click="statusFilter = 'unverified'"
                                :class="statusFilter === 'unverified' ? 'bg-gray-500 text-white shadow-sm' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50'"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold transition-all duration-150">
                                <i class="ti ti-help text-xs"></i> Unverified
                            </button>
=======
                        <!-- Search and Status Filter Bar -->
                        <div class="flex flex-col sm:flex-row gap-2.5 items-stretch sm:items-center">
                            <!-- Search Bar -->
                            <div class="relative w-full sm:w-64 group">
                                <span class="absolute inset-y-0 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors duration-200" style="left: 12px;">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </span>
                                <input type="text" x-model="searchQuery" id="tourist-search" placeholder="Search by name or email…" style="padding-left: 2.5rem;" class="w-full pr-8 py-1.5 border border-stone-300 rounded-xl text-xs sm:text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 bg-white placeholder-slate-400 transition-all duration-200" />
                                <!-- Clear button -->
                                <button type="button" x-show="searchQuery.length > 0" x-transition @click="searchQuery = ''" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-rose-500 transition-colors duration-150 cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Status Filter Controls -->
                            <div class="inline-flex items-center p-1 bg-stone-100 rounded-xl border border-stone-200 gap-1">
                                <button type="button" @click="statusFilter = 'all'"
                                    :class="statusFilter === 'all' 
                                        ? 'bg-slate-900 text-white shadow-xs' 
                                        : 'bg-transparent text-slate-600 hover:text-slate-900'"
                                    :style="statusFilter === 'all' ? 'background-color: #0f172a !important; color: #ffffff !important;' : ''"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold transition cursor-pointer">
                                    <span>All</span>
                                </button>

                                <button type="button" @click="statusFilter = 'verified'"
                                    :class="statusFilter === 'verified' 
                                        ? 'bg-emerald-600 text-white shadow-xs' 
                                        : 'bg-transparent text-emerald-700 hover:bg-emerald-100/60'"
                                    :style="statusFilter === 'verified' ? 'background-color: #059669 !important; color: #ffffff !important;' : ''"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold transition cursor-pointer">
                                    <span>Verified</span>
                                </button>

                                <button type="button" @click="statusFilter = 'pending'"
                                    :class="statusFilter === 'pending' 
                                        ? 'bg-amber-500 text-white shadow-xs' 
                                        : 'bg-transparent text-amber-700 hover:bg-amber-100/60'"
                                    :style="statusFilter === 'pending' ? 'background-color: #d97706 !important; color: #ffffff !important;' : ''"
                                    class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold transition cursor-pointer">
                                    <span>Pending</span>
                                </button>
                            </div>
>>>>>>> Stashed changes
                        </div>
                    </div>

                    <div class="overflow-x-auto relative">
                        <table class="seamless-table">
                            <thead>
                                <tr>
                                    <th class="text-left">Name / Email</th>
                                    <th class="text-left">Role</th>
                                    <th class="text-left">Identity Details</th>
                                    <th class="text-left">Status</th>
                                    <th class="text-center">Match %</th>
                                    <th class="text-left">Verification Notes</th>
                                    <th class="text-left min-w-[200px]">Action / Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allUsers as $user)
                                <tr x-show="(statusFilter === 'all' || '{{ $user->id_verification_status }}' === statusFilter) && 
                                            (searchQuery === '' || '{{ strtolower(addslashes($user->name . ' ' . $user->last_name)) }}'.includes(searchQuery.toLowerCase()) || '{{ strtolower(addslashes($user->email)) }}'.includes(searchQuery.toLowerCase()))">
                                    
                                    {{-- Name & Contact --}}
                                    <td class="px-4 py-3.5 align-top">
                                        @php
                                            $displayName = $user->fullName();
                                        @endphp
                                        <p class="font-bold text-slate-800 text-sm leading-snug">{{ $displayName }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <span class="truncate max-w-[180px]">{{ $user->email }}</span>
                                        </p>
                                        @if($user->contact)
                                        <p class="text-xs text-slate-500 inline-flex items-center gap-1.5 mt-0.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <span>{{ $user->contact }}</span>
                                        </p>
                                        @endif
                                    </td>

                                    {{-- Role --}}
                                    <td class="px-3 py-3.5 align-top">
                                        @if($user->isAdmin())
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-rose-50 text-rose-700 border border-rose-200 uppercase whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                </svg>
                                                Admin
                                            </span>
                                        @elseif($user->isStaff())
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 uppercase whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Staff
                                            </span>
                                        @elseif($user->isTourist())
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200 uppercase whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                                Tourist
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-slate-50 text-slate-700 border border-slate-200 uppercase whitespace-nowrap">
                                                {{ $user->role }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Identity Details --}}
                                    <td class="px-4 py-3.5 align-top text-xs text-slate-600" x-data="{ showDetails: false }">
                                        @if($user->isTourist())
                                            <div class="space-y-1.5">
                                                {{-- ID Type & Eye Toggle Header --}}
                                                <div class="flex items-center justify-between gap-2 pb-0.5 border-b border-slate-100">
                                                    <span class="flex items-center gap-1 text-slate-800 font-semibold whitespace-nowrap">
                                                        <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                        </svg>
                                                        <span><strong class="text-slate-500 font-medium">Type:</strong> {{ $user->id_type ?? 'ID' }}</span>
                                                    </span>
                                                    <button type="button" 
                                                            @click="showDetails = !showDetails" 
                                                            :title="showDetails ? 'Hide identity details' : 'Show identity details'"
                                                            class="p-1 rounded text-slate-400 hover:text-emerald-700 hover:bg-slate-100 transition cursor-pointer shrink-0">
                                                        {{-- Eye Icon (When Hidden) --}}
                                                        <svg x-show="!showDetails" class="w-3.5 h-3.5 text-slate-400 hover:text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        {{-- Eye-Slash Icon (When Shown) --}}
                                                        <svg x-show="showDetails" class="w-3.5 h-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                                        </svg>
                                                    </button>
                                                </div>

                                                {{-- ID Number --}}
                                                <p class="flex items-center gap-1.5 text-xs whitespace-nowrap">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                    </svg>
                                                    <strong class="text-slate-500 font-medium">No:</strong> 
                                                    <span x-show="showDetails" class="text-slate-800 font-semibold">{{ $user->id_number ?? 'None' }}</span>
                                                    <span x-show="!showDetails" class="tracking-widest font-mono text-slate-400">••••••••</span>
                                                </p>

                                                {{-- DOB & Age --}}
                                                <p class="flex items-center gap-1.5 text-xs whitespace-nowrap">
                                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    <strong class="text-slate-500 font-medium">DOB:</strong> 
                                                    <span x-show="showDetails" class="text-slate-800 font-semibold">
                                                        {{ $user->dob ? $user->dob->format('M j, Y') : 'N/A' }} 
                                                        <span class="text-slate-400 font-normal">({{ $user->age }})</span>
                                                    </span>
                                                    <span x-show="!showDetails" class="tracking-widest font-mono text-slate-400">••••••••</span>
                                                </p>

                                                @if($user->id_photo)
                                                <div class="pt-1">
                                                    <button type="button"
                                                        @click="openCompareModal({{ Js::from([
                                                            'id' => $user->id,
                                                            'name' => $user->name,
                                                            'full_name' => $user->fullName(),
                                                            'email' => $user->email,
                                                            'contact' => $user->contact ?? 'Not provided',
                                                            'classification' => $user->classification ?? 'Regular',
                                                            'id_type' => $user->id_type ?? 'ID Document',
                                                            'id_number' => $user->id_number ?? 'Not provided',
                                                            'dob' => $user->dob ? $user->dob->format('M d, Y') : 'Not provided',
                                                            'age' => $user->age,
                                                            'gender' => $user->gender ?? 'Not specified',
                                                            'id_photo_url' => Storage::url($user->id_photo),
                                                            'score' => $user->id_verification_score !== null ? round($user->id_verification_score) : null,
                                                            'notes' => $user->id_verification_notes ?? '',
                                                            'notes_array' => $user->id_verification_notes ? array_values(array_filter(array_map('trim', explode('|', $user->id_verification_notes)))) : [],
                                                            'ocr_processing_ms' => $user->ocr_processing_ms,
                                                            'ready_to_complete_requirements' => (bool)$user->ready_to_complete_requirements,
                                                            'status' => $user->id_verification_status,
                                                            'auto_verify_url' => route('admin.accounts.auto_verify', $user),
                                                            'decide_url' => route('verification.decide', $user),
                                                        ]) }})"
                                                        title="Compare declared details side-by-side with ID photo"
                                                        class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 rounded text-[11px] font-bold shadow-2xs transition cursor-pointer">
                                                        <svg class="w-3 h-3 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                                        </svg>
                                                        <span>Compare Photo</span>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        @elseif($user->isStaff() && $user->assignedDestination)
                                            <p class="text-emerald-700 font-semibold text-xs inline-flex items-center gap-1.5 whitespace-nowrap">
                                                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $user->assignedDestination->name }}
                                            </p>
                                        @else
                                            <span class="text-slate-400 italic text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-3 py-3.5 align-top">
                                        @php
                                            $st = $user->id_verification_status;
                                            $badgeClasses = 'bg-slate-100 text-slate-800 border-slate-200';
                                            if ($st === 'verified') {
                                                $badgeClasses = 'bg-emerald-100 text-emerald-800 border-emerald-200';
                                            } elseif ($st === 'pending') {
                                                $badgeClasses = 'bg-amber-100 text-amber-800 border-amber-200';
                                            } elseif ($st === 'rejected') {
                                                $badgeClasses = 'bg-rose-100 text-rose-800 border-rose-200';
                                            }
                                        @endphp
                                        <div class="flex flex-col items-start gap-1">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold uppercase border shadow-xs whitespace-nowrap {{ $badgeClasses }}">
                                                @if($st === 'verified')
                                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @elseif($st === 'pending')
                                                    <svg class="w-3.5 h-3.5 text-amber-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-3.5 h-3.5 text-rose-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @endif
                                                {{ $st }}
                                            </span>
                                            @if($user->is_manually_verified)
                                            <span class="inline-flex items-center gap-1 text-xs text-emerald-800 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 whitespace-nowrap">
                                                <svg class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Manual
                                            </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Dedicated Match % Column --}}
                                    <td class="px-3 py-3.5 align-top text-center">
                                        @if($user->id_verification_score !== null)
                                            @php
                                                $score = round($user->id_verification_score);
                                                if ($score >= 80) {
                                                    $scoreBadge = 'bg-emerald-50 text-emerald-800 border-emerald-300';
                                                    $scoreBar = 'bg-emerald-500';
                                                } elseif ($score >= 50) {
                                                    $scoreBadge = 'bg-amber-50 text-amber-800 border-amber-300';
                                                    $scoreBar = 'bg-amber-500';
                                                } else {
                                                    $scoreBadge = 'bg-rose-50 text-rose-800 border-rose-300';
                                                    $scoreBar = 'bg-rose-500';
                                                }
                                            @endphp
                                            <div class="inline-flex flex-col items-center gap-1">
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-black border shadow-2xs whitespace-nowrap {{ $scoreBadge }}">
                                                    @if($score >= 80)
                                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    @endif
                                                    {{ $score }}%
                                                </span>
                                                <div class="w-14 h-1.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                                    <div class="h-full rounded-full {{ $scoreBar }}" style="width: {{ min(100, $score) }}%"></div>
                                                </div>
                                            </div>
                                        @elseif($user->is_manually_verified)
                                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full border border-slate-200 whitespace-nowrap">
                                                Manual
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Verification Notes --}}
                                    <td class="px-4 py-3.5 align-top min-w-[200px] max-w-[280px]">
                                        @if($user->id_verification_notes)
                                            @php
                                                $notesList = explode('|', $user->id_verification_notes);
                                            @endphp
                                            @if(count($notesList) > 1)
                                                <div class="space-y-1 text-xs">
                                                    @foreach($notesList as $noteItem)
                                                        @php $noteItem = trim($noteItem); @endphp
                                                        @if($noteItem)
                                                        <div class="flex items-start gap-1.5 text-slate-600 leading-snug">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                                                            <span>{{ $noteItem }}</span>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-xs text-slate-600 leading-relaxed">{{ $user->id_verification_notes }}</p>
                                            @endif
                                        @else
                                            <span class="text-slate-400 italic text-xs">—</span>
                                        @endif
                                    </td>

                                    {{-- Action / Update --}}
                                    <td class="px-4 py-3.5 align-top">
                                        @if($user->id !== auth()->id())
                                        <div class="space-y-1.5">
                                            @if($user->id_photo && $user->id_verification_status !== 'verified')
                                            <form method="POST" action="{{ route('admin.accounts.auto_verify', $user) }}">
                                                @csrf
                                                <button type="submit" title="Scan ID photo with OCR and auto-approve if valid" class="w-full text-center px-2.5 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-xl text-xs font-bold shadow-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                                                    <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                    <span>Auto-Verify (OCR)</span>
                                                </button>
                                            </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.accounts.update_status', $user) }}" class="space-y-1.5" x-data="{ showStatusDropdown: false, activeStatus: '{{ $st }}' }">
                                                @csrf
                                                <input type="hidden" name="status" :value="activeStatus" />
                                                <div class="flex items-center gap-1.5 relative">
                                                    <!-- Dropdown Trigger Button -->
                                                    <button type="button" @click="showStatusDropdown = !showStatusDropdown" @click.away="showStatusDropdown = false" class="flex justify-between items-center w-26 rounded-xl border border-slate-300 shadow-sm bg-white px-2.5 py-1 text-xs text-slate-700 font-semibold hover:bg-slate-50 transition focus:outline-none focus:ring-1 focus:ring-emerald-500">
                                                        <span x-text="activeStatus.charAt(0).toUpperCase() + activeStatus.slice(1)"></span>
                                                        <svg class="h-3.5 w-3.5 text-slate-400 transform transition-transform duration-200 shrink-0 ml-1" :class="showStatusDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
<<<<<<< Updated upstream
                                                    <button type="button" @click="activeStatus = 'pending'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Pending
                                                    </button>
                                                    <button type="button" @click="activeStatus = 'rejected'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Reject
                                                    </button>
                                                    <button type="button" @click="activeStatus = 'unverified'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-green-50/40 hover:text-green-950 transition-colors">
                                                        Unverify
=======

                                                    <!-- Dropdown Menu -->
                                                    <div x-show="showStatusDropdown" 
                                                         x-transition:enter="transition ease-out duration-150"
                                                         x-transition:enter-start="opacity-0 scale-95"
                                                         x-transition:enter-end="opacity-100 scale-100"
                                                         x-transition:leave="transition ease-in duration-100"
                                                         x-transition:leave-start="opacity-100 scale-100"
                                                         x-transition:leave-end="opacity-0 scale-95"
                                                         class="absolute left-0 bottom-full mb-1.5 z-30 w-28 rounded-xl bg-white border border-slate-200 shadow-xl py-1 max-h-36 overflow-y-auto"
                                                         style="display: none;">
                                                        <button type="button" @click="activeStatus = 'verified'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-emerald-50 hover:text-emerald-950 transition-colors font-medium">
                                                            Verify
                                                        </button>
                                                        <button type="button" @click="activeStatus = 'pending'; showStatusDropdown = false" class="w-full text-left px-3 py-1.5 text-xs hover:bg-amber-50 hover:text-amber-950 transition-colors font-medium">
                                                            Set Pending
                                                        </button>
                                                    </div>

                                                    <button type="submit" class="px-2.5 py-1 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-sm hover:shadow transition-all duration-150 flex items-center gap-1 cursor-pointer">
                                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                                        </svg>
                                                        <span>Update</span>
>>>>>>> Stashed changes
                                                    </button>
                                                </div>
                                                <input type="text" name="notes" placeholder="Optional notes…" class="w-full text-xs border border-slate-200 rounded-xl px-2.5 py-1.5 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 bg-white placeholder-slate-400 transition" />
                                            </form>
                                        </div>
                                        @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs text-slate-400 italic bg-slate-50 border border-slate-200 rounded-xl">
                                            <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            Protected
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ======================================================== --}}
                {{-- MANUAL ID COMPARISON & VERIFICATION MODAL                --}}
                {{-- ======================================================== --}}
                <div x-show="compareModalOpen" x-cloak
                     class="fixed inset-0 z-50 overflow-y-auto bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-2 sm:p-4 md:p-6"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">

                    {{-- Modal Card --}}
                    <div class="relative w-full max-w-6xl bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col max-h-[92vh] my-auto"
                         @click.away="closeCompareModal()"
                         x-transition:enter="transition ease-out duration-200 transform"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150 transform"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95">

                        {{-- Modal Header --}}
                        <div class="px-5 py-4 sm:px-6 sm:py-4.5 bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 text-white flex items-center justify-between shrink-0 border-b border-emerald-800/40">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center shrink-0 text-emerald-300 shadow-inner">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-black tracking-tight text-white flex items-center gap-2">
                                        <span>Manual Identity Verification</span>
                                        <span x-show="selectedTourist?.status === 'verified'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-200 border border-emerald-400/30 uppercase tracking-wider">Verified</span>
                                        <span x-show="selectedTourist?.status === 'pending'" class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-200 border border-amber-400/30 uppercase tracking-wider">Pending Review</span>
                                    </h3>
                                    <p class="text-xs text-emerald-200/80 mt-0.5">
                                        Cross-examine tourist registered details side-by-side with their uploaded photo ID document
                                    </p>
                                </div>
                            </div>

                            <button type="button" @click="closeCompareModal()"
                                class="p-2 rounded-xl text-emerald-200 hover:text-white hover:bg-white/10 transition cursor-pointer" title="Close modal (Esc)">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Modal Body: Split-Screen Comparison Grid --}}
                        <div class="p-4 sm:p-6 overflow-y-auto flex-1 bg-slate-50/50 space-y-6">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                                
                                {{-- LEFT COLUMN: ID PHOTO DOCUMENT VIEWER (7 cols) --}}
                                <div class="lg:col-span-7 space-y-3">
                                    <div class="flex items-center justify-between gap-2 bg-white px-3.5 py-2 rounded-xl border border-slate-200 shadow-2xs">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                            <span class="text-xs font-bold text-slate-800">Uploaded Document</span>
                                            <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200" x-text="selectedTourist?.id_type"></span>
                                        </div>

                                        {{-- Image Controls Toolbar (No external tab link, download disabled) --}}
                                        <div class="flex items-center gap-1">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-[10px] font-bold text-slate-600 border border-slate-200 mr-1">
                                                <svg class="w-3 h-3 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                                <span>Secure View</span>
                                            </span>
                                            <button type="button" @click="zoomOut()" title="Zoom Out"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                                                -
                                            </button>
                                            <span class="text-[11px] font-mono font-bold text-slate-600 px-1.5 min-w-[42px] text-center" x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                            <button type="button" @click="zoomIn()" title="Zoom In"
                                                class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition cursor-pointer">
                                                +
                                            </button>
                                            <button type="button" @click="resetZoom()" title="Reset Zoom & Rotation"
                                                class="px-2 h-7 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold transition cursor-pointer ml-0.5">
                                                1:1
                                            </button>
                                            <button type="button" @click="rotate()" title="Rotate 90°"
                                                class="p-1.5 h-7 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 transition cursor-pointer" title="Rotate">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Photo Display Box (Interactive Mouse & Hand/Touch Zoom & Pan, Zero top-layer shadows) --}}
                                    <div class="id-viewport-container bg-slate-900 rounded-2xl border border-slate-700/80 p-2 min-h-[380px] sm:min-h-[440px] max-h-[520px] flex items-center justify-center overflow-hidden relative select-none cursor-grab active:cursor-grabbing"
                                         @wheel.prevent="handleWheel($event)"
                                         @mousedown="startDrag($event)"
                                         @mousemove="onDrag($event)"
                                         @mouseup="endDrag()"
                                         @mouseleave="endDrag()"
                                         @touchstart="startTouch($event)"
                                         @touchmove="onTouchMove($event)"
                                         @touchend="endTouch()"
                                         @contextmenu.prevent
                                         @dragstart.prevent>

                                        <template x-if="selectedTourist?.id_photo_url && !windowBlurred">
                                            <img :src="selectedTourist?.id_photo_url" alt="Tourist ID Document"
                                                @contextmenu.prevent
                                                @dragstart.prevent
                                                class="id-protected-media max-h-[460px] max-w-full object-contain rounded transition-transform duration-75 ease-out shadow-md pointer-events-none select-none"
                                                :style="'transform: translate(' + panX + 'px, ' + panY + 'px) scale(' + zoomLevel + ') rotate(' + rotation + 'deg); transform-origin: center center;'" />
                                        </template>

                                        <template x-if="!selectedTourist?.id_photo_url">
                                            <div class="text-center text-slate-400 py-12">
                                                <svg class="w-12 h-12 mx-auto mb-2 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <p class="text-xs">No ID photo document available</p>
                                            </div>
                                        </template>

                                        {{-- Privacy/Screenshot Blur Guard Overlay (Activates only when window loses focus during capture/switch) --}}
                                        <div x-show="windowBlurred" x-cloak
                                             class="absolute inset-0 z-30 bg-slate-950/95 backdrop-blur-xl flex flex-col items-center justify-center p-6 text-center text-slate-300">
                                            <div class="w-12 h-12 rounded-2xl bg-amber-500/20 border border-amber-400/30 flex items-center justify-center mb-3 text-amber-400 shadow-inner">
                                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="text-sm font-black text-white">Privacy Protection Active</p>
                                            <p class="text-xs text-slate-400 mt-1 max-w-xs leading-relaxed">
                                                ID viewing is hidden while window focus is lost or screen-capture tool is active. Click back into this window to resume viewing.
                                            </p>
                                        </div>

                                        {{-- Screenshot Intercept Alert Banner --}}
                                        <div x-show="screenshotAlert" x-cloak
                                             x-transition:enter="transition ease-out duration-150"
                                             x-transition:enter-start="opacity-0 -translate-y-2"
                                             x-transition:enter-end="opacity-100 translate-y-0"
                                             x-transition:leave="transition ease-in duration-150"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             class="absolute top-3 inset-x-3 z-40 bg-rose-900/95 text-white border border-rose-500/80 rounded-xl p-3 shadow-2xl flex items-center gap-2.5 text-xs font-semibold">
                                            <svg class="w-4 h-4 text-rose-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                            <span>Screen capture restricted: Screenshots of sensitive identity documents are blocked for data privacy compliance.</span>
                                        </div>

                                        {{-- Zoom level overlay pill & Drag Hint --}}
                                        <div class="absolute bottom-3 left-3 z-20 flex items-center gap-2">
                                            <div class="bg-black/70 backdrop-blur-xs text-white text-[10px] font-mono px-2 py-0.5 rounded-full border border-white/10 shadow-xs">
                                                Zoom: <span x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                            </div>
                                            <div x-show="zoomLevel > 1" class="hidden sm:block bg-black/60 backdrop-blur-xs text-emerald-300 text-[10px] px-2 py-0.5 rounded-full border border-emerald-400/20">
                                                <span>✋ Drag to pan</span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-[11px] text-slate-500 text-center flex items-center justify-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" /></svg>
                                        <span>Scroll mouse wheel or pinch to zoom. Click & drag to pan around the document.</span>
                                    </p>
                                </div>

                                {{-- RIGHT COLUMN: DECLARED DETAILS & OCR RESULTS (5 cols) --}}
                                <div class="lg:col-span-5 space-y-4">
                                    
                                    {{-- Declared Information Card --}}
                                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-sm space-y-3.5">
                                        <div class="flex items-center justify-between pb-2.5 border-b border-slate-100">
                                            <div class="flex items-center gap-2">
                                                <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                                </div>
                                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-800">Declared Registration Profile</h4>
                                            </div>
                                            <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-200" x-text="selectedTourist?.classification || 'Regular'"></span>
                                        </div>

                                        {{-- Full Name --}}
                                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80">
                                            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Declared Full Name</div>
                                            <div class="text-sm font-black text-slate-900 mt-0.5 flex items-center justify-between">
                                                <span x-text="selectedTourist?.full_name"></span>
                                            </div>
                                            <div class="text-[11px] text-slate-500 mt-0.5" x-text="selectedTourist?.email"></div>
                                        </div>

                                        {{-- ID Type & ID Number --}}
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">ID Type</span>
                                                <span class="text-xs font-bold text-slate-800 mt-0.5 block" x-text="selectedTourist?.id_type"></span>
                                            </div>

                                            <div class="p-2.5 bg-emerald-50/60 rounded-xl border border-emerald-200/80 relative">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider">Declared ID No.</span>
                                                    <button type="button" @click="copyIdNumber()" class="text-[10px] font-bold text-emerald-700 hover:text-emerald-900 cursor-pointer flex items-center gap-0.5" title="Copy ID number">
                                                        <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                                                    </button>
                                                </div>
                                                <span class="text-xs font-mono font-black text-emerald-950 mt-0.5 block select-all tracking-wide" x-text="selectedTourist?.id_number"></span>
                                            </div>
                                        </div>

                                        {{-- Date of Birth & Age --}}
                                        <div class="grid grid-cols-2 gap-2.5">
                                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Date of Birth</span>
                                                <span class="text-xs font-bold text-slate-800 mt-0.5 block" x-text="selectedTourist?.dob"></span>
                                            </div>

                                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Computed Age</span>
                                                <span class="text-xs font-bold text-slate-800 mt-0.5 block" x-text="selectedTourist?.age ? selectedTourist?.age + ' years old' : 'N/A'"></span>
                                            </div>
                                        </div>

                                        {{-- Contact & Status --}}
                                        <div class="grid grid-cols-2 gap-2.5">
                                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Contact Phone</span>
                                                <span class="text-xs font-semibold text-slate-700 mt-0.5 block" x-text="selectedTourist?.contact"></span>
                                            </div>

                                            <div class="p-2.5 bg-slate-50 rounded-xl border border-slate-200/80">
                                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Requirements</span>
                                                <span class="text-xs font-bold mt-0.5 block"
                                                      :class="selectedTourist?.ready_to_complete_requirements ? 'text-emerald-700' : 'text-amber-700'"
                                                      x-text="selectedTourist?.ready_to_complete_requirements ? 'Ready to Complete' : 'Incomplete Requirements'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- OCR Engine Match Analysis Card --}}
                                    <div class="bg-white rounded-2xl border border-slate-200/90 p-4 shadow-sm space-y-3">
                                        <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="w-4 h-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                                <h4 class="text-xs font-black uppercase tracking-wider text-slate-800">OCR Engine Match Breakdown</h4>
                                            </div>
                                            <template x-if="selectedTourist?.score !== null">
                                                <span class="text-xs font-black px-2.5 py-0.5 rounded-full border shadow-2xs"
                                                      :class="selectedTourist.score >= 80 ? 'bg-emerald-50 text-emerald-800 border-emerald-300' : (selectedTourist.score >= 50 ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-rose-50 text-rose-800 border-rose-300')">
                                                    <span x-text="selectedTourist.score + '% Overall Match'"></span>
                                                </span>
                                            </template>
                                        </div>

                                        {{-- Notes breakdown list --}}
                                        <template x-if="selectedTourist?.notes_array && selectedTourist.notes_array.length > 0">
                                            <div class="space-y-1.5">
                                                <template x-for="(note, idx) in selectedTourist.notes_array" :key="idx">
                                                    <div class="flex items-start gap-2 text-xs leading-snug p-1.5 rounded-lg"
                                                         :class="note.includes('MATCH') && !note.includes('MISMATCH') ? 'bg-emerald-50/50 text-emerald-900' : (note.includes('MISMATCH') || note.includes('FAILED') ? 'bg-rose-50/60 text-rose-900' : 'bg-slate-50 text-slate-700')">
                                                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 shrink-0"
                                                              :class="note.includes('MATCH') && !note.includes('MISMATCH') ? 'bg-emerald-500' : (note.includes('MISMATCH') || note.includes('FAILED') ? 'bg-rose-500' : 'bg-amber-500')"></span>
                                                        <span class="font-medium" x-text="note"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        <template x-if="!selectedTourist?.notes_array || selectedTourist.notes_array.length === 0">
                                            <p class="text-xs text-slate-400 italic">No automated OCR breakdown notes available.</p>
                                        </template>

                                        <template x-if="selectedTourist?.ocr_processing_ms">
                                            <div class="text-[10px] font-mono text-slate-400 flex items-center gap-1 pt-1 border-t border-slate-100">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span>Pipeline processing time: <strong class="text-slate-600" x-text="selectedTourist.ocr_processing_ms < 1000 ? selectedTourist.ocr_processing_ms + 'ms' : (selectedTourist.ocr_processing_ms / 1000).toFixed(2) + 's'"></strong></span>
                                            </div>
                                        </template>
                                    </div>

                                    {{-- Manual Verification Guidelines Box --}}
                                    <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-3 text-xs text-amber-900 space-y-1">
                                        <div class="font-bold flex items-center gap-1.5 text-amber-950">
                                            <svg class="w-3.5 h-3.5 text-amber-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                            <span>Manual Review Checklist</span>
                                        </div>
                                        <ul class="list-disc pl-4 space-y-0.5 text-[11px] text-amber-900/90 leading-tight">
                                            <li>Verify photo ID matches the tourist's declared name and spelling</li>
                                            <li>Confirm ID Number on photo aligns with declared number</li>
                                            <li>Check Date of Birth matches demographic age requirements</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Modal Action Footer --}}
                        <div class="px-5 py-4 sm:px-6 bg-slate-100/90 border-t border-slate-200 flex flex-wrap items-center justify-between gap-3 shrink-0">
                            
                            {{-- Left Form Action: Auto-Verify OCR Re-run --}}
                            <div>
                                <form method="POST" :action="selectedTourist?.auto_verify_url">
                                    @csrf
                                    <button type="submit" title="Scan ID photo with OCR and auto-approve if valid"
                                        class="inline-flex items-center gap-1.5 px-3 py-2 bg-white hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 border border-slate-300 hover:border-emerald-300 rounded-xl text-xs font-bold shadow-2xs transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5 text-emerald-700 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                        <span>Re-run OCR Scan</span>
                                    </button>
                                </form>
                            </div>

                            {{-- Right Form Actions: Decision & Close --}}
                            <div class="flex flex-wrap items-center gap-2">
                                
                                {{-- Keep Pending / Request Resubmission Form --}}
                                <form method="POST" :action="selectedTourist?.decide_url" class="flex items-center gap-1.5">
                                    @csrf
                                    <input type="hidden" name="decision" value="pending">
                                    <input type="text" name="notes" placeholder="Notes for review…"
                                        class="text-xs border border-slate-300 rounded-xl px-3 py-2 w-40 sm:w-52 bg-white focus:border-amber-500 focus:ring-1 focus:ring-amber-500 placeholder-slate-400 transition" />
                                    <button type="submit"
                                        class="px-3 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition shadow-xs cursor-pointer whitespace-nowrap">
                                        Keep Pending
                                    </button>
                                </form>

                                {{-- Approve Form --}}
                                <form method="POST" :action="selectedTourist?.decide_url">
                                    @csrf
                                    <input type="hidden" name="decision" value="verified">
                                    <button type="submit"
                                        class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs sm:text-sm font-black transition shadow-xs flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        <span>Approve & Verify</span>
                                    </button>
                                </form>

                                <button type="button" @click="closeCompareModal()"
                                    class="px-3 py-2 bg-white hover:bg-slate-200 text-slate-700 border border-slate-300 rounded-xl text-xs font-semibold transition cursor-pointer">
                                    Close
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>