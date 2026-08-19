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
            transform: translateY(-4px) !important;
            box-shadow: 0 10px 25px -5px rgba(21, 128, 61, 0.15), 0 4px 10px -5px rgba(21, 128, 61, 0.1) !important;
            border-color: #bbf7d0 !important;
        }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex items-center justify-between">
<<<<<<< Updated upstream
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="ti ti-user-plus text-2xl text-green-700"></i>
                Add Staff Account
=======
            <h2 class="font-display font-normal text-2xl sm:text-3xl text-slate-900 tracking-wide flex items-center gap-3">
                <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800 shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </span>
                <span>Add Account</span>
>>>>>>> Stashed changes
            </h2>
        </div>
    </x-slot>

<<<<<<< Updated upstream
    <div class="pb-12 pt-0 animate-fade-in-up">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}" aria-label="ID Verification Reviews"
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
    <div class="pb-12 pt-4">
        <div class="max-w-full 2xl:max-w-[1700px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
            <div class="flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-2 -mb-2 border-b border-slate-200 no-scrollbar whitespace-nowrap">
                <a href="{{ route('verification.reviews') }}" aria-label="Verify Tourists"
                   class="shrink-0 inline-flex items-center justify-center h-9 sm:h-10 px-3 sm:px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.reviews') || request()->routeIs('verification.accounts') ? 'bg-emerald-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
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

            {{-- Error Alerts --}}
            @if ($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 rounded-2xl px-4 py-3 text-sm shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="space-y-6">
                <div class="bg-white shadow-sm rounded-2xl overflow-hidden max-w-3xl mx-auto border border-slate-200 admin-card-hover"
                     x-data="{ 
                         emailVerified: false, 
                         otpSent: false, 
                         email: '{{ old('email') }}', 
                         contact: '{{ old('contact') }}',
                         otpCode: '',
                         countdown: 0,
                         sendingOtp: false,
                         verifyingOtp: false,
                         otpError: '',
                         otpSuccessMsg: '',
                         sendOtp() {
                             if (!this.email) {
                                 this.otpError = 'Please enter an email address first.';
                                 return;
                             }
                             const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;
                             if (!gmailRegex.test(this.email)) {
                                 this.otpError = 'Please enter a valid Gmail address (e.g. user@gmail.com).';
                                 return;
                             }
                             this.otpError = '';
                             this.otpSuccessMsg = '';
                             this.sendingOtp = true;
                             fetch('{{ route('register.send_code') }}', {
                                 method: 'POST',
                                 headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                 body: JSON.stringify({ email: this.email })
                             }).then(async r => {
                                 const d = await r.json();
                                 this.sendingOtp = false;
                                 if (!r.ok) {
                                     this.otpError = d.message || 'Error sending code.';
                                     return;
                                 }
                                 this.otpSent = true;
                                 this.otpSuccessMsg = d.message || 'A code has been sent.';
                                 this.countdown = 60;
                                 let timer = setInterval(() => {
                                     if (this.countdown <= 1) {
                                         clearInterval(timer);
                                         this.countdown = 0;
                                     } else {
                                         this.countdown--;
                                     }
                                 }, 1000);
                             }).catch(() => {
                                 this.sendingOtp = false;
                                 this.otpError = 'Connection error. Please try again.';
                             });
                         },
                         verifyOtp() {
                             if (this.otpCode.length !== 6) {
                                 this.otpError = 'Please enter a 6-digit code.';
                                 return;
                             }
                             this.otpError = '';
                             this.otpSuccessMsg = '';
                             this.verifyingOtp = true;
                             fetch('{{ route('register.verify_code') }}', {
                                 method: 'POST',
                                 headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                 body: JSON.stringify({ email: this.email, code: this.otpCode })
                             }).then(async r => {
                                 const d = await r.json();
                                 this.verifyingOtp = false;
                                 if (!r.ok) {
                                     this.otpError = d.message || 'Verification failed.';
                                     return;
                                 }
                                 this.emailVerified = true;
                                 this.otpSent = false;
                             }).catch(() => {
                                 this.verifyingOtp = false;
                                 this.otpError = 'Connection error. Please try again.';
                             });
                         }
                     }">
                     
                    <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-slate-50 to-white flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h3 class="text-base font-bold text-slate-800">Register New Staff Account</h3>
                        </div>
                        <span x-show="emailVerified" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold rounded-full transition duration-300">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Email Verified</span>
                        </span>
                    </div>

                    <form id="add-staff-form" method="POST" action="{{ route('admin.accounts.store') }}" class="p-5 sm:p-6 space-y-5">
                        @csrf
                        <input type="hidden" name="role" value="staff" />

                        {{-- Step 1: Email Verification via OTP --}}
                        <div class="space-y-3">
                            <h4 class="font-bold text-xs text-emerald-800 flex items-center gap-1.5 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>Step 1: Email Verification</span>
                            </h4>
                            
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Staff Email Address</label>
                                <div class="flex items-center gap-2">
                                    <input type="email" name="email" x-model="email" :readonly="emailVerified" placeholder="e.g. staff@gmail.com" class="flex-1 min-w-0 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-sm shadow-2xs bg-white placeholder-slate-400" required />
                                    <button type="button" @click="sendOtp()" :disabled="sendingOtp || (otpSent && countdown > 0) || emailVerified" class="shrink-0 px-3.5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-xs transition h-[38px] flex items-center justify-center gap-1.5 disabled:opacity-50 whitespace-nowrap cursor-pointer">
                                        <template x-if="sendingOtp">
                                            <svg class="animate-spin h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                        </template>
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                        </svg>
                                        <span x-text="countdown > 0 ? 'Resend ' + countdown + 's' : (otpSent ? 'Resend OTP' : 'Get OTP')"></span>
                                    </button>
                                </div>
                            </div>

                            {{-- OTP Code entry row --}}
                            <div x-show="otpSent && !emailVerified" x-transition class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-2.5">
                                <p class="text-xs text-slate-600">Please check the staff member's inbox and enter the 6-digit verification code below.</p>
                                <div class="flex flex-col sm:flex-row gap-2 items-center">
<<<<<<< Updated upstream
                                    <input type="text" x-model="otpCode" placeholder="Enter 6-digit OTP" maxlength="6" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-center text-sm shadow-sm bg-white font-mono tracking-widest" />
                                    <button type="button" @click="verifyOtp()" :disabled="verifyingOtp" class="w-full sm:w-auto px-4 py-2 bg-green-700 hover:bg-green-800 disabled:bg-gray-100 text-white rounded-lg text-xs font-bold shadow-sm transition shrink-0">
=======
                                    <input type="text" id="admin-otp-code" name="otp_code" x-model="otpCode" placeholder="Enter 6-digit OTP" maxlength="6" class="w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-center text-sm shadow-2xs bg-white font-mono tracking-widest" />
                                    <button type="button" @click="verifyOtp()" :disabled="verifyingOtp" class="w-full sm:w-auto px-4 py-2 bg-emerald-700 hover:bg-emerald-800 disabled:bg-slate-200 text-white rounded-xl text-xs font-bold shadow-xs transition shrink-0 cursor-pointer">
>>>>>>> Stashed changes
                                        <span x-show="!verifyingOtp">Verify OTP</span>
                                        <span x-show="verifyingOtp">Verifying...</span>
                                    </button>
                                </div>
                            </div>

                            {{-- OTP Alerts --}}
                            <div x-show="otpError" x-transition class="text-xs text-rose-600 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span x-text="otpError"></span>
                            </div>
                            <div x-show="otpSuccessMsg" x-transition class="text-xs text-emerald-700 font-bold flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                <span x-text="otpSuccessMsg"></span>
                            </div>
                        </div>

                        {{-- Step 2: Roster credentials & assignments --}}
                        <div :class="emailVerified ? '' : 'opacity-40 pointer-events-none'" class="space-y-4 border-t border-slate-100 pt-4 transition-all duration-300">
                            <h4 class="font-bold text-xs text-emerald-800 flex items-center gap-1.5 uppercase tracking-wider">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Step 2: Profile & Credentials</span>
                            </h4>
                            
                            {{-- Contact Number --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-700 mb-1">Active Contact Number</label>
                                <input type="text" name="contact" placeholder="e.g. 09123456789" value="{{ old('contact') }}" :required="emailVerified" :disabled="!emailVerified" class="w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-sm shadow-2xs bg-white placeholder-slate-400" />
                            </div>

                            {{-- Passwords --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                                    <input type="password" name="password" autocomplete="new-password" :required="emailVerified" :disabled="!emailVerified" class="w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-sm shadow-2xs bg-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation" autocomplete="new-password" :required="emailVerified" :disabled="!emailVerified" class="w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-sm shadow-2xs bg-white" />
                                </div>
                            </div>

                            {{-- Assign Destination --}}
                            <div class="space-y-2 border-t border-slate-100 pt-3">
                                <h4 class="font-bold text-xs text-emerald-800 flex items-center gap-1.5 uppercase tracking-wider">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Staff Destination Assignment</span>
                                </h4>
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Assigned Destination Spot</label>
                                    <input type="text" name="assigned_destination_name" list="destinations-list" :disabled="!emailVerified" placeholder="Type or select destination spot..." class="w-full border-slate-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-xl px-3.5 py-2 text-sm shadow-2xs bg-white placeholder-slate-400" value="{{ old('assigned_destination_name') }}" />
                                    <datalist id="destinations-list">
                                        @foreach($destinations as $dest)
                                            <option value="{{ $dest->name }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>

                            <div class="flex justify-end pt-3 border-t border-slate-100">
                                <button type="button" @click="if (document.getElementById('add-staff-form').reportValidity()) $dispatch('open-confirm-modal', { id: 'create-staff-modal' })" class="px-5 py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-bold shadow-sm hover:shadow transition duration-200 cursor-pointer">
                                    Create Staff Account
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>

        {{-- Create Staff Confirmation Modal --}}
        <x-confirm-modal id="create-staff-modal" title="Confirm Staff Registration" message="Are you sure you want to register this new staff account?">
            <button type="button" onclick="document.getElementById('add-staff-form').submit()" class="px-4 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 cursor-pointer">
                Confirm & Create
            </button>
        </x-confirm-modal>
    </div>
</x-app-layout>