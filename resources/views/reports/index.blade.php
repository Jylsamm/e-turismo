<x-app-layout>
    @push('head')
    <style>
        .report-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .report-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -6px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.03);
            border-color: #cbd5e1;
        }

        /* ── High-Contrast Self-Contained Card Styles ─────────────── */
        .card-dark-hero {
            background-color: #0f172a !important;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #064e3b 100%) !important;
            color: #ffffff !important;
        }
        .kpi-dark-emerald {
            background-color: #064e3b !important;
            background: linear-gradient(135deg, #064e3b 0%, #022c22 100%) !important;
            color: #ffffff !important;
        }

        /* ── Modal Backdrop & Window ───────────────────────────────── */
        #report-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            align-items: center;
            justify-content: center;
            padding: 1.25rem;
            overflow-y: auto;
            opacity: 0;
            transition: opacity 0.2s ease-out;
        }
        #report-modal-backdrop.open {
            display: flex;
            opacity: 1;
        }
        #report-modal {
            background: #ffffff;
            border-radius: 1.25rem;
            width: 100%;
            max-width: 1100px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            max-height: 92vh;
            transform: scale(0.96);
            transition: transform 0.2s ease-out;
        }
        #report-modal-backdrop.open #report-modal {
            transform: scale(1);
        }
        #report-modal-body {
            overflow-y: auto;
            flex: 1;
            padding: 1.5rem 1.75rem;
            background: #f8fafc;
        }

        /* ── Modal Spinner ─────────────────────────────────────────── */
        #report-modal-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 280px;
            gap: 1rem;
            color: #475569;
        }
        #report-modal-spinner.hidden {
            display: none !important;
        }
        .modal-spinner-ring {
            width: 52px;
            height: 52px;
            border: 4px solid #e2e8f0;
            border-top-color: #059669;
            border-right-color: #10b981;
            border-radius: 50%;
            animation: spin 0.75s cubic-bezier(0.6, 0.2, 0.4, 0.8) infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Print Media Stylesheet ────────────────────────────────── */
        @media print {
            @page {
                size: landscape;
                margin: 8mm;
            }
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }
            body * {
                visibility: hidden !important;
            }
            #visitor-record-preview,
            #visitor-record-preview * {
                visibility: visible !important;
            }
            #visitor-record-preview {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
            }
            #report-modal-backdrop {
                display: block !important;
                position: static !important;
                background: none !important;
                padding: 0 !important;
            }
            #report-modal {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                max-height: none !important;
            }
            #report-modal-body {
                padding: 0 !important;
                background: transparent !important;
                overflow: visible !important;
            }
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </span>
                    <h1 class="text-2xl font-black tracking-tight text-slate-900">Reports &amp; Visitor Statistics</h1>
                </div>
                <p class="text-xs text-slate-500 mt-1">Official tourism arrivals, demographic breakdowns, and DOT compliance records.</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-slate-100 border border-slate-200 text-xs font-semibold text-slate-700">
                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ \Carbon\Carbon::parse($filters['date_from'])->format('M d, Y') }} &ndash; {{ \Carbon\Carbon::parse($filters['date_to'])->format('M d, Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="pb-12 pt-4 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-7">

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-900 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
        @endif

        {{-- ── 1. Smart Filter & Scope Card ──────────────────────────── --}}
        <div class="bg-white border border-slate-200/90 rounded-2xl shadow-sm p-6 sm:p-7 report-card">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5 pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter Reporting Scope
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">Select date range and destination to refine dashboard metrics and official records.</p>
                </div>

                {{-- Quick Presets --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-xs sm:text-sm font-bold text-slate-400 mr-1 uppercase tracking-wider">Presets:</span>
                    <button type="button" onclick="setFilterPreset('this_month')"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 transition cursor-pointer">
                        This Month
                    </button>
                    <button type="button" onclick="setFilterPreset('last_month')"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 transition cursor-pointer">
                        Last Month
                    </button>
                    <button type="button" onclick="setFilterPreset('last_30_days')"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 transition cursor-pointer">
                        Last 30 Days
                    </button>
                    <button type="button" onclick="setFilterPreset('this_year')"
                        class="px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-bold bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 text-slate-700 transition cursor-pointer">
                        This Year
                    </button>
                </div>
            </div>

            <form id="filter-form" method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                {{-- Destination --}}
                <div class="sm:col-span-5">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Destination / Spot</label>
                    <div class="relative">
                        <select id="filter-destination" name="destination_id"
                            class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm sm:text-base font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition cursor-pointer">
                            <option value="">All Municipal Attractions (Combined)</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ $filters['destination_id'] == $dest->id ? 'selected' : '' }}>
                                    {{ $dest->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Date From --}}
                <div class="sm:col-span-3">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Date From</label>
                    <input id="filter-date-from" type="date" name="date_from" value="{{ $filters['date_from'] }}" required
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm sm:text-base font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                </div>

                {{-- Date To --}}
                <div class="sm:col-span-3">
                    <label class="block text-xs sm:text-sm font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Date To</label>
                    <input id="filter-date-to" type="date" name="date_to" value="{{ $filters['date_to'] }}" required
                        class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-sm sm:text-base font-semibold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition">
                </div>

                {{-- Submit --}}
                <div class="sm:col-span-1 flex items-end">
                    <button type="submit"
                        class="w-full h-[48px] bg-slate-900 hover:bg-emerald-700 text-white rounded-xl font-bold text-base transition duration-200 flex items-center justify-center shadow-sm hover:shadow active:scale-95 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- ── 2. Unified KPI Summary Grid ───────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            
            {{-- Card 1: Actual Visitors (Physical Footfall) --}}
            <div class="kpi-dark-emerald text-white rounded-2xl p-5 sm:p-6 shadow-sm report-card relative overflow-hidden flex flex-col justify-between"
                style="background-color: #064e3b; background: linear-gradient(135deg, #064e3b 0%, #022c22 100%); color: #ffffff;">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-300">Actual Visitors</span>
                        <span class="p-2 rounded-xl bg-emerald-800/80 text-emerald-200 border border-emerald-700/50">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white mt-1">{{ number_format($stats['total_visitors']) }}</div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-emerald-800/60 flex items-center justify-between gap-2 text-xs font-semibold">
                    <div class="inline-flex items-center gap-1.5 text-emerald-100 whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <span>Checked-in: <strong class="text-white font-extrabold">{{ $stats['primary_visitors'] + $stats['companion_visitors'] }}</strong></span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 text-emerald-100 whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-300"></span>
                        <span>Walk-ins: <strong class="text-white font-extrabold">{{ $stats['walkin_visitors'] }}</strong></span>
                    </div>
                </div>
            </div>

            {{-- Card 2: Total Bookings --}}
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm report-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-500">Total Bookings</span>
                        <span class="p-2 rounded-xl bg-sky-50 text-sky-700 border border-sky-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mt-1">{{ number_format($stats['total_bookings']) }}</div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-slate-100 grid grid-cols-3 gap-1.5 text-center">
                    <div class="bg-emerald-50/80 border border-emerald-200/60 rounded-xl py-1 px-1.5 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-extrabold uppercase tracking-tight text-emerald-700 leading-none">Conf</span>
                        <span class="text-xs sm:text-sm font-black text-emerald-950 mt-0.5 leading-tight">{{ $stats['confirmed'] }}</span>
                    </div>
                    <div class="bg-amber-50/80 border border-amber-200/60 rounded-xl py-1 px-1.5 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-extrabold uppercase tracking-tight text-amber-700 leading-none">Pend</span>
                        <span class="text-xs sm:text-sm font-black text-amber-950 mt-0.5 leading-tight">{{ $stats['pending'] }}</span>
                    </div>
                    <div class="bg-rose-50/80 border border-rose-200/60 rounded-xl py-1 px-1.5 flex flex-col items-center justify-center">
                        <span class="text-[10px] font-extrabold uppercase tracking-tight text-rose-700 leading-none">Decl</span>
                        <span class="text-xs sm:text-sm font-black text-rose-950 mt-0.5 leading-tight">{{ $stats['declined'] + $stats['cancelled'] }}</span>
                    </div>
                </div>
            </div>

            {{-- Card 3: Booking Confirmation Rate --}}
            @php
                $confRate = $stats['total_bookings'] > 0 ? round(($stats['confirmed'] / $stats['total_bookings']) * 100, 1) : 0;
            @endphp
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm report-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-500">Approval Rate</span>
                        <span class="p-2 rounded-xl bg-indigo-50 text-indigo-700 border border-indigo-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-indigo-950 tracking-tight mt-1">{{ $confRate }}%</div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-slate-100 flex flex-col gap-2 justify-center">
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden ring-1 ring-slate-200/50">
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-500 h-2 rounded-full transition-all duration-500" style="width: {{ min(100, $confRate) }}%"></div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-slate-600 font-semibold">
                        <span class="whitespace-nowrap">{{ $stats['confirmed'] }}/{{ $stats['total_bookings'] }} Approved</span>
                        <span class="text-[11px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-100 px-1.5 py-0.5 rounded-md whitespace-nowrap">Target 90%</span>
                    </div>
                </div>
            </div>

            {{-- Card 4: Walk-in Traffic --}}
            @php
                $walkinShare = $stats['total_visitors'] > 0 ? round(($stats['walkin_visitors'] / $stats['total_visitors']) * 100, 1) : 0;
            @endphp
            <div class="bg-white border border-slate-200/90 rounded-2xl p-5 sm:p-6 shadow-sm report-card flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-500">Walk-In Traffic</span>
                        <span class="p-2 rounded-xl bg-amber-50 text-amber-700 border border-amber-100">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                    </div>
                    <div class="text-3xl sm:text-4xl font-extrabold text-amber-950 tracking-tight mt-1">{{ number_format($stats['walkin_visitors']) }}</div>
                </div>
                <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2 text-xs">
                    <div class="inline-flex items-center gap-1.5 font-bold text-slate-700 whitespace-nowrap">
                        <span class="text-slate-500 font-medium">Share:</span>
                        <span class="px-2 py-0.5 rounded-lg bg-amber-50 text-amber-900 border border-amber-200/70 font-black">{{ $walkinShare }}%</span>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200/60 font-bold text-xs whitespace-nowrap">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Live Log
                    </span>
                </div>
            </div>

        </div>

        {{-- ── 3. Signature Feature: Official DOT Report Generator ─── --}}
        <div class="card-dark-hero text-white rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden border border-slate-700/60"
            style="background-color: #0f172a; background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #064e3b 100%); color: #ffffff;">
            <div class="absolute -right-20 -top-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Department of Tourism Standard Form
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
                        Tourism Attraction Visitor Record
                    </h3>
                    <p class="text-sm sm:text-base text-slate-300 mt-2.5 leading-relaxed">
                        Generate the official standardized monthly visitor breakdown grouped by <strong>residence classification</strong> (Local, Domestic, Foreign) and <strong>gender</strong> (Male / Female / Total). Ready for preview, printing, and DOCX document export.
                    </p>
                    <div class="flex flex-wrap items-center gap-5 mt-4 text-xs sm:text-sm text-slate-400">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Active Month: <strong class="text-white">{{ \Carbon\Carbon::parse($filters['date_from'])->format('F Y') }}</strong>
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-sky-400"></span>
                            Scope: <strong class="text-white">{{ $filters['destination_id'] ? ($destinations->firstWhere('id', $filters['destination_id'])->name ?? 'Selected Spot') : 'All Municipal Spots' }}</strong>
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row lg:flex-col gap-3 shrink-0">
                    <button id="btn-generate-report" type="button"
                        class="inline-flex items-center justify-center gap-2.5 bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-slate-950 font-black rounded-xl px-7 py-4 text-sm sm:text-base shadow-lg shadow-emerald-500/20 transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-5 h-5 text-slate-950" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Preview &amp; Print Form
                    </button>

                    <a id="btn-quick-export" href="{{ route('reports.export-visitor-record', ['destination_id' => $filters['destination_id'], 'date_from' => $filters['date_from'], 'date_to' => $filters['date_to']]) }}"
                        class="inline-flex items-center justify-center gap-2 text-white font-bold rounded-xl px-6 py-3.5 text-sm sm:text-base transition-all duration-200"
                        style="background: rgba(255, 255, 255, 0.12); color: #ffffff; border: 1.5px solid rgba(255, 255, 255, 0.25);">
                        <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download Word (.docx)
                    </a>
                </div>
            </div>
        </div>

        {{-- ── 4. Secondary Breakdown: Top Destinations & Demographics ─ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            {{-- Top Performing Destinations --}}
            <div class="lg:col-span-7 bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm report-card">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Top Destinations by Confirmed Bookings
                    </h3>
                    <span class="text-xs text-slate-400">Current Scope</span>
                </div>

                @if($topDestinations->isEmpty())
                    <div class="text-center py-8 text-slate-400 text-xs">
                        No booking records found for the selected period.
                    </div>
                @else
                    <div class="space-y-3.5">
                        @php $maxTop = $topDestinations->max('total') ?: 1; @endphp
                        @foreach($topDestinations as $idx => $top)
                            @php $pct = round(($top->total / $maxTop) * 100); @endphp
                            <div>
                                <div class="flex items-center justify-between text-xs font-semibold mb-1">
                                    <span class="text-slate-800 flex items-center gap-2">
                                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-[10px]">
                                            {{ $idx + 1 }}
                                        </span>
                                        {{ $top->name }}
                                        <span class="text-slate-400 font-normal text-[11px]">({{ $top->location ?? 'Municipal Spot' }})</span>
                                    </span>
                                    <span class="text-emerald-700 font-bold">{{ $top->total }} bookings</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full transition-all duration-500" style="width: {{ $pct }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Reporting Guidance Card --}}
            <div class="lg:col-span-5 bg-slate-50 border border-slate-200/90 rounded-2xl p-6 shadow-sm report-card flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        DOT Compliance Notes
                    </h3>
                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Per DOT Annex guidelines, tourism establishments and municipal offices must record visitors according to residency categories:
                    </p>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 rounded-full bg-sky-500 mt-1 shrink-0"></span>
                            <span><strong>This City/Municipality:</strong> Residents of the local municipality.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 rounded-full bg-indigo-500 mt-1 shrink-0"></span>
                            <span><strong>Other City/Municipality:</strong> Domestic tourists from other Philippine provinces or cities.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-500 mt-1 shrink-0"></span>
                            <span><strong>Foreign Country Residence:</strong> International passport holders or foreign tourists.</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-200/80 text-[11px] text-slate-400">
                    Form format complies with official Philippine Tourism Statistics templates.
                </div>
            </div>

        </div>

    </div>

    {{-- ─────────────── Report Preview Modal ─────────────── --}}
    <div id="report-modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="modal-title">
        <div id="report-modal">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 shrink-0 bg-white rounded-t-2xl">
                <div class="flex items-center gap-2.5">
                    <span class="p-1.5 rounded-lg bg-emerald-100 text-emerald-800">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </span>
                    <div>
                        <h3 id="modal-title" class="text-base font-bold text-slate-900">Tourism Attraction Visitor Record</h3>
                        <p class="text-xs text-slate-500">Official Monthly Annex Report Preview</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    {{-- Export DOCX --}}
                    <a id="btn-export-docx" href="#"
                        class="hidden inline-flex items-center gap-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl px-4 py-2 text-xs font-bold transition shadow-sm">
                        <svg class="w-4 h-4 text-sky-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Export DOCX
                    </a>

                    {{-- Print --}}
                    <button id="btn-print" type="button"
                        class="hidden inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl px-4 py-2 text-xs font-bold transition shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Record
                    </button>

                    {{-- Close --}}
                    <button id="btn-modal-close" type="button" aria-label="Close modal"
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Modal Body --}}
            <div id="report-modal-body">
                <div id="report-modal-spinner">
                    <div class="modal-spinner-ring"></div>
                    <div class="text-center">
                        <p class="text-sm font-bold text-slate-800">Generating Official Visitor Record…</p>
                        <p class="text-xs text-slate-400 mt-0.5">Aggregating bookings, companions, and walk-in arrivals</p>
                    </div>
                </div>
                <div id="report-modal-content" class="hidden"></div>
                <div id="report-modal-error" class="hidden text-red-600 text-sm p-4 bg-red-50 border border-red-200 rounded-xl"></div>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
    (function () {
        const backdrop    = document.getElementById('report-modal-backdrop');
        const spinner     = document.getElementById('report-modal-spinner');
        const content     = document.getElementById('report-modal-content');
        const errorBox    = document.getElementById('report-modal-error');
        const btnExport   = document.getElementById('btn-export-docx');
        const btnPrint    = document.getElementById('btn-print');
        const btnClose    = document.getElementById('btn-modal-close');
        const btnGenerate = document.getElementById('btn-generate-report');

        // ── Helpers ───────────────────────────────────────────────────
        function openModal() {
            backdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            backdrop.classList.remove('open');
            document.body.style.overflow = '';
        }

        function showSpinner() {
            spinner.classList.remove('hidden');
            spinner.style.display = 'flex';
            content.classList.add('hidden');
            errorBox.classList.add('hidden');
            btnExport.classList.add('hidden');
            btnPrint.classList.add('hidden');
        }

        function showContent(html, exportUrl) {
            spinner.classList.add('hidden');
            spinner.style.display = 'none';
            errorBox.classList.add('hidden');
            content.innerHTML = html;
            content.classList.remove('hidden');
            btnExport.href = exportUrl;
            btnExport.classList.remove('hidden');
            btnPrint.classList.remove('hidden');
        }

        function showError(msg) {
            spinner.classList.add('hidden');
            spinner.style.display = 'none';
            content.classList.add('hidden');
            errorBox.textContent = msg;
            errorBox.classList.remove('hidden');
        }

        // ── Generate (fetch HTML preview) ─────────────────────────────
        btnGenerate.addEventListener('click', function () {
            const destId   = document.getElementById('filter-destination')?.value ?? '';
            const dateFrom = document.getElementById('filter-date-from')?.value ?? '';
            const dateTo   = document.getElementById('filter-date-to')?.value ?? '';

            if (!dateFrom) {
                alert('Please select a Date From before generating.');
                return;
            }

            openModal();
            showSpinner();

            const previewUrl = '{{ route('reports.generate-visitor-record') }}';
            const exportUrl  = '{{ route('reports.export-visitor-record') }}';

            const params = new URLSearchParams();
            if (destId)   params.set('destination_id', destId);
            if (dateFrom) params.set('date_from',      dateFrom);
            if (dateTo)   params.set('date_to',        dateTo);

            const fullExportUrl = exportUrl + '?' + params.toString();

            fetch(previewUrl + '?' + params.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => {
                if (!response.ok) throw new Error('Server responded with status ' + response.status);
                return response.text();
            })
            .then(html => {
                showContent(html, fullExportUrl);
            })
            .catch(err => {
                showError('Failed to generate report: ' + err.message);
            });
        });

        // ── Close modal ───────────────────────────────────────────────
        btnClose.addEventListener('click', closeModal);
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) closeModal();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && backdrop.classList.contains('open')) closeModal();
        });

        // ── Print ─────────────────────────────────────────────────────
        btnPrint.addEventListener('click', function () {
            window.print();
        });
    })();

    // ── Preset Date Filter Quick Switcher ──────────────────────────
    function setFilterPreset(preset) {
        const now = new Date();
        const dateFromInput = document.getElementById('filter-date-from');
        const dateToInput   = document.getElementById('filter-date-to');
        const form          = document.getElementById('filter-form');

        function formatDate(d) {
            const year  = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day   = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        if (preset === 'this_month') {
            const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            const lastDay  = new Date(now.getFullYear(), now.getMonth() + 1, 0);
            dateFromInput.value = formatDate(firstDay);
            dateToInput.value   = formatDate(lastDay);
        } else if (preset === 'last_month') {
            const firstDay = new Date(now.getFullYear(), now.getMonth() - 1, 1);
            const lastDay  = new Date(now.getFullYear(), now.getMonth(), 0);
            dateFromInput.value = formatDate(firstDay);
            dateToInput.value   = formatDate(lastDay);
        } else if (preset === 'last_30_days') {
            const past30 = new Date();
            past30.setDate(now.getDate() - 30);
            dateFromInput.value = formatDate(past30);
            dateToInput.value   = formatDate(now);
        } else if (preset === 'this_year') {
            const firstDay = new Date(now.getFullYear(), 0, 1);
            const lastDay  = new Date(now.getFullYear(), 11, 31);
            dateFromInput.value = formatDate(firstDay);
            dateToInput.value   = formatDate(lastDay);
        }

        form.submit();
    }
    </script>
    @endpush

</x-app-layout>
