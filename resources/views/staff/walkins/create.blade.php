<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ti ti-user-plus text-green-700"></i> Walk-In Registration
        </h1>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        /* ── Base Variables ─────────────────────────── */
        :root {
            --green: #15803d;
            --green-light: #dcfce7;
            --amber: #d97706;
            --red: #dc2626;
            --red-light: #fef2f2;
            --border: #e5e7eb;
            --radius: 12px;
        }

        /* ── Stat Cards ─────────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1);
            border-color: #bbf7d0;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .stat-value {
            font-size: 1.4rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.1;
        }

        /* ── Capacity Bar ────────────────────────────── */
        .cap-bar-track {
            flex: 1;
            height: 6px;
            background: #f3f4f6;
            border-radius: 99px;
            overflow: hidden;
        }

        .cap-bar-fill {
            height: 100%;
            border-radius: 99px;
            background: var(--green);
            transition: width .3s;
        }

        .cap-bar-fill.warn {
            background: var(--amber);
        }

        .cap-bar-fill.full {
            background: var(--red);
        }

        /* ── Grid Table ─────────────────────────────── */
        .visitor-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .visitor-table thead th {
            padding: 9px 10px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            background: #f9fafb;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .visitor-table thead th:first-child {
            border-radius: 12px 0 0 0;
        }

        .visitor-table thead th:last-child {
            border-radius: 0 12px 0 0;
        }

        .visitor-table tbody tr:hover {
            background: #f9fafb;
        }

        .visitor-table tbody tr.row-error {
            background: #fff5f5;
        }

        .visitor-table td {
            padding: 5px 6px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        /* ── Cell Inputs ─────────────────────────────── */
        .cell-input {
            width: 100%;
            border: 1px solid transparent;
            border-radius: 7px;
            padding: 6px 9px;
            font-size: 13px;
            color: #111827;
            background: transparent;
            transition: border-color .12s, background .12s, box-shadow .12s;
            line-height: 1.3;
        }

        .cell-input:hover {
            border-color: #d1d5db;
            background: #fff;
        }

        .cell-input:focus {
            outline: none;
            border-color: var(--green);
            background: #fff;
            box-shadow: 0 0 0 2.5px rgba(21, 128, 61, .12);
        }

        .cell-input.cell-error {
            border-color: var(--red) !important;
            background: var(--red-light) !important;
        }

        .cell-input.cell-error:focus {
            box-shadow: 0 0 0 2.5px rgba(220, 38, 38, .1);
        }

        select.cell-input {
            cursor: pointer;
            appearance: none;
            padding-right: 24px;
        }

        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: "▾";
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: #9ca3af;
            pointer-events: none;
        }

        /* ── Row Actions ─────────────────────────────── */
        .row-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
            transition: background .12s;
        }

        .row-action-btn.btn-dupe {
            background: #eff6ff;
            color: #3b82f6;
        }

        .row-action-btn.btn-dupe:hover {
            background: #dbeafe;
        }

        .row-action-btn.btn-remove {
            background: #fef2f2;
            color: #ef4444;
        }

        .row-action-btn.btn-remove:hover {
            background: #fee2e2;
        }

        /* ── Paste Zone ──────────────────────────────── */
        .paste-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13px;
            color: #9ca3af;
            cursor: pointer;
            transition: border-color .15s, background .15s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .paste-zone:hover,
        .paste-zone.drag-over {
            border-color: var(--green);
            background: #f0fdf4;
            color: var(--green);
        }

        /* ── Sticky footer toolbar ───────────────────── */
        .sticky-toolbar {
            position: sticky;
            bottom: 0;
            z-index: 10;
            background: rgba(255, 255, 255, .95);
            backdrop-filter: blur(8px);
            border-top: 1px solid var(--border);
            padding: 14px 24px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 0 0 16px 16px;
        }

        /* ── Error tooltip ───────────────────────────── */
        .cell-tooltip {
            position: absolute;
            bottom: calc(100% + 4px);
            left: 50%;
            transform: translateX(-50%);
            background: #111827;
            color: #fff;
            font-size: 11px;
            padding: 3px 7px;
            border-radius: 5px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 50;
            display: none;
        }

        td:hover .cell-tooltip {
            display: block;
        }

        /* ── Row index number ─────────────────────────── */
        .row-num {
            font-size: 11px;
            font-weight: 700;
            color: #9ca3af;
            text-align: center;
            width: 28px;
            min-width: 28px;
        }
    </style>

    <div class="pb-6 pt-0 max-w-full mx-auto px-4 sm:px-6 lg:px-8 space-y-5"
        x-data="walkinGrid({{ $destination->capacity }}, {{ $currentVisitors }})"
        @keydown.ctrl.enter.window="submitForm()">

        {{-- Flash Error --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 text-sm">
                <i class="ti ti-alert-triangle text-lg"></i> {{ session('error') }}
            </div>
        @endif

        {{-- ① Quick Stats Bar ────────────────────────────────────────────── --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            {{-- Walk-ins Today --}}
            <div class="stat-card shadow-sm">
                <div class="stat-icon bg-green-50 text-green-700"><i class="ti ti-user-check"></i></div>
                <div>
                    <div class="stat-label">Walk-ins Today</div>
                    <div class="stat-value">{{ $todayWalkins }}</div>
                </div>
            </div>
            {{-- This Month --}}
            <div class="stat-card shadow-sm">
                <div class="stat-icon bg-blue-50 text-blue-700"><i class="ti ti-calendar-stats"></i></div>
                <div>
                    <div class="stat-label">This Month</div>
                    <div class="stat-value">{{ $totalWalkinsMonth }}</div>
                </div>
            </div>
            {{-- Live Capacity --}}
            <div class="stat-card shadow-sm col-span-2">
                <div class="stat-icon" :class="capacityClass.icon"><i class="ti ti-users"></i></div>
                <div class="flex-1 min-w-0">
                    <div class="stat-label">Live Capacity</div>
                    <div class="flex items-baseline gap-2">
                        <span class="stat-value" :class="capacityClass.text" x-text="projectedCount"></span>
                        <span class="text-gray-400 text-sm font-medium">/ {{ $destination->capacity }}</span>
                        <span class="text-xs font-semibold ml-auto" :class="capacityClass.badge"
                            x-text="capacityLabel"></span>
                    </div>
                    <div class="cap-bar-track mt-1.5">
                        <div class="cap-bar-fill" :class="capacityClass.bar"
                            :style="'width:' + Math.min(100, Math.round((projectedCount / {{ $destination->capacity }}) * 100)) + '%'">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ② Main Table Card ─────────────────────────────────────────────── --}}
        <div class="interactive-card">

            {{-- Card Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between gap-4 flex-wrap">
                <div class="flex items-center gap-2">
                    <i class="ti ti-table text-green-700" style="font-size:20px;"></i>
                    <div>
                        <h2 class="font-bold text-gray-800">Visitor Entry Grid</h2>
                        <p class="text-xs text-gray-400 mt-0.5">
                            <kbd class="px-1 py-0.5 bg-gray-100 rounded text-gray-500 text-xs font-mono">Tab</kbd> to
                            move right &nbsp;·&nbsp;
                            <kbd class="px-1 py-0.5 bg-gray-100 rounded text-gray-500 text-xs font-mono">Enter</kbd> on
                            last field adds row &nbsp;·&nbsp;
                            <kbd
                                class="px-1 py-0.5 bg-gray-100 rounded text-gray-500 text-xs font-mono">Ctrl+Enter</kbd>
                            submits
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    {{-- Paste from Excel --}}
                    <button type="button" @click="showPaste = !showPaste"
                        class="inline-flex items-center gap-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-semibold rounded-xl px-3 py-2 text-xs transition">
                        <i class="ti ti-clipboard-text"></i> Paste from Spreadsheet
                    </button>
                    {{-- Add Row --}}
                    <button type="button" @click="addRow()" id="add-row-btn"
                        class="inline-flex items-center gap-1.5 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-4 py-2 text-sm transition">
                        <i class="ti ti-plus"></i> Add Row
                    </button>
                </div>
            </div>

            {{-- Capacity Over-limit Warning Banner --}}
            <div x-show="isOverCapacity" x-cloak
                class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-start gap-3">
                <i class="ti ti-alert-circle text-red-500 text-xl shrink-0 mt-0.5"></i>
                <div>
                    <p class="text-sm font-bold text-red-700">Capacity Limit Reached</p>
                    <p class="text-xs text-red-600 mt-0.5">
                        Adding <span x-text="rows.length"></span> visitors would bring the total to
                        <span x-text="projectedCount"></span>, exceeding the {{ $destination->capacity }}-person daily
                        limit.
                        Remove rows or reduce group size.
                    </p>
                </div>
            </div>

            {{-- Paste Zone (collapsible) --}}
            <div x-show="showPaste" x-cloak class="px-6 pt-4 pb-2">
                <div class="paste-zone" @click="$refs.pasteArea.focus()"
                    @dragover.prevent="$event.currentTarget.classList.add('drag-over')"
                    @dragleave="$event.currentTarget.classList.remove('drag-over')">
                    <i class="ti ti-clipboard-data text-2xl flex-shrink-0"></i>
                    <div class="flex-1">
                        <p class="font-semibold text-gray-700 text-sm">Paste clipboard data here</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Copy rows from Excel/Google Sheets (columns: Name, Age, Contact, Email, Classification, Days
                            Stay) then
                            click here and press <kbd
                                class="bg-gray-100 text-gray-600 px-1 rounded font-mono">Ctrl+V</kbd>
                        </p>
                    </div>
                </div>
                <textarea x-ref="pasteArea" @paste="handlePaste($event)" class="sr-only"
                    aria-label="Paste area for bulk import" tabindex="-1"></textarea>
                <p class="text-xs text-gray-400 mt-2 mb-1">
                    <strong>Column order:</strong> Name · Age · Gender · Contact Number · Email · Classification (Local /
                    Domestic Tourist / International Tourist) · Days Stay
                </p>
            </div>

            {{-- ③ Visitor Grid Table ───────────────────────────────────────── --}}
            <div class="overflow-x-auto lg:overflow-visible" id="table-scroll-container">
                <form id="walkin-form" action="{{ route('staff.walkins.store') }}" method="POST">
                    @csrf
                    <table class="visitor-table" id="visitor-table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width:38px;">#</th>
                                <th style="min-width:180px;">Full Name <span class="text-red-400">*</span></th>
                                <th style="width:72px;">Age <span class="text-red-400">*</span></th>
                                <th style="width:110px;">Gender <span class="text-red-400">*</span></th>
                                <th style="min-width:140px;">Contact Number</th>
                                <th style="min-width:180px;">Email Address</th>
                                <th style="min-width:175px;">Classification <span class="text-red-400">*</span></th>
                                <th style="width:90px;">Days Stay <span class="text-red-400">*</span></th>
                                <th style="width:72px;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="visitor-tbody">
                            <template x-for="(row, i) in rows" :key="row.id">
                                <tr :class="{'row-error': row.hasError}">
                                    {{-- Row number --}}
                                    <td class="row-num" x-text="i + 1"></td>

                                    {{-- Full Name --}}
                                    <td class="relative" :class="{'relative': true}">
                                        <input type="text" :name="'visitors['+i+'][name]'" x-model="row.name"
                                            @input="clearError(row, 'name')"
                                            @keydown.tab.prevent="focusNext($event, i, 'name')"
                                            :class="{'cell-input': true, 'cell-error': row.errors.name}"
                                            :placeholder="i === 0 ? 'e.g. Juan dela Cruz' : ''" required
                                            autocomplete="off">
                                        <div class="cell-tooltip" x-show="row.errors.name" x-text="row.errors.name">
                                        </div>
                                    </td>

                                    {{-- Age --}}
                                    <td>
                                        <input type="number" :name="'visitors['+i+'][age]'" x-model.number="row.age"
                                            min="1" max="150" @input="clearError(row, 'age')"
                                            @keydown.tab.prevent="focusNext($event, i, 'age')"
                                            :class="{'cell-input': true, 'cell-error': row.errors.age}" placeholder="—"
                                            required>
                                    </td>

                                    {{-- Gender --}}
                                    <td>
                                        <div class="relative">
                                            <button type="button" @click="row.showGenderDropdown = !row.showGenderDropdown" @click.away="row.showGenderDropdown = false"
                                                @keydown.tab.prevent="focusNext($event, i, 'gender')"
                                                class="cell-input text-left flex justify-between items-center w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white" style="min-width: 90px;">
                                                <span x-text="row.gender || 'Select'" class="truncate"></span>
                                                <svg class="h-3 w-3 text-gray-400 transform transition-transform duration-150 shrink-0 ml-1" :class="row.showGenderDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <input type="hidden" :name="'visitors['+i+'][gender]'" :value="row.gender" required />
                                            
                                            <!-- Animated Dropdown Options -->
                                            <div x-show="row.showGenderDropdown"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute left-0 mt-1 z-50 w-full min-w-[100px] rounded-lg bg-white border border-gray-200 shadow-lg py-1 text-xs"
                                                style="display: none;">
                                                <button type="button" @click="row.gender = 'Male'; row.showGenderDropdown = false" class="w-full text-left px-3 py-2 hover:bg-green-50 hover:text-green-950 transition-colors">
                                                    Male
                                                </button>
                                                <button type="button" @click="row.gender = 'Female'; row.showGenderDropdown = false" class="w-full text-left px-3 py-2 hover:bg-green-50 hover:text-green-950 transition-colors">
                                                    Female
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Contact --}}
                                    <td>
                                        <input type="tel" :name="'visitors['+i+'][contact_number]'"
                                            x-model="row.contact_number"
                                            @keydown.tab.prevent="focusNext($event, i, 'contact_number')"
                                            :class="{'cell-input': true}" placeholder="09xxxxxxxxx">
                                    </td>

                                    {{-- Email --}}
                                    <td>
                                        <input type="email" :name="'visitors['+i+'][email]'" x-model="row.email"
                                            @input="clearError(row, 'email')"
                                            @keydown.tab.prevent="focusNext($event, i, 'email')"
                                            :class="{'cell-input': true, 'cell-error': row.errors.email}"
                                            placeholder="optional">
                                    </td>

                                    {{-- Classification --}}
                                    <td>
                                        <div class="relative">
                                            <button type="button" @click="row.showClassDropdown = !row.showClassDropdown" @click.away="row.showClassDropdown = false"
                                                @keydown.tab.prevent="focusNext($event, i, 'classification')"
                                                class="cell-input text-left flex justify-between items-center w-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white" style="min-width: 140px;">
                                                <span x-text="row.classification || 'Select'" class="truncate"></span>
                                                <svg class="h-3 w-3 text-gray-400 transform transition-transform duration-150 shrink-0 ml-1" :class="row.showClassDropdown ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <input type="hidden" :name="'visitors['+i+'][classification]'" :value="row.classification" required />
                                            
                                            <!-- Animated Dropdown Options -->
                                            <div x-show="row.showClassDropdown"
                                                x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-75"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="absolute left-0 mt-1 z-50 w-full min-w-[150px] rounded-lg bg-white border border-gray-200 shadow-lg py-1 text-xs"
                                                style="display: none;">
                                                <button type="button" @click="row.classification = 'Local'; row.showClassDropdown = false" class="w-full text-left px-3 py-2 hover:bg-green-50 hover:text-green-950 transition-colors">
                                                    Local
                                                </button>
                                                <button type="button" @click="row.classification = 'Domestic Tourist'; row.showClassDropdown = false" class="w-full text-left px-3 py-2 hover:bg-green-50 hover:text-green-950 transition-colors">
                                                    Domestic Tourist
                                                </button>
                                                <button type="button" @click="row.classification = 'International Tourist'; row.showClassDropdown = false" class="w-full text-left px-3 py-2 hover:bg-green-50 hover:text-green-950 transition-colors">
                                                    International Tourist
                                                </button>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Days Stay --}}
                                    <td>
                                        <input type="number" :name="'visitors['+i+'][duration_days]'"
                                            x-model.number="row.duration_days" min="1" max="30"
                                            @input="clearError(row, 'duration_days')"
                                            @keydown.tab.prevent="focusNextOrAddRow($event, i)"
                                            :class="{'cell-input': true, 'cell-error': row.errors.duration_days}"
                                            placeholder="1" required>
                                    </td>

                                    {{-- Actions --}}
                                    <td>
                                        <div class="flex items-center justify-center gap-1">
                                            <button type="button" class="row-action-btn btn-dupe"
                                                @click="duplicateRow(i)"
                                                title="Duplicate this row's values into a new row below">
                                                <i class="ti ti-copy"></i>
                                            </button>
                                            <button type="button" class="row-action-btn btn-remove"
                                                @click="removeRow(i)" x-show="rows.length > 1" title="Remove this row">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>

                    {{-- Sticky Footer Toolbar ──────────────────────────────── --}}
                    <div class="sticky-toolbar">
                        {{-- Row count badge --}}
                        <span
                            class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-700 font-semibold text-xs px-3 py-1.5 rounded-lg">
                            <i class="ti ti-users text-gray-500"></i>
                            <span x-text="rows.length + ' visitor' + (rows.length !== 1 ? 's' : '')"></span>
                        </span>

                        {{-- Add row --}}
                        <button type="button" @click="addRow()"
                            class="inline-flex items-center gap-1.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-semibold rounded-xl px-3 py-1.5 text-xs transition">
                            <i class="ti ti-plus"></i> Add Row
                        </button>

                        {{-- Clear all --}}
                        <button type="button" @click="clearAll()" x-show="rows.length > 1"
                            class="inline-flex items-center gap-1.5 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 text-gray-500 hover:text-red-600 font-semibold rounded-xl px-3 py-1.5 text-xs transition">
                            <i class="ti ti-eraser"></i> Clear All
                        </button>

                        <div class="flex-1"></div>

                        {{-- Cancel --}}
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-semibold rounded-xl px-4 py-2 text-sm transition">
                            <i class="ti ti-x"></i> Cancel
                        </a>

                        {{-- Submit --}}
                        <button type="submit" form="walkin-form" id="submit-btn"
                            :disabled="isOverCapacity || rows.length === 0"
                            :class="(isOverCapacity || rows.length === 0) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-800'"
                            class="inline-flex items-center gap-2 bg-green-700 text-white font-bold rounded-xl px-6 py-2 text-sm transition shadow-sm"
                            @click.prevent="submitForm()">
                            <i class="ti ti-device-floppy"></i>
                            Register Walk-Ins
                            <span class="bg-green-600 text-green-100 text-xs font-bold px-1.5 py-0.5 rounded"
                                x-text="rows.length"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- ④ Spot Info Sidebar (compact, below on mobile) ─────────────────── --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="md:col-span-1 interactive-card p-5 text-sm space-y-3">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <i class="ti ti-map-pin text-green-700"></i> Spot Info
                </h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tourist Spot</span>
                        <span class="font-bold text-gray-900 text-right max-w-[60%]">{{ $destination->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Daily Limit</span>
                        <span class="font-bold text-gray-900">{{ $destination->capacity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Current Occupancy</span>
                        <span class="font-bold" :class="capacityClass.text">
                            <span x-text="projectedCount"></span> / {{ $destination->capacity }}
                        </span>
                    </div>
                    <div class="cap-bar-track mt-1">
                        <div class="cap-bar-fill" :class="capacityClass.bar"
                            :style="'width:' + Math.min(100, Math.round((projectedCount / {{ $destination->capacity }}) * 100)) + '%'">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick tips --}}
            <div
                class="md:col-span-2 bg-blue-50 border border-blue-100 rounded-2xl p-5 text-sm text-blue-800 space-y-2">
                <h4 class="font-bold flex items-center gap-1.5"><i class="ti ti-keyboard"></i> Keyboard Shortcuts</h4>
                <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-xs">
                    <div><kbd
                            class="bg-white border border-blue-200 text-blue-700 px-1.5 py-0.5 rounded font-mono text-xs">Tab</kbd>
                        → next field in row</div>
                    <div><kbd
                            class="bg-white border border-blue-200 text-blue-700 px-1.5 py-0.5 rounded font-mono text-xs">Tab</kbd>
                        from last field → new row</div>
                    <div><kbd
                            class="bg-white border border-blue-200 text-blue-700 px-1.5 py-0.5 rounded font-mono text-xs">Ctrl+Enter</kbd>
                        → submit form</div>
                    <div><i class="ti ti-copy text-blue-600"></i> copy icon → duplicate row's values</div>
                    <div><kbd
                            class="bg-white border border-blue-200 text-blue-700 px-1.5 py-0.5 rounded font-mono text-xs">Ctrl+V</kbd>
                        in paste zone → bulk import</div>
                    <div><i class="ti ti-trash text-red-400"></i> trash icon → remove row</div>
                </div>
                <p class="text-xs text-blue-600 mt-1">
                    <strong>Paste format:</strong> Copy from Excel — columns must be in order:
                    Name · Age · Contact · Email · Classification · Days Stay
                </p>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function walkinGrid(capacity, initialCount) {
                return {
                    capacity,
                    initialCount,
                    rows: [],
                    showPaste: false,
                    _idCounter: 0,

                    // ── Init ──────────────────────────────────────────
                    init() {
                        this.addRow();  // Start with one blank row
                        // Focus first cell
                        this.$nextTick(() => this.focusCellAt(0, 'name'));
                    },

                    // ── Row factory ───────────────────────────────────
                    newRow(defaults = {}) {
                        return {
                            id: ++this._idCounter,
                            name: defaults.name ?? '',
                            age: defaults.age ?? '',
                            gender: defaults.gender ?? '',
                            contact_number: defaults.contact_number ?? '',
                            email: defaults.email ?? '',
                            classification: defaults.classification ?? 'Local',
                            duration_days: defaults.duration_days ?? 1,
                            hasError: false,
                            errors: { name: '', age: '', email: '', duration_days: '' },
                            showGenderDropdown: false,
                            showClassDropdown: false
                        };
                    },

                    // ── Computed ──────────────────────────────────────
                    get projectedCount() {
                        return this.initialCount + this.rows.length;
                    },
                    get isOverCapacity() {
                        return this.projectedCount > this.capacity;
                    },
                    get capacityLabel() {
                        const pct = this.capacity > 0 ? Math.round((this.projectedCount / this.capacity) * 100) : 100;
                        if (this.isOverCapacity) return '⚠ Over Limit';
                        if (pct >= 75) return 'Limited';
                        return 'Available';
                    },
                    get capacityClass() {
                        const pct = this.capacity > 0 ? Math.round((this.projectedCount / this.capacity) * 100) : 100;
                        if (this.isOverCapacity) return {
                            icon: 'bg-red-50 text-red-600',
                            text: 'text-red-600',
                            bar: 'full',
                            badge: 'text-red-600'
                        };
                        if (pct >= 75) return {
                            icon: 'bg-amber-50 text-amber-600',
                            text: 'text-amber-600',
                            bar: 'warn',
                            badge: 'text-amber-600'
                        };
                        return {
                            icon: 'bg-green-50 text-green-700',
                            text: 'text-green-700',
                            bar: '',
                            badge: 'text-green-700'
                        };
                    },

                    // ── Row CRUD ──────────────────────────────────────
                    addRow(defaults = {}) {
                        this.rows.push(this.newRow(defaults));
                        this.$nextTick(() => {
                            const lastIdx = this.rows.length - 1;
                            this.focusCellAt(lastIdx, 'name');
                            // Scroll table to bottom so new row is visible
                            const container = document.getElementById('table-scroll-container');
                            if (container) container.scrollTop = container.scrollHeight;
                        });
                    },
                    removeRow(idx) {
                        if (this.rows.length <= 1) return;
                        this.rows.splice(idx, 1);
                    },
                    duplicateRow(idx) {
                        // Copy all fields from row except name (leave blank for new visitor's unique name)
                        const src = this.rows[idx];
                        this.addRow({
                            name: '',
                            age: src.age,
                            gender: src.gender,
                            contact_number: src.contact_number,
                            email: src.email,
                            classification: src.classification,
                            duration_days: src.duration_days,
                        });
                    },
                    clearAll() {
                        if (!confirm('Clear all rows and start fresh?')) return;
                        this.rows = [];
                        this.addRow();
                    },

                    // ── Validation ────────────────────────────────────
                    clearError(row, field) {
                        row.errors[field] = '';
                        row.hasError = Object.values(row.errors).some(v => v !== '');
                    },
                    validateAll() {
                        let valid = true;
                        this.rows.forEach((row, i) => {
                            row.errors = { name: '', age: '', email: '', duration_days: '' };
                            row.hasError = false;

                            if (!row.name.trim()) {
                                row.errors.name = 'Name is required';
                                row.hasError = true; valid = false;
                            }
                            const age = parseInt(row.age);
                            if (isNaN(age) || age < 1 || age > 150) {
                                row.errors.age = 'Enter a valid age (1–150)';
                                row.hasError = true; valid = false;
                            }
                            if (row.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(row.email)) {
                                row.errors.email = 'Invalid email format';
                                row.hasError = true; valid = false;
                            }
                            const dur = parseInt(row.duration_days);
                            if (isNaN(dur) || dur < 1 || dur > 30) {
                                row.errors.duration_days = 'Must be 1–30 days';
                                row.hasError = true; valid = false;
                            }
                        });
                        return valid;
                    },

                    // ── Submit ────────────────────────────────────────
                    submitForm() {
                        if (this.isOverCapacity) return;
                        if (!this.validateAll()) {
                            // Scroll to first error row
                            this.$nextTick(() => {
                                const errRow = document.querySelector('tr.row-error');
                                if (errRow) errRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            });
                            return;
                        }
                        document.getElementById('walkin-form').submit();
                    },

                    // ── Keyboard focus navigation ─────────────────────
                    // Tab order per row: name → age → gender → contact_number → email → classification → duration_days
                    FIELD_ORDER: ['name', 'age', 'gender', 'contact_number', 'email', 'classification', 'duration_days'],

                    focusCellAt(rowIdx, field) {
                        this.$nextTick(() => {
                            const tbody = document.getElementById('visitor-tbody');
                            if (!tbody) return;
                            const tr = tbody.querySelectorAll('tr')[rowIdx];
                            if (!tr) return;
                            // Find column index for field
                            const colIdx = this.FIELD_ORDER.indexOf(field);
                            const cells = tr.querySelectorAll('td');
                            // cells[0] is row number, fields start at cells[1]
                            const targetCell = cells[colIdx + 1];
                            if (!targetCell) return;
                            const input = targetCell.querySelector('input, select');
                            if (input) { input.focus(); input.select && input.select(); }
                        });
                    },

                    focusNext(event, rowIdx, currentField) {
                        const currentColIdx = this.FIELD_ORDER.indexOf(currentField);
                        const nextColIdx = currentColIdx + 1;
                        if (nextColIdx < this.FIELD_ORDER.length) {
                            this.focusCellAt(rowIdx, this.FIELD_ORDER[nextColIdx]);
                        } else {
                            // Last column — Tab moves to first field of next row
                            this.focusNextOrAddRow(event, rowIdx);
                        }
                    },

                    focusNextOrAddRow(event, rowIdx) {
                        if (rowIdx < this.rows.length - 1) {
                            this.focusCellAt(rowIdx + 1, 'name');
                        } else {
                            // Last row's last field — add new row and focus it
                            this.addRow();
                            // focusCellAt is called inside addRow's $nextTick
                        }
                    },

                    // ── Paste / Bulk Import ───────────────────────────
                    handlePaste(event) {
                        event.preventDefault();
                        const raw = (event.clipboardData || window.clipboardData).getData('text');
                        const lines = raw.trim().split(/\r?\n/);
                        let imported = 0;

                        lines.forEach(line => {
                            if (!line.trim()) return;
                            // Support tab-separated (Excel) and comma-separated
                            const cols = line.includes('\t') ? line.split('\t') : line.split(',');
                            const clean = cols.map(c => c.trim().replace(/^"|"$/g, ''));

                            const name = clean[0] || '';
                            const age = parseInt(clean[1]) || '';
                            const gender = clean[2] || '';
                            const contact = clean[3] || '';
                            const email = clean[4] || '';

                            // Fuzzy-match classification
                            const rawClass = (clean[5] || '').toLowerCase();
                            let classification = 'Local';
                            if (rawClass.includes('international')) classification = 'International Tourist';
                            else if (rawClass.includes('domestic')) classification = 'Domestic Tourist';

                            const duration_days = parseInt(clean[6]) || 1;

                            if (name) {
                                this.addRow({ name, age, gender, contact_number: contact, email, classification, duration_days });
                                imported++;
                            }
                        });

                        if (imported > 0) {
                            this.showPaste = false;
                            // Flash success feedback
                            const msg = document.createElement('div');
                            msg.className = 'fixed top-5 right-5 z-50 bg-green-700 text-white text-sm font-semibold px-4 py-3 rounded-xl shadow-lg flex items-center gap-2';
                            msg.innerHTML = `<i class="ti ti-circle-check-filled"></i> Imported ${imported} row${imported !== 1 ? 's' : ''} from clipboard`;
                            document.body.appendChild(msg);
                            setTimeout(() => msg.remove(), 3000);
                        }
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>