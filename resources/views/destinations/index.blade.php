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
                <i class="ti ti-map-2 text-green-700"></i>
                Explore Spots
            </h2>
        </div>
    </x-slot>

    {{-- ══ Inline Styles ══════════════════════════════════════════════ --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal:       #16a34a;
            --teal-light: #4ade80;
            --teal-dark:  #166534;
            --ocean:      #22c55e;
            --sand:       #a3e635;
            --emerald:    #10b981;
            --rose:       #f43f5e;
            --indigo:     #0B3D2E;
            --bg:         #f0fdf4;
            --border:     #dcfce7;
            --text-1:     #0B3D2E;
            --text-2:     #374151;
            --text-3:     #6b7280;
            --text-4:     #9ca3af;
            --t:          0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card:    0 2px 12px rgba(0,0,0,.07);
            --sh-lg:      0 12px 40px rgba(22,197,94,.18);
            --r-sm: 8px; --r-md: 14px; --r-lg: 20px; --r-xl: 28px;
        }

        #dest-page * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        /* Search bar */
        .search-wrap { position: relative; width: 100%; min-width: 0; }
        .search-bar {
            display: flex; align-items: center;
            background: #fff; border-radius: 12px;
            border: 1.5px solid #dcfce7;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            height: 44px;
            transition: all 0.25s ease-in-out;
            width: 100%;
        }
        .search-bar:focus-within {
            border-color: #16a34a;
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.12);
        }
        .search-icon { margin-left: 14px; flex-shrink: 0; color: var(--text-4); transition: color 0.25s; }
        .search-bar:focus-within .search-icon { color: #16a34a; }
        .search-input {
            flex: 1; border: none; outline: none;
            padding: 0 12px; font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .88rem; color: var(--text-2); background: transparent;
            height: 100%;
            min-width: 0;
        }
        .search-input::placeholder { color: var(--text-4); }
        .search-divider { width: 1px; height: 24px; background: #e5e7eb; flex-shrink: 0; }
        .search-btn {
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; border: none; padding: 0 16px; margin: 4px;
            border-radius: 9px; font-size: .82rem; font-weight: 700;
            cursor: pointer; transition: all 0.2s ease-in-out; font-family: 'Plus Jakarta Sans', sans-serif;
            flex-shrink: 0;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .search-btn:hover { transform: scale(1.02); opacity: 0.95; }
        .search-btn:active { transform: scale(0.97); }

        .sort-select-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #fff;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 32px 0 12px;
            transition: all 0.25s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            height: 44px;
            cursor: pointer;
            min-width: 165px;
            width: auto;
        }
        .sort-select-wrapper:hover {
            border-color: #16a34a;
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.08);
        }

        /* Suggestions */
        .suggestions-box {
            position: absolute; top: calc(100% + 6px); left: 0; right: 0;
            background: #fff; border-radius: var(--r-md);
            box-shadow: 0 8px 32px rgba(0,0,0,.14);
            overflow: hidden; z-index: 300; border: 1px solid #e5e7eb;
        }
        .sug-item {
            display: flex; align-items: center; gap: 10px;
            padding: 11px 16px; cursor: pointer;
            transition: background var(--t); font-size: .88rem;
        }
        .sug-item:hover { background: #f0fdfc; }
        .sug-name { font-weight: 600; color: var(--text-1); }
        .sug-loc  { color: var(--text-4); font-size: .78rem; }
        .sug-item mark { background: rgba(20,184,166,.2); color: var(--teal-dark); border-radius: 3px; padding: 0 2px; font-weight: 700; }

        /* ── Main content ── */
        .section-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 28px 0 18px; gap: 12px; flex-wrap: wrap;
        }
        .section-title { font-weight: 700; font-size: 1.05rem; color: var(--text-1); }
        .result-count  { font-size: .82rem; color: var(--text-3); }
        .sort-select {
            border: none;
            background: transparent;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: .82rem;
            color: var(--text-2);
            font-weight: 700;
            outline: none;
            cursor: pointer;
            appearance: none;
            width: 100%;
            height: 100%;
        }
        .view-toggle {
            display: flex;
            background: #f3f4f6;
            padding: 3px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            height: 44px;
            align-items: center;
        }
        .view-btn {
            padding: 0 16px;
            border: none;
            background: transparent;
            cursor: pointer;
            color: var(--text-3);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            height: 100%;
        }
        .view-btn.active {
            background: #fff;
            color: #16a34a;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .filter-btn-trigger {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1.5px solid #e5e7eb;
            background: #fff;
            padding: 0 16px;
            border-radius: 12px;
            font-size: .82rem;
            font-weight: 700;
            color: var(--text-2);
            transition: all 0.25s ease;
            height: 44px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            cursor: pointer;
        }
        .filter-btn-trigger:hover {
            border-color: #16a34a;
            color: #16a34a;
            box-shadow: 0 2px 8px rgba(22, 163, 74, 0.08);
        }
        .filter-btn-trigger:active {
            transform: scale(0.97);
        }

        .toolbar-controls-grid {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .toolbar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: #fff;
            padding: 16px 20px;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            width: 100%;
            transition: all 0.25s ease;
        }

        /* Responsive stack styling */
        @media (max-width: 767px) {
            .toolbar-container {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                padding: 16px;
            }
            .search-wrap {
                max-width: 100% !important;
            }
            .toolbar-controls-grid {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                width: 100%;
            }
            .toolbar-controls-grid .relative,
            .toolbar-controls-grid .filter-btn-trigger,
            .toolbar-controls-grid .view-toggle {
                width: 100% !important;
                min-width: 0;
            }
            .toolbar-controls-grid .view-toggle {
                justify-content: center;
            }
            .view-btn {
                flex: 1;
            }
        }

        /* ── Destination Cards ── */
        .dest-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 20px; }
        .dest-grid.list-view { grid-template-columns: 1fr; }

        .dest-card {
            background: #fff; border-radius: var(--r-lg);
            overflow: hidden; box-shadow: var(--sh-card);
            border: 1px solid #e5f6f4;
            transition: transform var(--t), box-shadow var(--t);
            cursor: pointer; text-decoration: none; display: block;
        }
        .dest-card:hover { transform: translateY(-4px); box-shadow: var(--sh-lg); }

        .card-img {
            width: 100%; height: 180px;
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; overflow: hidden; position: relative;
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }
        .card-badge {
            position: absolute; top: 10px; right: 10px;
            padding: 3px 10px; border-radius: 99px;
            font-size: .7rem; font-weight: 700;
            letter-spacing: .3px; text-transform: uppercase;
        }
        .badge-open    { background: #d1fae5; color: #065f46; }
        .badge-limited { background: #fef3c7; color: #92400e; }
        .badge-full    { background: #fee2e2; color: #991b1b; }
        .badge-closed  { background: #f3f4f6; color: #4b5563; }

        .card-body { padding: 18px 20px 20px; }
        .card-cat-tag {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 6px;
            font-size: .7rem; font-weight: 600;
            background: rgba(13,148,136,.08); color: var(--teal-dark);
            margin-bottom: 6px;
        }
        .card-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 8px; margin-bottom: 6px; }
        .card-name { font-weight: 700; font-size: 1rem; color: var(--text-1); line-height: 1.3; }
        .card-location { display: flex; align-items: center; gap: 5px; font-size: .8rem; color: var(--text-3); margin-bottom: 12px; }
        .card-meta { display: flex; align-items: center; gap: 16px; padding-top: 12px; border-top: 1px solid #f3f4f6; }
        .meta-item { display: flex; align-items: center; gap: 5px; font-size: .78rem; color: var(--text-3); }
        .meta-item strong { color: var(--text-2); font-weight: 600; }

        .cap-bar { height: 5px; background: #e5e7eb; border-radius: 99px; margin-top: 10px; overflow: hidden; }
        .cap-fill { height: 100%; border-radius: 99px; }
        .fill-low  { background: var(--emerald); }
        .fill-mid  { background: var(--sand); }
        .fill-high { background: #f97316; }
        .fill-full { background: var(--rose); }

        /* List view adjustments */
        .dest-grid.list-view .dest-card { display: flex; }
        .dest-grid.list-view .card-img  { width: 140px; height: auto; min-height: 120px; flex-shrink: 0; font-size: 2.5rem; }
        .dest-grid.list-view .card-body { flex: 1; }

        /* Admin row */
        .card-admin-row {
            display: flex; gap: 8px; padding: 10px 20px;
            border-top: 1px solid #f0fdfc; background: #fafffe;
        }

        /* ── No results / empty ── */
        .no-results { grid-column: 1/-1; text-align: center; padding: 48px; }
        .no-results .nr-ico { font-size: 3rem; margin-bottom: 12px; }
        .no-results p { font-size: .95rem; color: var(--text-3); margin-bottom: 16px; }
        .btn-sm {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 8px 18px; border-radius: 99px;
            border: 1.5px solid var(--border); background: #fff;
            font-size: .82rem; font-weight: 600; color: var(--text-2);
            cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-sm:hover { border-color: var(--teal); color: var(--teal); }

        .empty-state { padding: 80px 24px; text-align: center; }
        .empty-illus {
            width: 110px; height: 110px; border-radius: 50%;
            background: linear-gradient(135deg, #ccfbf1, #bae6fd);
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem; margin: 0 auto 24px;
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
        .empty-title { font-family: 'Fraunces', serif; font-size: 1.6rem; color: var(--text-1); margin-bottom: 10px; }
        .empty-desc  { color: var(--text-3); max-width: 360px; margin: 0 auto 24px; }

        @media (max-width: 640px) {
            .dest-hero { padding: 40px 16px 56px; }
            #dest-page .dest-main { padding: 0 16px 48px; }
            .dest-grid { grid-template-columns: 1fr; }
            .dest-grid.list-view .dest-card { flex-direction: column; }
            .dest-grid.list-view .card-img { width: 100%; height: 110px; }
        }
    </style>

    <div class="pb-12 pt-0" id="dest-page">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">



        {{-- ══ Main Grid ══════════════════════════════════════════════════ --}}
        <main class="dest-main" id="list-main">

            {{-- Flash --}}
            @if(session('success'))
                <div style="background:#ecfdf5;border:1px solid #6ee7b7;color:#065f46;padding:12px 18px;border-radius:12px;font-size:.88rem;margin-top:20px;display:flex;align-items:center;gap:8px;">
                    <svg style="width:16px;height:16px;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg> {{ session('success') }}
                </div>
            @endif

            <div class="toolbar-container mb-4">
                {{-- Search & Filters --}}
                <div class="search-wrap flex-1" role="search" style="max-width: 600px; margin: 0;">
                    <div class="search-bar">
                        <svg class="search-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input
                            id="search-input"
                            class="search-input"
                            type="search"
                            placeholder="Search spots by name or location…"
                            aria-label="Search destinations"
                            autocomplete="off"
                            oninput="onSearchInput()"
                            onkeydown="onSearchKeydown(event)"
                            onfocus="showSuggestions()"
                        />
                        <input type="hidden" id="location-select" value="" />
                        <button class="search-btn" onclick="applyFilters()" aria-label="Apply search">Search</button>
                    </div>
                    <div id="suggestions-box" class="suggestions-box" style="display:none;" role="listbox" aria-label="Search suggestions"></div>
                </div>

                {{-- Controls --}}
                <div class="toolbar-controls-grid">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('destinations.create') }}"
                        style="background:linear-gradient(135deg,var(--teal),var(--ocean)); color:#fff; text-decoration:none; height:44px;"
                        class="font-bold px-4 rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-1.5 hover:opacity-90 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                        <span>Add Spot</span>
                    </a>
                    @endif

                    {{-- Sort by Popover Button --}}
                    <div class="relative">
                        <button class="filter-btn-trigger" onclick="toggleSortPanel()" aria-label="Toggle sort options">
                            <span id="sort-label">Sort: Default Match</span>
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <input type="hidden" id="sort-select" value="default" />
                        <div id="sort-dropdown-menu" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg z-50 p-2 space-y-1">
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition bg-green-50 text-green-700" onclick="selectSortOption('default', 'Default Match', this)">Default Match</button>
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition" onclick="selectSortOption('name-asc', 'Name A–Z', this)">Name A–Z</button>
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition" onclick="selectSortOption('name-desc', 'Name Z–A', this)">Name Z–A</button>
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition" onclick="selectSortOption('capacity-asc', 'Capacity: Low→High', this)">Capacity: Low→High</button>
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition" onclick="selectSortOption('capacity-desc', 'Capacity: High→Low', this)">Capacity: High→Low</button>
                            <button class="w-full text-left px-3 py-2 rounded-lg text-xs font-semibold hover:bg-green-50 hover:text-green-700 transition" onclick="selectSortOption('avail', 'Availability: Open First', this)">Availability: Open First</button>
                        </div>
                    </div>

                    {{-- Layout Switcher --}}
                    <div class="view-toggle" role="group" aria-label="Switch layout">
                        <button class="view-btn active" id="btn-grid" onclick="setLayout('grid')" title="Grid view" aria-pressed="true">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path d="M1 2.5A1.5 1.5 0 012.5 1h3A1.5 1.5 0 017 2.5v3A1.5 1.5 0 015.5 7h-3A1.5 1.5 0 011 5.5v-3zm8 0A1.5 1.5 0 0110.5 1h3A1.5 1.5 0 0115 2.5v3A1.5 1.5 0 0113.5 7h-3A1.5 1.5 0 019 5.5v-3zm-8 8A1.5 1.5 0 012.5 9h3A1.5 1.5 0 017 10.5v3A1.5 1.5 0 015.5 15h-3A1.5 1.5 0 011 13.5v-3zm8 0A1.5 1.5 0 0110.5 9h3a1.5 1.5 0 011.5 1.5v3a1.5 1.5 0 01-1.5 1.5h-3A1.5 1.5 0 019 13.5v-3z"/></svg>
                        </button>
                        <button class="view-btn" id="btn-list" onclick="setLayout('list')" title="List view" aria-pressed="false">
                            <svg width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M2.5 12a.5.5 0 01.5-.5h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5zm0-4a.5.5 0 01.5-.5h10a.5.5 0 010 1H3a.5.5 0 01-.5-.5z"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Results count label below toolbar --}}
            <div class="result-count-label text-xs font-bold text-gray-400 tracking-wider uppercase mb-5" id="result-count-label" aria-live="polite">
                <span id="result-count">{{ $destinations->count() }} destinations</span> found
            </div>

            @if($destinations->isEmpty())
            <div class="empty-state">
                <div class="empty-illus scale-150" aria-hidden="true"><svg style="width:2.5rem;height:2.5rem;opacity:0.4;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg></div>
                <div class="empty-title">No Destinations Yet</div>
                <p class="empty-desc">There are no tourist destinations registered yet. Check back soon — our team is actively adding new spots!</p>
            </div>
            @else

            <div class="dest-grid" id="dest-grid" role="list" aria-label="Destination list">
                @foreach($destinations as $dest)
                @php
                    $gradient = 'linear-gradient(135deg,#0d9488,#166534)';
                    $n = strtolower($dest->name);
                    if (str_contains($n,'casas')||str_contains($n,'shrine')||str_contains($n,'heritage')) {
                        $gradient='linear-gradient(135deg,#b45309,#92400e)';
                    } elseif (str_contains($n,'park')||str_contains($n,'rapids')||str_contains($n,'river')||str_contains($n,'adventure')) {
                        $gradient='linear-gradient(135deg,#0d9488,#0f766e)';
                    } elseif (str_contains($n,'lake')||str_contains($n,'falls')||str_contains($n,'maragang')) {
                        $gradient='linear-gradient(135deg,#0ea5e9,#0369a1)';
                    }
                    $confirmedToday = $dest->bookings()->where('status','confirmed')->where('visit_date', now()->toDateString())->count();
                    $pct = $dest->capacity > 0 ? min(100, round(($confirmedToday/$dest->capacity)*100)) : 0;
                    $fillCls = $pct>=100?'fill-full':($pct>=75?'fill-high':($pct>=50?'fill-mid':'fill-low'));
                    $status = $dest->availability_status === 'Available' ? 'open' : 'closed';
                    if ($dest->availability_status === 'Available' && $pct >= 75) $status = 'limited';
                    if ($dest->availability_status === 'Available' && $pct >= 100) $status = 'full';
                    $badgeCls = ['open'=>'badge-open','limited'=>'badge-limited','full'=>'badge-full','closed'=>'badge-closed'][$status] ?? 'badge-closed';
                    $badgeLbl = ['open'=>'Open','limited'=>'Limited','full'=>'Full','closed'=>'Unavailable'][$status] ?? 'Unavailable';
                    $cardIllus = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg>';
                @endphp
                <article class="dest-card" role="listitem"
                    data-name="{{ strtolower($dest->name) }}"
                    data-location="{{ strtolower($dest->location) }}"
                    data-capacity="{{ $dest->capacity }}"
                    data-status="{{ $status }}"
                    onclick="window.location='{{ route('destinations.show', $dest) }}'"
                    tabindex="0"
                    onkeydown="if(event.key==='Enter')window.location='{{ route('destinations.show', $dest) }}'"
                    aria-label="{{ $dest->name }}, {{ $dest->location }}, {{ $badgeLbl }}">

                    <div class="card-img" style="background:{{ $gradient }};" aria-hidden="true">
                        @if($dest->photos)
                            <img src="{{ Storage::url($dest->photos) }}" alt="{{ $dest->name }}">
                        @else
                            <span class="scale-150" style="display:inline-flex;opacity:0.6;">{!! $cardIllus !!}</span>
                        @endif
                        <span class="card-badge {{ $badgeCls }}">{{ $badgeLbl }}</span>
                    </div>

                    <div class="card-body">
                        <div class="card-top">
                            <div class="card-name">{{ $dest->name }}</div>
                        </div>
                        <div class="card-location">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            {{ $dest->location }}
                        </div>
                        <div class="card-meta">
                            <div class="meta-item"><strong>{{ $confirmedToday }}</strong>&nbsp;/&nbsp;{{ $dest->capacity }} today</div>
                        </div>
                        <div class="cap-bar" role="progressbar" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="cap-fill {{ $fillCls }}" style="width:{{ $pct }}%"></div>
                        </div>
                    </div>

                    @if(auth()->user()->isAdmin())
                    <div class="card-admin-row" onclick="event.stopPropagation()">
                        <a href="{{ route('destinations.edit', $dest) }}" style="font-size:.75rem;color:#b45309;font-weight:600;text-decoration:none;padding:4px 10px;border-radius:6px;background:#fef3c7;border:1px solid #fcd34d;display:inline-flex;align-items:center;gap:4px;"><svg style="width:12px;height:12px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> Edit</a>
                        <form action="{{ route('destinations.destroy', $dest) }}" method="POST" onsubmit="return confirm('Delete {{ $dest->name }}?')" style="margin:0;">
                            @csrf @method('DELETE')
                            <button type="submit" style="font-size:.75rem;color:#991b1b;font-weight:600;padding:4px 10px;border-radius:6px;background:#fee2e2;border:1px solid #fca5a5;cursor:pointer;font-family:inherit;display:inline-flex;align-items:center;gap:4px;"><svg style="width:12px;height:12px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg> Delete</button>
                        </form>
                    </div>
                    @endif
                </article>
                @endforeach

                {{-- No-results state (shown via JS) --}}
                <div id="no-results" class="no-results" style="display:none;" role="status">
                    <div class="nr-ico"><svg style="width:2rem;height:2rem;opacity:0.35;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg></div>
                    <p>No destinations match your search.<br>Try a different keyword or filter.</p>
                    <button class="btn-sm" onclick="clearFilters()">Clear all filters</button>
                </div>
            </div>

            @endif
        </main>
        </div>
    </div>

    {{-- ══ JavaScript ════════════════════════════════════════════════════ --}}
    <script>
    (function() {
        let activeLayout   = 'grid';

        // ── Filter Dropdown ──
        window.toggleFilterPanel = function() {
            const menu = document.getElementById('filter-dropdown-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        };

        window.toggleSortPanel = function() {
            const menu = document.getElementById('sort-dropdown-menu');
            if (menu) {
                menu.classList.toggle('hidden');
            }
        };

        // Close dropdowns when clicking outside
        document.addEventListener('click', e => {
            // Category filter
            const filterDropdown = document.getElementById('filter-dropdown-menu');
            const filterBtn = e.target.closest('[onclick="toggleFilterPanel()"]');
            if (filterDropdown && !filterDropdown.contains(e.target) && !filterBtn) {
                filterDropdown.classList.add('hidden');
            }
            
            // Sort dropdown
            const sortDropdown = document.getElementById('sort-dropdown-menu');
            const sortBtn = e.target.closest('[onclick="toggleSortPanel()"]');
            if (sortDropdown && !sortDropdown.contains(e.target) && !sortBtn) {
                sortDropdown.classList.add('hidden');
            }
        });

        window.selectSortOption = function(val, text, el) {
            const input = document.getElementById('sort-select');
            if (input) {
                input.value = val;
            }
            const label = document.getElementById('sort-label');
            if (label) {
                label.textContent = `Sort: ${text}`;
            }
            // Highlight selected item in dropdown
            const menu = document.getElementById('sort-dropdown-menu');
            if (menu) {
                menu.querySelectorAll('button').forEach(btn => {
                    btn.classList.toggle('bg-green-50', btn === el);
                    btn.classList.toggle('text-green-700', btn === el);
                });
                menu.classList.add('hidden'); // close menu
            }
            applyFilters();
        };

        // ── Layout Toggle ──
        window.setLayout = function(mode) {
            activeLayout = mode;
            const grid = document.getElementById('dest-grid');
            if (grid) grid.classList.toggle('list-view', mode === 'list');
            const btnGrid = document.getElementById('btn-grid');
            const btnList = document.getElementById('btn-list');
            if (btnGrid) {
                btnGrid.classList.toggle('active', mode === 'grid');
                btnGrid.setAttribute('aria-pressed', mode === 'grid' ? 'true' : 'false');
            }
            if (btnList) {
                btnList.classList.toggle('active', mode === 'list');
                btnList.setAttribute('aria-pressed', mode === 'list' ? 'true' : 'false');
            }
        };

        // ── Filter + Sort ──
        window.applyFilters = function() {
            const q    = document.getElementById('search-input').value.toLowerCase().trim();
            const loc  = document.getElementById('location-select').value.toLowerCase();
            const sort = document.getElementById('sort-select').value;
            const cards = Array.from(document.querySelectorAll('.dest-card'));

            let visible = 0;
            cards.forEach(c => {
                const name  = c.dataset.name     || '';
                const cloc  = c.dataset.location || '';
                const status= c.dataset.status   || '';

                const mQ  = !q   || name.includes(q) || cloc.includes(q);
                const mL  = !loc || cloc.includes(loc);
                const show = mQ && mL;

                c.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            // Sort
            const grid = document.getElementById('dest-grid');
            if (grid && sort !== 'default') {
                const visible_cards = cards.filter(c => c.style.display !== 'none');
                visible_cards.sort((a, b) => {
                    if (sort === 'name-asc')       return a.dataset.name.localeCompare(b.dataset.name);
                    if (sort === 'name-desc')       return b.dataset.name.localeCompare(a.dataset.name);
                    if (sort === 'capacity-asc')    return +a.dataset.capacity - +b.dataset.capacity;
                    if (sort === 'capacity-desc')   return +b.dataset.capacity - +a.dataset.capacity;
                    if (sort === 'avail') {
                        const o = {open:0,limited:1,full:2,closed:3};
                        return (o[a.dataset.status]||9)-(o[b.dataset.status]||9);
                    }
                    return 0;
                });
                visible_cards.forEach(c => grid.appendChild(c));
            }

            const nr = document.getElementById('no-results');
            if (nr) nr.style.display = visible > 0 ? 'none' : 'block';

            const rc = document.getElementById('result-count');
            if (rc) rc.textContent = `${visible} destination${visible !== 1 ? 's' : ''}`;
        };

        window.clearFilters = function() {
            document.getElementById('search-input').value = '';
            document.getElementById('location-select').value = '';
            document.getElementById('sort-select').value = 'default';
            applyFilters();
        };

        @php
            $jsDestinations = $destinations->map(function($d) {
                return [
                    'id' => $d->id,
                    'name' => $d->name,
                    'location' => $d->location,
                    'url' => route('destinations.show', $d)
                ];
            });
        @endphp
        const destinations = @json($jsDestinations);

        window.onSearchInput = function() {
            applyFilters();
            const q = document.getElementById('search-input').value.trim().toLowerCase();
            if (q.length < 1) { hideSuggestions(); return; }
            const hits = destinations.filter(d =>
                d.name.toLowerCase().includes(q) || d.location.toLowerCase().includes(q)
            ).slice(0, 5);
            renderSuggestions(hits, q);
        };

        function renderSuggestions(hits, q) {
            const box = document.getElementById('suggestions-box');
            if (!box || hits.length === 0) { hideSuggestions(); return; }
            const re = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g,'\\$&')})`, 'gi');
            box.innerHTML = hits.map(d => `
                <div class="sug-item" onclick="window.location='${d.url}'" role="option" tabindex="0"
                    onkeydown="if(event.key==='Enter')window.location='${d.url}'"
                    aria-label="${d.name}, ${d.location}">
                    <div>
                        <div class="sug-name">${d.name.replace(re,'<mark>$1</mark>')}</div>
                        <div class="sug-loc">${d.location.replace(re,'<mark>$1</mark>')}</div>
                    </div>
                </div>`).join('');
            box.style.display = 'block';
        }

        window.showSuggestions = function() {
            const q = document.getElementById('search-input').value.trim().toLowerCase();
            if (q.length >= 1) onSearchInput();
        };

        function hideSuggestions() {
            const box = document.getElementById('suggestions-box');
            if (box) box.style.display = 'none';
        }

        window.onSearchKeydown = function(e) {
            if (e.key === 'Escape') hideSuggestions();
            if (e.key === 'Enter')  hideSuggestions();
        };

        document.addEventListener('click', e => {
            if (!e.target.closest('.search-wrap')) hideSuggestions();
        });

        // Boot
        applyFilters();
    })();
    </script>
        </div>
    </div>
</x-app-layout>
