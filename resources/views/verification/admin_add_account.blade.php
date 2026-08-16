<x-app-layout>
    @push('head')
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
                <i class="ti ti-user-plus text-2xl text-emerald-700"></i>
                <span>Add Account</span>
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Sub-Navigation Tabs -->
            <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
                <a href="{{ route('verification.reviews') }}" aria-label="ID Verification Reviews"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.reviews') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-checklist text-base shrink-0 mr-1.5"></i>
                    <span>ID Verification Reviews</span>
                </a>
                <a href="{{ route('verification.accounts') }}" aria-label="Verify Tourists"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.accounts') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-users text-base shrink-0 mr-1.5"></i>
                    <span>Verify Tourists</span>
                </a>
                <a href="{{ route('verification.staff') }}" aria-label="Manage Staff"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.staff') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-user-cog text-base shrink-0 mr-1.5"></i>
                    <span>Manage Staff</span>
                </a>
                <a href="{{ route('verification.add_account') }}" aria-label="Add Account"
                   class="inline-flex items-center justify-center h-10 px-4 text-xs sm:text-sm font-bold rounded-xl transition-colors duration-150 {{ request()->routeIs('verification.add_account') ? 'bg-emerald-700 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                    <i class="ti ti-user-plus text-base shrink-0 mr-1.5"></i>
                    <span>Add Account</span>
                </a>
            </div>

            {{-- Error Alerts --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-2xl px-4 py-3 text-sm shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-2xl px-4 py-3 text-sm shadow-sm flex items-center gap-2">
                <i class="ti ti-circle-check text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <div class="space-y-6">
                <div class="bg-white shadow rounded-xl overflow-hidden max-w-3xl mx-auto border border-gray-200 admin-card-hover"
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
                             // Gmail validation regex matching standard registration rules
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
                     
                    <div class="px-5 py-3 border-b border-gray-100 bg-gradient-to-r from-gray-50/50 to-white flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-gray-800">Register New Staff</h3>
                        </div>
                        <span x-show="emailVerified" class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-green-50 text-green-700 border border-green-200 text-xs font-bold rounded-full transition duration-300">
                            <i class="ti ti-shield-check"></i> Email Verified
                        </span>
                    </div>

                    <form id="add-staff-form" method="POST" action="{{ route('admin.accounts.store') }}" class="p-5 space-y-4">
                        @csrf
                        <input type="hidden" name="role" value="staff" />

                        {{-- Step 1: Email Verification via OTP --}}
                        <div class="space-y-3">
                            <h4 class="font-bold text-xs text-brand-700 flex items-center gap-1 uppercase tracking-wide">
                                <i class="ti ti-mail text-brand-600"></i> Email Verification
                            </h4>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address</label>
                                <div class="flex items-center gap-2">
                                    <input type="email" name="email" x-model="email" :readonly="emailVerified" placeholder="e.g. staff@gmail.com" class="flex-1 min-w-0 border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" required />
                                    <button type="button" @click="sendOtp()" :disabled="sendingOtp || (otpSent && countdown > 0) || emailVerified" class="shrink-0 px-3 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg text-xs font-bold shadow-sm transition h-[36px] flex items-center justify-center gap-1 disabled:opacity-50 whitespace-nowrap">
                                        <template x-if="sendingOtp">
                                            <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                        </template>
                                        <i class="ti ti-mail-forward text-sm"></i>
                                        <span x-text="countdown > 0 ? 'Resend ' + countdown + 's' : (otpSent ? 'Resend OTP' : 'Get OTP')"></span>
                                    </button>
                                </div>
                            </div>

                            {{-- OTP Code entry row --}}
                            <div x-show="otpSent && !emailVerified" x-transition class="p-3 bg-gray-50 border border-gray-200 rounded-xl space-y-2">
                                <p class="text-xs text-gray-500">Please check the staff member's inbox and enter the 6-digit code below.</p>
                                <div class="flex flex-col sm:flex-row gap-2 items-center">
                                    <input type="text" id="admin-otp-code" name="otp_code" x-model="otpCode" placeholder="Enter 6-digit OTP" maxlength="6" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-center text-sm shadow-sm bg-white font-mono tracking-widest" />
                                    <button type="button" @click="verifyOtp()" :disabled="verifyingOtp" class="w-full sm:w-auto px-4 py-2 bg-green-700 hover:bg-green-800 disabled:bg-gray-100 text-white rounded-lg text-xs font-bold shadow-sm transition shrink-0">
                                        <span x-show="!verifyingOtp">Verify OTP</span>
                                        <span x-show="verifyingOtp">Verifying...</span>
                                    </button>
                                </div>
                            </div>

                            {{-- OTP Alerts --}}
                            <div x-show="otpError" x-transition class="text-xs text-red-600 font-semibold flex items-center gap-1">
                                <i class="ti ti-alert-circle"></i> <span x-text="otpError"></span>
                            </div>
                            <div x-show="otpSuccessMsg" x-transition class="text-xs text-green-600 font-semibold flex items-center gap-1">
                                <i class="ti ti-circle-check"></i> <span x-text="otpSuccessMsg"></span>
                            </div>
                        </div>

                        {{-- Step 2: Roster credentials & assignments --}}
                        <div :class="emailVerified ? '' : 'opacity-40 pointer-events-none'" class="space-y-3 border-t pt-4 transition-all duration-300">
                            
                            {{-- Contact Number --}}
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Active Contact Number</label>
                                <input type="text" name="contact" placeholder="e.g. 09123456789" value="{{ old('contact') }}" :required="emailVerified" :disabled="!emailVerified" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                            </div>

                            {{-- Passwords --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Password</label>
                                    <input type="password" name="password" autocomplete="new-password" :required="emailVerified" :disabled="!emailVerified" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Confirm Password</label>
                                    <input type="password" name="password_confirmation" autocomplete="new-password" :required="emailVerified" :disabled="!emailVerified" class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" />
                                </div>
                            </div>

                            {{-- Assign Destination --}}
                            <div class="space-y-2 border-t pt-3">
                                <h4 class="font-bold text-xs text-brand-700 flex items-center gap-1 uppercase tracking-wide">
                                    <i class="ti ti-map-pin text-brand-600"></i> Staff Assignment
                                </h4>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1">Assign Destination Spot</label>
                                    <input type="text" name="assigned_destination_name" list="destinations-list" :disabled="!emailVerified" placeholder="Type or select destination spot..." class="w-full border-gray-200 focus:border-brand-500 focus:ring-brand-500 rounded-lg px-3 py-2 text-sm shadow-sm bg-white" value="{{ old('assigned_destination_name') }}" />
                                    <datalist id="destinations-list">
                                        @foreach($destinations as $dest)
                                            <option value="{{ $dest->name }}"></option>
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>

                            <div class="flex justify-end pt-2 border-t">
                                <button type="button" @click="if (document.getElementById('add-staff-form').reportValidity()) $dispatch('open-confirm-modal', { id: 'create-staff-modal' })" class="px-5 py-2 bg-green-700 hover:bg-green-800 text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow transition duration-200 hover:-translate-y-0.5 active:translate-y-0">
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
            <button type="button" onclick="document.getElementById('add-staff-form').submit()" class="px-4 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Confirm & Create
            </button>
        </x-confirm-modal>
    </div>
</x-app-layout>