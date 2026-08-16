<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal: #0d9488; --teal-dark: #0f766e; --ocean: #0891b2;
            --emerald: #10b981; --rose: #f43f5e; --sand: #f59e0b;
            --border: #ccfbf1; --bg: #f0fdfc;
            --text-1: #134e4a; --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t: 0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card: 0 2px 12px rgba(0,0,0,.07);
            --r-sm: 8px; --r-md: 14px; --r-lg: 20px;
        }
        #booking-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }
        #booking-page { background: var(--bg); min-height: 100vh; }

        .booking-outer { max-width: 1100px; margin: 0 auto; padding: 0 20px 64px; }

        /* Back */
        .back-btn { display: inline-flex; align-items: center; gap: 8px; color: var(--teal); font-weight: 600; font-size: .88rem; background: none; border: none; padding: 28px 0 0; cursor: pointer; transition: gap var(--t); text-decoration: none; }
        .back-btn:hover { gap: 12px; }

        /* Header */
        .booking-header { text-align: center; padding: 28px 0 24px; }
        .booking-header h1 { font-family: 'Fraunces', serif; font-size: 1.8rem; color: var(--text-1); margin-bottom: 8px; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .booking-header p { font-size: .9rem; color: var(--text-3); }

        /* Dest chip */
        .dest-chip {
            display: inline-flex; align-items: center; gap: 12px;
            padding: 10px 20px; background: #fff; border: 1.5px solid var(--border);
            border-radius: 99px; margin-bottom: 24px;
            box-shadow: var(--sh-card); text-decoration: none;
        }
        .chip-icon { display: flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #ccfbf1; border-radius: 50%; color: var(--teal); }
        .chip-name { font-weight: 700; font-size: .88rem; color: var(--text-1); }
        .chip-loc  { font-size: .75rem; color: var(--text-3); }

        /* Summary box */
        .booking-summary {
            background: #f0fdfc; border: 1.5px solid var(--border);
            border-radius: var(--r-md); padding: 16px 18px; margin-bottom: 22px;
        }
        .bs-row { display: flex; justify-content: space-between; align-items: center; font-size: .86rem; padding: 6px 0; }
        .bs-key { color: var(--text-3); display: inline-flex; align-items: center; gap: 6px; }
        .bs-val { font-weight: 600; color: var(--text-1); }
        .bs-total { border-top: 1px solid var(--border); padding-top: 10px; margin-top: 8px; }
        .bs-total .bs-key { font-weight: 700; color: var(--text-1); }
        .status-pending { background: #fef3c7; color: #92400e; padding: 3px 10px; border-radius: 99px; font-size: .72rem; font-weight: 700; text-transform: uppercase; }

        /* Form card */
        .form-card { background: #fff; border-radius: var(--r-lg); padding: 28px; box-shadow: var(--sh-card); border: 1px solid #e5f6f4; }
        .form-section { margin-bottom: 20px; }
        .form-section:last-child { margin-bottom: 0; }
        .form-label { display: block; font-weight: 600; font-size: .83rem; color: var(--text-2); margin-bottom: 6px; }
        .form-label span { color: var(--rose); }
        .form-input {
            width: 100%; border: 1.5px solid #d1d5db; border-radius: var(--r-sm);
            padding: 11px 14px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .9rem; color: var(--text-2); outline: none;
            transition: border-color var(--t), box-shadow var(--t); background: #fff;
        }
        .form-input:focus { border-color: var(--teal); box-shadow: 0 0 0 3px rgba(13,148,136,.1); }
        .form-hint { font-size: .75rem; color: var(--text-4); margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media(max-width: 500px) { .form-row { grid-template-columns: 1fr; } }

        /* Stay range info */
        .stay-range-info {
            background: linear-gradient(135deg, #ecfdf5, #f0fdfc);
            border: 1.5px solid #6ee7b7; border-radius: var(--r-md);
            padding: 14px 16px; margin-bottom: 20px; font-size: .85rem; color: var(--teal-dark);
        }
        .stay-range-info .sri-title { font-weight: 800; margin-bottom: 4px; display: flex; align-items: center; gap: 6px; }
        .stay-range-info .sri-sub   { font-size: .78rem; opacity: .8; }

        /* Terms */
        .terms-box { background: #fffbeb; border: 1.5px solid #fcd34d; border-radius: var(--r-md); padding: 14px 18px; margin-bottom: 20px; font-size: .8rem; color: #92400e; }
        .terms-box p { font-weight: 700; margin-bottom: 6px; display: flex; align-items: center; gap: 6px; }
        .terms-box ul { list-style: disc; padding-left: 18px; }
        .terms-box li { margin-bottom: 3px; }

        /* Tourist info */
        .tourist-info { background: rgba(99,102,241,.05); border: 1.5px solid #c7d2fe; border-radius: var(--r-md); padding: 14px 16px; margin-bottom: 20px; }
        .ti-title { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #4338ca; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .ti-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .ti-item .ti-label { font-size: .7rem; color: var(--text-4); }
        .ti-item .ti-value { font-weight: 700; color: var(--text-2); font-size: .88rem; }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 14px; border: none; border-radius: var(--r-md);
            font-size: 1rem; font-weight: 800;
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; box-shadow: 0 4px 20px rgba(13,148,136,.35);
            cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(13,148,136,.45); }
        .btn-cancel {
            width: 100%; padding: 11px; border: 1.5px solid #e5e7eb; border-radius: var(--r-md);
            font-size: .9rem; font-weight: 600; background: #fff; color: var(--text-3);
            margin-top: 10px; cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 6px; text-decoration: none;
        }
        .btn-cancel:hover { border-color: var(--rose); color: var(--rose); }

        .error-box { background: #fff1f2; border: 1.5px solid #fda4af; color: #9f1239; border-radius: var(--r-md); padding: 12px 16px; font-size: .84rem; margin-bottom: 18px; }

        /* ── Visitor Entry Grid Styles (Replicated from Staff View) ── */
        .visitor-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
        }
        .visitor-table thead th {
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: .5px;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }
        .visitor-table thead th:first-child { border-radius: 8px 0 0 0; }
        .visitor-table thead th:last-child { border-radius: 0 8px 0 0; }
        .visitor-table tbody tr:hover { background: #f9fafb; }
        .visitor-table tbody tr.row-error { background: #fff5f5; }
        .visitor-table td {
            padding: 6px 8px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
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
        .cell-input:hover { border-color: #d1d5db; background: #fff; }
        .cell-input:focus {
            outline: none;
            border-color: var(--teal);
            background: #fff;
            box-shadow: 0 0 0 2.5px rgba(13,148,136,.12);
        }
        .cell-input.cell-error {
            border-color: var(--rose) !important;
            background: #fff5f5 !important;
        }
        select.cell-input { cursor: pointer; appearance: none; padding-right: 24px; }
        .select-wrapper { position: relative; }
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
        .row-action-btn.btn-dupe { background: #eff6ff; color: #3b82f6; }
        .row-action-btn.btn-dupe:hover { background: #dbeafe; }
        .row-action-btn.btn-remove { background: #fef2f2; color: #ef4444; }
        .row-action-btn.btn-remove:hover { background: #fee2e2; }

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
        .paste-zone:hover, .paste-zone.drag-over {
            border-color: var(--teal);
            background: #f0fdfc;
            color: var(--teal);
        }
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
        td:hover .cell-tooltip { display: block; }
        .row-num { font-size: 11px; font-weight: 700; color: #9ca3af; text-align: center; width: 28px; min-width: 28px; }
    </style>

    @php
        $preDate     = request('visit_date', old('visit_date'));
        $preDuration = max(1, min(10, (int) request('duration', 1)));
        $endDate     = $preDate ? \Carbon\Carbon::parse($preDate)->addDays($preDuration - 1) : null;
        $startFmt    = $preDate ? \Carbon\Carbon::parse($preDate)->format('M j, Y') : null;
        $endFmt      = $endDate ? $endDate->format('M j, Y') : null;
    @endphp

    <div id="booking-page" x-data="bookingGrid({{ $destination->capacity }}, {{ $totalConfirmed }})">
        <div class="booking-outer">

            {{-- Back --}}
            <a href="{{ route('destinations.show', $destination) }}" class="back-btn">
                <i class="ti ti-arrow-left text-lg"></i>
                <span>Back to Destination</span>
            </a>

            {{-- Header --}}
            <div class="booking-header">
                <h1><i class="ti ti-backpack text-teal-600 text-2xl"></i> Confirm Your Visit</h1>
                <p>Review your details and submit your booking request below.</p>
                <div style="margin-top:16px;display:flex;justify-content:center;">
                    <a href="{{ route('destinations.show', $destination) }}" class="dest-chip">
                        <span class="chip-icon">
                            <i class="ti ti-map-pin text-lg"></i>
                        </span>
                        <div>
                            <div class="chip-name">{{ $destination->name }}</div>
                            <div class="chip-loc">{{ $destination->location }}</div>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Errors --}}
            @if(session('error') || $errors->any())
            <div class="error-box">
                @if(session('error'))
                    <strong class="flex items-center gap-1"><i class="ti ti-alert-triangle text-rose-600 text-base"></i> {{ session('error') }}</strong>
                @endif
                @foreach($errors->all() as $e)
                    <p>• {{ $e }}</p>
                @endforeach
            </div>
            @endif

            {{-- Stay range banner (multi-day) --}}
            @if($startFmt && $preDuration > 1)
            <div class="stay-range-info">
                <div class="sri-title"><i class="ti ti-pin text-emerald-600 text-base"></i> {{ $preDuration }}-Day Stay: {{ $startFmt }} &rarr; {{ $endFmt }}</div>
                <div class="sri-sub">Your booking covers {{ $preDuration }} consecutive days. The visit date below is your start date.</div>
            </div>
            @endif

            {{-- Booking Summary --}}
            <div class="booking-summary">
                <div class="bs-row">
                    <span class="bs-key"><i class="ti ti-calendar text-teal-600 text-base"></i> Visit Date</span>
                    <span class="bs-val">{{ $startFmt ?: '—' }}</span>
                </div>
                @if($preDuration > 1)
                <div class="bs-row">
                    <span class="bs-key"><i class="ti ti-clock text-teal-600 text-base"></i> Duration</span>
                    <span class="bs-val">{{ $preDuration }} Days (ends {{ $endFmt }})</span>
                </div>
                @endif
                <div class="bs-row">
                    <span class="bs-key"><i class="ti ti-users text-teal-600 text-base"></i> Capacity / Day</span>
                    <span class="bs-val">{{ $destination->capacity }} visitors</span>
                </div>
                <div class="bs-row bs-total">
                    <span class="bs-key">Status after submission</span>
                    <span class="bs-val"><span class="status-pending">Pending Review</span></span>
                </div>
            </div>

            {{-- Tourist info --}}
            <div class="tourist-info">
                <div class="ti-title"><i class="ti ti-user-circle text-indigo-600 text-base"></i> Your Details (from account)</div>
                <div class="ti-grid">
                    <div class="ti-item">
                        <div class="ti-label">Name</div>
                        <div class="ti-value" id="tourist-primary-name">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="ti-item">
                        <div class="ti-label">Email</div>
                        <div class="ti-value" style="word-break:break-all;">{{ auth()->user()->email }}</div>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="form-card">
                <form id="booking-form" action="{{ route('bookings.store', $destination) }}" method="POST">
                    @csrf

                    <div class="form-row" style="margin-bottom:20px;">
                        <div class="form-section" style="margin-bottom:0;">
                            <label class="form-label">
                                Visit Date
                                @if($preDuration > 1)
                                    <span style="font-weight:400;color:var(--text-4);font-size:.72rem;">(Start Date)</span>
                                @endif
                            </label>
                            <input type="hidden" name="visit_date" value="{{ $preDate }}" required>
                            <input type="hidden" name="duration_days" value="{{ $preDuration }}">
                            <input class="form-input" type="text" readonly
                                value="{{ $startFmt ?: $preDate }}{{ $preDuration > 1 ? ' → ' . $endFmt : '' }}"
                                style="background:#f9fafb;color:var(--text-2);font-weight:700;cursor:not-allowed;">
                            <p class="form-hint flex items-center gap-1" style="color:var(--teal-dark);font-weight:600;">
                                <i class="ti ti-lock"></i> Selected from availability calendar.
                            </p>
                        </div>

                        <div class="form-section" style="margin-bottom:0;">
                            <label class="form-label">Duration</label>
                            <input class="form-input" type="text" readonly
                                value="{{ $preDuration }} Day{{ $preDuration > 1 ? 's' : '' }}"
                                style="background:#f9fafb;color:var(--text-3);">
                            <p class="form-hint">Selected from availability calendar.</p>
                        </div>
                    </div>

                    {{-- Dynamic Group Members Grid Section --}}
                    <div class="form-section border-t border-gray-100 pt-6" style="margin-bottom: 24px;">
                        <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                                    <i class="ti ti-users-group text-teal-600 text-lg"></i>
                                    Group Companions / Members
                                </h3>
                                <p class="text-xs text-gray-400 mt-0.5">Add companions who will join you on this visit.</p>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button type="button" @click="showPaste = !showPaste"
                                    class="inline-flex items-center gap-1 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 font-semibold rounded-xl px-3 py-1.5 text-xs transition">
                                    <i class="ti ti-clipboard-text"></i> Paste from Spreadsheet
                                </button>
                                <button type="button" @click="addRow()"
                                    class="inline-flex items-center gap-1 bg-teal-700 hover:bg-teal-800 text-white font-semibold rounded-xl px-3.5 py-1.5 text-xs transition">
                                    <i class="ti ti-plus"></i> Add Companion
                                </button>
                            </div>
                        </div>

                        {{-- Overcapacity Warning --}}
                        <div x-show="isOverCapacity" x-cloak
                            class="bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 mb-3 flex items-start gap-2.5">
                            <i class="ti ti-alert-circle text-red-500 text-lg shrink-0 mt-0.5"></i>
                            <div class="text-xs text-red-700">
                                <p class="font-bold">Capacity Limit Exceeded</p>
                                <p class="mt-0.5">Your group of <span x-text="totalGroupSize"></span> exceeds the remaining available slots (<span x-text="availableSlots"></span> remaining) on this date.</p>
                            </div>
                        </div>

                        {{-- Paste Zone (collapsible) --}}
                        <div x-show="showPaste" x-cloak class="mb-4">
                            <div class="paste-zone" @click="$refs.pasteArea.focus()"
                                @dragover.prevent="$event.currentTarget.classList.add('drag-over')"
                                @dragleave="$event.currentTarget.classList.remove('drag-over')">
                                <i class="ti ti-clipboard-data text-2xl flex-shrink-0"></i>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-700 text-sm">Paste clipboard data here</p>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        Copy rows from Excel/Sheets (columns: Name, Age, Gender, Contact, Email, Classification, Days) then click here and press Ctrl+V
                                    </p>
                                </div>
                            </div>
                            <textarea x-ref="pasteArea" @paste="handlePaste($event)" class="sr-only" aria-label="Paste area for bulk import" tabindex="-1"></textarea>
                        </div>

                        {{-- Empty State Placeholder --}}
                        <div x-show="rows.length === 0" class="text-center py-8 bg-gray-50 rounded-xl border border-dashed border-gray-200 mb-3">
                            <i class="ti ti-users text-4xl text-gray-300 block mb-2"></i>
                            <p class="text-sm font-semibold text-gray-500">No companions added yet</p>
                            <p class="text-xs text-gray-400 mt-1 mb-3">Travelling with family or friends? Add them to join your booking.</p>
                            <button type="button" @click="addRow()" class="inline-flex items-center gap-1 bg-teal-700 hover:bg-teal-800 text-white font-semibold rounded-xl px-4 py-2 text-xs transition">
                                <i class="ti ti-plus"></i> Add a Companion
                            </button>
                        </div>

                        {{-- Entry Grid Table --}}
                        <div x-show="rows.length > 0" class="overflow-x-auto border border-gray-150 rounded-xl">
                            <table class="visitor-table">
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
                                            <td class="row-num" x-text="i + 1"></td>
                                            <td class="relative">
                                                <input type="text" :name="'visitors['+i+'][name]'" x-model="row.name"
                                                    @input="clearError(row, 'name')"
                                                    @keydown.tab.prevent="focusNext($event, i, 'name')"
                                                    :class="{'cell-input': true, 'cell-error': row.errors.name}"
                                                    placeholder="Juan dela Cruz" required autocomplete="off">
                                                <div class="cell-tooltip" x-show="row.errors.name" x-text="row.errors.name"></div>
                                            </td>
                                            <td>
                                                <input type="number" :name="'visitors['+i+'][age]'" x-model.number="row.age"
                                                    min="1" max="150" @input="clearError(row, 'age')"
                                                    @keydown.tab.prevent="focusNext($event, i, 'age')"
                                                    :class="{'cell-input': true, 'cell-error': row.errors.age}" placeholder="Age" required>
                                            </td>
                                            <td>
                                                <div class="relative" x-data="{ open: false }">
                                                    <button type="button" @click="open = !open"
                                                        @keydown.tab.prevent="focusNext($event, i, 'gender')"
                                                        class="cell-input text-left flex justify-between items-center w-full focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gradient-to-b from-white to-gray-50/70 hover:from-white hover:to-teal-50/40 hover:border-teal-400 transition-all duration-200 group rounded-xl px-2.5 py-1.5 text-xs shadow-2xs hover:shadow-sm" style="min-width: 105px;">
                                                        <span class="flex items-center gap-1.5 truncate">
                                                            <template x-if="row.gender === 'Male'">
                                                                <span class="w-5 h-5 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-man"></i></span>
                                                            </template>
                                                            <template x-if="row.gender === 'Female'">
                                                                <span class="w-5 h-5 rounded-md bg-pink-100 text-pink-600 flex items-center justify-center text-xs font-bold shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-woman"></i></span>
                                                            </template>
                                                            <span x-text="row.gender || 'Select'" :class="!row.gender ? 'text-gray-400 font-normal' : 'font-semibold text-gray-800'"></span>
                                                        </span>
                                                        <i class="ti ti-chevron-down text-xs text-gray-400 group-hover:text-teal-600 transition-transform duration-200 transform shrink-0 ml-1" :class="open ? 'rotate-180 text-teal-600' : ''"></i>
                                                    </button>
                                                    <input type="hidden" :name="'visitors['+i+'][gender]'" :value="row.gender" required />
                                                    <div x-show="open" x-cloak @click.away="open = false"
                                                        class="absolute left-0 top-full mt-1.5 z-50 rounded-2xl bg-white/95 backdrop-blur-xl border border-teal-200/80 shadow-lg p-1.5 min-w-[130px] overflow-hidden font-sans">
                                                        <button type="button" @click="row.gender = 'Male'; open = false; clearError(row, 'gender')"
                                                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all duration-150 group"
                                                            :class="row.gender === 'Male' ? 'bg-blue-50/90 text-blue-950 font-bold border border-blue-200/60 shadow-2xs' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50/60 hover:text-blue-950 hover:translate-x-0.5'">
                                                            <span class="flex items-center gap-2">
                                                                <span class="w-6 h-6 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-man"></i></span>
                                                                <span>Male</span>
                                                            </span>
                                                        </button>
                                                        <button type="button" @click="row.gender = 'Female'; open = false; clearError(row, 'gender')"
                                                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all duration-150 group mt-1"
                                                            :class="row.gender === 'Female' ? 'bg-pink-50/90 text-pink-950 font-bold border border-pink-200/60 shadow-2xs' : 'text-gray-700 hover:bg-gradient-to-r hover:from-pink-50 hover:to-rose-50/60 hover:text-pink-950 hover:translate-x-0.5'">
                                                            <span class="flex items-center gap-2">
                                                                <span class="w-6 h-6 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-sm shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-woman"></i></span>
                                                                <span>Female</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="tel" :name="'visitors['+i+'][contact_number]'" x-model="row.contact_number"
                                                    @keydown.tab.prevent="focusNext($event, i, 'contact_number')"
                                                    class="cell-input" placeholder="09xxxxxxxxx">
                                            </td>
                                            <td>
                                                <input type="email" :name="'visitors['+i+'][email]'" x-model="row.email"
                                                    @input="clearError(row, 'email')"
                                                    @keydown.tab.prevent="focusNext($event, i, 'email')"
                                                    :class="{'cell-input': true, 'cell-error': row.errors.email}" placeholder="optional">
                                                <div class="cell-tooltip" x-show="row.errors.email" x-text="row.errors.email"></div>
                                            </td>
                                            <td>
                                                <div class="relative" x-data="{ open: false }">
                                                    <button type="button" @click="open = !open"
                                                        @keydown.tab.prevent="focusNext($event, i, 'classification')"
                                                        class="cell-input text-left flex justify-between items-center w-full focus:outline-none focus:ring-2 focus:ring-teal-500 bg-gradient-to-b from-white to-gray-50/70 hover:from-white hover:to-teal-50/40 hover:border-teal-400 transition-all duration-200 group rounded-xl px-2.5 py-1.5 text-xs shadow-2xs hover:shadow-sm" style="min-width: 150px;">
                                                        <span class="flex items-center gap-1.5 truncate">
                                                            <template x-if="row.classification === 'Local'">
                                                                <span class="w-5 h-5 rounded-md bg-emerald-100 text-emerald-600 flex items-center justify-center text-xs font-bold shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-home-heart"></i></span>
                                                            </template>
                                                            <template x-if="row.classification === 'Domestic Tourist'">
                                                                <span class="w-5 h-5 rounded-md bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-car"></i></span>
                                                            </template>
                                                            <template x-if="row.classification === 'International Tourist'">
                                                                <span class="w-5 h-5 rounded-md bg-purple-100 text-purple-600 flex items-center justify-center text-xs font-bold shadow-2xs group-hover:scale-110 transition-transform"><i class="ti ti-world"></i></span>
                                                            </template>
                                                            <span x-text="row.classification || 'Select'" :class="!row.classification ? 'text-gray-400 font-normal' : 'font-semibold text-gray-800'"></span>
                                                        </span>
                                                        <i class="ti ti-chevron-down text-xs text-gray-400 group-hover:text-teal-600 transition-transform duration-200 transform shrink-0 ml-1" :class="open ? 'rotate-180 text-teal-600' : ''"></i>
                                                    </button>
                                                    <input type="hidden" :name="'visitors['+i+'][classification]'" :value="row.classification" required />
                                                    <div x-show="open" x-cloak @click.away="open = false"
                                                        class="absolute left-0 top-full mt-1.5 z-50 rounded-2xl bg-white/95 backdrop-blur-xl border border-teal-200/80 shadow-lg p-1.5 min-w-[200px] overflow-hidden font-sans">
                                                        <button type="button" @click="row.classification = 'Local'; open = false; clearError(row, 'classification')"
                                                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all duration-150 group"
                                                            :class="row.classification === 'Local' ? 'bg-emerald-50/90 text-emerald-950 font-bold border border-emerald-200/60 shadow-2xs' : 'text-gray-700 hover:bg-gradient-to-r hover:from-emerald-50 hover:to-teal-50/60 hover:text-emerald-950 hover:translate-x-0.5'">
                                                            <span class="flex items-center gap-2.5">
                                                                <span class="w-7 h-7 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center text-base shadow-2xs group-hover:scale-110 transition-transform shrink-0"><i class="ti ti-home-heart"></i></span>
                                                                <span>Local</span>
                                                            </span>
                                                        </button>
                                                        <button type="button" @click="row.classification = 'Domestic Tourist'; open = false; clearError(row, 'classification')"
                                                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all duration-150 group mt-1"
                                                            :class="row.classification === 'Domestic Tourist' ? 'bg-blue-50/90 text-blue-950 font-bold border border-blue-200/60 shadow-2xs' : 'text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50/60 hover:text-blue-950 hover:translate-x-0.5'">
                                                            <span class="flex items-center gap-2.5">
                                                                <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-base shadow-2xs group-hover:scale-110 transition-transform shrink-0"><i class="ti ti-car"></i></span>
                                                                <span>Domestic Tourist</span>
                                                            </span>
                                                        </button>
                                                        <button type="button" @click="row.classification = 'International Tourist'; open = false; clearError(row, 'classification')"
                                                            class="w-full text-left px-3 py-2 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all duration-150 group mt-1"
                                                            :class="row.classification === 'International Tourist' ? 'bg-purple-50/90 text-purple-950 font-bold border border-purple-200/60 shadow-2xs' : 'text-gray-700 hover:bg-gradient-to-r hover:from-purple-50 hover:to-fuchsia-50/60 hover:text-purple-950 hover:translate-x-0.5'">
                                                            <span class="flex items-center gap-2.5">
                                                                <span class="w-7 h-7 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-base shadow-2xs group-hover:scale-110 transition-transform shrink-0"><i class="ti ti-world"></i></span>
                                                                <span>International Tourist</span>
                                                            </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="number" :name="'visitors['+i+'][duration_days]'" x-model.number="row.duration_days"
                                                    min="1" max="30" @input="clearError(row, 'duration_days')"
                                                    @keydown.tab.prevent="focusNextOrAddRow($event, i)"
                                                    :class="{'cell-input': true, 'cell-error': row.errors.duration_days}" placeholder="1" required>
                                            </td>
                                            <td class="text-center">
                                                <div class="flex items-center justify-center gap-1">
                                                    <button type="button" @click="duplicateRow(i)" class="row-action-btn btn-dupe" title="Duplicate Row">
                                                        <i class="ti ti-copy"></i>
                                                    </button>
                                                    <button type="button" @click="removeRow(i)" class="row-action-btn btn-remove" title="Remove Row" :disabled="rows.length <= 1">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="terms-box">
                        <p><i class="ti ti-clipboard-list text-amber-700 text-base"></i> Important Booking Terms</p>
                        <ul>
                            <li>All bookings are submitted with <strong>Pending Review</strong> status.</li>
                            <li>The site's assigned staff will review and approve your slot.</li>
                            <li>Once approved, a unique QR ticket is issued to scan at the gate.</li>
                            @if($preDuration > 1)
                                <li>Multi-day bookings are registered by start date; you'll need to check in each day.</li>
                            @endif
                        </ul>
                    </div>

                    <button type="button" @click="submitForm()" :disabled="isSubmitting" class="btn-submit" id="submit-btn" :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''">
                        <template x-if="!isSubmitting">
                            <span class="flex items-center justify-center gap-2">
                                <i class="ti ti-send text-lg"></i>
                                <span>Submit Booking Request</span>
                            </span>
                        </template>
                        <template x-if="isSubmitting">
                            <span class="flex items-center justify-center gap-2">
                                <i class="ti ti-loader-2 text-lg animate-spin"></i>
                                <span>Submitting Booking...</span>
                            </span>
                        </template>
                    </button>
                </form>
                <a href="{{ route('destinations.show', $destination) }}" class="btn-cancel">
                    <i class="ti ti-arrow-left text-base"></i>
                    <span>Back to Destination</span>
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function bookingGrid(capacity, initialCount) {
                return {
                    capacity,
                    initialCount,
                    rows: [],
                    showPaste: false,
                    isSubmitting: false,
                    _idCounter: 0,

                    init() {
                        this.addRow();  // Start with 1 blank companion row by default
                    },

                    newRow(defaults = {}) {
                        return {
                            id: ++this._idCounter,
                            name: defaults.name ?? '',
                            age: defaults.age ?? '',
                            gender: defaults.gender ?? '',
                            contact_number: defaults.contact_number ?? '',
                            email: defaults.email ?? '',
                            classification: defaults.classification ?? 'Local',
                            duration_days: defaults.duration_days ?? {{ $preDuration }},
                            hasError: false,
                            errors: { name: '', age: '', email: '', duration_days: '' }
                        };
                    },

                    get totalGroupSize() {
                        return 1 + this.rows.length;
                    },

                    get projectedCount() {
                        return this.totalGroupSize;
                    },

                    get availableSlots() {
                        return Math.max(0, this.capacity - this.initialCount);
                    },

                    get isOverCapacity() {
                        return this.totalGroupSize > this.availableSlots;
                    },

                    addRow(defaults = {}) {
                        this.rows.push(this.newRow(defaults));
                        this.$nextTick(() => {
                            const lastIdx = this.rows.length - 1;
                            this.focusCellAt(lastIdx, 'name');
                        });
                    },

                    removeRow(idx) {
                        this.rows.splice(idx, 1);
                    },

                    duplicateRow(idx) {
                        const src = this.rows[idx];
                        this.addRow({
                            name: '',
                            age: src.age,
                            gender: src.gender,
                            contact_number: src.contact_number,
                            email: src.email,
                            classification: src.classification,
                            duration_days: src.duration_days
                        });
                    },

                    clearError(row, field) {
                        row.errors[field] = '';
                        row.hasError = Object.values(row.errors).some(v => v !== '');
                    },

                    validateAll() {
                        let valid = true;
                        this.rows.forEach((row) => {
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

                    submitForm() {
                        if (this.isSubmitting) return;
                        if (this.isOverCapacity) {
                            alert('Capacity Limit Exceeded! Your group size exceeds the remaining capacity.');
                            return;
                        }
                        if (!this.validateAll()) {
                            this.$nextTick(() => {
                                const errRow = document.querySelector('tr.row-error');
                                if (errRow) errRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            });
                            return;
                        }
                        this.isSubmitting = true;
                        document.getElementById('booking-form').submit();
                    },

                    FIELD_ORDER: ['name', 'age', 'gender', 'contact_number', 'email', 'classification', 'duration_days'],

                    focusCellAt(rowIdx, field) {
                        this.$nextTick(() => {
                            const tbody = document.getElementById('visitor-tbody');
                            if (!tbody) return;
                            const tr = tbody.querySelectorAll('tr')[rowIdx];
                            if (!tr) return;
                            const colIdx = this.FIELD_ORDER.indexOf(field);
                            const cells = tr.querySelectorAll('td');
                            const targetCell = cells[colIdx + 1];
                            if (!targetCell) return;
                            const input = targetCell.querySelector('input, button');
                            if (input) { input.focus(); input.select && input.select(); }
                        });
                    },

                    focusNext(event, rowIdx, currentField) {
                        const currentColIdx = this.FIELD_ORDER.indexOf(currentField);
                        const nextColIdx = currentColIdx + 1;
                        if (nextColIdx < this.FIELD_ORDER.length) {
                            this.focusCellAt(rowIdx, this.FIELD_ORDER[nextColIdx]);
                        } else {
                            this.focusNextOrAddRow(event, rowIdx);
                        }
                    },

                    focusNextOrAddRow(event, rowIdx) {
                        if (rowIdx < this.rows.length - 1) {
                            this.focusCellAt(rowIdx + 1, 'name');
                        } else {
                            this.addRow();
                        }
                    },

                    handlePaste(event) {
                        event.preventDefault();
                        const raw = (event.clipboardData || window.clipboardData).getData('text');
                        const lines = raw.trim().split(/\r?\n/);
                        let imported = 0;

                        lines.forEach(line => {
                            if (!line.trim()) return;
                            const cols = line.includes('\t') ? line.split('\t') : line.split(',');
                            const clean = cols.map(c => c.trim().replace(/^"|"$/g, ''));

                            const name = clean[0] || '';
                            const age = parseInt(clean[1]) || '';
                            const gender = clean[2] || '';
                            const contact = clean[3] || '';
                            const email = clean[4] || '';

                            const rawClass = (clean[5] || '').toLowerCase();
                            let classification = 'Local';
                            if (rawClass.includes('international')) classification = 'International Tourist';
                            else if (rawClass.includes('domestic')) classification = 'Domestic Tourist';

                            const duration_days = parseInt(clean[6]) || {{ $preDuration }};

                            if (name) {
                                this.addRow({ name, age, gender, contact_number: contact, email, classification, duration_days });
                                imported++;
                            }
                        });

                        if (imported > 0) {
                            this.showPaste = false;
                        }
                    }
                };
            }
        </script>
    @endpush
</x-app-layout>
