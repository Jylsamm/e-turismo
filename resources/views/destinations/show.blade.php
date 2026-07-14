<x-app-layout>
    {{-- No header slot — full-width detail layout --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal:       #16a34a; --teal-light: #4ade80; --teal-dark: #166534;
            --ocean:      #22c55e; --sand: #a3e635; --emerald: #10b981;
            --rose:       #f43f5e; --indigo: #0B3D2E; --purple: #8b5cf6;
            --bg:         #f0fdf4; --border: #dcfce7;
            --text-1:     #0B3D2E; --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t:          0.22s cubic-bezier(0.4,0,0.2,1);
            --sh-card:    0 2px 12px rgba(0,0,0,.07);
            --sh-md:      0 4px 20px rgba(22,197,94,.13);
            --r-sm: 8px; --r-md: 14px; --r-lg: 20px; --r-xl: 28px;
        }
        #dest-detail * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        /* ── Wrapper ── */
        #dest-detail { background: var(--bg); min-height: 100vh; }
        .detail-outer { max-width: 1200px; margin: 0 auto; padding: 0 24px 64px; }

        /* ── Back button ── */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--teal); font-weight: 600; font-size: .88rem;
            background: none; border: none; padding: 28px 0 0;
            cursor: pointer; transition: gap var(--t); text-decoration: none;
        }
        .back-btn:hover { gap: 12px; }

        /* ── Hero ── */
        .detail-hero {
            border-radius: var(--r-xl); overflow: hidden;
            height: clamp(200px, 35vw, 360px);
            margin: 16px 0 28px; position: relative;
            display: flex; align-items: flex-end;
        }
        .detail-hero-bg { position: absolute; inset: 0; background-size: cover; background-position: center; }
        .detail-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0) 40%, rgba(0,0,0,.55) 100%); }
        .detail-hero-text { position: relative; z-index: 1; padding: 24px 32px; width: 100%; }
        .detail-hero-name { font-family: 'Fraunces', serif; font-size: clamp(1.5rem,4vw,2.2rem); color: #fff; line-height: 1.1; text-shadow: 0 2px 8px rgba(0,0,0,.3); }
        .detail-hero-loc  { color: rgba(255,255,255,.82); font-size: .9rem; margin-top: 6px; display: flex; align-items: center; gap: 5px; }

        /* ── Grid ── */
        .detail-grid { display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start; }
        @media(max-width: 768px) { .detail-grid { grid-template-columns: 1fr; } }

        /* ── Cards ── */
        .detail-card {
            background: #fff; border-radius: var(--r-lg); padding: 26px;
            box-shadow: var(--sh-card); border: 1px solid #e5f6f4; margin-bottom: 20px;
        }
        .detail-card:last-child { margin-bottom: 0; }
        .detail-section-title {
            font-weight: 700; font-size: .78rem; letter-spacing: .8px;
            text-transform: uppercase; color: var(--teal); margin-bottom: 14px;
        }
        .detail-desc { color: var(--text-2); line-height: 1.8; font-size: .93rem; }

        .tag-row { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 14px; }
        .tag { padding: 4px 12px; border-radius: 99px; background: #f0fdfc; color: var(--teal-dark); font-size: .75rem; font-weight: 600; border: 1px solid #99f6e4; }

        .highlights { list-style: none; margin-top: 18px; display: flex; flex-direction: column; gap: 10px; }
        .highlights li { display: flex; align-items: center; gap: 10px; font-size: .86rem; color: var(--text-2); }
        .hi-icon { width: 32px; height: 32px; border-radius: 8px; background: #f0fdfc; display: flex; align-items: center; justify-content: center; font-size: 1rem; flex-shrink: 0; }

        /* ── Sidebar stats ── */
        .sidebar-stat { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f3f4f6; font-size: .86rem; }
        .sidebar-stat:last-of-type { border-bottom: none; }
        .ss-label { color: var(--text-3); display: flex; align-items: center; gap: 6px; }
        .ss-value { font-weight: 700; color: var(--text-1); }

        .cap-bar-lg { height: 10px; background: #e5e7eb; border-radius: 99px; margin-top: 14px; overflow: hidden; }
        .cap-bar-fill { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.4,0,.2,1); }
        .fill-low  { background: var(--emerald); } .fill-mid  { background: var(--sand); }
        .fill-high { background: #f97316; }         .fill-full { background: var(--rose); }
        .cap-labels { display: flex; justify-content: space-between; font-size: .75rem; color: var(--text-3); margin-top: 5px; }

        .avail-block { border-radius: var(--r-md); padding: 16px; text-align: center; margin-top: 18px; }
        .avail-block .av-label  { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; opacity: .75; margin-bottom: 4px; }
        .avail-block .av-status { font-weight: 800; font-size: 1.15rem; }
        .av-open    { background: #d1fae5; color: #065f46; }
        .av-limited { background: #fef3c7; color: #92400e; }
        .av-full    { background: #fee2e2; color: #991b1b; }
        .av-closed  { background: #f3f4f6; color: #4b5563; }

        /* ── Action button ── */
        .btn-book {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; margin-top: 16px; padding: 13px;
            border: none; border-radius: var(--r-md); font-size: .95rem; font-weight: 700;
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; box-shadow: 0 4px 16px rgba(13,148,136,.3);
            cursor: pointer; transition: var(--t); text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-book:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.4); color: #fff; }
        .btn-book-disabled {
            display: flex; align-items: center; justify-content: center;
            width: 100%; margin-top: 16px; padding: 13px;
            border-radius: var(--r-md); font-size: .95rem; font-weight: 700;
            background: #e5e7eb; color: var(--text-4); cursor: not-allowed;
        }

        /* ── Calendar ── */
        #cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .cal-weekday { font-size: .62rem; font-weight: 700; text-align: center; color: var(--text-4); text-transform: uppercase; letter-spacing: .05em; padding: 4px 0; }
        .cal-day {
            position: relative; aspect-ratio: 1/1; display: flex; flex-direction: column;
            align-items: center; justify-content: center; border-radius: 10px;
            font-size: .76rem; font-weight: 600; cursor: default;
            border: 2px solid transparent; transition: all .15s ease;
            user-select: none; min-height: 36px;
        }
        .cal-day.empty  { background: transparent; border: none; }
        .cal-day.past   { background: #f9fafb; color: #d1d5db; cursor: not-allowed; }
        .cal-day.open   { background: #ecfdf5; color: #065f46; border-color: #6ee7b7; cursor: pointer; }
        .cal-day.open:hover, .cal-day.open.hovered { background: #10b981; color: #fff; border-color: #059669; transform: scale(1.08); box-shadow: 0 4px 12px rgba(16,185,129,.35); }
        .cal-day.limited { background: #fffbeb; color: #92400e; border-color: #fcd34d; cursor: pointer; }
        .cal-day.limited:hover, .cal-day.limited.hovered { background: #f59e0b; color: #fff; border-color: #d97706; transform: scale(1.08); box-shadow: 0 4px 12px rgba(245,158,11,.35); }
        .cal-day.full    { background: #fef2f2; color: #b91c1c; border-color: #fca5a5; cursor: not-allowed; }
        .cal-day.insufficient { background: #f9fafb; color: #9ca3af; border-color: #e5e7eb; cursor: not-allowed; position: relative; overflow: hidden; }
        .cal-day.insufficient::after { content: ''; position: absolute; top: 50%; left: 12%; right: 12%; height: 1.5px; background: #d1d5db; transform: translateY(-50%) rotate(-15deg); }
        .cal-day.range-start { background: #4f46e5 !important; color: #fff !important; border-color: #3730a3 !important; transform: scale(1.08); box-shadow: 0 4px 14px rgba(79,70,229,.45); border-radius: 10px 0 0 10px !important; }
        .cal-day.range-end   { background: #4f46e5 !important; color: #fff !important; border-color: #3730a3 !important; transform: scale(1.08); box-shadow: 0 4px 14px rgba(79,70,229,.45); border-radius: 0 10px 10px 0 !important; }
        .cal-day.range-mid   { background: #e0e7ff !important; color: #3730a3 !important; border-color: #a5b4fc !important; border-radius: 0 !important; }
        .cal-day.range-start.range-end { border-radius: 10px !important; }
        .slot-dot { position: absolute; bottom: 3px; font-size: .45rem; line-height: 1; color: inherit; opacity: .7; }
        .cal-shimmer { animation: shimmer 1.4s infinite; background: linear-gradient(90deg,#f3f4f6 25%,#e5e7eb 50%,#f3f4f6 75%); background-size: 200% 100%; border-radius: 10px; }
        @keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        /* Duration pills */
        .dur-pill {
            padding: 5px 14px; border-radius: 99px; font-size: .75rem; font-weight: 700;
            border: 2px solid #c7d2fe; background: #fff; color: #4338ca;
            cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .dur-pill.active { background: #4f46e5; color: #fff; border-color: #4f46e5; }

        /* Range summary */
        #range-summary { transition: all .3s ease; }

        /* Calendar nav */
        .cal-nav-btn { width: 30px; height: 30px; border-radius: 50%; background: transparent; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-3); transition: background var(--t); font-size: 1.1rem; font-weight: 700; }
        .cal-nav-btn:hover { background: #f3f4f6; color: var(--text-2); }
        .cal-nav-btn:disabled { opacity: .3; cursor: default; }

        /* Legend */
        .cal-legend { display: flex; flex-wrap: wrap; gap: 10px; font-size: .72rem; color: var(--text-3); }
        .cal-legend span { display: flex; align-items: center; gap: 4px; }
        .cal-legend .dot { width: 10px; height: 10px; border-radius: 3px; }

        @media (max-width: 480px) {
            .cal-day { font-size: .68rem; min-height: 30px; }
            .detail-hero-text { padding: 16px; }
        }
    </style>

    <div id="dest-detail">
        <div class="detail-outer">

            {{-- Back link --}}
            <a href="{{ route('destinations.index') }}" class="back-btn">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to Destinations
            </a>

            {{-- Hero image --}}
            @php
                $n = strtolower($destination->name);
                $gradient = 'linear-gradient(135deg,#15803d,#166534)';
                $emoji = '🌿';
                if (str_contains($n,'casas')||str_contains($n,'shrine')||str_contains($n,'heritage')) {
                    $gradient='linear-gradient(135deg,#b45309,#92400e)'; $emoji='🏛️';
                } elseif (str_contains($n,'park')||str_contains($n,'rapids')||str_contains($n,'river')||str_contains($n,'adventure')||str_contains($n,'gapo')) {
                    $gradient='linear-gradient(135deg,#0d9488,#0f766e)'; $emoji='🚣';
                } elseif (str_contains($n,'lake')||str_contains($n,'maragang')) {
                    $gradient='linear-gradient(135deg,#0ea5e9,#0369a1)'; $emoji='🌊';
                } elseif (str_contains($n,'falls')||str_contains($n,'nangan')) {
                    $gradient='linear-gradient(135deg,#0d9488,#166534)'; $emoji='💦';
                }

                $category = 'Nature'; $categoryIcon = '🌿';
                if (str_contains($n,'casas')||str_contains($n,'shrine')) { $category='Heritage'; $categoryIcon='🏛️'; }
                elseif (str_contains($n,'park')||str_contains($n,'rapids')||str_contains($n,'river')) { $category='Adventure'; $categoryIcon='🏔️'; }

                $confirmedToday = $destination->bookings()->where('status','confirmed')->where('visit_date', now()->toDateString())->count();
                $pct = $destination->capacity > 0 ? min(100, round(($confirmedToday/$destination->capacity)*100)) : 0;
                $fillCls = $pct>=100?'fill-full':($pct>=75?'fill-high':($pct>=50?'fill-mid':'fill-low'));
                $avStatus = $destination->availability_status === 'Available' ? ($pct>=100?'full':($pct>=75?'limited':'open')) : 'closed';
                $avClass = ['open'=>'av-open','limited'=>'av-limited','full'=>'av-full','closed'=>'av-closed'][$avStatus];
                $avLabel = ['open'=>'Open','limited'=>'Limited','full'=>'Full','closed'=>'Closed'][$avStatus];

                $highlights = [
                    ['icon'=>'📍','text'=>$destination->location],
                    ['icon'=>'👥','text'=>$destination->capacity.' max visitors/day'],
                    ['icon'=>'🎟️','text'=>'QR entrance ticket required'],
                    ['icon'=>'🛡️','text'=>'Sanitized & safe for visitors'],
                ];

                $tags = [$categoryIcon.' '.$category, '🛡️ Sanitized', '🎟️ QR Entrance'];
            @endphp

            <div class="detail-hero" aria-hidden="true">
                @if($destination->photos)
                    <div class="detail-hero-bg" style="background-image:url('{{ Storage::url($destination->photos) }}');"></div>
                @else
                    <div class="detail-hero-bg" style="background:{{ $gradient }};"></div>
                @endif
                <div class="detail-hero-overlay"></div>
                <div class="detail-hero-text">
                    <h1 class="detail-hero-name">{{ $destination->name }}</h1>
                    <div class="detail-hero-loc">
                        <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $destination->location }}
                    </div>
                </div>
            </div>

            <div class="detail-grid">

                {{-- ── Left Column ── --}}
                <div>
                    {{-- About --}}
                    <div class="detail-card">
                        <div class="detail-section-title">About this Destination</div>
                        <p class="detail-desc">
                            {{ $destination->description ?: 'A beautiful destination in Tigbao, Zamboanga del Sur. Part of the natural and cultural heritage of the region, offering visitors a memorable experience in a pristine setting.' }}
                        </p>
                        <div class="tag-row">
                            @foreach($tags as $tag)
                                <span class="tag">{{ $tag }}</span>
                            @endforeach
                        </div>
                        <ul class="highlights">
                            @foreach($highlights as $h)
                                <li>
                                    <span class="hi-icon" aria-hidden="true">{{ $h['icon'] }}</span>
                                    <span>{{ $h['text'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- ── Multi-Day Calendar Availability Checker ── --}}
                    @if($destination->availability_status === 'Available')
                    <div class="detail-card">
                        <div class="detail-section-title">📅 Plan Your Visit — Check Availability</div>
                        <p style="font-size:.85rem;color:var(--text-3);margin-bottom:16px;">Choose a tour duration and tap a highlighted start date to see slot details.</p>

                        {{-- Duration Selector --}}
                        <div style="margin-bottom:14px;">
                            <p style="font-size:.8rem;font-weight:700;color:var(--text-1);margin-bottom:8px;">🗓️ Tour Duration:</p>
                            <div style="display:flex;flex-wrap:wrap;gap:8px;" id="duration-pills">
                                @foreach([1,2,3,4,5,7,10] as $d)
                                <button type="button" data-days="{{ $d }}" onclick="setDuration({{ $d }})"
                                    class="dur-pill {{ $d===1 ? 'active' : '' }}">
                                    {{ $d }} {{ $d===1?'Day':'Days' }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="cal-legend" style="margin-bottom:12px;">
                            <span><span class="dot" style="background:#10b981;"></span>Available</span>
                            <span><span class="dot" style="background:#f59e0b;"></span>Limited</span>
                            <span><span class="dot" style="background:#fca5a5;"></span>Full</span>
                            <span><span class="dot" style="background:#e5e7eb;"></span>Can't start here</span>
                        </div>

                        {{-- Calendar --}}
                        <div style="background:#f9fafb;border:1.5px solid var(--border);border-radius:var(--r-lg);overflow:hidden;">
                            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f0fdfc;">
                                <button id="cal-prev" class="cal-nav-btn" onclick="prevMonth()">&lsaquo;</button>
                                <span id="cal-month-label" style="font-weight:700;font-size:.9rem;color:var(--text-1);"></span>
                                <button id="cal-next" class="cal-nav-btn" onclick="nextMonth()">&rsaquo;</button>
                            </div>
                            <div style="padding:10px 12px 14px;">
                                <div style="display:grid;grid-template-columns:repeat(7,1fr);gap:1px;margin-bottom:4px;">
                                    @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $wd)
                                        <div class="cal-weekday">{{ $wd }}</div>
                                    @endforeach
                                </div>
                                <div id="cal-grid"></div>
                                <div id="cal-empty-state" style="display:none;text-align:center;padding:24px 0;">
                                    <p style="font-size:1.5rem;margin-bottom:8px;">🗓️</p>
                                    <p style="font-size:.85rem;font-weight:600;color:var(--text-3);">No valid start dates this month</p>
                                    <p style="font-size:.75rem;color:var(--text-4);margin:4px 0 10px;">No consecutive open window for <span id="empty-dur-label"></span>.</p>
                                    <button onclick="nextMonth()" style="font-size:.78rem;color:var(--teal);font-weight:700;background:none;border:none;cursor:pointer;font-family:inherit;">Check next month →</button>
                                </div>
                            </div>
                        </div>

                        {{-- Range Summary --}}
                        <div id="range-summary" style="margin-top:12px;display:none;"></div>
                    </div>
                    @endif
                </div>

                {{-- ── Right Sidebar ── --}}
                <div>
                    <div class="detail-card">
                        <div class="detail-section-title">Visitor Info</div>

                        <div class="sidebar-stat">
                            <span class="ss-label">📍 Location</span>
                            <span class="ss-value" style="max-width:160px;text-align:right;font-size:.82rem;">{{ $destination->location }}</span>
                        </div>
                        <div class="sidebar-stat">
                            <span class="ss-label">👥 Capacity</span>
                            <span class="ss-value">{{ $destination->capacity }} / day</span>
                        </div>
                        <div class="sidebar-stat">
                            <span class="ss-label">{{ $categoryIcon }} Category</span>
                            <span class="ss-value">{{ $category }}</span>
                        </div>
                        <div class="sidebar-stat">
                            <span class="ss-label">✅ Confirmed</span>
                            <span class="ss-value">{{ $destination->bookings()->where('status','confirmed')->count() }}</span>
                        </div>
                        <div class="sidebar-stat">
                            <span class="ss-label">🎟️ Entrance</span>
                            <span class="ss-value">QR Code</span>
                        </div>

                        <div class="avail-block {{ $avClass }}">
                            <div class="av-label">Today's Status</div>
                            <div class="av-status">{{ $avLabel }}</div>
                        </div>

                        <div class="cap-bar-lg" role="progressbar" aria-label="Capacity usage" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100">
                            <div id="cap-fill-bar" class="cap-bar-fill {{ $fillCls }}" style="width:0%"></div>
                        </div>
                        <div class="cap-labels">
                            <span>{{ $confirmedToday }} confirmed today</span>
                            <span>{{ $pct }}% full</span>
                        </div>

                        {{-- Book button --}}
                        @if($destination->availability_status === 'Available')
                            <a id="main-book-btn" href="{{ route('bookings.create', $destination) }}" class="btn-book">
                                📅 Book This Destination →
                            </a>
                        @else
                            <div class="btn-book-disabled">Currently Unavailable</div>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('destinations.edit', $destination) }}" style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:10px;padding:10px;border-radius:var(--r-md);border:1.5px solid #fcd34d;background:#fffbeb;color:#92400e;font-size:.85rem;font-weight:600;text-decoration:none;transition:var(--t);">
                            ✏️ Edit Destination Profile
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ═══ Calendar JS ══════════════════════════════════════════════════ --}}
    <script>
    (function() {
        const AVAIL_URL  = '{{ route('destinations.availability', $destination) }}';
        const BOOK_BASE  = '{{ route('bookings.create', $destination) }}';
        const CAP        = {{ $destination->capacity }};
        const MIN_DATE   = new Date(); MIN_DATE.setDate(MIN_DATE.getDate()+1); MIN_DATE.setHours(0,0,0,0);
        const MAX_MONTHS = 6;

        let duration    = 1;
        let viewYear    = MIN_DATE.getFullYear();
        let viewMonth   = MIN_DATE.getMonth();
        let selectedStart = null;
        let monthCache  = {};
        let loading     = false;

        const grid         = document.getElementById('cal-grid');
        const monthLabel   = document.getElementById('cal-month-label');
        const emptyState   = document.getElementById('cal-empty-state');
        const emptyDurLbl  = document.getElementById('empty-dur-label');
        const rangeSummary = document.getElementById('range-summary');
        const prevBtn      = document.getElementById('cal-prev');
        const bookBtn      = document.getElementById('main-book-btn');
        const capFill      = document.getElementById('cap-fill-bar');

        // Animate capacity bar on load
        if (capFill) setTimeout(() => capFill.style.width = '{{ $pct }}%', 200);

        // ── Duration ──────────────────────────────────────────────────────
        window.setDuration = function(d) {
            duration = d;
            document.querySelectorAll('.dur-pill').forEach(p => {
                p.classList.toggle('active', +p.dataset.days === d);
            });
            if (selectedStart && !isValidStart(selectedStart)) {
                selectedStart = null;
                rangeSummary.style.display = 'none';
                rangeSummary.innerHTML = '';
                resetBookBtn();
            }
            renderCalendar();
        };

        // ── Month Nav ─────────────────────────────────────────────────────
        window.prevMonth = function() {
            const now = new Date(); now.setDate(1); now.setHours(0,0,0,0);
            if (new Date(viewYear, viewMonth, 1) <= now) return;
            viewMonth === 0 ? (viewYear--, viewMonth=11) : viewMonth--;
            selectedStart = null; rangeSummary.style.display='none'; resetBookBtn();
            renderCalendar();
        };
        window.nextMonth = function() {
            const max = new Date(); max.setMonth(max.getMonth()+MAX_MONTHS);
            if (new Date(viewYear, viewMonth+1, 1) > max) return;
            viewMonth === 11 ? (viewYear++, viewMonth=0) : viewMonth++;
            selectedStart = null; rangeSummary.style.display='none'; resetBookBtn();
            renderCalendar();
        };

        // ── Render ────────────────────────────────────────────────────────
        function renderCalendar() {
            const key = `${viewYear}-${String(viewMonth+1).padStart(2,'0')}`;
            monthLabel.textContent = new Date(viewYear, viewMonth, 1)
                .toLocaleDateString('en-US', { month:'long', year:'numeric' });
            const now = new Date(); now.setDate(1); now.setHours(0,0,0,0);
            prevBtn.disabled = new Date(viewYear, viewMonth, 1) <= now;
            if (monthCache[key]) paintGrid(monthCache[key]);
            else { paintShimmer(); loadMonth(key); }
        }

        async function loadMonth(key) {
            if (loading) return; loading = true;
            const [y, m] = key.split('-').map(Number);
            const days = new Date(y, m, 0).getDate();
            const dayData = {};
            const fetches = [];
            for (let d = 1; d <= days; d++) {
                const date = new Date(y, m-1, d);
                const ds = fmtDate(date);
                if (date < MIN_DATE) { dayData[ds]={slots:0,status:'past'}; continue; }
                fetches.push(
                    fetch(`${AVAIL_URL}?date=${ds}`)
                        .then(r => r.ok?r.json():null)
                        .then(data => { dayData[ds] = data ? {slots:data.slots,status:data.status} : {slots:0,status:'error'}; })
                        .catch(()  => { dayData[ds] = {slots:0,status:'error'}; })
                );
            }
            await Promise.all(fetches);
            monthCache[key] = dayData; loading = false;
            paintGrid(dayData);
        }

        function paintShimmer() {
            emptyState.style.display = 'none'; grid.innerHTML = '';
            const first = new Date(viewYear, viewMonth, 1).getDay();
            const total = new Date(viewYear, viewMonth+1, 0).getDate();
            for (let i=0;i<first;i++) { const b=document.createElement('div'); b.className='cal-day empty'; grid.appendChild(b); }
            for (let d=1;d<=total;d++) { const el=document.createElement('div'); el.className='cal-day cal-shimmer'; el.textContent=d; grid.appendChild(el); }
        }

        function paintGrid(dayData) {
            grid.innerHTML = ''; emptyState.style.display='none';
            const first = new Date(viewYear, viewMonth, 1).getDay();
            const total = new Date(viewYear, viewMonth+1, 0).getDate();
            let hasValid = false;
            for (let i=0;i<first;i++) { const b=document.createElement('div'); b.className='cal-day empty'; grid.appendChild(b); }
            for (let d=1;d<=total;d++) {
                const date = new Date(viewYear, viewMonth, d);
                const ds   = fmtDate(date);
                const info = dayData[ds]||{slots:0,status:'past'};
                const el   = document.createElement('div');
                el.dataset.date = ds;
                if (date < MIN_DATE) {
                    el.className = 'cal-day past';
                } else if (info.status === 'full') {
                    el.className = 'cal-day full'; el.title = 'Fully booked';
                } else {
                    const run = consecDays(date, dayData);
                    if (run >= duration) {
                        hasValid = true;
                        el.className = `cal-day ${info.status === 'limited' ? 'limited' : 'open'}`;
                        el.title = `${info.slots} slot${info.slots!==1?'s':''} available`;
                        el.addEventListener('click', () => selectDate(date, dayData));
                        el.addEventListener('mouseenter', () => hoverRange(date, dayData));
                        el.addEventListener('mouseleave', clearHover);
                    } else {
                        el.className = 'cal-day insufficient';
                        el.title = run===0 ? 'Fully booked' : `Only ${run} of ${duration} day${duration>1?'s':''} available from here`;
                    }
                }
                applyRangeClass(el, date);
                const num = document.createElement('span'); num.textContent = d; el.appendChild(num);
                if (info.slots>0 && info.slots<=Math.ceil(CAP*0.3) && date>=MIN_DATE) {
                    const dot = document.createElement('span'); dot.className='slot-dot'; dot.textContent=info.slots; el.appendChild(dot);
                }
                grid.appendChild(el);
            }
            if (!hasValid) {
                emptyState.style.display='block';
                emptyDurLbl.textContent=`${duration} day${duration>1?'s':''}`;
            }
        }

        // ── Helpers ───────────────────────────────────────────────────────
        function consecDays(date, dayData) {
            let count=0, d=new Date(date);
            for (let i=0;i<duration;i++) {
                const info=dayData[fmtDate(d)];
                if (!info||info.status==='full'||info.status==='past') break;
                count++; d.setDate(d.getDate()+1);
            }
            return count;
        }
        function isValidStart(date) {
            const key=`${viewYear}-${String(viewMonth+1).padStart(2,'0')}`;
            const dd=monthCache[key]; if(!dd) return false;
            return consecDays(date,dd)>=duration;
        }

        function selectDate(date, dayData) {
            selectedStart = date;
            renderCalendar();
            showRangeSummary(date, dayData);
        }

        function showRangeSummary(date, dayData) {
            const end = new Date(date); end.setDate(end.getDate()+duration-1);
            let minSlots=Infinity, hasLimited=false, breakdown=[];
            let d=new Date(date);
            for (let i=0;i<duration;i++) {
                const ds=fmtDate(d), info=dayData[ds]||{slots:0,status:'full'};
                if(info.slots<minSlots) minSlots=info.slots;
                if(info.status==='limited') hasLimited=true;
                breakdown.push({date:ds,slots:info.slots,status:info.status});
                d.setDate(d.getDate()+1);
            }
            if(minSlots===Infinity) minSlots=0;
            const rs = minSlots===0?'full':(hasLimited?'limited':'open');
            const startFmt = date.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
            const endFmt   = end.toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'});
            const bookUrl  = `${BOOK_BASE}?visit_date=${fmtDate(date)}&duration=${duration}`;
            const colors = {open:'background:#ecfdf5;border:1.5px solid #6ee7b7;color:#065f46',limited:'background:#fffbeb;border:1.5px solid #fcd34d;color:#92400e',full:'background:#fef2f2;border:1.5px solid #fca5a5;color:#991b1b'};
            const statusMsg = {open:`✅ ${minSlots} slot${minSlots!==1?'s':''} available across all days`,limited:`⚠️ Limited — ${minSlots} slot${minSlots!==1?'s':''} available (bottleneck day)`,full:'🚫 One or more days in this range are fully booked'};
            let bkHtml='';
            if(duration>1) {
                bkHtml=`<div style="margin-top:12px;"><p style="font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--text-4);margin-bottom:6px;">Day-by-day</p>${breakdown.map((b,i)=>{const df=new Date(b.date+'T00:00:00').toLocaleDateString('en-US',{weekday:'short',month:'short',day:'numeric'});const dot=b.status==='open'?'🟢':b.status==='limited'?'🟡':'🔴';return`<div style="display:flex;justify-content:space-between;font-size:.78rem;padding:2px 0;"><span>${dot} Day ${i+1} — ${df}</span><span style="font-weight:700;">${b.slots} slot${b.slots!==1?'s':''}</span></div>`;}).join('')}</div>`;
            }
            rangeSummary.style.display='block';
            rangeSummary.innerHTML=`<div style="padding:16px;border-radius:var(--r-md);${colors[rs]};font-size:.85rem;"><div style="display:flex;align-items:flex-start;justify-content:space-between;gap:8px;flex-wrap:wrap;"><div><p style="font-weight:800;font-size:.95rem;">📌 ${duration}-Day Stay Selected</p><p style="font-size:.75rem;opacity:.8;margin-top:2px;">${startFmt}${duration>1?' → '+endFmt:''}</p></div>${rs!=='full'?`<a href="${bookUrl}" style="background:#4f46e5;color:#fff;font-weight:700;font-size:.78rem;border-radius:8px;padding:8px 14px;text-decoration:none;white-space:nowrap;">Book This Stay →</a>`:''}</div><p style="margin-top:8px;font-weight:700;">${statusMsg[rs]}</p>${bkHtml}</div>`;
            if(rs!=='full'&&bookBtn) { bookBtn.href=bookUrl; bookBtn.textContent=`📅 Book ${duration>1?duration+'-Day Stay':'This Date'} →`; }
        }

        function hoverRange(date, dayData) {
            clearHover();
            if(!consecDays(date,dayData)>=duration) return;
            const end=new Date(date); end.setDate(end.getDate()+duration-1);
            grid.querySelectorAll('.cal-day:not(.empty):not(.past)').forEach(el=>{
                const d=el.dataset.date?new Date(el.dataset.date+'T00:00:00'):null;
                if(d&&d>=date&&d<=end) el.classList.add('hovered');
            });
        }
        function clearHover() { grid.querySelectorAll('.hovered').forEach(el=>el.classList.remove('hovered')); }
        function applyRangeClass(el, date) {
            if(!selectedStart) return;
            const end=new Date(selectedStart); end.setDate(end.getDate()+duration-1);
            if(date<selectedStart||date>end) return;
            const isS=date.getTime()===selectedStart.getTime(), isE=date.getTime()===end.getTime();
            if(isS&&isE) el.classList.add('range-start','range-end');
            else if(isS) el.classList.add('range-start');
            else if(isE) el.classList.add('range-end');
            else         el.classList.add('range-mid');
        }
        function resetBookBtn() {
            if(bookBtn){ bookBtn.href='{{ route('bookings.create', $destination) }}'; bookBtn.textContent='📅 Book This Destination →'; }
        }
        function fmtDate(d) { return d.toISOString().split('T')[0]; }

        renderCalendar();
    })();
    </script>
</x-app-layout>
