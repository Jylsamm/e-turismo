<style>
/* ── Date picker icon ── */
input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: .7; filter: invert(40%) sepia(80%) saturate(500%) hue-rotate(200deg); }
input[type="date"]::-webkit-inner-spin-button { display: none; }

/* ── Camera container ── */
.cam-box { background:#08111f; border-radius:1rem; overflow:hidden; border:1px solid #1e3a52; }

/* ── Teal dashed guide ── */
.cam-guide-rect { fill:none; stroke:#14b8a6; stroke-width:2.5; stroke-dasharray:10 6; animation:teal-pulse 2.4s ease-in-out infinite; }
@keyframes teal-pulse {
  0%,100% { stroke:#14b8a6; stroke-opacity:.7; }
  50%     { stroke:#34d399; stroke-opacity:1;  }
}

/* ── Instruction pill ── */
.cam-pill {
  display:inline-flex; align-items:center; gap:8px;
  background:#0f172a;
  border: 1.5px solid #0d9488; color:#ffffff;
  font-size:.78rem; font-weight:600; padding:.45rem 1rem;
  border-radius:9999px; pointer-events:none; letter-spacing:.01em;
  box-shadow: 0 4px 12px rgba(0,0,0,0.5);
  max-width: 90%;
  text-align: center;
}
@keyframes scale-in {
  0% { transform: scale(0.9); opacity: 0; }
  100% { transform: scale(1); opacity: 1; }
}
.animate-scale {
  animation: scale-in 0.25s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* ── Bottom bar ── */
.cam-bottom-bar {
  display:flex; align-items:center; justify-content:space-between;
  padding:.55rem .85rem;
  background:rgba(8,17,31,.92);
  border-top:1px solid rgba(20,184,166,.15);
}
.cam-orient-label {
  display:flex; align-items:center; gap:5px;
  font-size:.7rem; font-weight:600; color:#99f6e4;
  letter-spacing:.04em; text-transform:uppercase;
}
.cam-flip-btn {
  display:flex; align-items:center; gap:4px;
  font-size:.7rem; font-weight:600; color:#94a3b8;
  background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1);
  border-radius:6px; padding:.3rem .65rem; cursor:pointer;
  transition:.18s; text-transform:uppercase; letter-spacing:.04em;
}
.cam-flip-btn:hover { background:rgba(20,184,166,.15); color:#f0fdfa; border-color:rgba(20,184,166,.4); }

/* ── Shutter ── */
.cam-shutter {
  width:52px; height:52px; border-radius:9999px; background:#fff;
  border:4px solid #1e3a52; display:flex; align-items:center; justify-content:center;
  cursor:pointer; transition:border-color .2s,transform .15s;
  box-shadow:0 4px 16px rgba(0,0,0,.4); flex-shrink:0;
}
.cam-shutter:hover { border-color:#14b8a6; transform:scale(1.06); }
.cam-shutter-dot { width:30px; height:30px; border-radius:9999px; background:#14b8a6; }

/* ── Denied state ── */
.cam-denied { display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:2rem 1.5rem; gap:1rem; }
.cam-denied-icon { color:#f87171; }
.cam-denied h5   { color:#fecaca; font-weight:700; font-size:.9rem; }
.cam-denied p    { color:#94a3b8; font-size:.75rem; line-height:1.5; max-width:26ch; }
.cam-retry-btn  { padding:.5rem 1.2rem; background:rgba(248,113,113,.12); border:1px solid rgba(248,113,113,.4); color:#fca5a5; border-radius:8px; font-size:.75rem; font-weight:600; cursor:pointer; transition:.18s; }
.cam-retry-btn:hover { background:rgba(248,113,113,.25); color:#fff; }

/* ── Enable btn ── */
.cam-enable-btn { padding:.5rem 1.3rem; background:#0d9488; color:#fff; border-radius:8px; font-size:.75rem; font-weight:700; border:none; cursor:pointer; transition:.18s; box-shadow:0 2px 12px rgba(20,184,166,.3); }
.cam-enable-btn:hover { background:#0f766e; transform:translateY(-1px); }

/* ── Captured badge ── */
.cam-captured-badge { position:absolute; top:8px; left:8px; z-index:10; background:rgba(16,185,129,.92); color:#fff; font-size:.62rem; font-weight:800; padding:2px 8px; border-radius:9999px; letter-spacing:.06em; text-transform:uppercase; }

/* ── DOB wrapper ── */
.dob-wrapper { position:relative; }
.dob-wrapper input[type="date"] { padding-right:2.5rem; }
.dob-cal-icon { position:absolute; right:.65rem; top:50%; transform:translateY(-50%); pointer-events:none; color:#9ca3af; }
</style>

<x-guest-layout>
<form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="reg-form">
  @csrf

  {{-- Name --}}
  <div class="grid grid-cols-2 gap-3">
    <div>
      <x-input-label for="first_name" :value="__('First Name')" />
      <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="given-name" />
      <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div>
      <x-input-label for="last_name" :value="__('Last Name')" />
      <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
      <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
  </div>

  <div class="mt-4">
    <x-input-label for="middle_initial" :value="__('Middle Initial (optional)')" />
    <x-text-input id="middle_initial" class="block mt-1 w-full" type="text" name="middle_initial" :value="old('middle_initial')" maxlength="5" placeholder="e.g. A" />
    <x-input-error :messages="$errors->get('middle_initial')" class="mt-2" />
  </div>

  {{-- Email --}}
  <div class="mt-4">
    <x-input-label for="email" :value="__('Gmail Address')" />
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="yourname@gmail.com" />
    <div id="email-check-msg" class="mt-1 text-xs font-semibold"></div>
    <x-input-error :messages="$errors->get('email')" class="mt-2" />
  </div>

  {{-- Classification --}}
  <div class="mt-4">
    <x-input-label for="classification" :value="__('Visitor Classification')" />
    <select id="classification" name="classification" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
      <option value="" disabled selected>Select Classification</option>
      <option value="Local"    {{ old('classification')=='Local'    ? 'selected' : '' }}>Local (Municipal Resident)</option>
      <option value="Domestic" {{ old('classification')=='Domestic' ? 'selected' : '' }}>Domestic (National Resident)</option>
      <option value="Foreign"  {{ old('classification')=='Foreign'  ? 'selected' : '' }}>Foreign (International Visitor)</option>
    </select>
    <x-input-error :messages="$errors->get('classification')" class="mt-2" />
  </div>

  {{-- 1. ID Type --}}
  <div class="mt-4">
    <x-input-label for="id_type" :value="__('ID Type')" />
    <select id="id_type" name="id_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
      <option value="" disabled selected>Select ID Type</option>
      <option value="Passport"         {{ old('id_type')=='Passport'         ? 'selected' : '' }}>Passport</option>
      <option value="National ID"      {{ old('id_type')=='National ID'      ? 'selected' : '' }}>National ID (PhilSys)</option>
      <option value="Driver's License" {{ old('id_type')=="Driver's License" ? 'selected' : '' }}>Driver's License</option>
      <option value="SSS ID"           {{ old('id_type')=='SSS ID'           ? 'selected' : '' }}>SSS ID</option>
      <option value="GSIS ID"          {{ old('id_type')=='GSIS ID'          ? 'selected' : '' }}>GSIS ID</option>
      <option value="PhilHealth ID"    {{ old('id_type')=='PhilHealth ID'    ? 'selected' : '' }}>PhilHealth ID</option>
      <option value="Pag-IBIG ID"      {{ old('id_type')=='Pag-IBIG ID'      ? 'selected' : '' }}>Pag-IBIG ID</option>
      <option value="Voter ID"         {{ old('id_type')=='Voter ID'         ? 'selected' : '' }}>Voter's ID</option>
      <option value="Postal ID"        {{ old('id_type')=='Postal ID'        ? 'selected' : '' }}>Postal ID</option>
      <option value="School ID"        {{ old('id_type')=='School ID'        ? 'selected' : '' }}>School / Student ID</option>
      <option value="Barangay ID"      {{ old('id_type')=='Barangay ID'      ? 'selected' : '' }}>Barangay ID</option>
      <option value="Company ID"       {{ old('id_type')=='Company ID'       ? 'selected' : '' }}>Company / Employee ID</option>
    </select>
    <x-input-error :messages="$errors->get('id_type')" class="mt-2" />
  </div>

  {{-- 2. ID Number / School Name --}}
  <div class="mt-4" id="id-number-group">
    <x-input-label for="id_number_input" :value="__('ID Number')" id="id-number-label" />
    <x-text-input id="id_number_input" class="block mt-1 w-full" type="text" name="id_number" :value="old('id_number')" required placeholder="e.g. 2022-041633" />
    <p id="id-number-hint" class="mt-1 text-xs text-gray-500 hidden">Enter your full school name (e.g. <em>J.H. Cerilles State College</em>). Do not use abbreviations.</p>
    <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
  </div>

  {{-- 3. Date of Birth (conditional) --}}
  <div class="mt-4" id="dob-group">
    <x-input-label for="dob" :value="__('Date of Birth')" id="dob-label" />
    <div class="dob-wrapper mt-1">
      <x-text-input id="dob" class="block w-full" type="date" name="dob" :value="old('dob')" />
      <span class="dob-cal-icon">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
      </span>
    </div>
    <p id="dob-hint" class="mt-1 text-xs text-gray-400 hidden">Not required for this ID type.</p>
    <x-input-error :messages="$errors->get('dob')" class="mt-2" />
  </div>

  {{-- 4. Camera Capture --}}
  <div class="mt-5">
    <x-input-label :value="__('ID Photo Capture — Front + Back (Live Camera)')" />
    <div class="cam-box mt-2" id="cam-box">

      {{-- STATE A: not yet asked --}}
      <div id="cam-state-pending" class="flex flex-col items-center justify-center text-center gap-4 px-6 py-10">
        <div style="width:3.5rem;height:3.5rem;border-radius:9999px;background:rgba(13,148,136,0.18);border:1.5px solid rgba(20,184,166,0.5);display:flex;align-items:center;justify-content:center;color:#2dd4bf;">
          <svg style="width:1.75rem;height:1.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <div>
          <p style="color:#f8fafc; font-weight:600; font-size:.875rem;">Capture Your ID with Camera</p>
          <p style="color:#cbd5e1; font-size:.75rem; margin-top:.25rem; line-height:1.6;">Your device camera will photograph your ID directly.</p>
        </div>
        <button type="button" id="btn-enable-camera" class="cam-enable-btn">
          <span class="flex items-center gap-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.868V15.13a1 1 0 01-1.447.898L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
            Enable Camera
          </span>
        </button>
      </div>

      {{-- STATE B: denied --}}
      <div id="cam-state-denied" class="cam-denied hidden">
        <div class="cam-denied-icon">
          <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
        <h5>Camera Access Denied</h5>
        <p>Please allow camera access in your browser settings, then click Retry below.</p>
        <div class="text-xs text-slate-500 bg-slate-900/60 border border-slate-700 rounded-lg px-4 py-2 text-left leading-relaxed" style="max-width:28ch">
          <strong class="text-slate-400 block mb-1">How to enable:</strong>
          <span class="block">• Chrome: <em>Address bar → 🔒 → Camera → Allow</em></span>
          <span class="block">• Firefox: <em>Address bar → 🔒 → Camera → Allow</em></span>
          <span class="block">• Safari: <em>Settings → Safari → Camera → Allow</em></span>
        </div>
        <button type="button" id="btn-retry-camera" class="cam-retry-btn">
          <span class="flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89"/></svg>
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
            <span id="cam-step-badge" class="bg-indigo-600/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Step 1 of 2</span>
            <span id="cam-side-badge" class="bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider">Front ID</span>
          </div>

          {{-- Auto-advance Confirmation Overlay --}}
          <div id="cam-transition-overlay" class="absolute inset-0 bg-slate-900/95 flex flex-col items-center justify-center text-center gap-3 z-30 hidden">
            <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center text-white text-xl animate-scale shadow-lg">✓</div>
            <p class="text-white font-bold text-sm">Front Captured Successfully!</p>
            <p class="text-teal-300 text-xs">Automatically switching to Back of ID...</p>
          </div>

          {{-- SVG overlay --}}
          <svg id="cam-guide-svg" class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg">
            <defs>
              <mask id="cam-guide-mask">
                <rect width="100%" height="100%" fill="white"/>
                <rect id="cam-guide-cutout" x="8%" y="12%" width="84%" height="76%" rx="14" fill="black"/>
              </mask>
            </defs>
            <rect width="100%" height="100%" fill="rgba(8,17,31,0.7)" mask="url(#cam-guide-mask)"/>
            <rect id="cam-guide-outline" x="8%" y="12%" width="84%" height="76%" rx="14" fill="none" stroke="#14b8a6" stroke-width="2.5" stroke-dasharray="10 6" class="cam-guide-rect"/>
          </svg>
          {{-- Instruction pill --}}
          <div class="absolute bottom-4 inset-x-0 flex justify-center pointer-events-none z-10">
            <span id="cam-pill" class="cam-pill">
              <svg class="w-3.5 h-3.5 text-teal-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              <span id="cam-pill-text">Hold steady to prevent blur</span>
            </span>
          </div>
        </div>
        {{-- Bottom bar --}}
        <div class="cam-bottom-bar">
          <div class="cam-orient-label">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7"/></svg>
            <span id="orient-label-text">Landscape Guide</span>
          </div>
          <button type="button" id="btn-shutter" class="cam-shutter" title="Capture photo">
            <div class="cam-shutter-dot"></div>
          </button>
          <button type="button" id="btn-flip" class="cam-flip-btn">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Flip
          </button>
        </div>
      </div>

      {{-- STATE D: completion review state --}}
      <div id="cam-state-captured" class="hidden flex flex-col">
        <div class="p-3 bg-slate-900 border-b border-teal-950 text-center">
          <span class="text-green-400 font-bold text-xs uppercase tracking-widest block flex items-center justify-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
            ID capture complete
          </span>
        </div>
        <div class="grid grid-cols-2 gap-3 p-3 bg-slate-950">
          <div class="flex flex-col gap-1.5">
            <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Front side</span>
            <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
              <img id="cam-img-front-thumb" class="block w-full h-auto" alt="Front ID Preview" />
              <span class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
              </span>
            </div>
          </div>
          <div class="flex flex-col gap-1.5">
            <span class="text-[10px] text-slate-400 font-bold tracking-wider uppercase text-center">Back side</span>
            <div class="bg-black rounded-lg overflow-hidden border border-slate-800 relative">
              <img id="cam-img-back-thumb" class="block w-full h-auto" alt="Back ID Preview" />
              <span class="absolute top-1.5 right-1.5 bg-green-500 text-white rounded-full p-0.5 shadow">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
              </span>
            </div>
          </div>
        </div>
        
        {{-- Hidden element to keep original selector variables safe from JS errors --}}
        <img id="cam-captured-img" class="hidden" alt="Merged Preview" />

        <div class="cam-bottom-bar justify-center">
          <button type="button" id="btn-retake" class="cam-flip-btn" style="color:#fb923c;border-color:rgba(251,146,60,.35);">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 7.89"/></svg>
            Retake & Restart
          </button>
        </div>
      </div>

    </div>

    <input id="id_photo" name="id_photo" type="file" accept="image/jpeg" required class="sr-only" aria-hidden="true" tabindex="-1"/>
    <p id="cam-error-msg"   class="mt-2 text-sm text-red-600  hidden"></p>
    <p id="cam-success-msg" class="mt-2 text-sm text-green-600 hidden"></p>
    <x-input-error :messages="$errors->get('id_photo')" class="mt-2" />
  </div>

  {{-- 5. Password --}}
  <div class="mt-5">
    <x-input-label for="password" :value="__('Password')" />
    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2" />
  </div>

  {{-- 6. Confirm Password --}}
  <div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
  </div>

  <div class="flex items-center justify-end mt-5">
    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
      {{ __('Already registered?') }}
    </a>
    <x-primary-button class="ms-4" id="submit-btn">{{ __('Create Account') }}</x-primary-button>
  </div>
</form>

<script>
const ID_TYPES_WITH_DOB = new Set(['Passport','National ID',"Driver's License",'SSS ID','GSIS ID','PhilHealth ID','Pag-IBIG ID','Voter ID','Postal ID']);

const idTypeSelect  = document.getElementById('id_type');
const idLabel       = document.getElementById('id-number-label');
const idInput       = document.getElementById('id_number_input');
const idHint        = document.getElementById('id-number-hint');
const dobGroup      = document.getElementById('dob-group');
const dobInput      = document.getElementById('dob');
const dobHint       = document.getElementById('dob-hint');
const emailInput    = document.getElementById('email');
const msgDiv        = document.getElementById('email-check-msg');
const submitBtn     = document.getElementById('submit-btn');
const statePending  = document.getElementById('cam-state-pending');
const stateDenied   = document.getElementById('cam-state-denied');
const stateActive   = document.getElementById('cam-state-active');
const stateCaptured = document.getElementById('cam-state-captured');
const camVideo      = document.getElementById('cam-video');
const camCapImg     = document.getElementById('cam-captured-img');
const orientLabel   = document.getElementById('orient-label-text');
const pillText      = document.getElementById('cam-pill-text');
const fileInput     = document.getElementById('id_photo');
const camErrMsg     = document.getElementById('cam-error-msg');
const camOkMsg      = document.getElementById('cam-success-msg');

let stream          = null;
let facingMode      = 'environment';
let orientation     = 'landscape';
let captured        = false;
let pillTimer       = null;
let debounce        = null;
const PILLS = ['Hold steady to prevent blur','Align ID within the glowing frame','Ensure good lighting — avoid glare','All text must be clearly readable'];
let pillIdx = 0;

// ── Two-Step Capture Variables ─────────────────────────────
let currentStep     = 1;
let frontPhotoData  = null;
let backPhotoData   = null;

// ── ID Type rules ──────────────────────────────────────────
function applyIdType() {
  const v = idTypeSelect.value;
  if (v === 'School ID') {
    idLabel.textContent = 'School Name'; idInput.placeholder = 'e.g. J.H. Cerilles State College'; idInput.name = 'school_name'; idHint.classList.remove('hidden');
  } else {
    idLabel.textContent = 'ID Number'; idInput.placeholder = 'e.g. 2022-041633'; idInput.name = 'id_number'; idHint.classList.add('hidden');
  }
  const needsDob = ID_TYPES_WITH_DOB.has(v);
  dobInput.required = needsDob;
  if (!needsDob) { dobInput.value = ''; dobHint.classList.remove('hidden'); dobGroup.style.opacity = '.6'; }
  else           { dobHint.classList.add('hidden'); dobGroup.style.opacity = '1'; }
}
idTypeSelect.addEventListener('change', applyIdType);
applyIdType();

// ── Form validity ──────────────────────────────────────────
function checkValidity() {
  const bad = msgDiv.className.includes('text-red-600');
  submitBtn.disabled = (bad || !captured);
  submitBtn.style.opacity = (bad || !captured) ? '.5' : '1';
}
checkValidity();

// ── Email check ────────────────────────────────────────────
emailInput.addEventListener('input', function() {
  clearTimeout(debounce);
  const v = emailInput.value.trim();
  if (!v) { msgDiv.textContent = ''; return; }
  debounce = setTimeout(() => {
    msgDiv.className = 'mt-1 text-xs font-semibold text-gray-500';
    msgDiv.textContent = 'Checking…';
    fetch("{{ route('email.check') }}", {
      method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:JSON.stringify({email:v})
    }).then(r=>r.json()).then(d => {
      if (!d.valid || !d.available) { msgDiv.className='mt-1 text-xs font-semibold text-red-600'; msgDiv.textContent='\u2717 '+d.message; }
      else                          { msgDiv.className='mt-1 text-xs font-semibold text-green-600'; msgDiv.textContent='\u2713 '+d.message; }
      checkValidity();
    }).catch(()=>{ msgDiv.textContent=''; });
  }, 400);
});

// ── Camera helpers ─────────────────────────────────────────
function showState(name) {
  [statePending,stateDenied,stateActive,stateCaptured].forEach(el=>el.classList.add('hidden'));
  ({pending:statePending,denied:stateDenied,active:stateActive,captured:stateCaptured}[name]).classList.remove('hidden');
}
function stopStream() {
  if (pillTimer) { clearInterval(pillTimer); pillTimer=null; }
  if (stream)    { stream.getTracks().forEach(t=>t.stop()); stream=null; }
  camVideo.srcObject = null;
}
function startPills() {
  if (pillTimer) clearInterval(pillTimer);
  pillIdx=0; pillText.textContent=PILLS[0];
  pillTimer=setInterval(()=>{ pillIdx=(pillIdx+1)%PILLS.length; pillText.textContent=PILLS[pillIdx]; },3500);
}
function updateFrame() {
  const svg=document.getElementById('cam-guide-svg');
  if (!svg||stateActive.classList.contains('hidden')) return;
  const r=svg.getBoundingClientRect(), W=r.width, H=r.height;
  if (!W||!H) return;
  let cW,cH;
  if (orientation==='landscape') { cW=W*.84; cH=cW/1.586; if(cH>H*.78){cH=H*.78;cW=cH*1.586;} }
  else                           { cH=H*.78; cW=cH/1.586; if(cW>W*.84){cW=W*.84;cH=cW*1.586;} }
  const x=(W-cW)/2, y=(H-cH)/2;
  ['cam-guide-cutout','cam-guide-outline'].forEach(id=>{
    const el=document.getElementById(id); if(!el)return;
    el.setAttribute('x',x); el.setAttribute('y',y); el.setAttribute('width',cW); el.setAttribute('height',cH);
  });
}
window.addEventListener('resize', updateFrame);

async function startCamera(){
  camErrMsg.classList.add('hidden');camOkMsg.classList.add('hidden');stopStream();
  if(!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia){
    camErrMsg.textContent='Insecure Context: Camera access requires HTTPS or localhost. Try accessing via localhost or generate a local TLS cert.';
    camErrMsg.classList.remove('hidden');
    showState('pending');
    return;
  }
  try{
    stream=await navigator.mediaDevices.getUserMedia({video:{facingMode:{ideal:facingMode},width:{ideal:1920},height:{ideal:1080}},audio:false});
    camVideo.srcObject=stream; showState('active'); setTimeout(updateFrame,150); startPills();
    
    // Update step UI for state
    document.getElementById('cam-step-badge').textContent = `Step ${currentStep} of 2`;
    document.getElementById('cam-side-badge').textContent = currentStep === 1 ? 'Front ID' : 'Back ID';
    document.getElementById('cam-side-badge').className = currentStep === 1 
      ? 'bg-teal-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider'
      : 'bg-indigo-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
  }catch(err){
    if(err.name==='NotAllowedError'||err.name==='PermissionDeniedError'){showState('denied');}
    else{camErrMsg.textContent='Camera error: '+(err.message||err.name)+'. Please refresh and try again.';camErrMsg.classList.remove('hidden');showState('pending');}
  }
}

document.getElementById('btn-enable-camera').addEventListener('click', startCamera);
document.getElementById('btn-retry-camera').addEventListener('click',  startCamera);

document.getElementById('btn-flip').addEventListener('click',()=>{
  orientation=(orientation==='landscape')?'portrait':'landscape';
  orientLabel.textContent=orientation==='landscape'?'Landscape Guide':'Portrait Guide';
  updateFrame();
});

document.getElementById('btn-shutter').addEventListener('click',()=>{
  if (!stream) return;
  const vW=camVideo.videoWidth, vH=camVideo.videoHeight;
  if (!vW||!vH) return;

  const canvas=document.createElement('canvas');
  canvas.width =vW;
  canvas.height=vH;
  canvas.getContext('2d').drawImage(camVideo, 0, 0, vW, vH);

  try {
    const url=canvas.toDataURL('image/jpeg',.95);
    
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
        document.getElementById('cam-side-badge').className = 'bg-indigo-500/90 text-white text-[10px] font-bold px-2 py-1 rounded shadow-md uppercase tracking-wider';
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
      imgFront.onload = function() {
        ctx.drawImage(imgFront, 0, 0, vW, vH);
        
        const imgBack = new Image();
        imgBack.onload = function() {
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
          const f = new File([bytes], `id_composite_${Date.now()}.jpg`, {type: 'image/jpeg'});
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
          checkValidity();
        };
        imgBack.src = backPhotoData;
      };
      imgFront.src = frontPhotoData;
    }
  } catch(e) {
    camErrMsg.textContent = 'Failed to capture. Please try again.';
    camErrMsg.classList.remove('hidden');
  }
});

document.getElementById('btn-retake').addEventListener('click',()=>{
  captured = false;
  currentStep = 1;
  frontPhotoData = null;
  backPhotoData = null;
  fileInput.value = '';
  camOkMsg.classList.add('hidden');
  checkValidity();
  startCamera();
});

document.getElementById('reg-form').addEventListener('submit', function(e){
  if (msgDiv.className.includes('text-red-600')||!captured) { e.preventDefault(); return; }
  stopStream();
  const ov=document.createElement('div');
  ov.className='fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm';
  ov.innerHTML='<div class="text-center"><div class="text-6xl mb-4 animate-bounce">\u23f3</div><h2 class="text-2xl font-bold text-white mb-2">Reading Your ID...</h2><p class="text-teal-300 text-sm">This usually takes a few seconds.</p></div>';
  document.body.appendChild(ov);
  submitBtn.disabled=true; submitBtn.textContent='Processing…';
});
</script>
</x-guest-layout>
