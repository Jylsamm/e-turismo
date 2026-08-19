<style>
  /* ── Hide Edge's native password reveal eye to prevent duplication with custom toggle ── */
  input[type="password"]::-ms-reveal,
  input[type="password"]::-ms-clear {
    display: none;
  }

  /* ── Date picker icon ── */
  input[type="date"]::-webkit-calendar-picker-indicator {
    cursor: pointer;
    opacity: .7;
    filter: invert(40%) sepia(80%) saturate(500%) hue-rotate(200deg);
  }

  input[type="date"]::-webkit-inner-spin-button {
    display: none;
  }

  /* ── Camera container ── */
  .cam-box {
    background: #08111f;
    border-radius: 1rem;
    overflow: hidden;
    border: 1px solid #1e3a52;
  }

  /* ── Teal dashed guide ── */
  .cam-guide-rect {
    fill: none;
    stroke: #14b8a6;
    stroke-width: 2.5;
    stroke-dasharray: 10 6;
    animation: teal-pulse 2.4s ease-in-out infinite;
  }

  @keyframes teal-pulse {

    0%,
    100% {
      stroke: #14b8a6;
      stroke-opacity: .7;
    }

    50% {
      stroke: #34d399;
      stroke-opacity: 1;
    }
  }

  /* ── Instruction pill ── */
  .cam-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #0f172a;
    border: 1.5px solid #0d9488;
    color: #ffffff;
    font-size: .78rem;
    font-weight: 600;
    padding: .45rem 1rem;
    border-radius: 9999px;
    pointer-events: none;
    letter-spacing: .01em;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
    max-width: 90%;
    text-align: center;
  }

  @keyframes scale-in {
    0% {
      transform: scale(0.9);
      opacity: 0;
    }

    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  .animate-scale {
    animation: scale-in 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
  }

  /* ── Bottom bar ── */
  .cam-bottom-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: .55rem .85rem;
    background: rgba(8, 17, 31, .92);
    border-top: 1px solid rgba(20, 184, 166, .15);
  }

  .cam-orient-label {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .7rem;
    font-weight: 600;
    color: #99f6e4;
    letter-spacing: .04em;
    text-transform: uppercase;
  }

  .cam-flip-btn {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: .7rem;
    font-weight: 600;
    color: #94a3b8;
    background: rgba(255, 255, 255, .06);
    border: 1px solid rgba(255, 255, 255, .1);
    border-radius: 6px;
    padding: .3rem .65rem;
    cursor: pointer;
    transition: .18s;
    text-transform: uppercase;
    letter-spacing: .04em;
  }

  .cam-flip-btn:hover {
    background: rgba(20, 184, 166, .15);
    color: #f0fdfa;
    border-color: rgba(20, 184, 166, .4);
  }

  /* ── Shutter ── */
  .cam-shutter {
    width: 52px;
    height: 52px;
    border-radius: 9999px;
    background: #fff;
    border: 4px solid #1e3a52;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: border-color .2s, transform .15s;
    box-shadow: 0 4px 16px rgba(0, 0, 0, .4);
    flex-shrink: 0;
  }

  .cam-shutter:hover {
    border-color: #14b8a6;
    transform: scale(1.06);
  }

  .cam-shutter-dot {
    width: 30px;
    height: 30px;
    border-radius: 9999px;
    background: #14b8a6;
  }

  /* ── Denied state ── */
  .cam-denied {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 2rem 1.5rem;
    gap: 1rem;
  }

  .cam-denied-icon {
    color: #f87171;
  }

  .cam-denied h5 {
    color: #fecaca;
    font-weight: 700;
    font-size: .9rem;
  }

  .cam-denied p {
    color: #94a3b8;
    font-size: .75rem;
    line-height: 1.5;
    max-width: 26ch;
  }

  .cam-retry-btn {
    padding: .5rem 1.2rem;
    background: rgba(248, 113, 113, .12);
    border: 1px solid rgba(248, 113, 113, .4);
    color: #fca5a5;
    border-radius: 8px;
    font-size: .75rem;
    font-weight: 600;
    cursor: pointer;
    transition: .18s;
  }

  .cam-retry-btn:hover {
    background: rgba(248, 113, 113, .25);
    color: #fff;
  }

  /* ── Enable btn ── */
  .cam-enable-btn {
    padding: .5rem 1.3rem;
    background: #0d9488;
    color: #fff;
    border-radius: 8px;
    font-size: .75rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: .18s;
    box-shadow: 0 2px 12px rgba(20, 184, 166, .3);
  }

  .cam-enable-btn:hover {
    background: #0f766e;
    transform: translateY(-1px);
  }

  /* ── Captured badge ── */
  .cam-captured-badge {
    position: absolute;
    top: 8px;
    left: 8px;
    z-index: 10;
    background: rgba(16, 185, 129, .92);
    color: #fff;
    font-size: .62rem;
    font-weight: 800;
    padding: 2px 8px;
    border-radius: 9999px;
    letter-spacing: .06em;
    text-transform: uppercase;
  }

  /* ── Sectioned form and OTP flow ── */
  /* ── Step progress container: give nodes room so labels don't collide with circles ── */
  .step-node {
    position: relative;
    text-align: center;
    transition: all 0.3s ease;
    min-height: 68px; /* ensures label has clear space below the circle */
  }

  .step-circle {
    border-width: 2px;
    border-style: solid;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    z-index: 2; /* keep circle above label/lock badge stacking issues */
  }

  .step-circle.active {
    border-color: #10b981;
    /* active: emerald-500 */
    background-color: #ecfdf5;
    /* active bg: emerald-50 */
    color: #047857;
    /* active text: emerald-700 */
    box-shadow: 0 0 0 4px #d1fae5, 0 4px 10px rgba(16, 185, 129, 0.25);
    transform: scale(1.06);
  }

  .step-circle.completed {
    border-color: #10b981;
    /* completed border: emerald-500 */
    background-color: #10b981;
    /* completed bg: emerald-500 */
    color: #ffffff;
    /* completed text: white */
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.15);
  }

  .step-label {
    position: absolute;
    top: 48px; /* was fine in markup, but reinforce here so it can't be overridden/collapsed */
    left: 50%;
    transform: translateX(-50%);
    width: max-content;
    z-index: 1;
    transition: color 0.3s ease, font-weight 0.3s ease;
  }

  .step-lock-badge {
    z-index: 3; /* sit above the circle, not clipped or overlapping label text */
  }

  #reg-form .step-label.active {
    color: #34d399 !important;
    font-weight: 800;
    text-shadow: 0 0 10px rgba(52, 211, 153, 0.4);
  }

  #reg-form .step-label.completed {
    color: #e2e8f0 !important;
    font-weight: 700;
  }

  #reg-form .step-label.locked {
    color: rgba(255, 255, 255, 0.4) !important;
    font-weight: 600;
  }

  #step-progress-line {
    background: linear-gradient(90deg, #10b981 0%, #34d399 50%, #10b981 100%) !important;
    background-size: 200% 100% !important;
    animation: loading-line-run 2s linear infinite !important;
    box-shadow: 0 0 8px rgba(52, 211, 153, 0.5) !important;
  }

  @keyframes loading-line-run {
    0% {
      background-position: 200% 0;
    }
    100% {
      background-position: -200% 0;
    }
  }

  .step-node.clickable {
    cursor: pointer;
  }

  .step-node.locked-node {
    cursor: not-allowed;
  }

  .section-block {
    position: relative;
    border: 1px solid #d1fae5;
    border-radius: 1rem;
    background: #ffffff;
    padding: 1.2rem 1.25rem;
    margin-bottom: 1.5rem;
    transition: opacity .35s ease;
  }

  .section-block.section-locked {
    opacity: .45;
    pointer-events: none;
  }

  .section-block.section-locked::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, .55);
    border-radius: 1rem;
    pointer-events: none;
  }

  /* Verified collapsed state for Section 1 */
  .section-block.section-verified {
    border-color: #16a34a;
    background: #f0fdf4;
  }

  .section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .75rem;
    margin-bottom: 1rem;
  }

  .section-title h2 {
    margin: 0;
    font-size: 1rem;
    font-weight: 800;
    color: #0f172a;
  }

  .section-hint {
    font-size: .825rem;
    color: #475569;
    margin-top: .25rem;
  }

  .otp-actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: .75rem;
    margin-top: .75rem;
  }

  .otp-input {
    max-width: 12rem;
  }

  .otp-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: .4rem;
    padding: .75rem 1rem;
    border-radius: .85rem;
    font-weight: 700;
    color: #fff;
    background: #16a34a;
    border: none;
    cursor: pointer;
    transition: .2s ease;
  }

  .otp-button:disabled {
    opacity: .55;
    cursor: not-allowed;
  }

  .otp-message {
    margin-top: .75rem;
    font-size: .88rem;
  }

  /* OTP reveal row — hidden until code sent */
  #otp-reveal-row {
    overflow: hidden;
    max-height: 0;
    opacity: 0;
    transition: max-height .45s cubic-bezier(.4, 0, .2, 1), opacity .35s ease, margin-top .35s ease;
    margin-top: 0;
  }

  #otp-reveal-row.otp-visible {
    max-height: 120px;
    opacity: 1;
    margin-top: .75rem;
  }

  /* Verified banner inside section 1 */
  #email-verified-banner {
    display: none;
    align-items: center;
    gap: .6rem;
    padding: .65rem .9rem;
    background: #dcfce7;
    border: 1.5px solid #16a34a;
    border-radius: .75rem;
    margin-top: .75rem;
    font-size: .88rem;
    font-weight: 700;
    color: #065f46;
  }

  #email-verified-banner.visible {
    display: flex;
  }

  /* ── Name fields: auto-uppercase ── */
  #first_name,
  #last_name,
  #middle_initial {
    text-transform: uppercase;
  }

  /* ── DOB wrapper ── */
  .dob-wrapper {
    position: relative;
  }

  .dob-cal-icon {
    position: absolute;
    right: .65rem;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #9ca3af;
  }

  /* ── Custom Calendar Styles ── */
  .custom-datepicker-container,
  .custom-datepicker-container * {
    box-sizing: border-box;
  }

  .custom-datepicker-container {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    margin-top: 8px;
    width: 320px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 1rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    z-index: 100;
    overflow: hidden;
    user-select: none;
    font-family: inherit;
  }

  .custom-datepicker-container.open {
    display: block;
    animation: datepicker-fade-in 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }

  @keyframes datepicker-fade-in {
    from {
      opacity: 0;
      transform: translateY(-4px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Mobile Backdrop & Centered Modal */
  @media (max-width: 640px) {
    .custom-datepicker-backdrop {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(4px);
      z-index: 99;
    }

    .custom-datepicker-backdrop.open {
      display: block;
    }

    .custom-datepicker-container {
      position: fixed !important;
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%) !important;
      margin-top: 0;
      max-width: 90%;
      width: 320px;
      z-index: 100;
    }

    @keyframes datepicker-fade-in {
      from {
        opacity: 0;
        transform: translate(-50%, -46%) scale(0.95);
      }

      to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
      }
    }
  }

  /* Header styles */
  .datepicker-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-bottom: 1px solid #f1f5f9;
    background-color: #f8fafc;
  }

  .datepicker-header button {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    color: #475569;
    cursor: pointer;
    transition: all 0.2s;
  }

  .datepicker-header button:hover {
    background: #f1f5f9;
    color: #0f172a;
  }

  .datepicker-title-btn {
    font-weight: 700;
    font-size: 0.95rem;
    color: #0f172a;
    border: none !important;
    background: transparent !important;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    white-space: nowrap;
    /* prevent year range from wrapping */
    flex-shrink: 0;
    flex: 1;
  }

  #dp-month-year-label {
    white-space: nowrap;
    /* keep "2000 – 2015" on one line */
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
  }

  .datepicker-title-btn:hover {
    background: #e2e8f0 !important;
  }

  /* Day Grid view */
  .datepicker-grid-header {
    display: grid !important;
    grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
    text-align: center;
    padding: 8px 12px 4px;
    font-size: 0.75rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .datepicker-grid-days {
    display: grid !important;
    grid-template-columns: repeat(7, minmax(0, 1fr)) !important;
    padding: 4px 12px 12px;
    gap: 4px;
  }

  .datepicker-day-cell {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 40px !important;
    font-size: 0.85rem;
    font-weight: 600;
    color: #334155;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.15s ease;
  }

  .datepicker-day-cell:hover:not(.disabled) {
    background-color: #ecfdf5;
    color: #047857;
  }

  .datepicker-day-cell.today-outline {
    border: 1.5px solid #10b981;
    color: #047857;
  }

  .datepicker-day-cell.selected {
    background-color: #10b981 !important;
    color: #ffffff !important;
  }

  .datepicker-day-cell.other-month {
    color: #94a3b8;
    font-weight: 400;
  }

  .datepicker-day-cell.disabled {
    color: #cbd5e1;
    background-color: #f8fafc;
    cursor: not-allowed;
    text-decoration: line-through;
    opacity: 0.6;
  }

  /* Year / Month grid views — 4-column grid, no scrolling */
  .datepicker-selection-grid {
    display: grid !important;
    grid-template-columns: repeat(4, minmax(0, 1fr)) !important;
    gap: 6px;
    padding: 12px 14px;
    overflow: hidden;
  }

  /* Tablet: 3 columns */
  @media (max-width: 480px) {
    .datepicker-selection-grid {
      grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
    }
  }

  /* Mobile: 2 columns */
  @media (max-width: 360px) {
    .datepicker-selection-grid {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }
  }

  .datepicker-select-item {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 8px 4px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #334155;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    cursor: pointer;
    transition: all 0.15s;
    background: #ffffff;
    text-align: center;
    white-space: nowrap;
  }

  .datepicker-select-item:hover:not(.disabled) {
    background: #ecfdf5;
    border-color: #10b981;
    color: #047857;
  }

  .datepicker-select-item.selected {
    background: #10b981;
    color: #ffffff;
    border-color: #10b981;
  }

  .datepicker-select-item.disabled {
    color: #cbd5e1;
    background: #f8fafc;
    cursor: not-allowed;
    text-decoration: line-through;
    opacity: 0.6;
  }

  /* Footer action buttons */
  .datepicker-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 16px;
    border-top: 1px solid #e2e8f0;
    background-color: #f8fafc;
  }

  .datepicker-footer button {
    padding: 6px 12px;
    font-size: 0.8rem;
    font-weight: 700;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.15s;
  }

  .datepicker-btn-clear {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #64748b;
  }

  .datepicker-btn-clear:hover {
    background: #f1f5f9;
    color: #334155;
  }

  .datepicker-btn-today {
    background: #10b981;
    border: 1px solid #10b981;
    color: #ffffff;
  }

  .datepicker-btn-today:hover {
    background: #059669;
  }

  .datepicker-btn-today:disabled {
    display: none;
    /* Hide if underage */
  }

  /* Visual custom cal trigger mouse state */
  .dob-wrapper {
    cursor: pointer;
  }

  .dob-wrapper input[readonly] {
    cursor: pointer;
    background-color: #ffffff !important;
  }

  /* ── Wizard Step Sections ── */
  .section-block {
    display: none;
    opacity: 0;
    transform: translateX(30px);
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin-bottom: 0 !important;
  }
  .section-block::after {
    display: none !important; /* disable locked overlay */
  }

  .section-block.active-step {
    display: block;
    opacity: 1;
    transform: translateX(0);
  }

  .section-block.slide-out-left {
    display: block;
    transform: translateX(-60px);
    opacity: 0;
  }

  .section-block.slide-in-right {
    display: block;
    transform: translateX(60px);
    opacity: 0;
  }

  .section-block.slide-out-right {
    display: block;
    transform: translateX(60px);
    opacity: 0;
  }

  .section-block.slide-in-left {
    display: block;
    transform: translateX(-60px);
    opacity: 0;
  }

  @media (prefers-reduced-motion: reduce) {
    .section-block {
      transition: opacity 0.15s ease-in-out !important;
      transform: none !important;
    }
    #stepper-active-glow {
      transition: none !important;
      animation: none !important;
    }
  }

  /* ── Stepper Active Glow ── */
  #stepper-active-glow {
    position: absolute;
    width: 48px;
    height: 48px;
    border-radius: 9999px;
    border: 2px solid #10b981;
    background-color: rgba(16, 185, 129, 0.15);
    box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);
    z-index: 0;
    transition: left 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
    pointer-events: none;
    transform: translateY(-50%);
    animation: active-pulse 2s infinite ease-in-out;
  }

  @keyframes active-pulse {
    0%, 100% { transform: translateY(-50%) scale(1); box-shadow: 0 0 12px rgba(16, 185, 129, 0.4); }
    50% { transform: translateY(-50%) scale(1.1); box-shadow: 0 0 20px rgba(16, 185, 129, 0.7); }
  }

  /* ── Checkmark Scale-In ── */
  @keyframes check-scale-in {
    0% { transform: scale(0.3); opacity: 0; }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); opacity: 1; }
  }
  .check-icon-anim {
    animation: check-scale-in 0.35s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
  }

  /* ── Text Readability inside Dark Glass Container ── */
  #reg-form label {
    color: rgba(255, 255, 255, 0.95) !important;
    font-size: 1rem !important;
    font-weight: 600 !important;
  }
  .section-title h2 {
    color: #ffffff !important;
    font-size: 1.35rem !important;
    font-weight: 800 !important;
  }
<<<<<<< Updated upstream
  .section-hint, .otp-message {
    color: rgba(255, 255, 255, 0.7) !important;
=======

  .section-hint,
  .otp-message {
    color: rgba(255, 255, 255, 0.85) !important;
    font-size: 0.95rem !important;
    line-height: 1.5 !important;
>>>>>>> Stashed changes
  }
  .otp-message.text-red-600 {
    color: #f87171 !important;
  }
  .otp-message.text-green-600 {
    color: #34d399 !important;
  }

  /* ── Smooth Input Focus States ── */
  #reg-form input:focus, #reg-form select:focus, #reg-form textarea:focus {
    border-color: #10b981 !important;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25) !important;
    outline: none !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }

  /* ── Button Micro-Interactions ── */
  .otp-button, .cam-enable-btn, .cam-retry-btn, button[type="submit"], #submit-btn, .btn-primary, x-primary-button {
    transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
  }
  .otp-button:hover:not(:disabled), 
  .cam-enable-btn:hover:not(:disabled), 
  .cam-retry-btn:hover:not(:disabled), 
  #submit-btn:hover:not(:disabled) {
    transform: scale(1.03);
    box-shadow: 0 0 12px rgba(16, 185, 129, 0.4);
  }
  .otp-button:active:not(:disabled), 
  .cam-enable-btn:active:not(:disabled), 
  .cam-retry-btn:active:not(:disabled), 
  #submit-btn:active:not(:disabled) {
    transform: scale(0.97);
  }

  /* ── Photo Capture Success Green Flash ── */
  @keyframes success-green-flash {
    0% { background-color: rgba(16, 185, 129, 0.45); }
    100% { background-color: transparent; }
  }
  .flash-success {
    animation: success-green-flash 0.8s ease-out forwards;
  }
</style>

<x-guest-layout maxWidth="max-w-xl md:max-w-3xl lg:max-w-4xl">
  <!-- Back Button -->
  <div class="mb-6">
    <a href="{{ route('home') }}"
      class="group inline-flex items-center gap-1.5 text-sm font-medium bg-white/10 hover:bg-white/20 transition-all duration-200 px-3 py-1.5 rounded-full border border-white/10" style="color: white;">
      <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="currentColor"
        viewBox="0 0 20 20">
        <path fill-rule="evenodd"
          d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
          clip-rule="evenodd" />
      </svg>
      Back
    </a>
  </div>

  <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="reg-form">
    @csrf

    <div class="mb-8 px-2 select-none">
      <!-- Progress Indicator Container -->
      <div class="w-full max-w-2xl mx-auto mt-4 px-4 pb-8 relative">
        <div class="relative flex items-center justify-between">
          <!-- Background Connecting Line -->
          <div class="absolute left-[32px] right-[32px] top-[20px] h-[3px] bg-white/10 -translate-y-1/2 z-0 rounded"></div>
          <!-- Active Filled Progress Line -->
          <div id="step-progress-line"
            class="absolute left-[32px] top-[20px] h-[3px] -translate-y-1/2 z-0 rounded transition-all duration-500 ease-out"
            style="width: 0%;"></div>
          
          <!-- Smooth Active Glow Ring -->
          <div id="stepper-active-glow" class="absolute w-12 h-12 rounded-full border-2 border-emerald-500 bg-emerald-500/10 shadow-[0_0_15px_rgba(16,185,129,0.4)] z-0 transition-all duration-300 ease-out -translate-y-1/2 pointer-events-none" style="top: 20px; left: 0;"></div>

          <!-- Step 1 -->
          <div class="step-node flex flex-col items-center z-10 w-16 clickable" id="step-node-1"
            onclick="handleStepClick('section-email', 0)">
            <div
              class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-2 border-emerald-600 bg-emerald-50 text-emerald-800 ring-4 ring-emerald-100 shadow-[0_0_12px_rgba(16,185,129,0.25)] scale-105"
              id="step-circle-1">
              <span class="step-inner-val">1</span>
              <!-- Lock Badge -->
              <div
                class="step-lock-badge absolute -top-1 -right-1 bg-slate-800 text-white rounded-full p-0.5 shadow-sm hidden"
                style="font-size: 8px;">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
            </div>
            <span
              class="step-label text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-center text-slate-900 active"
              id="step-label-1">Email</span>
          </div>

          <!-- Step 2 -->
          <div class="step-node flex flex-col items-center z-10 w-16 locked-node" id="step-node-2"
            onclick="handleStepClick('section-details', 1)">
            <div
              class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-2 border-gray-300 bg-white text-gray-500 shadow-sm"
              id="step-circle-2">
              <span class="step-inner-val">2</span>
              <!-- Lock Badge -->
              <div class="step-lock-badge absolute -top-1 -right-1 bg-slate-800 text-white rounded-full p-0.5 shadow-sm"
                style="font-size: 8px;">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
            </div>
            <span
              class="step-label text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-center text-gray-400 locked"
              id="step-label-2">Details</span>
          </div>

          <!-- Step 3 -->
          <div class="step-node flex flex-col items-center z-10 w-16 locked-node" id="step-node-3"
            onclick="handleStepClick('section-identity', 2)">
            <div
              class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-2 border-gray-300 bg-white text-gray-500 shadow-sm"
              id="step-circle-3">
              <span class="step-inner-val">3</span>
              <!-- Lock Badge -->
              <div class="step-lock-badge absolute -top-1 -right-1 bg-slate-800 text-white rounded-full p-0.5 shadow-sm"
                style="font-size: 8px;">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
            </div>
            <span
              class="step-label text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-center text-gray-400 locked"
              id="step-label-3">ID Check</span>
          </div>

          <!-- Step 4 -->
          <div class="step-node flex flex-col items-center z-10 w-16 locked-node" id="step-node-4"
            onclick="handleStepClick('section-password', 3)">
            <div
              class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-2 border-gray-300 bg-white text-gray-500 shadow-sm"
              id="step-circle-4">
              <span class="step-inner-val">4</span>
              <!-- Lock Badge -->
              <div class="step-lock-badge absolute -top-1 -right-1 bg-slate-800 text-white rounded-full p-0.5 shadow-sm"
                style="font-size: 8px;">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
            </div>
            <span
              class="step-label text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-center text-gray-400 locked"
              id="step-label-4">Password</span>
          </div>

          <!-- Step 5 -->
          <div class="step-node flex flex-col items-center z-10 w-16 locked-node" id="step-node-5"
            onclick="handleStepClick('section-submit', 4)">
            <div
              class="step-circle w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-2 border-gray-300 bg-white text-gray-500 shadow-sm"
              id="step-circle-5">
              <span class="step-inner-val">5</span>
              <!-- Lock Badge -->
              <div class="step-lock-badge absolute -top-1 -right-1 bg-slate-800 text-white rounded-full p-0.5 shadow-sm"
                style="font-size: 8px;">
                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
            </div>
            <span
              class="step-label text-[9px] sm:text-[11px] font-extrabold uppercase tracking-wider text-center text-gray-400 locked"
              id="step-label-5">Submit</span>
          </div>
        </div>
      </div>
    </div>

    <div class="section-block" id="section-email">
      <div class="section-title">
        <h2>Email Verification</h2>
        <span id="email-verified-badge"
          class="hidden text-xs font-bold text-green-700 bg-green-100 border border-green-300 px-3 py-1 rounded-full flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
          </svg>
          Verified
        </span>
      </div>

      <div id="email-input-group">
        <x-input-label for="email" :value="__('Gmail Address')" />
        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
          autocomplete="username" placeholder="yourname@gmail.com" autofocus />
        <div id="email-check-msg" class="mt-1 text-xs font-semibold"></div>
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
      </div>

      {{-- Row 2: Get Code button (always visible once email valid) --}}
      <div class="flex items-center gap-3 mt-3">
        <button type="button" id="btn-get-code" class="otp-button" disabled>Get Code</button>
        <button type="button" id="btn-edit-email" class="hidden text-xs font-bold text-emerald-400 hover:text-emerald-300 underline transition cursor-pointer">Change Email</button>
      </div>

      {{-- Row 3: OTP input + Verify — hidden until code is sent --}}
      <div id="otp-reveal-row">
        <div class="flex flex-wrap items-center gap-3">
          <input id="otp_code"
            class="otp-input block mt-0 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
            type="text" name="otp_code" maxlength="6" placeholder="Enter 6-digit code" inputmode="numeric"
            pattern="[0-9]*" autocomplete="one-time-code" />
          <button type="button" id="btn-verify-code" class="otp-button">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verify
          </button>
        </div>
        <p id="otp-error-inline" class="mt-1.5 text-xs font-semibold text-red-600 hidden"></p>
      </div>

      {{-- Verified banner --}}
      <div id="email-verified-banner">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span id="email-verified-banner-text">Email verified — you can now fill in the rest of the form.</span>
      </div>

      <p id="otp-status-msg" class="otp-message text-gray-500">Enter your Gmail address and click <strong>Get
          Code</strong>.</p>

      <!-- Next button for Step 1 -->
      <div class="flex justify-end items-center mt-6 pt-4 border-t border-white/10">
        <button type="button" class="btn-next-step otp-button" id="btn-next-1" disabled onclick="navigateToStep(1)">Next →</button>
      </div>
    </div>

    <div class="section-block section-locked" id="section-details">
      <div class="section-title">
        <h2>Personal Details</h2>
      </div>

      {{-- Name --}}
      <div class="grid grid-cols-2 gap-3">
        <div>
          <x-input-label for="first_name" :value="__('First Name')" />
          <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
            :value="old('first_name')" required autofocus autocomplete="given-name" />
          <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>
        <div>
          <x-input-label for="last_name" :value="__('Last Name')" />
          <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')"
            required autocomplete="family-name" />
          <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>
      </div>

      <style>
        /* Force input text to uppercase, but keep placeholders exact/lowercase where applicable */
        .uppercase-input {
          text-transform: uppercase;
        }

        .uppercase-input::placeholder {
          text-transform: none !important;
        }

        .uppercase-input::-webkit-input-placeholder {
          text-transform: none !important;
        }

        .uppercase-input::-moz-placeholder {
          text-transform: none !important;
        }
      </style>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          ['first_name', 'last_name', 'middle_initial'].forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('input', function () {
              const pos = this.selectionStart;
              this.value = this.value.toUpperCase();
              if (id === 'middle_initial' && this.value.length > 1) {
                this.value = this.value.slice(0, 1);
              }
              this.setSelectionRange(pos, pos);
            });
          });
        });
      </script>
      <div class="mt-4 grid grid-cols-2 gap-3">
        <div>
          <x-input-label for="middle_initial" :value="__('Middle Initial (optional)')" />
          <x-text-input id="middle_initial" class="block mt-1 w-full uppercase-input" type="text" name="middle_initial"
            :value="old('middle_initial')" maxlength="1" placeholder="e.g. V." />
          <x-input-error :messages="$errors->get('middle_initial')" class="mt-2" />
        </div>
        <div id="suffix-combobox" style="position:relative;">
          <x-input-label for="suffix" :value="__('Suffix (optional)')" />
          <div style="position:relative; margin-top:4px;">
            <x-text-input id="suffix" class="block w-full uppercase-input" type="text" name="suffix"
              :value="old('suffix')" maxlength="20" autocomplete="off" style="padding-right: 2.5rem;"
              placeholder="e.g. Jr." />
            <button type="button" tabindex="-1"
              style="position:absolute; right:0; top:0; bottom:0; width: 2.5rem; background:none; border:none; padding:0; cursor:pointer; color:#6b7280; display:flex; align-items:center; justify-content:center;"
              onmousedown="event.preventDefault(); var inp=document.getElementById('suffix'); inp.focus(); if(window.suffixOpenDropdown) suffixOpenDropdown(inp);">
              <svg xmlns="http://www.w3.org/2000/svg" style="width:16px; height:16px; pointer-events:none;"
                viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>
          <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
        </div>
      </div>

      {{-- Classification --}}
      <div class="mt-4" x-data="{ 
        classification: sessionStorage.getItem('reg_form_state') ? (JSON.parse(sessionStorage.getItem('reg_form_state')).classification || '') : '{{ old('classification') }}', 
        showClassification: false 
      }">
        <x-input-label for="classification" :value="__('Visitor Classification')" />
        <div class="relative mt-1">
          <!-- Dropdown Trigger Button -->
          <button type="button" @click="showClassification = !showClassification" @click.away="showClassification = false"
            class="flex justify-between items-center w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 shadow-sm transition duration-150">
            <span x-text="
              classification === 'Local' ? 'Local (Municipal Resident)' : 
              (classification === 'Domestic' ? 'Domestic (National Resident)' : 
              (classification === 'Foreign' ? 'Foreign (International Visitor)' : 'Select Classification'))
            " class="text-gray-800"></span>
            <svg class="h-4 w-4 text-gray-400 transform transition-transform duration-200" :class="showClassification ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          
          <input type="hidden" id="classification" name="classification" :value="classification" required />

          <!-- Dropdown List with transitions -->
          <div x-show="showClassification"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-0 mt-1.5 z-50 w-full rounded-md bg-white border border-gray-200 shadow-xl py-1 overflow-hidden"
            style="display: none;">
            
            <button type="button" @click="classification = 'Local'; showClassification = false; saveFormState(); updateStepProgress();"
              class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-950 transition-colors">
              Local (Municipal Resident)
            </button>
            <button type="button" @click="classification = 'Domestic'; showClassification = false; saveFormState(); updateStepProgress();"
              class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-950 transition-colors">
              Domestic (National Resident)
            </button>
            <button type="button" @click="classification = 'Foreign'; showClassification = false; saveFormState(); updateStepProgress();"
              class="w-full text-left px-4 py-2.5 text-sm text-gray-700 hover:bg-green-50 hover:text-green-950 transition-colors">
              Foreign (International Visitor)
            </button>
          </div>
        </div>
        <x-input-error :messages="$errors->get('classification')" class="mt-2" />
      </div>

      {{-- Gender --}}
      <div class="mt-4" x-data="{ 
        gender: sessionStorage.getItem('reg_form_state') ? (JSON.parse(sessionStorage.getItem('reg_form_state')).gender || '') : '{{ old('gender') }}', 
        showGender: false 
      }">
        <x-input-label for="gender" :value="__('Gender')" />
        <div class="relative mt-1">
          <!-- Dropdown Trigger Button -->
          <button type="button" @click="showGender = !showGender" @click.away="showGender = false"
            class="flex justify-between items-center w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 font-semibold hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 shadow-sm transition duration-150">
            <span x-text="gender === 'Male' ? 'Male' : (gender === 'Female' ? 'Female' : 'Select Gender')" class="text-gray-800"></span>
            <svg class="h-4 w-4 text-gray-400 transform transition-transform duration-200" :class="showGender ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          
          <input type="hidden" id="gender" name="gender" :value="gender" required />

          <!-- Dropdown List with transitions -->
          <div x-show="showGender"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-0 mt-1.5 z-50 w-full rounded-md bg-white border border-gray-200 shadow-xl py-1 overflow-hidden"
            style="display: none;">
            
            <button type="button" @click="gender = 'Male'; showGender = false; saveFormState(); updateStepProgress();"
              class="w-full text-left px-4 py-2.5 text-sm text-gray-750 hover:bg-green-50 hover:text-green-950 transition-colors">
              Male
            </button>
            <button type="button" @click="gender = 'Female'; showGender = false; saveFormState(); updateStepProgress();"
              class="w-full text-left px-4 py-2.5 text-sm text-gray-755 hover:bg-green-50 hover:text-green-950 transition-colors">
              Female
            </button>
          </div>
        </div>
        <x-input-error :messages="$errors->get('gender')" class="mt-2" />
      </div>

      <!-- Next button for Step 2 -->
      <div class="flex justify-end items-center mt-6 pt-4 border-t border-white/10">
        <button type="button" class="btn-next-step otp-button" id="btn-next-2" disabled onclick="navigateToStep(2)">Next →</button>
      </div>
    </div>

    <div class="section-block section-locked" id="section-identity">
      <div class="section-title">
        <h2>Identity Verification</h2>
      </div>
      {{-- 1. ID Type --}}
      <div class="mt-4">
        <x-input-label for="id_type" :value="__('ID Type')" />
        <select id="id_type" name="id_type"
          class="block mt-1 w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm"
          required>
          <option value="" disabled selected>Select ID Type</option>
          <option value="Passport" {{ old('id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
          <option value="National ID" {{ old('id_type') == 'National ID' ? 'selected' : '' }}>National ID (PhilSys)
          </option>
          <option value="Driver's License" {{ old('id_type') == "Driver's License" ? 'selected' : '' }}>Driver's License
          </option>
          <option value="SSS ID" {{ old('id_type') == 'SSS ID' ? 'selected' : '' }}>SSS ID</option>
          <option value="GSIS ID" {{ old('id_type') == 'GSIS ID' ? 'selected' : '' }}>GSIS ID</option>
          <option value="PhilHealth ID" {{ old('id_type') == 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
          <option value="Pag-IBIG ID" {{ old('id_type') == 'Pag-IBIG ID' ? 'selected' : '' }}>Pag-IBIG ID</option>
          <option value="Voter ID" {{ old('id_type') == 'Voter ID' ? 'selected' : '' }}>Voter's ID</option>
          <option value="Postal ID" {{ old('id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
          <option value="School ID" {{ old('id_type') == 'School ID' ? 'selected' : '' }}>School / Student ID</option>
          <option value="Barangay ID" {{ old('id_type') == 'Barangay ID' ? 'selected' : '' }}>Barangay ID</option>
          <option value="Company ID" {{ old('id_type') == 'Company ID' ? 'selected' : '' }}>Company / Employee ID</option>
        </select>
        <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
      </div>

      {{-- 2. ID Number / School Name --}}
      <div class="mt-4" id="id-number-group">
        <x-input-label for="id_number_input" :value="__('ID Number')" id="id-number-label" />
        <x-text-input id="id_number_input" class="block mt-1 w-full" type="text" name="id_number"
          :value="old('id_number', old('school_name'))" required placeholder="e.g. 2242-0414-6523" />
        <p id="id-number-hint" class="mt-1 text-xs text-gray-500 hidden">Enter your full school name. Do not use
          abbreviations.</p>
        <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
        <x-input-error :messages="$errors->get('school_name')" class="mt-2" />
      </div>

      {{-- 3. Date of Birth (conditional) --}}
      <div class="mt-4" id="dob-group">
        <x-input-label for="dob_display" :value="__('Date of Birth')" id="dob-label" />
        <div class="dob-wrapper mt-1 relative">
          <!-- Text input with custom calendar trigger. Readonly to prevent invalid/garbage text input. -->
          <input type="text" id="dob_display"
            class="block w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm"
            readonly placeholder="Select Date of Birth" />

          <!-- Hidden field to submit standard date format to Laravel backend -->
          <input type="hidden" id="dob" name="dob" :value="old('dob')" />

          <span class="dob-cal-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </span>

          <!-- Mobile Backdrop -->
          <div id="dob-datepicker-backdrop" class="custom-datepicker-backdrop"></div>

          <!-- Custom JS Calendar Dropdown Container -->
          <div id="dob-datepicker-container" class="custom-datepicker-container">
            <!-- Header -->
            <div class="datepicker-header">
              <button type="button" id="dp-prev-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <button type="button" id="dp-title-btn" class="datepicker-title-btn">
                <span id="dp-month-year-label">July 2026</span>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              <button type="button" id="dp-next-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>

            <!-- View 1: Day View -->
            <div id="dp-day-view">
              <div class="datepicker-grid-header">
                <span>Su</span><span>Mo</span><span>Tu</span><span>We</span><span>Th</span><span>Fr</span><span>Sa</span>
              </div>
              <div id="dp-days-container" class="datepicker-grid-days">
                <!-- Javascript fills this -->
              </div>
            </div>

            <!-- View 2: Month View -->
            <div id="dp-month-view" class="hidden">
              <div class="datepicker-selection-grid" id="dp-months-container">
                <!-- Javascript fills this -->
              </div>
            </div>

            <!-- View 3: Year View -->
            <div id="dp-year-view" class="hidden">
              <div class="datepicker-selection-grid" id="dp-years-container">
                <!-- Javascript fills this -->
              </div>
            </div>

            <!-- Footer -->
            <div class="datepicker-footer">
              <button type="button" class="datepicker-btn-clear" id="dp-clear-btn">Clear</button>
              <button type="button" class="datepicker-btn-today" id="dp-today-btn">Today</button>
            </div>
          </div>
        </div>
        <p id="dob-hint" class="mt-1 text-xs text-gray-400 hidden">Not required for this ID type.</p>
        <x-input-error :messages="$errors->get('dob')" class="mt-2" />
      </div>

      {{-- 4. Camera Capture --}}
      <div class="mt-5">
        <span class="text-green-600">
          <x-input-label :value="__('ID Photo Capture — Front + Back (Live Camera)')" style="color: green;" />
        </span>
        <div class="cam-box mt-2" id="cam-box">

          {{-- STATE A: not yet asked --}}
          <div id="cam-state-pending" class="flex flex-col items-center justify-center text-center gap-4 px-6 py-10">
            <div class="relative w-16 h-16 flex items-center justify-center">
              <div class="absolute inset-0 rounded-full animate-ping opacity-35 bg-teal-500" style="animation-duration: 2s;"></div>
              <div
                style="width:3.5rem;height:3.5rem;border-radius:9999px;background:rgba(13,148,136,0.18);border:1.5px solid rgba(20,184,166,0.5);display:flex;align-items:center;justify-content:center;color:#2dd4bf;"
                class="relative z-10">
                <svg style="width:1.75rem;height:1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </div>
            </div>
            <div>
              <p style="color:#f8fafc; font-weight:600; font-size:.875rem;">Capture Your ID with Camera</p>
              <p style="color:#cbd5e1; font-size:.75rem; margin-top:.25rem; line-height:1.6;">Your device camera will
                photograph your ID directly.</p>
            </div>
            <button type="button" id="btn-enable-camera" class="cam-enable-btn">
              <span class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 10l4.553-2.069A1 1 0 0121 8.868V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                Enable Camera
              </span>
            </button>
          </div>

          {{-- STATE B: denied --}}
          <div id="cam-state-denied" class="cam-denied hidden">
            <div class="cam-denied-icon">
              <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
            </div>
            <h5>Camera Access Denied</h5>
            <p>Please allow camera access in your browser settings, then click Retry below.</p>
            <div
              class="text-xs text-slate-500 bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-left leading-relaxed"
              style="max-width:28ch">
              <strong class="text-slate-400 block mb-1">How to enable:</strong>
              <span class="block">• Chrome: <em>Address bar → 🔒 → Camera → Allow</em></span>
              <span class="block">• Firefox: <em>Address bar → 🔒 → Camera → Allow</em></span>
              <span class="block">• Safari: <em>Settings → Safari → Camera → Allow</em></span>
            </div>
            <button type="button" id="btn-retry-camera" class="cam-retry-btn">
              <span class="flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89" />
                </svg>
                Retry Camera Access
              </span>
            </button>
          </div>

          {{-- STATE C: live preview --}}
          <div id="cam-state-active" class="hidden flex flex-col">
            <div class="relative" style="aspect-ratio:4/3;background:#000;overflow:hidden;">
              <video id="cam-video" autoplay playsinline muted class="w-full h-full object-cover"></video>

              {{-- Persistent Step & Side Badges --}}
              <div class="absolute top-3 left-3 z-20 flex flex-row gap-2 pointer-events-none">
                <span id="cam-step-badge"
                  class="bg-brand-700/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Step
                  1 of 2</span>
                <span id="cam-side-badge"
                  class="bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Front
                  ID</span>
              </div>

              {{-- Auto-advance Confirmation Overlay --}}
              <div id="cam-transition-overlay"
                class="absolute inset-0 bg-slate-900/95 flex flex-col items-center justify-center text-center gap-3 z-30 hidden">
                <div
                  class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white text-xl animate-scale shadow-lg">
                  ✓</div>
                <p class="text-white font-bold text-sm">Front Captured Successfully!</p>
                <p class="text-teal-300 text-xs">Automatically switching to Back of ID...</p>
              </div>

              {{-- SVG overlay --}}
              <svg id="cam-guide-svg" class="absolute inset-0 w-full h-full pointer-events-none"
                xmlns="http://www.w3.org/2000/svg">
                <defs>
                  <mask id="cam-guide-mask">
                    <rect width="100%" height="100%" fill="white" />
                    <rect id="cam-guide-cutout" x="8%" y="12%" width="84%" height="76%" rx="14" fill="black" />
                  </mask>
                </defs>
                <rect width="100%" height="100%" fill="rgba(8,17,31,0.7)" mask="url(#cam-guide-mask)" />
                <rect id="cam-guide-outline" x="8%" y="12%" width="84%" height="76%" rx="14" fill="none"
                  stroke="#14b8a6" stroke-width="2.5" stroke-dasharray="10 6" class="cam-guide-rect" />
              </svg>
              {{-- Instruction pill --}}
              <div class="absolute bottom-4 inset-x-0 flex justify-center pointer-events-none z-10">
                <span id="cam-pill" class="cam-pill">
                  <svg class="w-3.5 h-3.5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span id="cam-pill-text">Hold steady to prevent blur</span>
                </span>
              </div>
            </div>
            {{-- Bottom bar --}}
            <div class="cam-bottom-bar">
              <div class="cam-orient-label">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7" />
                </svg>
                <span id="orient-label-text">Landscape Guide</span>
              </div>
              <button type="button" id="btn-shutter" class="cam-shutter" title="Capture photo">
                <div class="cam-shutter-dot"></div>
              </button>
              <button type="button" id="btn-flip" class="cam-flip-btn">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Flip
              </button>
            </div>
          </div>

          {{-- STATE D: completion review state --}}
          <div id="cam-state-captured" class="hidden flex flex-col">
            <div class="p-3 bg-slate-900 border-b border-teal-950 text-center">
              <span
                class="text-green-400 font-bold text-xs uppercase tracking-widest block flex items-center justify-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                ID capture complete
              </span>
            </div>
            <div class="grid grid-cols-2 gap-3 p-3 bg-slate-950">
              <div class="flex flex-col gap-1.5">
                <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Front
                  side</span>
                <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
                  <img id="cam-img-front-thumb" class="block w-full h-auto" alt="Front ID Preview" />
                  <span class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                  </span>
                </div>
              </div>
              <div class="flex flex-col gap-1.5">
                <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Back side</span>
                <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
                  <img id="cam-img-back-thumb" class="block w-full h-auto" alt="Back ID Preview" />
                  <span class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                  </span>
                </div>
              </div>
            </div>

            {{-- Hidden element to keep original selector variables safe from JS errors --}}
            <img id="cam-captured-img" class="hidden" alt="Merged Preview" />

            <div class="cam-bottom-bar justify-center">
              <button type="button" id="btn-retake" class="cam-flip-btn"
                style="color:#fb923c;border-color:rgba(251,146,60,.35);">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89" />
                </svg>
                Retake & Restart
              </button>
            </div>
          </div>

        </div>

        <input id="id_photo" name="id_photo" type="file" accept="image/jpeg" required class="sr-only" aria-hidden="true"
          tabindex="-1" />
        <p id="cam-error-msg" class="mt-2 text-sm text-red-600  hidden"></p>
        <p id="cam-success-msg" class="mt-2 text-sm text-green-600 hidden"></p>
        <x-input-error :messages="$errors->get('id_photo')" class="mt-2" />
      </div>

      <!-- Next button for Step 3 -->
      <div class="flex justify-end items-center mt-6 pt-4 border-t border-white/10">
        <button type="button" class="btn-next-step otp-button" id="btn-next-3" disabled onclick="navigateToStep(3)">Next →</button>
      </div>
    </div>

    <div class="section-block section-locked" id="section-password">
      <div class="section-title">
        <h2>Account Security</h2>
      </div>

      {{-- 5. Password --}}
      <div class="mb-4">
        <x-input-label for="password" :value="__('Password')" />
        <div class="relative mt-1">
          <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required
            autocomplete="new-password" />
          <button type="button" onclick="togglePassword('password', this)"
            class="password-toggle-btn toggled-hidden"
            aria-label="Show password"
            aria-pressed="false">
            <svg class="w-5 h-5 eye-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path class="eye-lid" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
              <circle class="eye-pupil" cx="12" cy="12" r="3"></circle>
              <line class="eye-slash" x1="4" y1="20" x2="20" y2="4"></line>
            </svg>
          </button>
        </div>
      </div>

      {{-- 6. Confirm Password --}}
      <div class="mb-2">
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
        <div class="relative mt-1">
          <x-text-input id="password_confirmation" class="block w-full pr-12" type="password"
            name="password_confirmation" required autocomplete="new-password" />
          <button type="button" onclick="togglePassword('password_confirmation', this)"
            class="password-toggle-btn toggled-hidden"
            aria-label="Show password"
            aria-pressed="false">
            <svg class="w-5 h-5 eye-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path class="eye-lid" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
              <circle class="eye-pupil" cx="12" cy="12" r="3"></circle>
              <line class="eye-slash" x1="4" y1="20" x2="20" y2="4"></line>
            </svg>
          </button>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
      </div>

      <!-- Next button for Step 4 -->
      <div class="flex justify-end items-center mt-6 pt-4 border-t border-white/10">
        <button type="button" class="btn-next-step otp-button" id="btn-next-4" disabled onclick="navigateToStep(4)">Next →</button>
      </div>
    </div>

    <div class="section-block section-locked" id="section-submit">
      <div class="section-title">
        <h2>Review & Submit</h2>
      </div>
      <div class="flex justify-end items-center mt-6 pt-4 border-t border-white/10">
        <div class="flex items-center gap-4">
          <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
            href="{{ route('login') }}">
            Already registered?
          </a>
          <x-primary-button id="submit-btn">Create Account</x-primary-button>
        </div>
      </div>
    </div>
  </form>

  <script>
    const ID_TYPES_WITH_DOB = new Set(['Passport', 'National ID', "Driver's License", 'SSS ID', 'GSIS ID', 'PhilHealth ID', 'Pag-IBIG ID', 'Voter ID', 'Postal ID']);

    // ── Name fields: force uppercase value as user types ───────
    ['first_name', 'last_name', 'middle_initial'].forEach(id => {
      const el = document.getElementById(id);
      if (!el) return;
      el.addEventListener('input', function () {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
      });
    });

    const idTypeSelect = document.getElementById('id_type');
    const idLabel = document.getElementById('id-number-label');
    const idInput = document.getElementById('id_number_input');
    const idHint = document.getElementById('id-number-hint');
    const dobGroup = document.getElementById('dob-group');
    const dobInput = document.getElementById('dob');
    const dobHint = document.getElementById('dob-hint');
    const emailInput = document.getElementById('email');
    const msgDiv = document.getElementById('email-check-msg');
    const btnGetCode = document.getElementById('btn-get-code');
    const btnVerifyCode = document.getElementById('btn-verify-code');
    const otpInput = document.getElementById('otp_code');
    const otpStatus = document.getElementById('otp-status-msg');
    const submitBtn = document.getElementById('submit-btn');
    const sectionDetails = document.getElementById('section-details');
    const sectionIdentity = document.getElementById('section-identity');
    const sectionPassword = document.getElementById('section-password');
    const sectionSubmit = document.getElementById('section-submit');
    // stepPills removed
    const statePending = document.getElementById('cam-state-pending');
    const stateDenied = document.getElementById('cam-state-denied');
    const stateActive = document.getElementById('cam-state-active');
    const stateCaptured = document.getElementById('cam-state-captured');
    const camVideo = document.getElementById('cam-video');
    const camCapImg = document.getElementById('cam-captured-img');
    const orientLabel = document.getElementById('orient-label-text');
    const pillText = document.getElementById('cam-pill-text');
    const fileInput = document.getElementById('id_photo');
    const camErrMsg = document.getElementById('cam-error-msg');
    const camOkMsg = document.getElementById('cam-success-msg');

    let stream = null;
    let facingMode = 'environment';
    let orientation = 'landscape';
    let captured = false;
    let pillTimer = null;
    let debounce = null;
    const PILLS = ['Hold steady to prevent blur', 'Align ID within the glowing frame', 'Ensure good lighting — avoid glare', 'All text must be clearly readable'];
    let pillIdx = 0;

    // ── Two-Step Capture Variables ─────────────────────────────
    let currentStep = 1;
    let frontPhotoData = null;
    let backPhotoData = null;

    // ── ID Type rules ──────────────────────────────────────────
    function applyIdType() {
      const v = idTypeSelect.value;
      if (v === 'School ID') {
        idLabel.textContent = 'School Name'; idInput.placeholder = 'e.g. Zamboanga del Sur State University'; idInput.name = 'school_name'; idHint.classList.remove('hidden');
      } else {
        idLabel.textContent = 'ID Number'; idInput.placeholder = 'e.g. 2022-041633'; idInput.name = 'id_number'; idHint.classList.add('hidden');
      }
      const needsDob = ID_TYPES_WITH_DOB.has(v);
      dobInput.required = needsDob;
      if (!needsDob) { dobInput.value = ''; dobHint.classList.remove('hidden'); dobGroup.style.opacity = '.6'; }
      else { dobHint.classList.add('hidden'); dobGroup.style.opacity = '1'; }
    }
    idTypeSelect.addEventListener('change', applyIdType);
    applyIdType();

    // ── Form validity ──────────────────────────────────────────
    let otpVerified = false;
    let codeSent = false;
    let cooldownExpiresAt = null;
    let cooldownTimerInterval = null;

    // Extra refs for new elements
    const otpRevealRow = document.getElementById('otp-reveal-row');
    const otpErrorInline = document.getElementById('otp-error-inline');
    const emailVerifiedBanner = document.getElementById('email-verified-banner');
    const emailVerifiedBannerText = document.getElementById('email-verified-banner-text');
    const emailVerifiedBadge = document.getElementById('email-verified-badge');

    function setLockSectionInputs(sectionEl, locked) {
      sectionEl.querySelectorAll('input,select,textarea,button').forEach(el => {
        if (locked) el.setAttribute('disabled', '');
        else el.removeAttribute('disabled');
      });
    }

    function checkValidity() {
      const emailBad = msgDiv.className.includes('text-red-600');
      const ready = !emailBad && captured && otpVerified;
      submitBtn.disabled = !ready;
      submitBtn.style.opacity = ready ? '1' : '.4';
    }

    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const classificationSelect = document.getElementById('classification');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('password_confirmation');

    let currentStepIndex = 0; // 0: email, 1: details, 2: identity, 3: password, 4: submit

    function getSectionId(idx) {
      return ['section-email', 'section-details', 'section-identity', 'section-password', 'section-submit'][idx];
    }

    function navigateToStep(targetIndex) {
      if (targetIndex === currentStepIndex) return;
      
      const states = getStepStates();
      if (!states[targetIndex]) return; // locked step

      const currentSection = document.getElementById(getSectionId(currentStepIndex));
      const targetSection = document.getElementById(getSectionId(targetIndex));

      if (!currentSection || !targetSection) return;

      const isNext = targetIndex > currentStepIndex;

      // Handle prefers-reduced-motion
      const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      if (reducedMotion) {
        currentSection.className = 'section-block';
        targetSection.className = 'section-block active-step';
        currentStepIndex = targetIndex;
        
        // Focus first input
        const firstInput = targetSection.querySelector('input:not([disabled]),select:not([disabled])');
        if (firstInput) firstInput.focus();

        updateStepProgress();
        return;
      }

      // Set transition classes
      if (isNext) {
        currentSection.className = 'section-block slide-out-left';
        targetSection.className = 'section-block slide-in-right';
      } else {
        currentSection.className = 'section-block slide-out-right';
        targetSection.className = 'section-block slide-in-left';
      }

      // Force reflow
      void targetSection.offsetWidth;

      setTimeout(() => {
        // Hide old section
        currentSection.className = 'section-block';
        // Show new section
        targetSection.className = 'section-block active-step';
        currentStepIndex = targetIndex;
        
        // Focus first input
        const firstInput = targetSection.querySelector('input:not([disabled]),select:not([disabled])');
        if (firstInput) firstInput.focus();

        updateStepProgress();
      }, 300);
    }

    function updateActiveGlow() {
      const activeNode = document.getElementById(`step-node-${currentStepIndex + 1}`);
      const glow = document.getElementById('stepper-active-glow');
      if (activeNode && glow) {
        const leftOffset = activeNode.offsetLeft + (activeNode.offsetWidth / 2) - 24; // 24 is half of 48px
        glow.style.left = `${leftOffset}px`;
      }
    }

    function getStepStates() {
      const step1_completed = otpVerified;

      const step2_completed = step1_completed &&
        firstNameInput.value.trim() !== '' &&
        lastNameInput.value.trim() !== '' &&
        classificationSelect.value !== '';

      const needsDob = ID_TYPES_WITH_DOB.has(idTypeSelect.value);
      const step3_completed = step2_completed &&
        idTypeSelect.value !== '' &&
        idInput.value.trim() !== '' &&
        (!needsDob || dobInput.value !== '') &&
        captured;

      const step4_completed = step3_completed &&
        passwordInput.value.length >= 8 &&
        passwordInput.value === confirmPasswordInput.value;

      return [
        true, // Step 1 always unlocked
        step1_completed, // Step 2 details unlocked if step 1 completed
        step2_completed, // Step 3 identity unlocked if step 2 completed
        step3_completed, // Step 4 password unlocked if step 3 completed
        step4_completed  // Step 5 submit unlocked if step 4 completed
      ];
    }

    function updateStepProgress() {
      const step1_completed = otpVerified;

      const step2_completed = step1_completed &&
        firstNameInput.value.trim() !== '' &&
        lastNameInput.value.trim() !== '' &&
        classificationSelect.value !== '';

      const needsDob = ID_TYPES_WITH_DOB.has(idTypeSelect.value);
      const step3_completed = step2_completed &&
        idTypeSelect.value !== '' &&
        idInput.value.trim() !== '' &&
        (!needsDob || dobInput.value !== '') &&
        captured;

      const step4_completed = step3_completed &&
        passwordInput.value.length >= 8 &&
        passwordInput.value === confirmPasswordInput.value;

      // Update validation state of Next buttons
      const btnNext1 = document.getElementById('btn-next-1');
      const btnNext2 = document.getElementById('btn-next-2');
      const btnNext3 = document.getElementById('btn-next-3');
      const btnNext4 = document.getElementById('btn-next-4');

      if (btnNext1) btnNext1.disabled = !step1_completed;
      if (btnNext2) btnNext2.disabled = !step2_completed;
      if (btnNext3) btnNext3.disabled = !step3_completed;
      if (btnNext4) btnNext4.disabled = !step4_completed;

      const states = [
        { completed: step1_completed, active: currentStepIndex === 0, locked: currentStepIndex < 0 },
        { completed: step2_completed, active: currentStepIndex === 1, locked: currentStepIndex < 1 },
        { completed: step3_completed, active: currentStepIndex === 2, locked: currentStepIndex < 2 },
        { completed: step4_completed, active: currentStepIndex === 3, locked: currentStepIndex < 3 },
        { completed: false, active: currentStepIndex === 4, locked: currentStepIndex < 4 }
      ];

      // Update UI for each step node
      states.forEach((state, i) => {
        const idx = i + 1;
        const circle = document.getElementById(`step-circle-${idx}`);
        const label = document.getElementById(`step-label-${idx}`);
        const node = document.getElementById(`step-node-${idx}`);
        const innerVal = node.querySelector('.step-inner-val');
        const lockBadge = node.querySelector('.step-lock-badge');

        // Reset classes
        circle.classList.remove('active', 'completed');
        label.classList.remove('active', 'completed', 'locked');
        node.classList.remove('clickable', 'locked-node');
        node.removeAttribute('aria-current');

        const stepStates = getStepStates();
        const stepUnlocked = stepStates[i];

        if (state.completed) {
          circle.classList.add('completed');
          label.classList.add('completed');
          if (stepUnlocked) node.classList.add('clickable');
          innerVal.innerHTML = '<svg class="w-4 h-4 text-white check-icon-anim" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
          if (lockBadge) lockBadge.classList.add('hidden');
        } else if (state.active) {
          circle.classList.add('active');
          label.classList.add('active');
          node.setAttribute('aria-current', 'step');
          if (stepUnlocked) node.classList.add('clickable');
          innerVal.textContent = idx;
          if (lockBadge) lockBadge.classList.add('hidden');
        } else {
          label.classList.add('locked');
          if (stepUnlocked) {
            node.classList.add('clickable');
            innerVal.textContent = idx;
            if (lockBadge) lockBadge.classList.add('hidden');
          } else {
            node.classList.add('locked-node');
            innerVal.textContent = idx;
            if (lockBadge) lockBadge.classList.remove('hidden');
          }
        }
      });

      // Calculate filled progress line width
      let completedCount = 0;
      if (step1_completed) completedCount = 1;
      if (step2_completed) completedCount = 2;
      if (step3_completed) completedCount = 3;
      if (step4_completed) completedCount = 4;

      const progressLine = document.getElementById('step-progress-line');
      if (progressLine) {
        progressLine.style.width = `${completedCount * 25}%`;
      }

      // Lock inputs in other sections, unlock in active section
      ['section-email', 'section-details', 'section-identity', 'section-password', 'section-submit'].forEach((id, idx) => {
        const sec = document.getElementById(id);
        if (sec) {
          const isCurrent = idx === currentStepIndex;
          setLockSectionInputs(sec, !isCurrent);
        }
      });

      updateActiveGlow();
      checkValidity();
    }

    function handleStepClick(sectionId, stepIdx) {
      const stepStates = getStepStates();
      if (stepStates[stepIdx]) {
        navigateToStep(stepIdx);
      }
    }

<<<<<<< Updated upstream
=======
    window.handleNextStep2 = function () {
      const fn = firstNameInput ? firstNameInput.value.trim() : '';
      const ln = lastNameInput ? lastNameInput.value.trim() : '';
      const cl = classificationSelect ? classificationSelect.value : '';
      const gEl = document.getElementById('gender');
      const g = gEl ? gEl.value : '';
      const ph = contactInput ? contactInput.value.trim() : '';

      let isValid = true;
      let firstInvalidEl = null;

      const errFn = document.getElementById('err-first-name');
      const errLn = document.getElementById('err-last-name');
      const errCl = document.getElementById('err-classification');
      const errG = document.getElementById('err-gender');
      const errPh = document.getElementById('err-contact');

      if (errFn) {
        if (!fn) { errFn.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = firstNameInput; }
        else { errFn.classList.add('hidden'); }
      }

      if (errLn) {
        if (!ln) { errLn.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = lastNameInput; }
        else { errLn.classList.add('hidden'); }
      }

      if (errCl) {
        if (!cl) { errCl.classList.remove('hidden'); isValid = false; }
        else { errCl.classList.add('hidden'); }
      }

      if (errG) {
        if (g !== 'Male' && g !== 'Female') { errG.classList.remove('hidden'); isValid = false; }
        else { errG.classList.add('hidden'); }
      }

      if (errPh) {
        if (ph.length < 7) { errPh.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = contactInput; }
        else { errPh.classList.add('hidden'); }
      }

      if (!isValid) {
        if (firstInvalidEl) firstInvalidEl.focus();
        return;
      }

      navigateToStep(2);
    };

    window.handleNextStep3 = function () {
      const idTypeVal = idTypeSelect ? idTypeSelect.value : '';
      const idNumVal  = idInput ? idInput.value.trim() : '';
      const needsDob  = ID_TYPES_WITH_DOB.has(idTypeVal);
      const dobVal    = dobInput ? dobInput.value : '';

      let isValid = true;
      let firstInvalidEl = null;

      const errIdType = document.getElementById('err-id-type');
      const errIdNum  = document.getElementById('err-id-number');
      const errDob    = document.getElementById('err-dob');
      const errPhoto  = document.getElementById('err-id-photo');

      if (errIdType) {
        if (!idTypeVal) { errIdType.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = idTypeSelect; }
        else { errIdType.classList.add('hidden'); }
      }

      if (errIdNum) {
        if (!idNumVal) { errIdNum.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = idInput; }
        else { errIdNum.classList.add('hidden'); }
      }

      if (errDob) {
        if (needsDob && !dobVal) { errDob.classList.remove('hidden'); isValid = false; }
        else { errDob.classList.add('hidden'); }
      }

      if (errPhoto) {
        if (!captured) { errPhoto.classList.remove('hidden'); isValid = false; }
        else { errPhoto.classList.add('hidden'); }
      }

      if (!isValid) {
        if (firstInvalidEl) firstInvalidEl.focus();
        return;
      }

      navigateToStep(3);
    };

    window.handleNextStep4 = function () {
      const pwd  = passwordInput ? passwordInput.value : '';
      const pwdC = confirmPasswordInput ? confirmPasswordInput.value : '';

      let isValid = true;
      let firstInvalidEl = null;

      const errPwd  = document.getElementById('err-password');
      const errPwdC = document.getElementById('err-password-confirm');

      if (errPwd) {
        if (pwd.length < 8) { errPwd.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = passwordInput; }
        else { errPwd.classList.add('hidden'); }
      }

      if (errPwdC) {
        if (!pwdC || pwdC !== pwd) { errPwdC.classList.remove('hidden'); isValid = false; if (!firstInvalidEl) firstInvalidEl = confirmPasswordInput; }
        else { errPwdC.classList.add('hidden'); }
      }

      const base64Val = document.getElementById('id_photo_base64') ? document.getElementById('id_photo_base64').value : '';
      const fileCount = document.getElementById('id_photo') && document.getElementById('id_photo').files ? document.getElementById('id_photo').files.length : 0;
      const hasPhoto  = captured || base64Val.length > 0 || fileCount > 0;

      if (!hasPhoto) {
        // If ID photo is missing, auto-navigate to ID Check step & highlight camera error
        navigateToStep(2);
        const errPhoto = document.getElementById('err-id-photo');
        if (errPhoto) errPhoto.classList.remove('hidden');
        return;
      }

      if (!isValid) {
        if (firstInvalidEl) firstInvalidEl.focus();
        return;
      }

      // ── All valid — trigger account creation ──
      const btnSubmit = document.getElementById('btn-create-account');
      const progressWrap = document.getElementById('submit-progress-wrap');
      if (btnSubmit) {
        btnSubmit.disabled = true;
        btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
        btnSubmit.innerHTML = `<span class="flex items-center gap-2">
          <svg class="w-4 h-4 animate-spin text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Creating Account...
        </span>`;
      }
      if (progressWrap) {
        progressWrap.classList.add('visible');
      }

      document.getElementById('reg-form').requestSubmit();
    };

>>>>>>> Stashed changes
    // Bind listeners to trigger updateStepProgress as user types/selects
    [firstNameInput, lastNameInput, passwordInput, confirmPasswordInput, idInput].forEach(el => {
      if (el) el.addEventListener('input', updateStepProgress);
    });
    [classificationSelect, idTypeSelect, dobInput, document.getElementById('gender')].forEach(el => {
      if (el) el.addEventListener('change', updateStepProgress);
    });

    // ── SessionStorage Persistence ─────────────────────────────
    const SS_KEY = 'reg_form_state';

    function saveFormState() {
      const state = {
        email: emailInput.value.trim(),
        verifiedEmail: otpVerified ? emailInput.value.trim() : null,
        codeSent: Boolean(codeSent),
        otpPendingEmail: codeSent ? emailInput.value.trim() : null,
        cooldownExpiresAt: cooldownExpiresAt || null,
        first_name: (document.getElementById('first_name') || {}).value || '',
        last_name: (document.getElementById('last_name') || {}).value || '',
        middle_initial: (document.getElementById('middle_initial') || {}).value || '',
        suffix: (document.getElementById('suffix') || {}).value || '',
        classification: (document.getElementById('classification') || {}).value || '',
        gender: (document.getElementById('gender') || {}).value || '',
        id_type: idTypeSelect.value,
        id_number: idInput.value,
        dob: dobInput.value,
        dob_display: (document.getElementById('dob_display') || {}).value || '',
        password: passwordInput.value,
        password_confirmation: confirmPasswordInput.value,
      };
      sessionStorage.setItem(SS_KEY, JSON.stringify(state));
    }

    function restoreFormState() {
      let state;
      try { state = JSON.parse(sessionStorage.getItem(SS_KEY)); } catch (e) { return; }
      if (!state) return;

      // Restore plain field values
      if (state.first_name) { const el = document.getElementById('first_name'); if (el) el.value = state.first_name; }
      if (state.last_name) { const el = document.getElementById('last_name'); if (el) el.value = state.last_name; }
      if (state.middle_initial) { const el = document.getElementById('middle_initial'); if (el) el.value = state.middle_initial; }
      if (state.suffix) { const el = document.getElementById('suffix'); if (el) el.value = state.suffix; }
      if (state.classification) { const el = document.getElementById('classification'); if (el) el.value = state.classification; }
      if (state.gender) { const el = document.getElementById('gender'); if (el) el.value = state.gender; }
      if (state.id_type) { idTypeSelect.value = state.id_type; applyIdType(); }
      if (state.id_number) { idInput.value = state.id_number; }
      if (state.dob) { dobInput.value = state.dob; }
      if (state.dob_display) { const el = document.getElementById('dob_display'); if (el) el.value = state.dob_display; }
      if (state.password) { passwordInput.value = state.password; }
      if (state.password_confirmation) { confirmPasswordInput.value = state.password_confirmation; }

      // Restore verified email state (skip OTP re-entry)
<<<<<<< Updated upstream
=======
      @if($errors->has('email'))
        delete state.verifiedEmail;
        delete state.codeSent;
      @endif
>>>>>>> Stashed changes
      if (state.verifiedEmail) {
        emailInput.value = state.verifiedEmail;
        otpVerified = true;
        codeSent = true;

        // Show verified UI
        emailInput.readOnly = true;
        emailInput.style.background = '#f9fafb';
        btnGetCode.disabled = true;
        btnGetCode.style.display = 'none'; // Keep hidden after refresh
        otpInput.disabled = true;
        btnVerifyCode.disabled = true;

        emailVerifiedBannerText.textContent = `✓ ${state.verifiedEmail} verified successfully!`;
        emailVerifiedBanner.classList.add('visible');
        document.getElementById('section-email').classList.add('section-verified');
        if (emailVerifiedBadge) emailVerifiedBadge.classList.remove('hidden');

        msgDiv.className = 'mt-1 text-xs font-semibold text-green-600';
        msgDiv.textContent = '✓ Gmail address verified.';
        const btnEditEmail = document.getElementById('btn-edit-email');
        if (btnEditEmail) btnEditEmail.classList.add('hidden');
      } else if (state.codeSent && state.otpPendingEmail) {
        // Code was sent, user refreshed before entering OTP or verifying
        emailInput.value = state.otpPendingEmail;
        codeSent = true;
        emailInput.readOnly = true;
        emailInput.style.background = '#f9fafb';

        // Reveal OTP row immediately on page reload
        otpRevealRow.classList.add('otp-visible');
        const btnEditEmail = document.getElementById('btn-edit-email');
        if (btnEditEmail) btnEditEmail.classList.remove('hidden');

        otpStatus.textContent = 'A 6-digit code was sent to your Gmail address. Check your inbox.';
        otpStatus.className = 'otp-message text-green-600';

        if (state.cooldownExpiresAt) {
          cooldownExpiresAt = state.cooldownExpiresAt;
          const remaining = Math.max(0, Math.ceil((state.cooldownExpiresAt - Date.now()) / 1000));
          if (remaining > 0) {
            btnGetCode.disabled = true;
            btnGetCode.textContent = `Resend in ${remaining}s`;
            if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
            cooldownTimerInterval = setInterval(() => {
              const curSec = Math.max(0, Math.ceil((cooldownExpiresAt - Date.now()) / 1000));
              if (curSec <= 0) {
                clearInterval(cooldownTimerInterval);
                btnGetCode.innerHTML = 'Resend Code';
                btnGetCode.disabled = false;
                return;
              }
              btnGetCode.textContent = `Resend in ${curSec}s`;
            }, 1000);
          } else {
            btnGetCode.innerHTML = 'Resend Code';
            btnGetCode.disabled = false;
          }
        } else {
          btnGetCode.innerHTML = 'Resend Code';
          btnGetCode.disabled = false;
        }

        setTimeout(() => { if (otpInput) otpInput.focus(); }, 300);
      } else if (state.email) {
        emailInput.value = state.email;
      }
    }

    // Bind save-on-change to all relevant fields
    const _saveFields = ['first_name', 'last_name', 'middle_initial', 'suffix', 'classification', 'gender', 'id_type', 'id_number_input', 'dob', 'password', 'password_confirmation'];
    _saveFields.forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        el.addEventListener('input', saveFormState);
        el.addEventListener('change', saveFormState);
      }
    });
    // Also save after email verification and after DOB datepicker selection
    if (dobInput) dobInput.addEventListener('change', saveFormState);
    emailInput.addEventListener('input', saveFormState);

    // Keep sessionStorage intact during submit so that if backend validation
    // fails (e.g. password mismatch), the user's OTP verification isn't wiped out.
    document.getElementById('reg-form').addEventListener('submit', function () {
      // Intentionally not clearing SS_KEY here.
    }, { once: true });

    // ── Restore state immediately before init ──
    restoreFormState();

    // Initialize active step index based on restored state
    if (otpVerified) {
      currentStepIndex = 1;
    } else {
      currentStepIndex = 0;
    }

    function initStepVisibility() {
      const sections = ['section-email', 'section-details', 'section-identity', 'section-password', 'section-submit'];
      sections.forEach((id, idx) => {
        const sec = document.getElementById(id);
        if (sec) {
          if (idx === currentStepIndex) {
            sec.className = 'section-block active-step';
            setLockSectionInputs(sec, false);
          } else {
            sec.className = 'section-block';
            setLockSectionInputs(sec, true);
          }
        }
      });
      updateActiveGlow();
    }

    initStepVisibility();
    checkValidity();
    updateStepProgress();

    window.addEventListener('load', updateActiveGlow);
    window.addEventListener('resize', updateActiveGlow);

    // ── Email check ────────────────────────────────────────────
    emailInput.addEventListener('input', function () {
      clearTimeout(debounce);
      const v = emailInput.value.trim();

      // Reset OTP state only if a new email is typed and code wasn't sent yet
      if (!codeSent) {
        otpVerified = false;
        btnGetCode.disabled = true;
        otpStatus.textContent = 'Enter your Gmail address and click Get Code.';
        otpStatus.className = 'otp-message text-gray-500';
        updateStepProgress();
      }

      if (!v) { msgDiv.textContent = ''; return; }
      debounce = setTimeout(() => {
        msgDiv.className = 'mt-1 text-xs font-semibold text-gray-500';
        msgDiv.textContent = 'Checking…';
        fetch("{{ route('email.check') }}", {
          method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ email: v })
        }).then(r => r.json()).then(d => {
          if (!d.valid || !d.available) {
            msgDiv.className = 'mt-1 text-xs font-semibold text-red-600';
            msgDiv.textContent = '\u2717 ' + d.message;
            btnGetCode.disabled = true;
          } else {
            msgDiv.className = 'mt-1 text-xs font-semibold text-green-600';
            msgDiv.textContent = '\u2713 ' + d.message;
            if (!codeSent) btnGetCode.disabled = false;  // only enable if code not yet sent
          }
          checkValidity();
        }).catch(() => {
          msgDiv.textContent = '';
          btnGetCode.disabled = true;
        });
      }, 400);
    });

    // ── OTP input: numeric-only mask + Enter-to-verify ─────────
    otpInput.addEventListener('input', function () {
      // Strip non-digits
      this.value = this.value.replace(/\D/g, '').slice(0, 6);
    });
    otpInput.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { e.preventDefault(); btnVerifyCode.click(); }
    });

    // ── Helper: show/hide spinner on a button ──────────────────
    function setButtonLoading(btn, loading, originalHTML) {
      if (loading) {
        btn.dataset.origHtml = btn.innerHTML;
        btn.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>&nbsp;' + originalHTML;
        btn.disabled = true;
      } else {
        btn.innerHTML = btn.dataset.origHtml || originalHTML;
      }
    }

    // ── Get Code (Turbo Instant Optimistic Dispatch) ───────────
    btnGetCode.addEventListener('click', function () {
      const email = emailInput.value.trim();
      if (!email) return;

      // 1. Instant Optimistic UI Reaction (< 10ms)
      emailInput.readOnly = true;
      emailInput.style.background = '#f9fafb';
      btnGetCode.disabled = true;

      codeSent = true;
      let cooldown = 60;
      cooldownExpiresAt = Date.now() + (cooldown * 1000);
      saveFormState();

      // Immediately reveal OTP row with zero delay
      otpRevealRow.classList.add('otp-visible');
      setTimeout(() => { if (otpInput) otpInput.focus(); }, 150);

      const btnEditEmail = document.getElementById('btn-edit-email');
      if (btnEditEmail) btnEditEmail.classList.remove('hidden');

      otpStatus.textContent = 'Sending 6-digit code to your Gmail inbox…';
      otpStatus.className = 'otp-message text-emerald-400 font-semibold';

      if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
      btnGetCode.textContent = `Resend in ${cooldown}s`;
      cooldownTimerInterval = setInterval(() => {
        const remaining = Math.max(0, Math.ceil((cooldownExpiresAt - Date.now()) / 1000));
        if (remaining <= 0) {
          clearInterval(cooldownTimerInterval);
          btnGetCode.innerHTML = 'Resend Code';
          btnGetCode.disabled = false;
          return;
        }
        btnGetCode.textContent = `Resend in ${remaining}s`;
      }, 1000);

      // 2. Network Dispatch in Background
      fetch("{{ route('register.send_code') }}", {
        method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ email })
      }).then(async r => {
        const d = await r.json();
        if (!r.ok) {
          // Failure — rollback optimistic state
          codeSent = false;
          cooldownExpiresAt = null;
          if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
          emailInput.readOnly = false;
          emailInput.style.background = '';
          btnGetCode.innerHTML = 'Get Code';
          btnGetCode.disabled = false;
          otpRevealRow.classList.remove('otp-visible');
          if (btnEditEmail) btnEditEmail.classList.add('hidden');
          otpStatus.textContent = d.message || 'Unable to send code.';
          otpStatus.className = 'otp-message text-red-600';
          saveFormState();
          return;
        }
        // Success confirmation
        otpStatus.textContent = '✓ Code sent! Check your Gmail inbox.';
        otpStatus.className = 'otp-message text-green-600 font-semibold';
      }).catch(() => {
        // Rollback on network error
        codeSent = false;
        cooldownExpiresAt = null;
        if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
        emailInput.readOnly = false;
        emailInput.style.background = '';
        btnGetCode.innerHTML = 'Get Code';
        btnGetCode.disabled = false;
        otpRevealRow.classList.remove('otp-visible');
        if (btnEditEmail) btnEditEmail.classList.add('hidden');
        otpStatus.textContent = 'Unable to connect. Please check your internet connection.';
        otpStatus.className = 'otp-message text-red-600';
        saveFormState();
      });
    });

    // ── Change Email Button ────────────────────────────────────
    const btnEditEmail = document.getElementById('btn-edit-email');
    if (btnEditEmail) {
      btnEditEmail.addEventListener('click', function () {
        codeSent = false;
        cooldownExpiresAt = null;
        if (cooldownTimerInterval) clearInterval(cooldownTimerInterval);
        emailInput.readOnly = false;
        emailInput.style.background = '';
        emailInput.focus();
        otpRevealRow.classList.remove('otp-visible');
        btnGetCode.innerHTML = 'Get Code';
        btnGetCode.disabled = false;
        btnEditEmail.classList.add('hidden');
        otpStatus.textContent = 'Enter your Gmail address and click Get Code.';
        otpStatus.className = 'otp-message text-gray-500';
        saveFormState();
      });
    }

    // ── Verify Code ────────────────────────────────────────────
    btnVerifyCode.addEventListener('click', function () {
      const email = emailInput.value.trim();
      const code = otpInput.value.trim();

      otpErrorInline.classList.add('hidden');
      otpErrorInline.textContent = '';

      if (!email || code.length !== 6) {
        otpErrorInline.textContent = 'Please enter the full 6-digit code.';
        otpErrorInline.classList.remove('hidden');
        otpInput.focus();
        return;
      }

      btnVerifyCode.disabled = true;
      btnVerifyCode.innerHTML = '<svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/></svg>&ensp;Verifying…';
      otpStatus.textContent = '';

      fetch("{{ route('register.verify_code') }}", {
        method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ email, code })
      }).then(async r => {
        const d = await r.json();
        if (!r.ok) {
          otpErrorInline.textContent = d.message || 'Invalid code — please try again.';
          otpErrorInline.classList.remove('hidden');
          btnVerifyCode.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Verify';
          btnVerifyCode.disabled = false;
          otpInput.focus();
          return;
        }

        // ── SUCCESS ──
        otpVerified = true;

        // Hide OTP row smoothly
        otpRevealRow.classList.remove('otp-visible');

        // Hide status msg, show banner
        otpStatus.textContent = '';
        emailVerifiedBannerText.textContent = `✓ ${emailInput.value.trim()} verified successfully!`;
        emailVerifiedBanner.classList.add('visible');

        // Lock everything in section 1 permanently
        emailInput.readOnly = true;
        btnGetCode.disabled = true;
        btnGetCode.style.display = 'none'; // Hide Get Code after successful verification
        otpInput.disabled = true;
        btnVerifyCode.disabled = true;

        // Mark section 1 as verified visually
        document.getElementById('section-email').classList.add('section-verified');
        emailVerifiedBadge.classList.remove('hidden');

        updateStepProgress();
        saveFormState(); // Persist verified state so refresh doesn't reset wizard

        // Auto-advance to section 2
        setTimeout(() => {
          navigateToStep(1);
        }, 500);

      }).catch(() => {
        otpErrorInline.textContent = 'Unable to verify code at this time. Please try again.';
        otpErrorInline.classList.remove('hidden');
        btnVerifyCode.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Verify';
        btnVerifyCode.disabled = false;
      });
    });

    // Check URL parameters for direct OTP prefill from email action link
    const urlParams = new URLSearchParams(window.location.search);
    const urlOtpCode = urlParams.get('code') || urlParams.get('otp');
    if (urlOtpCode && urlOtpCode.length === 6 && otpInput && !otpVerified) {
      otpRevealRow.classList.add('otp-visible');
      otpInput.value = urlOtpCode;
      setTimeout(() => {
        if (btnVerifyCode && !btnVerifyCode.disabled) {
          btnVerifyCode.focus();
        }
      }, 300);
    }

    // ── Camera helpers ─────────────────────────────────────────
    function showState(name) {
      [statePending, stateDenied, stateActive, stateCaptured].forEach(el => el.classList.add('hidden'));
      ({ pending: statePending, denied: stateDenied, active: stateActive, captured: stateCaptured }[name]).classList.remove('hidden');
    }
    function stopStream() {
      if (pillTimer) { clearInterval(pillTimer); pillTimer = null; }
      if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
      camVideo.srcObject = null;
    }
    function startPills() {
      if (pillTimer) clearInterval(pillTimer);
      pillIdx = 0; pillText.textContent = PILLS[0];
      pillTimer = setInterval(() => { pillIdx = (pillIdx + 1) % PILLS.length; pillText.textContent = PILLS[pillIdx]; }, 3500);
    }
    function updateFrame() {
      const svg = document.getElementById('cam-guide-svg');
      if (!svg || stateActive.classList.contains('hidden')) return;
      const r = svg.getBoundingClientRect(), W = r.width, H = r.height;
      if (!W || !H) return;
      let cW, cH;
      if (orientation === 'landscape') { cW = W * .84; cH = cW / 1.586; if (cH > H * .78) { cH = H * .78; cW = cH * 1.586; } }
      else { cH = H * .78; cW = cH / 1.586; if (cW > W * .84) { cW = W * .84; cH = cW * 1.586; } }
      const x = (W - cW) / 2, y = (H - cH) / 2;
      ['cam-guide-cutout', 'cam-guide-outline'].forEach(id => {
        const el = document.getElementById(id); if (!el) return;
        el.setAttribute('x', x); el.setAttribute('y', y); el.setAttribute('width', cW); el.setAttribute('height', cH);
      });
    }
    window.addEventListener('resize', updateFrame);

    async function startCamera() {
      camErrMsg.classList.add('hidden'); camOkMsg.classList.add('hidden'); stopStream();
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        camErrMsg.textContent = 'Insecure Context: Camera access requires HTTPS or localhost. Try accessing via localhost or generate a local TLS cert.';
        camErrMsg.classList.remove('hidden');
        showState('pending');
        return;
      }
      try {
        stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: { ideal: facingMode }, width: { ideal: 1920 }, height: { ideal: 1080 } }, audio: false });
        camVideo.srcObject = stream; showState('active'); setTimeout(updateFrame, 150); startPills();

        // Update step UI for state
        document.getElementById('cam-step-badge').textContent = `Step ${currentStep} of 2`;
        document.getElementById('cam-side-badge').textContent = currentStep === 1 ? 'Front ID' : 'Back ID';
        document.getElementById('cam-side-badge').className = currentStep === 1
          ? 'bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider'
          : 'bg-brand-600/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
      } catch (err) {
        if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') { showState('denied'); }
        else { camErrMsg.textContent = 'Camera error: ' + (err.message || err.name) + '. Please refresh and try again.'; camErrMsg.classList.remove('hidden'); showState('pending'); }
      }
    }

    document.getElementById('btn-enable-camera').addEventListener('click', startCamera);
    document.getElementById('btn-retry-camera').addEventListener('click', startCamera);

    document.getElementById('btn-flip').addEventListener('click', () => {
      orientation = (orientation === 'landscape') ? 'portrait' : 'landscape';
      orientLabel.textContent = orientation === 'landscape' ? 'Landscape Guide' : 'Portrait Guide';
      updateFrame();
    });

    document.getElementById('btn-shutter').addEventListener('click', () => {
      if (!stream) return;
      const vW = camVideo.videoWidth, vH = camVideo.videoHeight;
      if (!vW || !vH) return;

      const canvas = document.createElement('canvas');
      canvas.width = vW;
      canvas.height = vH;
      canvas.getContext('2d').drawImage(camVideo, 0, 0, vW, vH);

      try {
        const url = canvas.toDataURL('image/jpeg', .95);

        if (currentStep === 1) {
          frontPhotoData = url;
          currentStep = 2;

          // Show auto-advance overlay
          const transitionOverlay = document.getElementById('cam-transition-overlay');
          transitionOverlay.classList.remove('hidden');

          // Auto-advance step UI text under the overlay
          setTimeout(() => {
            transitionOverlay.classList.add('hidden');
            document.getElementById('cam-step-badge').textContent = 'Step 2 of 2';
            document.getElementById('cam-side-badge').textContent = 'Back ID';
            document.getElementById('cam-side-badge').className = 'bg-brand-600/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
          }, 1500);

        } else {
          backPhotoData = url;

          // Combine front and back images vertically into one single high-quality composite image
          const compositeCanvas = document.createElement('canvas');
          compositeCanvas.width = vW;
          compositeCanvas.height = vH * 2;

          const ctx = compositeCanvas.getContext('2d');

          // Load both images onto the composite canvas
          const imgFront = new Image();
          imgFront.onload = function () {
            ctx.drawImage(imgFront, 0, 0, vW, vH);

            const imgBack = new Image();
            imgBack.onload = function () {
              ctx.drawImage(imgBack, 0, vH, vW, vH);

              // Generate final base64 composite — quality 0.82 keeps file ~3–6 MB which OCR handles well
              const compositeUrl = compositeCanvas.toDataURL('image/jpeg', .82);
              camCapImg.src = compositeUrl;

              // Convert composite base64 to binary File object
              const bin = atob(compositeUrl.split(',')[1]);
              const bytes = new Uint8Array(bin.length);
              for (let i = 0; i < bin.length; i++) {
                bytes[i] = bin.charCodeAt(i);
              }
              const f = new File([bytes], `id_composite_${Date.now()}.jpg`, { type: 'image/jpeg' });
              const dt = new DataTransfer();
              dt.items.add(f);
              fileInput.files = dt.files;

              // Update confirmation thumbnails
              document.getElementById('cam-img-front-thumb').src = frontPhotoData;
              document.getElementById('cam-img-back-thumb').src = backPhotoData;

              captured = true;
              camOkMsg.textContent = '✓ Front and Back ID photos captured.';
              camOkMsg.classList.remove('hidden');
              stopStream();
              showState('captured');
              
              // Play green flash success animation
              stateCaptured.classList.add('flash-success');
              setTimeout(() => {
                stateCaptured.classList.remove('flash-success');
              }, 800);

              updateStepProgress();
            };
            imgBack.src = backPhotoData;
          };
          imgFront.src = frontPhotoData;
        }
      } catch (e) {
        camErrMsg.textContent = 'Failed to capture. Please try again.';
        camErrMsg.classList.remove('hidden');
      }
    });

    document.getElementById('btn-retake').addEventListener('click', () => {
      captured = false;
      currentStep = 1;
      frontPhotoData = null;
      backPhotoData = null;
      fileInput.value = '';
      camOkMsg.classList.add('hidden');
      updateStepProgress();
      startCamera();
    });

    // ── Custom Datepicker JS Implementation ───────────────────
    (function () {
      const dobInput = document.getElementById('dob');
      const dobDisplay = document.getElementById('dob_display');
      const wrapper = document.querySelector('.dob-wrapper');
      const container = document.getElementById('dob-datepicker-container');
      const backdrop = document.getElementById('dob-datepicker-backdrop');

      const prevBtn = document.getElementById('dp-prev-btn');
      const nextBtn = document.getElementById('dp-next-btn');
      const titleBtn = document.getElementById('dp-title-btn');
      const monthYearLabel = document.getElementById('dp-month-year-label');

      const dayView = document.getElementById('dp-day-view');
      const monthView = document.getElementById('dp-month-view');
      const yearView = document.getElementById('dp-year-view');

      const daysContainer = document.getElementById('dp-days-container');
      const monthsContainer = document.getElementById('dp-months-container');
      const yearsContainer = document.getElementById('dp-years-container');

      const clearBtn = document.getElementById('dp-clear-btn');
      const todayBtn = document.getElementById('dp-today-btn');

      let currentDate = new Date(); // Tracks navigation view
      let selectedDate = null;       // Tracks currently selected date
      let currentView = 'day';       // 'day' | 'month' | 'year'
      let decadeStartYear = 2000;    // Tracks the base year for year grid navigation

      const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
      ];

      // Helper: check if date is valid (must be 12+ and not in the future)
      function isUnderageOrFuture(date) {
        const today = new Date();
        // Reset times for date comparisons
        today.setHours(0, 0, 0, 0);
        const checkDate = new Date(date);
        checkDate.setHours(0, 0, 0, 0);

        if (checkDate > today) return true; // Future date

        // Check 12 years constraint
        const minAgeDate = new Date(today.getFullYear() - 12, today.getMonth(), today.getDate());
        return checkDate > minAgeDate; // Under 12
      }

      // Parse initial date value from hidden input if present
      function parseInitialDate() {
        if (dobInput.value) {
          const parts = dobInput.value.split('-');
          if (parts.length === 3) {
            const parsed = new Date(parts[0], parts[1] - 1, parts[2]);
            if (!isNaN(parsed.getTime())) {
              selectedDate = parsed;
              currentDate = new Date(parsed);
              // Format display
              const dd = String(parsed.getDate()).padStart(2, '0');
              const mm = String(parsed.getMonth() + 1).padStart(2, '0');
              const yyyy = parsed.getFullYear();
              dobDisplay.value = `${dd}/${mm}/${yyyy}`;
            }
          }
        }
      }
      parseInitialDate();

      // Open / Close functions
      function openPicker() {
        if (dobInput.hasAttribute('disabled')) return;

        container.classList.add('open');
        if (backdrop) backdrop.classList.add('open');

        // Reset to day view on open
        currentView = 'day';
        switchView('day');
        render();
      }

      function closePicker() {
        container.classList.remove('open');
        if (backdrop) backdrop.classList.remove('open');
      }

      function togglePicker() {
        if (container.classList.contains('open')) {
          closePicker();
        } else {
          openPicker();
        }
      }

      // Click outside to close
      document.addEventListener('click', function (e) {
        if (container.classList.contains('open')) {
          if (!wrapper.contains(e.target)) {
            closePicker();
          }
        }
      });

      dobDisplay.addEventListener('click', function (e) {
        e.stopPropagation();
        togglePicker();
      });

      // Switch between day, month, and year selection panels
      function switchView(view) {
        currentView = view;
        dayView.classList.toggle('hidden', view !== 'day');
        monthView.classList.toggle('hidden', view !== 'month');
        yearView.classList.toggle('hidden', view !== 'year');

        if (view === 'day') {
          prevBtn.style.visibility = 'visible';
          nextBtn.style.visibility = 'visible';
        } else if (view === 'month') {
          prevBtn.style.visibility = 'hidden';
          nextBtn.style.visibility = 'hidden';
        } else if (view === 'year') {
          prevBtn.style.visibility = 'visible';
          nextBtn.style.visibility = 'visible';
        }
      }

      // Title click shifts view levels: day -> month -> year
      titleBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (currentView === 'day') {
          switchView('month');
          render();
        } else if (currentView === 'month') {
          switchView('year');
          // Align decade start to nearest 16-year page boundary
          decadeStartYear = currentDate.getFullYear() - (currentDate.getFullYear() % 16);
          render();
        } else {
          switchView('day');
          render();
        }
      });

      prevBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (currentView === 'day') {
          currentDate.setMonth(currentDate.getMonth() - 1);
        } else if (currentView === 'year') {
          decadeStartYear -= 16; // step back one full 4×4 page
        }
        render();
      });

      nextBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        if (currentView === 'day') {
          currentDate.setMonth(currentDate.getMonth() + 1);
        } else if (currentView === 'year') {
          decadeStartYear += 16; // step forward one full 4×4 page
        }
        render();
      });

      // Render method
      function render() {
        if (currentView === 'day') {
          renderDays();
        } else if (currentView === 'month') {
          renderMonths();
        } else if (currentView === 'year') {
          renderYears();
        }
      }

      // ── Render Day Selector Grid ──
      function renderDays() {
        monthYearLabel.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        daysContainer.innerHTML = '';

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // First day of current month
        const firstDayIndex = new Date(year, month, 1).getDay();
        // Total days in current month
        const totalDays = new Date(year, month + 1, 0).getDate();
        // Total days in previous month
        const prevTotalDays = new Date(year, month, 0).getDate();

        // Render remaining days of previous month
        for (let i = firstDayIndex - 1; i >= 0; i--) {
          const cellDate = new Date(year, month - 1, prevTotalDays - i);
          const cell = createDayCell(prevTotalDays - i, cellDate, true);
          daysContainer.appendChild(cell);
        }

        // Render current month days
        for (let i = 1; i <= totalDays; i++) {
          const cellDate = new Date(year, month, i);
          const cell = createDayCell(i, cellDate, false);
          daysContainer.appendChild(cell);
        }

        // Render starting days of next month to pad the grid (needs 42 total cells)
        const remainingCells = 42 - daysContainer.children.length;
        for (let i = 1; i <= remainingCells; i++) {
          const cellDate = new Date(year, month + 1, i);
          const cell = createDayCell(i, cellDate, true);
          daysContainer.appendChild(cell);
        }

        // Handle "Today" button state in footer
        const today = new Date();
        todayBtn.disabled = isUnderageOrFuture(today);
      }

      function createDayCell(dayNum, date, isOtherMonth) {
        const cell = document.createElement('div');
        cell.className = 'datepicker-day-cell';
        cell.textContent = dayNum;

        if (isOtherMonth) {
          cell.classList.add('other-month');
        }

        // Highlight today subtly (outline only)
        const today = new Date();
        if (date.getDate() === today.getDate() && date.getMonth() === today.getMonth() && date.getFullYear() === today.getFullYear()) {
          cell.classList.add('today-outline');
        }

        // Highlight selected date
        if (selectedDate && date.getDate() === selectedDate.getDate() && date.getMonth() === selectedDate.getMonth() && date.getFullYear() === selectedDate.getFullYear()) {
          cell.classList.add('selected');
        }

        // Disable if underage or future
        if (isUnderageOrFuture(date)) {
          cell.classList.add('disabled');
        } else {
          cell.addEventListener('click', function (e) {
            e.stopPropagation();
            selectDate(date);
            closePicker();
          });
        }

        return cell;
      }

      // ── Render Month Selector Grid ──
      function renderMonths() {
        monthYearLabel.textContent = `${currentDate.getFullYear()}`;
        monthsContainer.innerHTML = '';

        monthNames.forEach((monthName, index) => {
          const cell = document.createElement('div');
          cell.className = 'datepicker-select-item';
          cell.textContent = monthName.slice(0, 3); // 3-letter abbreviation

          // Highlight current month
          if (index === currentDate.getMonth()) {
            cell.classList.add('selected');
          }

          cell.addEventListener('click', function (e) {
            e.stopPropagation();
            currentDate.setMonth(index);
            switchView('day');
            render();
          });

          monthsContainer.appendChild(cell);
        });
      }

      // ── Render Year Selector Grid (4×4 = 16 years per page) ──
      function renderYears() {
        const endYear = decadeStartYear + 15;
        // Use non-breaking space + en-dash + non-breaking space to prevent any line-wrap
        monthYearLabel.textContent = `${decadeStartYear} – ${endYear}`;
        yearsContainer.innerHTML = '';

        for (let yr = decadeStartYear; yr <= endYear; yr++) {
          const cell = document.createElement('div');
          cell.className = 'datepicker-select-item';
          cell.textContent = yr;

          // Highlight selected or current year
          if (yr === currentDate.getFullYear()) {
            cell.classList.add('selected');
          }

          // Check if the entire year is in the future
          const today = new Date();
          if (yr > today.getFullYear()) {
            cell.classList.add('disabled');
          } else {
            cell.addEventListener('click', function (e) {
              e.stopPropagation();
              currentDate.setFullYear(yr);
              switchView('month');
              render();
            });
          }

          yearsContainer.appendChild(cell);
        }
      }

      // Select date action
      function selectDate(date) {
        selectedDate = date;

        // Write standard yyyy-mm-dd to hidden field
        const yyyy = date.getFullYear();
        const mm = String(date.getMonth() + 1).padStart(2, '0');
        const dd = String(date.getDate()).padStart(2, '0');
        dobInput.value = `${yyyy}-${mm}-${dd}`;

        // Write human readable dd/mm/yyyy to display field
        dobDisplay.value = `${dd}/${mm}/${yyyy}`;

        // Dispatch events to trigger validation
        dobInput.dispatchEvent(new Event('input', { bubbles: true }));
        dobInput.dispatchEvent(new Event('change', { bubbles: true }));
      }

      // Clear action
      clearBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        selectedDate = null;
        dobInput.value = '';
        dobDisplay.value = '';

        // Dispatch events to trigger validation
        dobInput.dispatchEvent(new Event('input', { bubbles: true }));
        dobInput.dispatchEvent(new Event('change', { bubbles: true }));

        closePicker();
      });

      // Today action (selects today's date if valid)
      todayBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        const today = new Date();
        if (!isUnderageOrFuture(today)) {
          selectDate(today);
          closePicker();
        }
      });

      // Update display dynamically if external JS changes hidden input value (e.g. autofill)
      const observer = new MutationObserver(() => {
        parseInitialDate();
      });
      observer.observe(dobInput, { attributes: true, attributeFilter: ['value'] });
    })();

    document.getElementById('reg-form').addEventListener('submit', function (e) {
      if (msgDiv.className.includes('text-red-600') || !captured) { e.preventDefault(); return; }
      
      e.preventDefault(); // Stop default submit to play transition first
      
      sessionStorage.setItem('just_registered', 'true');
      
      stopStream();

      // Fade out the main form card
      const guestCard = document.querySelector('.bg-black/60');
      if (guestCard) {
        guestCard.style.transition = 'all 0.6s cubic-bezier(0.25, 1, 0.5, 1)';
        guestCard.style.opacity = '0';
        guestCard.style.transform = 'scale(0.95)';
      }
      
      // Play success checkmark scale-out animation
      const successOverlay = document.createElement('div');
      successOverlay.className = 'fixed inset-0 z-[9999] flex items-center justify-center backdrop-blur-md';
      successOverlay.style.background = 'linear-gradient(135deg, #0b3d2e 0%, #061810 100%)';
      successOverlay.style.opacity = '0';
      successOverlay.style.transition = 'opacity 0.5s ease';
      successOverlay.innerHTML = `
        <style>
          @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
          }
        </style>
        <div class="text-center px-4">
          <div class="w-20 h-20 mx-auto bg-emerald-500 rounded-full flex items-center justify-center text-white text-4xl shadow-lg shadow-emerald-500/50 scale-0" style="animation: check-scale-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s forwards;">
            ✓
          </div>
          <h2 class="text-3xl font-black text-white mt-6 mb-2" style="animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.5s forwards; opacity: 0; transform: translateY(15px);">Welcome to E-Turismo!</h2>
          <p class="text-emerald-400 text-sm" style="animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.7s forwards; opacity: 0; transform: translateY(15px);">Setting up your tourist dashboard...</p>
        </div>
      `;
      document.body.appendChild(successOverlay);

      // Trigger reflow
      void successOverlay.offsetWidth;
      successOverlay.style.opacity = '1';

      // Submit form after animation completes
      setTimeout(() => {
        e.target.submit();
      }, 1900);
    });


  </script>

  <script>
    (function () {
      var OPTIONS = ['Jr.', 'Sr.', 'II', 'III', 'IV', 'N/A'];

      function initSuffixDropdown() {
        var suffixInput = document.getElementById('suffix');
        var chevronBtn = document.querySelector('#suffix-combobox button');
        if (!suffixInput) return;

        /* ── Build portal entirely in JS and append to body ──
           This ensures it's never inside overflow:hidden / opacity containers. */
        var portal = document.createElement('div');
        portal.id = 'suffix-portal';
        Object.assign(portal.style, {
          display: 'none',
          position: 'fixed',
          zIndex: '99999',
          background: '#ffffff',
          border: '1px solid #d1d5db',
          borderRadius: '6px',
          boxShadow: '0 8px 24px rgba(0,0,0,0.14)',
          minWidth: '140px',
          overflow: 'hidden',
        });

        var ul = document.createElement('ul');
        Object.assign(ul.style, { margin: '0', padding: '4px 0', listStyle: 'none' });

        OPTIONS.forEach(function (opt) {
          var li = document.createElement('li');
          li.dataset.value = opt;
          Object.assign(li.style, {
            cursor: 'pointer',
            padding: '9px 14px',
            fontSize: '0.875rem',
            fontWeight: '500',
            color: '#111827',   /* solid near-black — no opacity issues */
            display: 'flex',
            alignItems: 'center',
            gap: '8px',
            userSelect: 'none',
          });

          /* green check icon */
          var checkSvg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
          checkSvg.setAttribute('viewBox', '0 0 20 20');
          checkSvg.setAttribute('fill', '#10b981');
          Object.assign(checkSvg.style, { width: '14px', height: '14px', flexShrink: '0', visibility: 'hidden' });
          var checkPath = document.createElementNS('http://www.w3.org/2000/svg', 'path');
          checkPath.setAttribute('fill-rule', 'evenodd');
          checkPath.setAttribute('d', 'M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z');
          checkPath.setAttribute('clip-rule', 'evenodd');
          checkSvg.appendChild(checkPath);

          /* label */
          var span = document.createElement('span');
          span.style.flex = '1';
          span.textContent = opt;

          li.appendChild(checkSvg);
          li.appendChild(span);

          /* hover */
          li.addEventListener('mouseover', function () {
            li.style.background = '#f0fdf4';
            li.style.color = '#065f46';
          });
          li.addEventListener('mouseout', function () {
            li.style.background = '';
            li.style.color = '#111827';
          });

          /* select — preventDefault stops blur from firing before click completes */
          li.addEventListener('mousedown', function (e) {
            e.preventDefault();
            suffixInput.value = (opt === 'N/A') ? '' : opt;
            suffixInput.dispatchEvent(new Event('input', { bubbles: true }));
            suffixInput.dispatchEvent(new Event('change', { bubbles: true }));
            syncChecks();
            hidePortal();
          });

          ul.appendChild(li);
        });

        portal.appendChild(ul);
        document.body.appendChild(portal);

        /* ── Helpers ── */
        function syncChecks() {
          var cur = suffixInput.value.trim();
          ul.querySelectorAll('li').forEach(function (li) {
            var chk = li.querySelector('svg');
            var isMatch = (li.dataset.value === cur) || (li.dataset.value === 'N/A' && (cur === '' || cur.toUpperCase() === 'N/A'));
            if (chk) chk.style.visibility = isMatch ? 'visible' : 'hidden';
          });
        }

        function reposition() {
          var r = suffixInput.getBoundingClientRect();
          portal.style.top = (r.bottom + 4) + 'px';
          portal.style.left = r.left + 'px';
          portal.style.width = r.width + 'px';
        }

        function showPortal() {
          syncChecks();
          reposition();
          portal.style.display = 'block';
        }

        function hidePortal() {
          portal.style.display = 'none';
        }

        /* ── Input events ── */
        suffixInput.addEventListener('focus', showPortal);
        suffixInput.addEventListener('blur', function () {
          setTimeout(hidePortal, 150);
        });

        /* ── Chevron button toggle ── */
        if (chevronBtn) {
          chevronBtn.addEventListener('mousedown', function (e) {
            e.preventDefault();
            if (portal.style.display === 'none') {
              suffixInput.focus();
              showPortal();
            } else {
              hidePortal();
            }
          });
        }

        /* ── Keep portal aligned on scroll/resize ── */
        window.addEventListener('scroll', function () { if (portal.style.display !== 'none') reposition(); }, true);
        window.addEventListener('resize', function () { if (portal.style.display !== 'none') reposition(); });

        /* ── Outside click closes portal ── */
        document.addEventListener('mousedown', function (e) {
          if (!portal.contains(e.target) && !e.target.closest('#suffix-combobox')) {
            hidePortal();
          }
        });
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSuffixDropdown);
      } else {
        initSuffixDropdown();
      }
    })();
  </script>
</x-guest-layout>