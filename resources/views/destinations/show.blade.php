<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush
    {{-- No header slot — full-width detail layout --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800;900&family=IBM+Plex+Mono:wght@500;600;700&family=JetBrains+Mono:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fraunces:ital,wght@0,600;1,600&display=swap');

        :root {
            --teal:       hsl(142, 70%, 45%); --teal-light: hsl(142, 60%, 75%); --teal-dark: hsl(162, 80%, 15%);
            --ocean:      hsl(145, 63%, 49%); --sand: hsl(76, 75%, 55%); --emerald: hsl(161, 68%, 40%);
            --rose:       hsl(343, 85%, 60%); --indigo: hsl(162, 80%, 15%); --purple: hsl(262, 83%, 65%);
            --bg:         #f4fbf7; --border: rgba(22, 163, 74, 0.08);
            --text-1:     hsl(162, 80%, 12%); --text-2: #374151; --text-3: #6b7280; --text-4: #9ca3af;
            --t:          0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --sh-card:    0 10px 30px -10px rgba(11, 61, 46, 0.06), 0 1px 3px -1px rgba(0, 0, 0, 0.03);
            --sh-md:      0 8px 26px rgba(16, 185, 129, 0.08);
            --r-sm: 10px; --r-md: 16px; --r-lg: 24px; --r-xl: 32px;

            /* ── Meridian Calendar Identity Tokens ── */
            --m-terrain: #FAF9F6;
            --m-ink: #1A1A18;
            --m-muted: #78756E;
            --m-faint: #B5B2AA;
            --m-contour: #0F766E;
            --m-contour-lt: #CCFBF1;
            --m-saffron: #A16207;
            --m-saffron-lt: #FEF3C7;
            --m-terracotta: #991B1B;
            --m-terracotta-lt: #FEE2E2;
            --m-route: #1E1B4B;
            --m-route-lt: #E0E7FF;
            --m-copper: #B45309;
            --m-card: #FFFFFF;
            --m-grid: rgba(26,26,24,0.04);
            --m-border: rgba(26,26,24,0.08);
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
            --ease-out: cubic-bezier(0, 0, 0.2, 1);
        }
        #dest-detail * { font-family: 'Plus Jakarta Sans', sans-serif; box-sizing: border-box; }

        /* ── Wrapper ── */
        #dest-detail { background: var(--bg); min-height: 100vh; width: 100%; overflow-x: clip; }
        .detail-outer { max-width: 1200px; width: 100%; margin: 0 auto; padding: 0 24px 64px; box-sizing: border-box; }

        /* ── Back button ── */
        .back-btn {
            display: inline-flex; align-items: center; gap: 8px;
            color: var(--teal); font-weight: 700; font-size: .88rem;
            background: none; border: none; padding: 28px 0 20px;
            cursor: pointer; transition: gap var(--t), color var(--t); text-decoration: none;
        }
        .back-btn:hover { gap: 12px; color: var(--teal-dark); }

        /* ── Hero ── */
        .detail-hero {
            border-radius: var(--r-lg); overflow: hidden;
            min-height: 320px;
            position: relative;
            display: flex; align-items: flex-end;
            transition: transform var(--t), box-shadow var(--t);
            box-shadow: var(--sh-card);
        }
        .detail-hero:hover { transform: translateY(-3px); box-shadow: 0 20px 40px -15px rgba(11, 61, 46, 0.12); }
        .detail-hero-bg { position: absolute; inset: 0; background-size: cover; background-position: center; transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
        .detail-hero:hover .detail-hero-bg { transform: scale(1.03); }
        .detail-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(0,0,0,0) 30%, rgba(0,0,0,.65) 100%); }
        .detail-hero-text { position: relative; z-index: 1; padding: 32px; width: 100%; }
        .detail-hero-name { font-family: 'Fraunces', serif; font-size: clamp(1.6rem, 4vw, 2.4rem); color: #fff; line-height: 1.15; text-shadow: 0 2px 12px rgba(0,0,0,.3); }
        .detail-hero-loc  { color: rgba(255,255,255,.88); font-size: .9rem; margin-top: 8px; display: flex; align-items: center; gap: 6px; }

        /* ── Bento Grid ── */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            align-items: stretch;
        }
        .bento-hero { grid-column: span 2; grid-row: span 1; }
        .bento-sidebar { grid-column: span 1; grid-row: span 1; }
        .bento-about { grid-column: span 2; grid-row: span 1; }
        .bento-map { grid-column: span 1; grid-row: span 1; display: flex; flex-direction: column; }
        .bento-map #visitor-checkin-map { flex: 1; min-height: 260px; }
        .bento-calendar {
            grid-column: span 3;
            border: 2px solid rgba(16, 185, 129, 0.18) !important;
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.06), var(--sh-card);
        }
        .bento-form {
            grid-column: span 3;
            border: 2px solid rgba(79, 70, 229, 0.18) !important;
            box-shadow: 0 10px 30px -10px rgba(79, 70, 229, 0.06), var(--sh-card);
        }

        /* Tablet */
        @media(max-width: 1200px) {
            .bento-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .bento-hero { grid-column: span 2; }
            .bento-about { grid-column: span 2; }
            .bento-calendar { grid-column: span 2; }
            .bento-form { grid-column: span 2; }
            .bento-sidebar { grid-column: span 1; }
            .bento-map { grid-column: span 1; }
        }

        /* Mobile */
        @media(max-width: 768px) {
            .bento-grid { grid-template-columns: 1fr; gap: 16px; }
            .bento-hero, .bento-about, .bento-calendar, .bento-form, .bento-sidebar, .bento-map { grid-column: span 1; }
            .detail-outer { padding: 0 16px 40px; }
            .detail-card { padding: 20px; border-radius: var(--r-md); }
            .detail-hero { min-height: 240px; }
            .detail-hero-text { padding: 24px; }
            .ti-grid { grid-template-columns: 1fr; gap: 12px; }
            .visitor-table, .visitor-table tbody, .visitor-table tr, .visitor-table td {
                display: block !important; width: 100% !important;
            }
            .visitor-table thead { display: none !important; }
            .visitor-table tr {
                background: #ffffff; border: 1.5px solid rgba(22, 163, 74, 0.12);
                border-radius: 16px; padding: 16px 18px 18px; margin-bottom: 18px;
                display: grid !important; grid-template-columns: repeat(2, 1fr) !important;
                gap: 12px 14px !important; box-shadow: 0 4px 12px rgba(11, 61, 46, 0.03);
            }
            .visitor-table tr.row-error { border-color: var(--rose) !important; }
            .visitor-table td { padding: 0 !important; border: none !important; }
            .visitor-table tr td:nth-child(2),
            .visitor-table tr td:nth-child(5),
            .visitor-table tr td:nth-child(6) { grid-column: span 2 !important; }
            .visitor-table tr td:first-child { grid-column: span 1 !important; display: flex !important; align-items: center; }
            .visitor-table tr td:last-child { grid-column: span 1 !important; display: flex !important; justify-content: flex-end; align-items: center; }
            .visitor-table td[data-label]::before {
                content: attr(data-label); display: block; font-size: 10px; font-weight: 800;
                text-transform: uppercase; letter-spacing: 0.8px; color: var(--text-3); margin-bottom: 5px;
            }
            .visitor-table td.row-num::before {
                content: "Companion #" attr(data-num); font-size: 11px; font-weight: 800;
                color: var(--teal-dark); text-transform: uppercase; letter-spacing: 0.5px;
            }
            .visitor-table td.row-num { font-size: 0 !important; text-align: left !important; }
        }

        @media(max-width: 480px) {
            .detail-outer { padding: 0 12px 32px; }
            .detail-card { padding: 16px; border-radius: var(--r-sm); }
            .detail-hero-text { padding: 20px; }
            .detail-hero-loc { font-size: 0.8rem; }
            .cal-day { font-size: 0.65rem; min-height: 28px; }
            .cal-weekday { font-size: 0.58rem; }
            .dur-pill { padding: 4px 10px; font-size: 0.7rem; }
            .bento-map #visitor-checkin-map { min-height: 200px; }
        }

        /* ── Cards ── */
        .detail-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
            border-radius: var(--r-lg); padding: 28px;
            box-shadow: var(--sh-card); border: 1px solid var(--border);
            transition: transform var(--t), box-shadow var(--t);
            height: 100%; display: flex; flex-direction: column;
        }
        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 35px -12px rgba(11, 61, 46, 0.08), 0 2px 5px -2px rgba(0, 0, 0, 0.04);
        }
        .detail-section-title {
            font-weight: 800; font-size: .78rem; letter-spacing: 1.2px;
            text-transform: uppercase; color: var(--teal); margin-bottom: 16px;
            display: flex; align-items: center; gap: 8px; flex-shrink: 0;
        }
        .detail-desc { color: var(--text-2); line-height: 1.8; font-size: .93rem; }

        /* ── Sidebar stats ── */
        .sidebar-stat { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid rgba(0, 0, 0, 0.04); font-size: .86rem; }
        .sidebar-stat:last-of-type { border-bottom: none; }
        .ss-label { color: var(--text-3); display: flex; align-items: center; gap: 8px; }
        .ss-value { font-weight: 700; color: var(--text-1); }

        .cap-bar-lg { height: 12px; background: rgba(0, 0, 0, 0.05); border-radius: 99px; margin-top: 16px; overflow: hidden; flex-shrink: 0; }
        .cap-bar-fill { height: 100%; border-radius: 99px; transition: width 1s cubic-bezier(.4,0,.2,1); }
        .fill-low  { background: linear-gradient(90deg, var(--emerald), var(--ocean)); }
        .fill-mid  { background: linear-gradient(90deg, var(--sand), #eab308); }
        .fill-high { background: linear-gradient(90deg, #f97316, #ea580c); }
        .fill-full { background: linear-gradient(90deg, var(--rose), #e11d48); }
        .cap-labels { display: flex; justify-content: space-between; font-size: .75rem; color: var(--text-3); margin-top: 6px; flex-shrink: 0; }

        .avail-block { border-radius: var(--r-md); padding: 18px; text-align: center; margin-top: auto; transition: transform var(--t); flex-shrink: 0; }
        .avail-block:hover { transform: scale(1.02); }
        .avail-block .av-label  { font-size: .75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.8px; opacity: .8; margin-bottom: 6px; }
        .avail-block .av-status { font-weight: 800; font-size: 1.25rem; }
        .av-open    { background: #d1fae5; color: #065f46; }
        .av-limited { background: #fef3c7; color: #92400e; }
        .av-full    { background: #fee2e2; color: #991b1b; }
        .av-closed  { background: #f3f4f6; color: #4b5563; }

        /* ── Action button ── */
        .btn-book {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; margin-top: 16px; padding: 13px; flex-shrink: 0;
            border: none; border-radius: var(--r-md); font-size: .95rem; font-weight: 700;
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; box-shadow: 0 4px 16px rgba(13,148,136,.3);
            cursor: pointer; transition: var(--t); text-decoration: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-book:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,148,136,.4); color: #fff; }
        .btn-book-disabled {
            display: flex; align-items: center; justify-content: center;
            width: 100%; margin-top: 16px; padding: 13px; flex-shrink: 0;
            border-radius: var(--r-md); font-size: .95rem; font-weight: 700;
            background: #e5e7eb; color: var(--text-4); cursor: not-allowed;
        }

        /* ═══════════════════════════════════════
           MERIDIAN — CALENDAR IDENTITY SYSTEM
           ═══════════════════════════════════════ */
        .meridian-container { width: 100%; }

        /* Duration Markers */
        .meridian-duration { margin-bottom: 16px; }
        .meridian-duration-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
            text-transform: uppercase; color: var(--m-muted); margin-bottom: 8px;
            display: flex; align-items: center; gap: 6px;
        }
        .meridian-duration-label i { font-size: 14px; color: var(--m-copper); }
        .meridian-pills { display: flex; flex-wrap: wrap; gap: 6px; }
        .meridian-pill {
            font-family: 'IBM Plex Mono', monospace; font-size: 12px; font-weight: 600;
            font-variant-numeric: tabular-nums; padding: 7px 14px; border-radius: 8px;
            border: 1.5px solid var(--m-border); background: var(--m-card);
            color: var(--m-muted); cursor: pointer; transition: all 200ms var(--ease);
            position: relative; overflow: hidden;
        }
        .meridian-pill::before {
            content: ''; position: absolute; left: 0; top: 50%;
            width: 3px; height: 8px; background: var(--m-faint);
            transform: translateY(-50%); border-radius: 0 2px 2px 0;
            transition: background 200ms var(--ease);
        }
        .meridian-pill:hover {
            border-color: var(--m-route); color: var(--m-route);
            transform: scale(1.04); box-shadow: 0 2px 8px rgba(30,27,75,0.08);
        }
        .meridian-pill:hover::before { background: var(--m-route); }
        .meridian-pill.active {
            background: var(--m-route); border-color: var(--m-route);
            color: #fff; box-shadow: 0 4px 14px rgba(30,27,75,0.25);
            transform: scale(1.04);
        }
        .meridian-pill.active::before { background: rgba(255,255,255,0.35); }

        /* Calendar Card Surface (Sleek Rounded Container) */
        .meridian-card-outer {
            width: 100%;
        }
        .meridian-card {
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.05);
        }

        /* Month Navigation */
        .meridian-nav {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 20px; border-bottom: 1px solid #f1f5f9; position: relative; background: #ffffff;
        }
        .meridian-month { font-size: 16px; font-weight: 800; color: #0f172a; letter-spacing: -0.3px; font-family: 'DM Sans', sans-serif; }
        .meridian-month-year { color: #475569; font-weight: 700; font-size: 15px; margin-left: 5px; }
        .meridian-compass {
            width: 36px; height: 36px; border-radius: 50%; border: 1.5px solid #cbd5e1;
            background: #ffffff; cursor: pointer; display: flex; align-items: center;
            justify-content: center; color: #334155; font-size: 16px; font-weight: 700;
            transition: all 200ms var(--ease); position: relative;
        }
        .meridian-compass::before {
            content: ''; position: absolute; inset: 3px; border-radius: 50%;
            border: 1px dashed #94a3b8; opacity: 0.6;
        }
        .meridian-compass:hover {
            border-color: var(--m-contour); color: var(--m-contour);
            background: var(--m-contour-lt); transform: scale(1.08);
        }
        .meridian-compass:disabled {
            opacity: 0.3; cursor: default; transform: none; background: transparent;
            border-color: #e2e8f0; color: #94a3b8;
        }

        /* Weekday Headers */
        .meridian-weekdays {
            display: grid; grid-template-columns: repeat(7, 1fr);
            padding: 12px 14px 6px; gap: 4px; background: #fafafa;
        }
        .meridian-wd {
            text-align: center; font-family: 'IBM Plex Mono', monospace;
            font-size: 11px; font-weight: 700; letter-spacing: 0.8px;
            color: #334155; text-transform: uppercase;
            padding-bottom: 6px; border-bottom: 1.5px solid #e2e8f0;
        }

        /* Topo Grid Wrapper */
        .meridian-grid-wrap { position: relative; padding: 10px 14px 16px; background: #ffffff; }
        .meridian-grid-wrap::before {
            content: ''; position: absolute; inset: 0; opacity: 0.4;
            background:
                radial-gradient(ellipse 55% 70% at 22% 35%, transparent 44%, rgba(15,118,110,0.04) 45%, rgba(15,118,110,0.04) 46%, transparent 47%),
                radial-gradient(ellipse 45% 55% at 22% 35%, transparent 34%, rgba(15,118,110,0.03) 35%, rgba(15,118,110,0.03) 36%, transparent 37%),
                radial-gradient(ellipse 35% 42% at 22% 35%, transparent 24%, rgba(15,118,110,0.025) 25%, rgba(15,118,110,0.025) 26%, transparent 27%),
                radial-gradient(ellipse 50% 60% at 78% 65%, transparent 40%, rgba(15,118,110,0.035) 41%, rgba(15,118,110,0.035) 42%, transparent 43%),
                radial-gradient(ellipse 40% 48% at 78% 65%, transparent 30%, rgba(15,118,110,0.025) 31%, rgba(15,118,110,0.025) 32%, transparent 33%);
            pointer-events: none;
        }
        .meridian-grid {
            display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;
            position: relative; z-index: 1;
        }

        /* Trail SVG */
        .meridian-trail-svg {
            position: absolute; inset: 0; z-index: 5;
            pointer-events: none; overflow: visible;
        }
        .meridian-trail-path {
            fill: none; stroke: #1e1b4b; stroke-width: 2.5; stroke-linecap: round;
            stroke-dasharray: 200; stroke-dashoffset: 200; opacity: 0.5;
            transition: stroke-dashoffset 400ms var(--ease-out), opacity 300ms ease;
        }
        .meridian-trail-path.preview { stroke-dasharray: 6 5; stroke-dashoffset: 0; opacity: 0.35; }
        .meridian-trail-path.active { stroke-dasharray: 200; stroke-dashoffset: 0; opacity: 0.7; stroke-width: 3; }
        .meridian-trail-dot {
            fill: #1e1b4b; stroke: #fff; stroke-width: 2; opacity: 0;
            transition: opacity 250ms ease, r 250ms var(--ease);
        }
        .meridian-trail-dot.visible { opacity: 1; }
        .meridian-trail-dot.start { r: 5; }
        .meridian-trail-dot.end { r: 4; }

        /* Day Cells */
        .meridian-day {
            position: relative; aspect-ratio: 1/1; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            border-radius: 10px; font-family: 'IBM Plex Mono', monospace; font-size: 13.5px; font-weight: 700;
            font-variant-numeric: tabular-nums; cursor: default; border: 1.5px solid transparent;
            transition: all 180ms var(--ease); user-select: none; color: #1e293b; background: #ffffff;
            min-height: 38px; padding: 0; outline: none; -webkit-appearance: none; appearance: none;
        }
        .meridian-day-num {
            font-family: 'IBM Plex Mono', monospace;
            font-size: 13.5px;
            font-weight: 700;
            line-height: 1;
            color: inherit;
            pointer-events: none;
            display: block;
        }
        .meridian-day.empty { pointer-events: none; border: none; background: transparent !important; }
        .meridian-day.past {
            color: #94a3b8 !important; opacity: 0.65; cursor: not-allowed; background: #f8fafc !important;
            border-color: #f1f5f9 !important;
        }
        .meridian-day.available {
            background: #ecfdf5 !important; border-color: #a7f3d0 !important;
            color: #065f46 !important; cursor: pointer; font-weight: 800 !important;
        }
        .meridian-day.available:hover {
            background: #0f766e !important; border-color: #0f766e !important;
            color: #ffffff !important; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(15,118,110,0.3); z-index: 3;
        }
        .meridian-day.limited {
            background: #fef3c7 !important; border-color: #fde68a !important;
            color: #92400e !important; cursor: pointer; font-weight: 800 !important;
        }
        .meridian-day.limited:hover {
            background: #b45309 !important; border-color: #b45309 !important;
            color: #ffffff !important; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(180,83,9,0.3); z-index: 3;
        }
        .meridian-day.full {
            background: #fee2e2 !important; border-color: #fecaca !important;
            color: #991b1b !important; cursor: not-allowed; opacity: 0.85; font-weight: 700;
        }
        .meridian-day.insufficient {
            color: #64748b !important; opacity: 0.7; position: relative; cursor: not-allowed;
            background: #f1f5f9 !important; border-color: #e2e8f0 !important;
        }
        .meridian-day.insufficient::after {
            content: ''; position: absolute; top: 50%; left: 15%; right: 15%;
            height: 1.5px; background: #94a3b8; transform: translateY(-50%) rotate(-18deg); border-radius: 1px;
        }
        .meridian-day.range-start {
            background: #1e1b4b !important; border-color: #1e1b4b !important;
            color: #ffffff !important; border-radius: 10px 4px 4px 10px !important;
            transform: scale(1.06); box-shadow: 0 4px 14px rgba(30,27,75,0.35);
            z-index: 4; animation: cellPop 300ms var(--ease); font-weight: 900 !important;
        }
        .meridian-day.range-end {
            background: #1e1b4b !important; border-color: #1e1b4b !important;
            color: #ffffff !important; border-radius: 4px 10px 10px 4px !important;
            transform: scale(1.06); box-shadow: 0 4px 14px rgba(30,27,75,0.35);
            z-index: 4; animation: cellPop 300ms var(--ease); font-weight: 900 !important;
        }
        .meridian-day.range-mid {
            background: #e0e7ff !important; border-color: #c7d2fe !important;
            color: #1e1b4b !important; border-radius: 4px !important; font-weight: 800 !important;
        }
        .meridian-day.range-start.range-end { border-radius: 10px !important; }
        .meridian-day.range-cascade { animation: rangeFill 350ms var(--ease-out) both; }
        .meridian-day.preview-end { outline: 2px dashed #1e1b4b; outline-offset: -2px; }
        .meridian-day.preview-mid {
            background: rgba(224,231,255,0.7) !important; border-color: rgba(99,102,241,0.2) !important;
            color: #1e1b4b !important; border-radius: 4px !important;
        }
        .meridian-day-dot {
            position: absolute; bottom: 3px; font-size: 8px; font-weight: 800;
            font-family: 'IBM Plex Mono', monospace; opacity: 0.85; line-height: 1;
        }
        .meridian-day.range-start .meridian-day-dot,
        .meridian-day.range-end .meridian-day-dot { opacity: 0.95; color: #ffffff; }
        .meridian-day.range-mid .meridian-day-dot { opacity: 0.95; color: #1e1b4b; }

        /* Shimmer Loading for Calendar */
        .meridian-shimmer {
            animation: meridianShimmer 1.4s infinite;
            background: linear-gradient(90deg, #f3f4f6 25%, #e5e7eb 50%, #f3f4f6 75%);
            background-size: 200% 100%; border-radius: 10px; min-height: 38px;
        }
        @keyframes meridianShimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

        /* Legend */
        .meridian-legend {
            display: flex; flex-wrap: wrap; gap: 14px; padding: 12px 18px 14px;
            border-top: 1px solid var(--m-grid);
        }
        .meridian-legend-item {
            display: flex; align-items: center; gap: 6px; font-size: 10.5px;
            font-weight: 600; color: var(--m-muted); font-family: 'DM Sans', sans-serif;
        }
        .meridian-legend-swatch {
            width: 13px; height: 13px; border-radius: 4px;
            border: 1px solid rgba(0,0,0,0.06); flex-shrink: 0;
        }
        .meridian-legend-swatch.sw-available { background: var(--m-contour-lt); border-color: rgba(15,118,110,0.2); }
        .meridian-legend-swatch.sw-limited  { background: var(--m-saffron-lt); border-color: rgba(161,98,7,0.2); }
        .meridian-legend-swatch.sw-full     { background: var(--m-terracotta-lt); border-color: rgba(153,27,27,0.15); }
        .meridian-legend-swatch.sw-insufficient {
            background: transparent; border-color: var(--m-faint); position: relative; overflow: hidden;
        }
        .meridian-legend-swatch.sw-insufficient::after {
            content: ''; position: absolute; top: 50%; left: 15%; right: 15%;
            height: 1.5px; background: var(--m-faint); transform: translateY(-50%) rotate(-18deg);
        }
        .meridian-legend-swatch.sw-route { background: var(--m-route); border-color: var(--m-route); }

        /* Empty State */
        .meridian-empty { text-align: center; padding: 24px 16px; display: none; }
        .meridian-empty.show { display: block; }
        .meridian-empty-icon { font-size: 26px; color: var(--m-faint); margin-bottom: 6px; }
        .meridian-empty-text { font-size: 13px; font-weight: 700; color: var(--m-muted); }
        .meridian-empty-sub { font-size: 11px; color: var(--m-faint); margin-top: 2px; }
        .meridian-empty-link {
            display: inline-block; margin-top: 8px; font-size: 12px; font-weight: 700;
            color: var(--m-contour); cursor: pointer; background: none; border: none; font-family: inherit;
        }

        /* Animations */
        @keyframes cellPop {
            0%   { transform: scale(0.85); opacity: 0.5; }
            60%  { transform: scale(1.1); }
            100% { transform: scale(1.06); opacity: 1; }
        }
        @keyframes rangeFill {
            0%   { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* ── Manifest Group Roster Identity Tokens & Styles ── */
        :root {
            --mn-paper: #FDFBF7;
            --mn-ink: #1C1917;
            --mn-ink-2: #44403C;
            --mn-muted: #78716C;
            --mn-faint: #A8A29E;
            --mn-copper: #B45309;
            --mn-copper-lt: #FEF3C7;
            --mn-forest: #166534;
            --mn-forest-lt: #DCFCE7;
            --mn-card: #FFFFFF;
            --mn-ledger: #FAF8F4;
            --mn-border: #E7E0D6;
            --mn-red: #991B1B;
            --mn-red-lt: #FEE2E2;
        }

        .mn-ledger {
            background: var(--mn-card);
            border: 1.5px solid var(--mn-border);
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(28,25,23,0.04);
            margin-bottom: 24px;
        }
        .mn-ledger-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 22px;
            border-bottom: 1px solid var(--mn-border);
            background: #ffffff;
            flex-wrap: wrap;
            gap: 12px;
        }
        .mn-ledger-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mn-ledger-title-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: var(--mn-forest-lt);
            color: var(--mn-forest);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .mn-ledger-title {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--mn-forest);
        }
        .mn-ledger-count {
            font-size: 11px;
            color: var(--mn-faint);
            margin-top: 2px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 600;
        }
        .mn-btn-add {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border: 1.5px solid var(--mn-forest);
            border-radius: 10px;
            background: var(--mn-forest-lt);
            color: var(--mn-forest);
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 200ms var(--ease);
        }
        .mn-btn-add:hover {
            background: var(--mn-forest);
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(22,101,52,0.2);
        }
        .mn-btn-paste {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1.5px solid var(--mn-border);
            border-radius: 10px;
            background: #ffffff;
            color: var(--mn-ink-2);
            font-family: 'DM Sans', sans-serif;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 150ms var(--ease);
        }
        .mn-btn-paste:hover {
            background: var(--mn-ledger);
            border-color: var(--mn-faint);
        }

        .mn-table-wrap {
            padding: 12px 18px 20px;
            overflow-x: auto;
            background: #ffffff;
        }
        .mn-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 820px;
        }
        .mn-table thead th {
            padding: 10px 10px;
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--mn-faint);
            text-align: left;
            border-bottom: 2px solid #d4cfc7;
            border-right: 1px solid #e5e0d8;
            white-space: nowrap;
            background: var(--mn-card);
        }
        .mn-table thead th:last-child { border-right: none; }
        .mn-table thead th.mn-col-num { width: 44px; text-align: center; }
        .mn-table thead th.mn-col-name { min-width: 180px; }
        .mn-table thead th.mn-col-age { width: 64px; }
        .mn-table thead th.mn-col-gender { width: 90px; }
        .mn-table thead th.mn-col-contact { min-width: 130px; }
        .mn-table thead th.mn-col-email { min-width: 160px; }
        .mn-table thead th.mn-col-class { width: 140px; }
        .mn-table thead th.mn-col-days { width: 72px; }
        .mn-table thead th.mn-col-leader { width: 72px; text-align: center; }
        .mn-table thead th.mn-col-actions { width: 76px; text-align: center; }

        .mn-table tbody tr {
            border-bottom: 1px solid var(--mn-border);
            transition: background 150ms var(--ease);
        }
        .mn-table tbody tr:nth-child(even) { background: var(--mn-ledger); }
        .mn-table tbody tr:hover { background: #F0EDE6; }
        .mn-table tbody tr.mn-row-leader { background: rgba(22,101,52,0.04); }
        .mn-table tbody tr.mn-row-leader:hover { background: rgba(22,101,52,0.08); }
        .mn-table tbody tr.row-error { background: var(--mn-red-lt) !important; }
        .mn-table tbody tr:last-child { border-bottom: none; }

        .mn-table td {
            padding: 8px 8px;
            vertical-align: middle;
            font-size: 13px;
            border-right: 1px solid #e5e0d8;
            border-bottom: 1px solid #e5e0d8;
        }
        .mn-table td:last-child { border-right: none; }
        .mn-table td.mn-cell-num {
            text-align: center;
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            font-weight: 700;
            color: var(--mn-faint);
            padding: 6px 4px;
            border-right: 1px solid var(--mn-border);
        }

        .mn-name-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .mn-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 0.5px;
            flex-shrink: 0;
            position: relative;
            font-family: 'JetBrains Mono', monospace;
        }
        .mn-avatar-leader {
            background: var(--mn-forest);
            color: #fff;
        }
        .mn-avatar-leader::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 2px solid var(--mn-forest);
            opacity: 0.25;
        }
        .mn-avatar-member {
            background: var(--mn-ledger);
            color: var(--mn-ink-2);
            border: 1.5px solid var(--mn-border);
        }
        .mn-name-text {
            font-weight: 600;
            color: var(--mn-ink);
            line-height: 1.3;
        }
        .mn-name-sub {
            font-size: 10px;
            color: var(--mn-forest);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .mn-stamp {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border: 1.5px solid var(--mn-forest);
            border-radius: 6px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: var(--mn-forest);
            background: var(--mn-forest-lt);
            transform: rotate(-2deg);
            white-space: nowrap;
        }
        .mn-stamp i { font-size: 11px; }

        .mn-input {
            width: 100%;
            border: 1.5px solid transparent;
            border-radius: 8px;
            padding: 6px 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--mn-ink);
            background: transparent;
            transition: border-color 150ms, background 150ms, box-shadow 150ms;
            line-height: 1.3;
        }
        .mn-input:hover { border-color: var(--mn-border); background: #fff; }
        .mn-input:focus {
            outline: none;
            border-color: var(--mn-copper);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(180,83,9,0.08);
        }
        .mn-input.mn-input-error {
            border-color: var(--mn-red) !important;
            background: var(--mn-red-lt) !important;
        }
        .mn-input::placeholder { color: var(--mn-faint); font-weight: 400; }

        .mn-input-mono {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
        }

        .mn-select-wrap { position: relative; }
        .mn-select-wrap::after {
            content: "▾";
            font-size: 11px;
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--mn-faint);
            pointer-events: none;
        }
        select.mn-input {
            appearance: none;
            cursor: pointer;
            padding-right: 24px;
        }

        .mn-row-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }
        .mn-btn-row {
            width: 26px; height: 26px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px;
            transition: all 150ms var(--ease);
        }
        .mn-btn-dup { background: #EFF6FF; color: #2563EB; }
        .mn-btn-dup:hover { background: #DBEAFE; transform: scale(1.1); }
        .mn-btn-del { background: var(--mn-red-lt); color: var(--mn-red); }
        .mn-btn-del:hover { background: #FECACA; transform: scale(1.1); }

        .mn-btn-set-leader {
            background: none;
            border: 1.5px solid var(--mn-border);
            border-radius: 6px;
            padding: 3px 8px;
            cursor: pointer;
            font-size: 10.5px;
            color: var(--mn-faint);
            font-family: inherit;
            font-weight: 700;
            transition: all 150ms ease;
        }
        .mn-btn-set-leader:hover {
            border-color: var(--mn-forest);
            color: var(--mn-forest);
            background: var(--mn-forest-lt);
        }

        @media (max-width: 860px) {
            .mn-table-wrap { padding: 12px 12px 16px; overflow-x: hidden; }
            .mn-ledger-header { padding: 14px 14px 12px; flex-direction: column; align-items: flex-start; gap: 10px; }
            .mn-table thead { display: none !important; }
            .mn-table, .mn-table tbody, .mn-table tr, .mn-table td {
                display: block;
                width: 100% !important;
                min-width: 0 !important;
                max-width: 100% !important;
            }
            .mn-table tr {
                background: var(--mn-card) !important;
                border: 1.5px solid var(--mn-border);
                border-radius: 14px;
                padding: 12px 14px;
                margin-bottom: 12px;
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 8px 10px !important;
                box-shadow: 0 2px 8px rgba(0,0,0,0.03);
                box-sizing: border-box;
            }
            .mn-table tr.mn-row-leader { border-color: rgba(22,101,52,0.3) !important; }
            .mn-table td { padding: 4px 0 6px !important; border-right: none !important; border-bottom: 1px solid #e5e0d8 !important; box-sizing: border-box; }
            .mn-table td:last-child { border-bottom: none !important; }
            .mn-table td.mn-cell-num {
                grid-column: 1 / -1;
                display: flex !important;
                align-items: center;
                gap: 10px;
                border-right: none !important;
                padding-bottom: 8px !important;
                border-bottom: 1px solid var(--mn-border) !important;
                margin-bottom: 2px;
            }
            .mn-table td:nth-child(2) { grid-column: 1 / -1; }
            .mn-table td:last-child {
                grid-column: 1 / -1;
                grid-row: auto;
                display: flex !important;
                justify-content: flex-start;
                align-items: center;
                padding-top: 6px !important;
            }
            .mn-table td[data-label]::before {
                content: attr(data-label);
                display: block;
                font-size: 9px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.8px;
                color: var(--mn-faint);
                margin-bottom: 2px;
            }
            .mn-table td.mn-cell-num::before {
                content: "MEMBER #" attr(data-num);
                font-family: 'JetBrains Mono', monospace;
                font-size: 10px;
                font-weight: 700;
                color: var(--mn-copper);
                letter-spacing: 1px;
            }
        }

        @media (max-width: 540px) {
            .mn-table tr { padding: 12px; grid-template-columns: 1fr !important; gap: 8px !important; }
            .mn-table td:nth-child(2) { grid-column: 1; }
            .mn-table td:last-child { grid-column: 1; justify-content: flex-start; }
            .meridian-grid-wrap { padding: 8px 6px 12px !important; }
            .meridian-grid { gap: 3px !important; }
            .meridian-weekdays { padding: 8px 6px 4px !important; gap: 3px !important; }
            .meridian-wd { font-size: 9.5px !important; }
            .meridian-day { min-height: 32px !important; font-size: 12px !important; border-radius: 6px !important; }
            .meridian-day-dot { font-size: 7px !important; bottom: 1px !important; }
            .meridian-pill { padding: 5px 10px !important; font-size: 11px !important; }
            .travel-dates-grid { grid-template-columns: 1fr !important; }
            .tinfo-grid { grid-template-columns: 1fr !important; }
        }

        /* ── Travel Dates Table ── */
        .travel-dates-table { background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: var(--r-md); overflow: hidden; }
        .travel-dates-header { display: flex; align-items: center; gap: 8px; padding: 10px 14px; background: #dcfce7; border-bottom: 1px solid #bbf7d0; }
        .travel-dates-icon { width: 28px; height: 28px; border-radius: 8px; background: #16a34a; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .travel-dates-eyebrow { font-size: .7rem; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; color: #14532d; flex: 1; }
        .travel-dates-badge { font-size: .7rem; font-weight: 700; background: #16a34a; color: #fff; padding: 2px 10px; border-radius: 99px; white-space: nowrap; }
        .travel-dates-grid { display: grid; grid-template-columns: 1fr 1fr; }
        .travel-day-row { display: flex; align-items: center; gap: 10px; padding: 9px 14px; border-bottom: 1px solid #d1fae5; position: relative; }
        .travel-day-row:nth-child(odd) { border-right: 1px solid #d1fae5; }
        .travel-day-row:last-child:nth-child(odd) { grid-column: span 2; border-right: none; }
        .travel-day-row:nth-last-child(-n+2):not(:nth-child(odd)) { border-bottom: none; }
        .travel-day-row:last-child { border-bottom: none; }
        .travel-day-ordinal { font-size: .62rem; font-weight: 800; color: #9ca3af; text-transform: uppercase; letter-spacing: .4px; width: 26px; flex-shrink: 0; line-height: 1; border-right: 1.5px solid #d1fae5; padding-right: 8px; }
        .travel-day-info { display: flex; flex-direction: column; gap: 1px; }
        .travel-day-weekday { font-size: .82rem; font-weight: 800; color: #065f46; }
        .travel-day-date { font-size: .72rem; font-weight: 600; color: #16a34a; }

        .paste-zone { border: 2px dashed #d1d5db; border-radius: 12px; padding: 14px 18px; font-size: 13px; color: #9ca3af; cursor: pointer; transition: border-color .15s, background .15s; display: flex; align-items: center; gap: 10px; }
        .paste-zone:hover, .paste-zone.drag-over { border-color: var(--teal); background: #f0fdfc; color: var(--teal); }

        .row-num { font-size: 11px; font-weight: 700; color: #9ca3af; text-align: center; width: 28px; min-width: 28px; }

        .tourist-info { background: rgba(99,102,241,.05); border: 1.5px solid #c7d2fe; border-radius: var(--r-md); padding: 14px 16px; margin-bottom: 20px; }
        .tinfo-title { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #4338ca; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .tinfo-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .tinfo-item .tinfo-label { font-size: .7rem; color: var(--text-4); font-weight: 600; margin-bottom: 2px; }
        .tinfo-item .tinfo-value { font-weight: 700; color: var(--text-2); font-size: .88rem; word-break: break-word; }

        /* ── Informative Booking Terms Guide ── */
        .booking-terms-guide {
            background: linear-gradient(145deg, #ffffff 0%, #fffbf0 100%);
            border: 1.5px solid #fde68a;
            border-radius: 16px;
            padding: 18px 20px;
            margin-bottom: 24px;
            box-shadow: 0 4px 18px -4px rgba(217, 119, 6, 0.08);
        }
        .terms-guide-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 1px solid #fef3c7;
        }
        .terms-guide-icon-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: #fef3c7;
            color: #b45309;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            border: 1px solid #fde68a;
        }
        .terms-guide-title {
            font-size: 13.5px;
            font-weight: 800;
            color: #78350f;
            line-height: 1.2;
            letter-spacing: -0.2px;
        }
        .terms-guide-subtitle {
            font-size: 11.5px;
            color: #92400e;
            opacity: 0.85;
            margin-top: 2px;
        }
        .terms-guide-steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }
        @media (max-width: 768px) {
            .terms-guide-steps { grid-template-columns: 1fr; gap: 10px; }
        }
        .terms-step-item {
            background: #ffffff;
            border: 1px solid #fef3c7;
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
        }
        .terms-step-item:hover {
            border-color: #fcd34d;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.08);
        }
        .terms-step-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .terms-step-num-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: #fef3c7;
            color: #92400e;
            font-family: 'IBM Plex Mono', monospace;
            font-size: 11px;
            font-weight: 800;
        }
        .terms-step-icon {
            font-size: 16px;
        }
        .terms-step-heading {
            font-size: 12px;
            font-weight: 800;
            color: #1e293b;
        }
        .terms-step-desc {
            font-size: 11px;
            color: #64748b;
            line-height: 1.45;
        }
        .terms-step-desc strong {
            color: #334155;
            font-weight: 700;
        }
        .terms-guide-footer {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #faf8f5;
            border: 1px solid #fef3c7;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 11.5px;
            color: #78716c;
        }
        .terms-guide-footer i {
            color: #b45309;
            font-size: 14px;
            flex-shrink: 0;
        }

        .btn-submit-booking {
            width: 100%; padding: 14px; border: none; border-radius: var(--r-md);
            font-size: 1rem; font-weight: 800;
            background: linear-gradient(135deg, var(--teal), var(--ocean));
            color: #fff; box-shadow: 0 4px 20px rgba(22,197,94,.35);
            cursor: pointer; transition: var(--t); font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit-booking:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(22,197,94,.45); }

        /* ── Highlight tags ── */
        .hl-tag {
            display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px;
            border-radius: var(--r-md); background: #f9fafb; border: 1.5px solid var(--border);
            font-size: 0.72rem; font-weight: 700; color: var(--text-2);
            text-decoration: none; transition: all .2s ease;
        }
        .hl-tag:hover { background: #ecfdf5; border-color: rgba(22, 163, 74, 0.25); color: var(--teal-dark); }

        /* ── Map pin styles ── */
        .custom-visitor-pin-container { background: none !important; border: none !important; }
        .visitor-pin-wrapper { position: relative; width: 38px; height: 38px; }
        .visitor-pin-pulse {
            position: absolute; inset: 0; border-radius: 50%;
            background: rgba(34, 197, 94, 0.25);
            animation: pinPulse 2s ease-out infinite;
        }
        .visitor-pin-body {
            position: absolute; inset: 4px; border-radius: 50%;
            background: linear-gradient(135deg, #16a34a, #15803d);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 3px 10px rgba(22, 163, 74, 0.4);
        }
        .visitor-pin-icon { color: #fff; font-size: 16px; }
        @keyframes pinPulse { 0% { transform: scale(1); opacity: 1; } 100% { transform: scale(2.2); opacity: 0; } }

        .checkin-popup-card { padding: 4px; min-width: 200px; }
        .checkin-popup-header { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
        .checkin-popup-icon-badge { width: 28px; height: 28px; border-radius: 8px; background: #ecfdf5; display: flex; align-items: center; justify-content: center; color: #16a34a; font-size: 16px; }
        .checkin-popup-title { font-weight: 700; font-size: 13px; color: #111827; }
        .checkin-popup-spotname { font-size: 14px; font-weight: 800; color: #065f46; margin-bottom: 4px; }
        .checkin-popup-desc { font-size: 12px; color: #6b7280; line-height: 1.5; margin: 0; }

        /* ── Leaflet popup override ── */
        .leaflet-popup-content-wrapper { border-radius: 14px !important; box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important; }
        .leaflet-popup-content { margin: 12px 14px !important; }
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
                if (str_contains($n,'casas')||str_contains($n,'shrine')||str_contains($n,'heritage')) {
                    $gradient='linear-gradient(135deg,#b45309,#92400e)';
                } elseif (str_contains($n,'park')||str_contains($n,'rapids')||str_contains($n,'river')||str_contains($n,'adventure')||str_contains($n,'gapo')) {
                    $gradient='linear-gradient(135deg,#0d9488,#0f766e)';
                } elseif (str_contains($n,'lake')||str_contains($n,'maragang')) {
                    $gradient='linear-gradient(135deg,#0ea5e9,#0369a1)';
                } elseif (str_contains($n,'falls')||str_contains($n,'nangan')) {
                    $gradient='linear-gradient(135deg,#0d9488,#166534)';
                }

                $confirmedToday = $destination->bookings()->where('status','confirmed')->where('visit_date', now()->toDateString())->count();
                $pct = $destination->capacity > 0 ? min(100, round(($confirmedToday/$destination->capacity)*100)) : 0;
                $fillCls = $pct>=100?'fill-full':($pct>=75?'fill-high':($pct>=50?'fill-mid':'fill-low'));
                $avStatus = $destination->availability_status === 'Available' ? ($pct>=100?'full':($pct>=75?'limited':'open')) : 'closed';
                $avClass = ['open'=>'av-open','limited'=>'av-limited','full'=>'av-full','closed'=>'av-closed'][$avStatus];
                $avLabel = ['open'=>'Open','limited'=>'Limited','full'=>'Full','closed'=>'Closed'][$avStatus];

                $highlights = [
                    ['type'=>'location','text'=>$destination->location],
                    ['type'=>'capacity','text'=>$destination->capacity.' max visitors/day'],
                    ['type'=>'ticket','text'=>'QR entrance ticket required'],
                    ['type'=>'sanitized','text'=>'Sanitized & safe for visitors'],
                ];
            @endphp

            <div class="bento-grid">

                {{-- Hero Banner Block --}}
                <div class="detail-hero bento-hero">
                    @if($destination->photos)
                        <div class="detail-hero-bg" style="background-image:url('{{ app('filesystem')->url($destination->photos) }}');"></div>
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

                {{-- Visitor Info Sidebar Block --}}
                <div class="detail-card bento-sidebar">
                    <div class="detail-section-title">
                        <svg class="w-4 h-4" style="color:var(--teal);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Visitor Info
                    </div>

                    <div class="sidebar-stat">
                        <span class="ss-label">
                            <svg class="w-4 h-4" style="color:#f43f5e;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Location
                        </span>
                        <span class="ss-value" style="max-width:150px;text-align:right;font-size:.8rem;line-height:1.3;">{{ $destination->location }}</span>
                    </div>
                    <div class="sidebar-stat">
                        <span class="ss-label">
                            <svg class="w-4 h-4" style="color:#3b82f6;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Capacity
                        </span>
                        <span class="ss-value">{{ $destination->capacity }} / day</span>
                    </div>
                    <div class="sidebar-stat">
                        <span class="ss-label">
                            <svg class="w-4 h-4" style="color:#10b981;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Confirmed
                        </span>
                        <span class="ss-value">{{ $destination->bookings()->where('status','confirmed')->count() }}</span>
                    </div>
                    <div class="sidebar-stat">
                        <span class="ss-label">
                            <svg class="w-4 h-4" style="color:#8b5cf6;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            Entrance
                        </span>
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

                    @if($destination->availability_status !== 'Available')
                        <div class="btn-book-disabled">Currently Unavailable</div>
                    @endif

                    @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('destinations.edit', $destination) }}" style="display:flex;align-items:center;justify-content:center;gap:6px;margin-top:10px;padding:10px;border-radius:var(--r-md);border:1.5px solid #fcd34d;background:#fffbeb;color:#92400e;font-size:.85rem;font-weight:600;text-decoration:none;transition:var(--t);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Destination Profile
                    </a>
                    @endif
                </div>

                {{-- About Destination Block --}}
                <div class="detail-card bento-about">
                    <div class="detail-section-title">
                        <svg class="w-4 h-4" style="color:var(--teal);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>About {{ $destination->name }}</span>
                    </div>
                    <div class="detail-desc" style="margin-bottom: 20px;">
                        {!! nl2br(e($destination->description)) !!}
                    </div>

                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: auto;">
                        @foreach($highlights as $hl)
                            <span class="hl-tag">
                                @if($hl['type'] === 'location')
                                    <i class="ti ti-map-pin" style="font-size: 1rem; color: #059669;"></i>
                                @elseif($hl['type'] === 'capacity')
                                    <i class="ti ti-users" style="font-size: 1rem; color: #2563eb;"></i>
                                @elseif($hl['type'] === 'ticket')
                                    <i class="ti ti-ticket" style="font-size: 1rem; color: #7c3aed;"></i>
                                @else
                                    <i class="ti ti-shield-check" style="font-size: 1rem; color: #0d9488;"></i>
                                @endif
                                <span>{{ $hl['text'] }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Check-In Location Card --}}
                @if($destination->checkin_latitude && $destination->checkin_longitude)
                <div class="detail-card bento-map">
                    <div class="detail-section-title">
                        <svg class="w-3.5 h-3.5" style="color:#f43f5e;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Check-In Location
                    </div>
                    <p style="font-size: .8rem; color: var(--text-3); margin-bottom: 12px; line-height: 1.5; flex-shrink: 0;">
                        Scan your QR ticket within the geofenced area to check in.
                    </p>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destination->checkin_latitude }},{{ $destination->checkin_longitude }}"
                       target="_blank" rel="noopener noreferrer"
                       style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 14px; padding: 9px 16px; background: #fff; border: 1.5px solid #e5e7eb; border-radius: var(--r-sm); color: #374151; font-size: .78rem; font-weight: 700; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.04); transition: all .2s ease; width: 100%; justify-content: center; flex-shrink: 0;"
                       onmouseover="this.style.borderColor='#4285F4';this.style.color='#4285F4';this.style.boxShadow='0 4px 12px rgba(66,133,244,0.1)';this.style.transform='translateY(-1px)';"
                       onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#374151';this.style.boxShadow='0 1px 3px rgba(0,0,0,0.04)';this.style.transform='translateY(0)';"
                    >
                        <img src="{{ asset('images/google-maps.png') }}" alt="Google Maps" style="width: 16px; height: 16px; flex-shrink: 0;" onerror="this.style.display='none'" />
                        Open in Google Maps
                    </a>
                    <div id="visitor-checkin-map" style="border-radius: var(--r-sm); border: 1px solid #e5f6f4; z-index: 0;"></div>
                </div>

                @push('scripts')
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                <script>
                (function() {
                    const lat = {{ $destination->checkin_latitude }};
                    const lng = {{ $destination->checkin_longitude }};
                    const initialRadius = {{ $destination->checkin_radius ?? 100 }};
                    const spotName = @json($destination->name);
                    const absoluteCoordsUrl = @json(route('spots.checkin-coords', $destination));
                    const urlObj = new URL(absoluteCoordsUrl);
                    const coordsEndpoint = window.location.origin + urlObj.pathname + urlObj.search;

                    const map = L.map('visitor-checkin-map', { zoomControl: true, scrollWheelZoom: false, attributionControl: false })
                                 .setView([lat, lng], 15);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors',
                        maxZoom: 19,
                    }).addTo(map);

                    setTimeout(() => {
                        map.invalidateSize();
                    }, 250);

                    // Custom animated green pin icon with hover effects (Seamless UI)
                    const pinIcon = L.divIcon({
                        className: 'custom-visitor-pin-container',
                        html: `
                            <div class="visitor-pin-wrapper">
                                <div class="visitor-pin-pulse"></div>
                                <div class="visitor-pin-body">
                                    <span class="visitor-pin-icon"><i class="ti ti-scan"></i></span>
                                </div>
                            </div>
                        `,
                        iconSize: [38, 38],
                        iconAnchor: [19, 38],
                        popupAnchor: [0, -40]
                    });

                    const marker = L.marker([lat, lng], { icon: pinIcon })
                        .addTo(map)
                        .bindPopup(`
                            <div class="checkin-popup-card">
                                <div class="checkin-popup-header">
                                    <span class="checkin-popup-icon-badge">
                                        <i class="ti ti-radar"></i>
                                    </span>
                                    <span class="checkin-popup-title">Tourist Check-in Point</span>
                                </div>
                                <div class="checkin-popup-spotname">${spotName}</div>
                                <p class="checkin-popup-desc">Scan your QR ticket within the geofenced circle area to check-in.</p>
                            </div>
                        `);

                    // Geofence area circle styling consistent with visitor preview
                    const radiusCircle = L.circle([lat, lng], {
                        radius: initialRadius,
                        color: '#15803d',
                        fillColor: '#22c55e',
                        fillOpacity: 0.18,
                        weight: 2
                    }).addTo(map);

                    // Poll the coordinates endpoint every 10 seconds for real-time synchronization
                    setInterval(async function () {
                        try {
                            const res = await fetch(coordsEndpoint, { cache: 'no-store' });
                            if (!res.ok) return;
                            const data = await res.json();
                            if (data.checkin_latitude && data.checkin_longitude) {
                                const newLatLng = [parseFloat(data.checkin_latitude), parseFloat(data.checkin_longitude)];
                                const currentLatLng = marker.getLatLng();
                                
                                // Check coordinate changes
                                if (Math.abs(currentLatLng.lat - newLatLng[0]) > 0.000001 || Math.abs(currentLatLng.lng - newLatLng[1]) > 0.000001) {
                                    marker.setLatLng(newLatLng);
                                    radiusCircle.setLatLng(newLatLng);
                                    map.panTo(newLatLng);
                                }

                                // Check geofence radius changes
                                const newRadius = parseInt(data.checkin_radius) || 100;
                                if (radiusCircle.getRadius() !== newRadius) {
                                    radiusCircle.setRadius(newRadius);
                                }
                            }
                        } catch (e) {
                            // Fail silently to not impact user experience
                        }
                    }, 10000);
                })();
                </script>
                @endpush
                @endif

                @if($destination->availability_status === 'Available')
                    <div class="detail-card bento-calendar max-w-none" style="margin-bottom: 0;">
                        <div class="detail-section-title" style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                            <span class="ux-step-badge bg-emerald-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">Step 1</span>
                            <span>Plan Your Visit — Check Availability</span>
                        </div>

                        <div class="meridian-container">
                            <!-- Duration Pills (Distance Markers) -->
                            <div class="meridian-duration">
                                <div class="meridian-duration-label">
                                    <i class="ti ti-ruler-2"></i>
                                    Tour Duration
                                </div>
                                <div class="meridian-pills" id="duration-pills">
                                    @foreach([1,2,3,4,5,7,10] as $d)
                                    <button type="button" data-days="{{ $d }}" onclick="setDuration({{ $d }})"
                                        class="meridian-pill {{ $d===1 ? 'active' : '' }}">
                                        {{ $d }} {{ $d===1?'Day':'Days' }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Calendar Card -->
                            <div class="meridian-card-outer">
                                <div class="meridian-card">

                                    <!-- Month Navigation (Compass) -->
                                    <div class="meridian-nav">
                                        <button type="button" class="meridian-compass" id="cal-prev" onclick="prevMonth()" aria-label="Previous month">
                                            <i class="ti ti-chevron-left"></i>
                                        </button>
                                        <div class="meridian-month" id="cal-month-label"></div>
                                        <button type="button" class="meridian-compass" id="cal-next" onclick="nextMonth()" aria-label="Next month">
                                            <i class="ti ti-chevron-right"></i>
                                        </button>
                                    </div>

                                    <!-- Weekday Headers (Grid Coordinates) -->
                                    <div class="meridian-weekdays">
                                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $wd)
                                            <div class="meridian-wd">{{ $wd }}</div>
                                        @endforeach
                                    </div>

                                    <!-- Grid with Topo Contour Background + SVG Trail Overlay -->
                                    <div class="meridian-grid-wrap" id="cal-grid-wrap">
                                        <svg class="meridian-trail-svg" id="cal-trail-svg">
                                            <path class="meridian-trail-path" id="cal-trail-path" d=""/>
                                            <circle class="meridian-trail-dot start" id="cal-trail-dot-start" cx="0" cy="0" r="0"/>
                                            <circle class="meridian-trail-dot end" id="cal-trail-dot-end" cx="0" cy="0" r="0"/>
                                        </svg>
                                        <div class="meridian-grid" id="cal-grid"></div>
                                        <div class="meridian-empty" id="cal-empty-state">
                                            <div class="meridian-empty-icon"><i class="ti ti-calendar-off"></i></div>
                                            <div class="meridian-empty-text">No valid start dates this month</div>
                                            <div class="meridian-empty-sub">Not enough consecutive days for <span id="empty-dur-label"></span></div>
                                            <button type="button" class="meridian-empty-link" onclick="nextMonth()">Check next month &rarr;</button>
                                        </div>
                                    </div>

                                    <!-- Map Legend -->
                                    <div class="meridian-legend">
                                        <div class="meridian-legend-item">
                                            <div class="meridian-legend-swatch sw-available"></div>
                                            <span>Available</span>
                                        </div>
                                        <div class="meridian-legend-item">
                                            <div class="meridian-legend-swatch sw-limited"></div>
                                            <span>Limited</span>
                                        </div>
                                        <div class="meridian-legend-item">
                                            <div class="meridian-legend-swatch sw-full"></div>
                                            <span>Full</span>
                                        </div>
                                        <div class="meridian-legend-item">
                                            <div class="meridian-legend-swatch sw-insufficient"></div>
                                            <span>Can't start here</span>
                                        </div>
                                        <div class="meridian-legend-item">
                                            <div class="meridian-legend-swatch sw-route"></div>
                                            <span>Your route</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Booking Form Card --}}
                    @auth
                        @php
                            $primaryUser = [
                                'name' => trim(auth()->user()->name . ' ' . auth()->user()->last_name),
                                'email' => auth()->user()->email,
                                'age' => auth()->user()->age !== 'N/A' ? auth()->user()->age : '',
                                'gender' => auth()->user()->gender ?? '',
                                'contact_number' => auth()->user()->contact ?? '',
                                'classification' => auth()->user()->classification ?? 'Local',
                                'isDefault' => true,
                            ];
                        @endphp
                        <div id="booking-form-card" x-data="bookingFormGrid({{ $destination->capacity }}, {{ json_encode($primaryUser) }})" x-on:date-selected.window="handleDateSelected($event.detail)" class="detail-card bento-form border-2" style="border-color: var(--teal); margin-top: 0;">
                            
                            {{-- Pick Date Prompt --}}
                            <div x-show="selectedDate === null" class="bg-gradient-to-r from-amber-50 to-amber-100/50 border border-amber-200 rounded-2xl p-6 text-center text-amber-900 shadow-2xs">
                                <i class="ti ti-calendar-event text-3xl text-amber-600 block mb-2"></i>
                                <h4 class="font-bold text-sm text-amber-950">Choose Your Travel Date</h4>
                                <p class="text-xs text-amber-700/80 mt-1">Please select an available start date from the calendar above to begin booking your stay.</p>
                            </div>

                            <form id="show-booking-form" action="{{ route('bookings.store', $destination) }}" method="POST" x-show="selectedDate !== null" x-cloak>
                                    @csrf
                                    <input type="hidden" id="visit_date_input" name="visit_date" x-model="selectedDate" required>
                                    <input type="hidden" id="duration_days_input" name="duration_days" x-model="duration">
                                    
                                    <div class="detail-section-title" style="display:flex;align-items:center;gap:8px;margin-bottom: 16px;">
                                        <span class="ux-step-badge bg-indigo-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">Step 2</span>
                                        <span>Confirm Booking & Companions</span>
                                    </div>

                                    {{-- Selected Travel Dates Table --}}
                                    <div class="travel-dates-table" style="margin-bottom:20px;">
                                        <div class="travel-dates-header">
                                            <span class="travel-dates-icon"><i class="ti ti-calendar-check"></i></span>
                                            <span class="travel-dates-eyebrow">Selected Travel Dates</span>
                                            <span class="travel-dates-badge" x-text="duration + (duration > 1 ? ' Days Stay' : ' Day Visit')"></span>
                                        </div>
                                        <div class="travel-dates-grid" id="travel-dates-grid">
                                            <template x-for="(day, i) in travelDays" :key="i">
                                                <div class="travel-day-row">
                                                    <div class="travel-day-ordinal" x-text="day.ordinal"></div>
                                                    <div class="travel-day-info">
                                                        <span class="travel-day-weekday" x-text="day.weekday"></span>
                                                        <span class="travel-day-date" x-text="day.date"></span>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>



                                    {{-- Manifest Group Roster Ledger --}}
                                    <div class="mn-ledger">
                                        <div class="mn-ledger-header">
                                            <div class="mn-ledger-title-group">
                                                <div class="mn-ledger-title-icon"><i class="ti ti-users-group"></i></div>
                                                <div>
                                                    <div class="mn-ledger-title">Group Companions / Members</div>
                                                    <div class="mn-ledger-count" x-text="rows.length + (rows.length === 1 ? ' member in roster' : ' members in roster')"></div>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <button type="button" @click="showPaste = !showPaste" class="mn-btn-paste">
                                                    <i class="ti ti-clipboard-text"></i> Paste Spreadsheet
                                                </button>
                                                <button type="button" @click="addRow()" class="mn-btn-add">
                                                    <i class="ti ti-plus"></i> Add Companion
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Overcapacity Warning --}}
                                        <div x-show="isOverCapacity" x-cloak
                                            class="bg-red-50 border border-red-200 rounded-xl px-4 py-2.5 mx-4 mt-3 flex items-start gap-2.5">
                                            <i class="ti ti-alert-circle text-red-500 text-lg shrink-0 mt-0.5"></i>
                                            <div class="text-xs text-red-700">
                                                <p class="font-bold">Capacity Limit Exceeded</p>
                                                <p class="mt-0.5">Your group size exceeds the remaining available quota for this destination.</p>
                                            </div>
                                        </div>

                                        {{-- Paste Zone (collapsible) --}}
                                        <div x-show="showPaste" x-cloak class="p-4 border-b border-amber-100 bg-amber-50/40">
                                            <div class="paste-zone" @click="$refs.pasteArea.focus()"
                                                @dragover.prevent="$event.currentTarget.classList.add('drag-over')"
                                                @dragleave="$event.currentTarget.classList.remove('drag-over')">
                                                <i class="ti ti-clipboard-data text-2xl flex-shrink-0 text-amber-700"></i>
                                                <div class="flex-1">
                                                    <p class="font-semibold text-gray-800 text-xs">Paste Spreadsheet Data</p>
                                                    <p class="text-[11px] text-gray-500 mt-0.5">
                                                        Copy columns from Excel/Sheets (Name, Age, Gender, Contact, Email, Classification, Days) then click here and press Ctrl+V
                                                    </p>
                                                </div>
                                            </div>
                                            <textarea x-ref="pasteArea" @paste="handlePaste($event)" class="sr-only" aria-label="Paste area for bulk import" tabindex="-1"></textarea>
                                        </div>

                                        {{-- Manifest Table --}}
                                        <div class="mn-table-wrap">
                                            <table class="mn-table" id="rosterTable">
                                                <thead>
                                                    <tr>
                                                        <th class="mn-col-num">#</th>
                                                        <th class="mn-col-name">Full Name <span class="text-red-500">*</span></th>
                                                        <th class="mn-col-age">Age <span class="text-red-500">*</span></th>
                                                        <th class="mn-col-gender">Gender <span class="text-red-500">*</span></th>
                                                        <th class="mn-col-contact">Contact</th>
                                                        <th class="mn-col-email">Email</th>
                                                        <th class="mn-col-class">Class. <span class="text-red-500">*</span></th>
                                                        <th class="mn-col-days">Days <span class="text-red-500">*</span></th>
                                                        <th class="mn-col-actions" style="text-align:center;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="show-visitor-tbody">
                                                    <template x-for="(row, i) in rows" :key="row.id">
                                                        <tr :class="{'mn-row-leader': row.isLeader || row.isDefault, 'row-error': row.hasError}">
                                                            <!-- # Column -->
                                                            <td class="mn-cell-num" :data-num="String(i + 1).padStart(2, '0')" data-label="#">
                                                                <template x-if="row.isLeader || row.isDefault">
                                                                    <div class="mn-stamp"><i class="ti ti-crown"></i> Captain</div>
                                                                </template>
                                                                <template x-if="!row.isLeader && !row.isDefault">
                                                                    <span x-text="String(i + 1).padStart(2, '0')"></span>
                                                                </template>
                                                            </td>

                                                            <!-- Name Column -->
                                                            <td data-label="Full Name *" class="relative">
                                                                <div class="mn-name-cell">
                                                                    <div :class="(row.isLeader || row.isDefault) ? 'mn-avatar mn-avatar-leader' : 'mn-avatar mn-avatar-member'" x-text="getInitials(row.name)"></div>
                                                                    <div class="flex-1">
                                                                        <input type="text" :name="'visitors['+i+'][name]'" x-model="row.name"
                                                                            @input="clearError(row, 'name')"
                                                                            @keydown.tab.prevent="focusNext($event, i, 'name')"
                                                                            :readonly="row.isDefault"
                                                                            :class="{'mn-input': true, 'mn-input-error': row.errors.name, 'opacity-85 cursor-not-allowed font-semibold': row.isDefault}"
                                                                            placeholder="Juan dela Cruz" required autocomplete="off">
                                                                        <template x-if="row.isDefault">
                                                                            <div class="mn-name-sub">Account holder (Primary)</div>
                                                                        </template>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <!-- Age Column -->
                                                            <td data-label="Age *">
                                                                <input type="number" :name="'visitors['+i+'][age]'" x-model.number="row.age"
                                                                    min="1" max="150" @input="clearError(row, 'age')"
                                                                    @keydown.tab.prevent="focusNext($event, i, 'age')"
                                                                    :readonly="row.isDefault"
                                                                    :class="{'mn-input mn-input-mono': true, 'mn-input-error': row.errors.age, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                    placeholder="Age" required>
                                                            </td>

                                                            <!-- Gender Column -->
                                                            <td data-label="Gender *">
                                                                <div class="mn-select-wrap">
                                                                    <select :name="'visitors['+i+'][gender]'" x-model="row.gender"
                                                                        :disabled="row.isDefault"
                                                                        :class="{'mn-input': true, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                        required>
                                                                        <option value="">Select</option>
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        <option value="Prefer not to say">Prefer not to say</option>
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <!-- Contact Column -->
                                                            <td data-label="Contact No.">
                                                                <input type="tel" :name="'visitors['+i+'][contact_number]'" x-model="row.contact_number"
                                                                    @keydown.tab.prevent="focusNext($event, i, 'contact_number')"
                                                                    :readonly="row.isDefault"
                                                                    :class="{'mn-input': true, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                    placeholder="09xxxxxxxxx">
                                                            </td>

                                                            <!-- Email Column -->
                                                            <td data-label="Email">
                                                                <input type="email" :name="'visitors['+i+'][email]'" x-model="row.email"
                                                                    @input="clearError(row, 'email')"
                                                                    @keydown.tab.prevent="focusNext($event, i, 'email')"
                                                                    :readonly="row.isDefault"
                                                                    :class="{'mn-input': true, 'mn-input-error': row.errors.email, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                    placeholder="optional">
                                                            </td>

                                                            <!-- Classification Column -->
                                                            <td data-label="Classification *">
                                                                <div class="mn-select-wrap">
                                                                    <select :name="'visitors['+i+'][classification]'" x-model="row.classification"
                                                                        :disabled="row.isDefault"
                                                                        :class="{'mn-input': true, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                        required>
                                                                        <option value="Local">Local</option>
                                                                        <option value="Domestic Tourist">Domestic Tourist</option>
                                                                        <option value="International Tourist">International Tourist</option>
                                                                    </select>
                                                                </div>
                                                            </td>

                                                            <!-- Days Stay Column -->
                                                            <td data-label="Days Stay *">
                                                                <input type="number" :name="'visitors['+i+'][duration_days]'" x-model.number="row.duration_days"
                                                                    min="1" max="30" @input="clearError(row, 'duration_days')"
                                                                    @keydown.tab.prevent="focusNextOrAddRow($event, i)"
                                                                    :readonly="row.isDefault"
                                                                    :class="{'mn-input mn-input-mono': true, 'mn-input-error': row.errors.duration_days, 'opacity-85 cursor-not-allowed': row.isDefault}"
                                                                    placeholder="1" required>
                                                            </td>

                                                            <!-- Actions Column -->
                                                            <td data-label="Actions" class="text-center">
                                                                <div class="flex items-center justify-center gap-1.5">
                                                                    <!-- Leader badge (captain row only) -->
                                                                    <template x-if="row.isLeader || row.isDefault">
                                                                        <span title="Trip Leader" style="display:inline-flex;align-items:center;gap:4px;font-size:.7rem;font-weight:700;color:#166534;background:#dcfce7;border:1px solid #86efac;border-radius:99px;padding:3px 8px;">
                                                                            <i class="ti ti-crown" style="font-size:.85rem;"></i> Leader
                                                                        </span>
                                                                    </template>
                                                                    <!-- Duplicate / Delete (non-default rows only) -->
                                                                    <template x-if="!row.isDefault">
                                                                        <div class="flex items-center gap-1">
                                                                            <button type="button" @click="duplicateRow(i)" class="mn-btn-row mn-btn-dup" title="Duplicate Row">
                                                                                <i class="ti ti-copy"></i>
                                                                            </button>
                                                                            <button type="button" @click="removeRow(i)" class="mn-btn-row mn-btn-del" title="Remove Row">
                                                                                <i class="ti ti-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    </template>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    {{-- Informative 3-Step Booking Terms Guide --}}
                                    <div class="booking-terms-guide">
                                        <div class="terms-guide-header">
                                            <div class="terms-guide-icon-badge">
                                                <i class="ti ti-shield-check"></i>
                                            </div>
                                            <div>
                                                <h4 class="terms-guide-title">Important Booking Terms & Entry Process</h4>
                                                <p class="terms-guide-subtitle">Here is what happens after you submit your reservation request:</p>
                                            </div>
                                        </div>

                                        <div class="terms-guide-steps">
                                            <!-- Step 1 -->
                                            <div class="terms-step-item">
                                                <div class="terms-step-top">
                                                    <span class="terms-step-num-badge">1</span>
                                                    <i class="ti ti-clock-hour-4 terms-step-icon text-amber-600"></i>
                                                </div>
                                                <div class="terms-step-heading">Pending Review Status</div>
                                                <p class="terms-step-desc">All bookings are submitted under <strong>Pending Review</strong> status to immediately reserve your slot quota for requested dates.</p>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="terms-step-item">
                                                <div class="terms-step-top">
                                                    <span class="terms-step-num-badge">2</span>
                                                    <i class="ti ti-user-check terms-step-icon text-blue-600"></i>
                                                </div>
                                                <div class="terms-step-heading">Staff Verification</div>
                                                <p class="terms-step-desc">The site's assigned staff will review your group details and payment verification before officially approving your booking.</p>
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="terms-step-item">
                                                <div class="terms-step-top">
                                                    <span class="terms-step-num-badge">3</span>
                                                    <i class="ti ti-qrcode terms-step-icon text-emerald-600"></i>
                                                </div>
                                                <div class="terms-step-heading">QR Entrance Tickets</div>
                                                <p class="terms-step-desc">Once approved, unique scannable <strong>QR entrance tickets</strong> are generated for each visitor to scan at the gate.</p>
                                            </div>
                                        </div>

                                        <div class="terms-guide-footer">
                                            <i class="ti ti-info-circle"></i>
                                            <span>You can track your approval status or manage reservations anytime in your <strong>Tourist Portal</strong>.</span>
                                        </div>
                                    </div>

                                    <button type="button" @click="submitForm()" :disabled="isSubmitting" class="btn-submit-booking" id="submit-btn" :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''">
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
                            </div>
                    @else
                        <div id="booking-form-card" x-data="{ selectedDate: null }" x-on:date-selected.window="selectedDate = $event.detail.date" class="detail-card bento-form text-center py-6" style="margin-top: 0;">
                            <div x-show="selectedDate === null" class="text-amber-800 font-semibold text-xs">
                                <i class="ti ti-calendar-event text-base mr-1"></i> Please select a start date from the calendar (Step 1) to book.
                            </div>
                            <div x-show="selectedDate !== null" x-cloak>
                                <div class="detail-section-title" style="display:flex;align-items:center;gap:8px;margin-bottom: 20px;justify-content:center;">
                                    <span class="ux-step-badge bg-indigo-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider">Step 2</span>
                                    <span>Confirm Booking</span>
                                </div>
                                <p class="text-sm text-gray-500 font-semibold mb-3">Please login to book this destination.</p>
                                <a href="{{ route('login') }}" class="btn-book" style="display:inline-flex;width:auto;padding:10px 24px;">Login to Book</a>
                            </div>
                        </div>
                    @endauth

            </div>
        </div>
    </div>
    <script>
    (function() {
        const MONTH_AVAIL_URL  = '{{ route('destinations.availability.month', $destination) }}';
        const CAP        = {{ $destination->capacity }};
        const MIN_DATE   = new Date(); MIN_DATE.setDate(MIN_DATE.getDate()+1); MIN_DATE.setHours(0,0,0,0);
        const MAX_MONTHS = 6;

        let duration    = 1;
        let viewYear    = MIN_DATE.getFullYear();
        let viewMonth   = MIN_DATE.getMonth();
        let selectedStart = null;
        let monthCache  = @json($initialAvailability ?? []);
        let loading     = false;

        const grid           = document.getElementById('cal-grid');
        const monthLabel     = document.getElementById('cal-month-label');
        const emptyState     = document.getElementById('cal-empty-state');
        const emptyDurLbl    = document.getElementById('empty-dur-label');
        const prevBtn        = document.getElementById('cal-prev');
        const nextBtn        = document.getElementById('cal-next');
        const trailSvg       = document.getElementById('cal-trail-svg');
        const trailPath      = document.getElementById('cal-trail-path');
        const trailDotStart  = document.getElementById('cal-trail-dot-start');
        const trailDotEnd    = document.getElementById('cal-trail-dot-end');
        const capFill        = document.getElementById('cap-fill-bar');

        if (capFill) setTimeout(() => capFill.style.width = '{{ $pct }}%', 200);

        const calTip = document.createElement('div');
        calTip.id = 'cal-tooltip';
        calTip.style.cssText = [
            'position:fixed','z-index:9999','pointer-events:none',
            'background:#1e1b4b','color:#fff','font-size:11px','font-weight:600',
            'font-family:DM Sans, sans-serif','padding:5px 11px','border-radius:8px',
            'white-space:nowrap','box-shadow:0 4px 14px rgba(30,27,75,.35)','opacity:0',
            'transition:opacity 0.15s ease','border:1px solid rgba(255,255,255,0.15)'
        ].join(';');
        document.body.appendChild(calTip);

        function showTip(el, text) {
            calTip.textContent = text;
            calTip.style.opacity = '1';
            const r = el.getBoundingClientRect();
            calTip.style.left = (r.left + r.width / 2 - calTip.offsetWidth / 2) + 'px';
            calTip.style.top  = (r.top - calTip.offsetHeight - 8) + 'px';
        }
        function hideTip() { calTip.style.opacity = '0'; }

        window.setDuration = function(d) {
            duration = d;
            document.querySelectorAll('.meridian-pill').forEach(p => {
                p.classList.toggle('active', +p.dataset.days === d);
            });
            if (selectedStart && !isValidStart(selectedStart)) {
                selectedStart = null;
                clearTrail();
            }
            renderCalendar();
            if (selectedStart) {
                window.dispatchEvent(new CustomEvent('date-selected', {
                    detail: {
                        date: fmtDate(selectedStart),
                        duration: duration,
                        slots: getDayInfo(fmtDate(selectedStart)) ? (getDayInfo(fmtDate(selectedStart)).slots || 0) : 0
                    }
                }));
            }
        };

        window.prevMonth = function() {
            const now = new Date(); now.setDate(1); now.setHours(0,0,0,0);
            if (new Date(viewYear, viewMonth, 1) <= now) return;
            viewMonth === 0 ? (viewYear--, viewMonth=11) : viewMonth--;
            selectedStart = null; clearTrail();
            renderCalendar();
        };
        window.nextMonth = function() {
            const max = new Date(); max.setMonth(max.getMonth()+MAX_MONTHS);
            if (new Date(viewYear, viewMonth+1, 1) > max) return;
            viewMonth === 11 ? (viewYear++, viewMonth=0) : viewMonth++;
            selectedStart = null; clearTrail();
            renderCalendar();
        };

        function renderCalendar() {
            const key = `${viewYear}-${String(viewMonth+1).padStart(2,'0')}`;
            const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            monthLabel.innerHTML = monthNames[viewMonth] + ' <span class="meridian-month-year">' + viewYear + '</span>';
            const now = new Date(); now.setDate(1); now.setHours(0,0,0,0);
            prevBtn.disabled = new Date(viewYear, viewMonth, 1) <= now;
            if (monthCache[key]) paintGrid(monthCache[key]);
            else { paintShimmer(); loadMonth(key); }
        }

        async function loadMonth(key) {
            if (loading) return; loading = true;
            try {
                const res = await fetch(`${MONTH_AVAIL_URL}?month=${key}`);
                if (res.ok) {
                    const data = await res.json();
                    monthCache[key] = data;
                    paintGrid(data);
                }
            } finally {
                loading = false;
            }
        }

        function paintShimmer() {
            emptyState.classList.remove('show');
            grid.innerHTML = '';
            const first = new Date(viewYear, viewMonth, 1).getDay();
            const total = new Date(viewYear, viewMonth+1, 0).getDate();
            for (let i=0;i<first;i++) { const b=document.createElement('div'); b.className='meridian-day empty'; grid.appendChild(b); }
            for (let d=1;d<=total;d++) {
                const el=document.createElement('div');
                el.className='meridian-day meridian-shimmer';
                const num = document.createElement('span');
                num.className = 'meridian-day-num';
                num.textContent = d;
                el.appendChild(num);
                grid.appendChild(el);
            }
        }

        function paintGrid(dayData) {
            grid.innerHTML = ''; emptyState.classList.remove('show');
            const first = new Date(viewYear, viewMonth, 1).getDay();
            const total = new Date(viewYear, viewMonth+1, 0).getDate();
            let hasValid = false;
            for (let i=0;i<first;i++) { const b=document.createElement('div'); b.className='meridian-day empty'; grid.appendChild(b); }
            for (let d=1;d<=total;d++) {
                const date = new Date(viewYear, viewMonth, d);
                const ds   = fmtDate(date);
                const info = dayData[ds]||{slots:0,status:'past'};
                const el   = document.createElement('button');
                el.type = 'button';
                el.className = 'meridian-day';
                el.dataset.date = ds;
                el.dataset.day = d;
                el.setAttribute('aria-label', `${ds}`);

                const num = document.createElement('span');
                num.className = 'meridian-day-num';
                num.textContent = d;
                el.appendChild(num);

                if (date < MIN_DATE) {
                    el.classList.add('past');
                } else if (info.status === 'full') {
                    el.classList.add('full');
                    el.addEventListener('mouseenter', () => showTip(el, 'Fully booked'));
                    el.addEventListener('mouseleave', hideTip);
                } else {
                    const run = consecDays(date);
                    if (run >= duration) {
                        hasValid = true;
                        el.classList.add(info.status === 'limited' ? 'limited' : 'available');
                        const tipText = `${info.slots} slot${info.slots!==1?'s':''} available`;
                        el.addEventListener('mouseenter', () => { hoverRange(date); showTip(el, tipText); });
                        el.addEventListener('mouseleave', () => { clearHover(); hideTip(); });
                        el.addEventListener('click', () => selectDate(date));
                    } else {
                        el.classList.add('insufficient');
                        const tipText2 = run===0 ? 'Fully booked' : `Only ${run} of ${duration} day${duration>1?'s':''} available`;
                        el.addEventListener('mouseenter', () => showTip(el, tipText2));
                        el.addEventListener('mouseleave', hideTip);
                    }
                }

                if (info.slots > 0 && date >= MIN_DATE && info.status !== 'full') {
                    const dot = document.createElement('span');
                    dot.className = 'meridian-day-dot';
                    dot.textContent = info.slots;
                    el.appendChild(dot);
                }

                grid.appendChild(el);
            }

            const totalCells = first + total;
            const trailing = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let i = 0; i < trailing; i++) {
                const el = document.createElement('div');
                el.className = 'meridian-day empty';
                grid.appendChild(el);
            }

            if (!hasValid) {
                emptyState.classList.add('show');
                emptyDurLbl.textContent = `${duration} day${duration>1?'s':''}`;
            }

            if (selectedStart) {
                applyRangeClasses(false);
            } else {
                clearTrail();
            }
        }

        function getDayInfo(dateStr) {
            const monthKey = dateStr.substring(0, 7);
            if (!monthCache[monthKey]) loadMonth(monthKey);
            return (monthCache[monthKey] && monthCache[monthKey][dateStr]) ? monthCache[monthKey][dateStr] : null;
        }

        function consecDays(date) {
            let count = 0, d = new Date(date);
            for (let i = 0; i < duration; i++) {
                const ds = fmtDate(d);
                const info = getDayInfo(ds);
                if (!info || info.status === 'full' || info.status === 'past' || info.status === 'error') break;
                count++;
                d.setDate(d.getDate() + 1);
            }
            return count;
        }

        function isValidStart(date) {
            return consecDays(date) >= duration;
        }

        function selectDate(date) {
            if (selectedStart && fmtDate(selectedStart) === fmtDate(date)) {
                selectedStart = null;
                clearTrail();
                renderCalendar();
                return;
            }

            selectedStart = date;
            renderCalendar();
            applyRangeClasses(true);

            window.dispatchEvent(new CustomEvent('date-selected', {
                detail: {
                    date: fmtDate(date),
                    duration: duration,
                    slots: getDayInfo(fmtDate(date)) ? (getDayInfo(fmtDate(date)).slots || 0) : 0
                }
            }));
        }

        function applyRangeClasses(animate = false) {
            if (!selectedStart) return;
            const startStr = fmtDate(selectedStart);
            const endDate  = new Date(selectedStart); endDate.setDate(endDate.getDate() + duration - 1);
            const endStr   = fmtDate(endDate);

            let idx = 0;
            grid.querySelectorAll('.meridian-day[data-date]').forEach(el => {
                const ds = el.dataset.date;
                if (!ds) return;
                if (ds >= startStr && ds <= endStr) {
                    el.classList.remove('available','limited','preview-mid','preview-end');
                    if (ds === startStr) el.classList.add('range-start');
                    if (ds === endStr)   el.classList.add('range-end');
                    if (ds > startStr && ds < endStr) el.classList.add('range-mid');
                    if (animate) {
                        el.classList.add('range-cascade');
                        el.style.animationDelay = (idx * 35) + 'ms';
                    }
                    idx++;
                }
            });

            if (duration > 1) {
                const startCell = grid.querySelector(`.meridian-day[data-date="${startStr}"]`);
                const endCell   = grid.querySelector(`.meridian-day[data-date="${endStr}"]`);
                if (startCell && endCell) {
                    setTimeout(() => drawTrail(startCell, endCell, true), 80);
                }
            } else {
                clearTrail();
            }
        }

        function hoverRange(date) {
            clearHover();
            if (consecDays(date) < duration) return;
            const startStr = fmtDate(date);
            const endDate  = new Date(date); endDate.setDate(endDate.getDate() + duration - 1);
            const endStr   = fmtDate(endDate);

            grid.querySelectorAll('.meridian-day[data-date]').forEach(el => {
                const ds = el.dataset.date;
                if (ds && ds > startStr && ds < endStr) el.classList.add('preview-mid');
                if (ds && ds === endStr && duration > 1) el.classList.add('preview-end');
            });

            if (duration > 1) {
                const startCell = grid.querySelector(`.meridian-day[data-date="${startStr}"]`);
                const endCell   = grid.querySelector(`.meridian-day[data-date="${endStr}"]`);
                if (startCell && endCell) drawTrail(startCell, endCell, false);
            }
        }

        function clearHover() {
            grid.querySelectorAll('.preview-mid, .preview-end').forEach(el => {
                el.classList.remove('preview-mid', 'preview-end');
            });
            if (!selectedStart) clearTrail();
        }

        function getCellCenter(cell) {
            const gridRect = grid.getBoundingClientRect();
            const cellRect = cell.getBoundingClientRect();
            return {
                x: cellRect.left + cellRect.width / 2 - gridRect.left,
                y: cellRect.top + cellRect.height / 2 - gridRect.top
            };
        }

        function drawTrail(startCell, endCell, isActive) {
            if (!trailSvg || !trailPath) return;
            const s = getCellCenter(startCell);
            const e = getCellCenter(endCell);
            const dx = e.x - s.x;
            const dy = e.y - s.y;
            const dist = Math.sqrt(dx*dx + dy*dy);
            const cpY = Math.min(s.y, e.y) - Math.min(dist * 0.18, 35);
            const cpX = (s.x + e.x) / 2;
            const d = `M ${s.x} ${s.y} Q ${cpX} ${cpY} ${e.x} ${e.y}`;

            const gridRect = grid.getBoundingClientRect();
            trailSvg.setAttribute('viewBox', `0 0 ${gridRect.width} ${gridRect.height}`);
            trailSvg.style.width = gridRect.width + 'px';
            trailSvg.style.height = gridRect.height + 'px';

            trailPath.setAttribute('d', d);
            trailPath.classList.remove('preview', 'active');

            if (isActive) {
                const pathLength = trailPath.getTotalLength() || 200;
                trailPath.style.strokeDasharray = pathLength;
                trailPath.style.strokeDashoffset = pathLength;
                trailPath.classList.add('active');
                trailPath.getBoundingClientRect();
                trailPath.style.strokeDashoffset = '0';
            } else {
                trailPath.classList.add('preview');
            }

            if (trailDotStart && trailDotEnd) {
                trailDotStart.setAttribute('cx', s.x);
                trailDotStart.setAttribute('cy', s.y);
                trailDotStart.classList.add('visible');
                trailDotEnd.setAttribute('cx', e.x);
                trailDotEnd.setAttribute('cy', e.y);
                trailDotEnd.classList.toggle('visible', isActive);
            }
        }

        function clearTrail() {
            if (!trailPath) return;
            trailPath.setAttribute('d', '');
            trailPath.classList.remove('preview', 'active');
            trailPath.style.strokeDasharray = '';
            trailPath.style.strokeDashoffset = '';
            if (trailDotStart) trailDotStart.classList.remove('visible');
            if (trailDotEnd) trailDotEnd.classList.remove('visible');
        }

        function fmtDate(d) {
            const y = d.getFullYear();
            const m = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${y}-${m}-${day}`;
        }

        window.addEventListener('resize', () => {
            if (selectedStart && duration > 1) {
                const startStr = fmtDate(selectedStart);
                const endDate  = new Date(selectedStart); endDate.setDate(endDate.getDate() + duration - 1);
                const endStr   = fmtDate(endDate);
                const startCell = grid.querySelector(`.meridian-day[data-date="${startStr}"]`);
                const endCell   = grid.querySelector(`.meridian-day[data-date="${endStr}"]`);
                if (startCell && endCell) drawTrail(startCell, endCell, true);
            }
        });

        // Initialize calendar immediately
        renderCalendar();
    })();
    </script>

    <script>
    window.bookingFormGrid = function(capacity, primaryTourist = null) {
        return {
            capacity: capacity,
            primaryTourist: primaryTourist,
            initialCount: 0,
            selectedDate: null,
            duration: 1,
            rows: [],
            showPaste: false,
            isSubmitting: false,
            _idCounter: 0,

            get formattedDateRange() {
                if (!this.selectedDate) return '';
                const start = new Date(this.selectedDate + 'T00:00:00');
                const end = new Date(start);
                end.setDate(end.getDate() + (this.duration - 1));
                const sFmt = start.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                const eFmt = end.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                return this.duration > 1 ? `${sFmt} → ${eFmt}` : sFmt;
            },

            get travelDays() {
                if (!this.selectedDate) return [];
                const ordinals = ['1st','2nd','3rd','4th','5th','6th','7th','8th','9th','10th',
                                  '11th','12th','13th','14th','15th','16th','17th','18th','19th','20th',
                                  '21st','22nd','23rd','24th','25th','26th','27th','28th','29th','30th'];
                const days = [];
                const start = new Date(this.selectedDate + 'T00:00:00');
                for (let i = 0; i < this.duration; i++) {
                    const d = new Date(start);
                    d.setDate(d.getDate() + i);
                    days.push({
                        ordinal: ordinals[i] || `${i+1}th`,
                        weekday: d.toLocaleDateString('en-US', { weekday: 'long' }),
                        date: d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                    });
                }
                return days;
            },

            init() {
                // Event listener registered declaratively on the HTML container
            },

            handleDateSelected(detail) {
                this.selectedDate = detail.date;
                this.duration = detail.duration;
                this.initialCount = detail.slots;
                
                if (this.rows.length === 0) {
                    if (this.primaryTourist) {
                        this.addRow({
                            ...this.primaryTourist,
                            duration_days: this.duration
                        });
                    } else {
                        this.addRow();
                    }
                } else {
                    this.rows.forEach(r => r.duration_days = this.duration);
                }
            },

            getInitials(name) {
                if (!name) return '??';
                const parts = name.trim().split(/\s+/);
                if (parts.length >= 2) return (parts[0][0] + parts[parts.length-1][0]).toUpperCase();
                return name.slice(0, 2).toUpperCase();
            },

            setLeader(idx) {
                this.rows.forEach((r, i) => r.isLeader = (i === idx));
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
                    duration_days: defaults.duration_days ?? this.duration,
                    isLeader: defaults.isLeader ?? (defaults.isDefault ?? false),
                    isDefault: defaults.isDefault ?? false,
                    hasError: false,
                    errors: { name: '', age: '', email: '', duration_days: '' }
                };
            },

            get projectedCount() {
                return this.rows.length;
            },

            get isOverCapacity() {
                if (!this.selectedDate) return false;
                return this.rows.length > this.initialCount;
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
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'warning',
                            title: 'Capacity Limit Exceeded',
                            message: 'Your group size exceeds the remaining slots on this date.'
                        }
                    }));
                    return;
                }
                if (!this.validateAll()) {
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: 'error',
                            title: 'Validation Error',
                            message: 'Please review and complete all required companion fields.'
                        }
                    }));
                    this.$nextTick(() => {
                        const errRow = document.querySelector('tr.row-error');
                        if (errRow) errRow.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                    return;
                }
                this.isSubmitting = true;
                document.getElementById('show-booking-form').submit();
            },

            FIELD_ORDER: ['name', 'age', 'gender', 'contact_number', 'email', 'classification', 'duration_days'],

            focusCellAt(rowIdx, field) {
                this.$nextTick(() => {
                    const tbody = document.getElementById('show-visitor-tbody');
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

                    const duration_days = parseInt(clean[6]) || this.duration;

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
    };
    </script>
</x-app-layout>
