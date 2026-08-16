<x-guest-layout>
    <style>
        /* ── Hide Edge's native password reveal eye ── */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        /* ── Smooth Fade Animation ── */
        .auth-fade {
            transition: opacity 0.25s ease-out, transform 0.25s ease-out;
        }

        /* ── Thicker & Accurate Progress Bar Styling ── */
        .progress-track-custom {
            height: 6px !important;
            width: 100% !important;
            max-width: 240px !important;
            margin: 1.5rem auto 0 auto !important;
            background: rgba(255, 255, 255, 0.2) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            border-radius: 9999px !important;
            overflow: hidden !important;
            position: relative !important;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.5);
        }

        .progress-bar-custom {
            height: 100% !important;
            border-radius: 9999px !important;
            background: linear-gradient(90deg, #10b981 0%, #34d399 50%, #10b981 100%) !important;
            box-shadow: 0 0 16px rgba(16, 185, 129, 0.9), 0 0 8px rgba(52, 211, 153, 0.8) !important;
            width: 0%;
        }

        .progress-bar-custom.active-fill {
            animation: fillAccurate 1.1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards !important;
        }

        @keyframes fillAccurate {
            0% {
                width: 0%;
            }

            35% {
                width: 45%;
            }

            75% {
                width: 85%;
            }

            100% {
                width: 100%;
            }
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Container holding the login form -->
    <div id="login-form-container" class="auth-fade">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('home') }}"
                class="group inline-flex items-center gap-1.5 text-sm font-medium bg-white/10 hover:bg-white/20 transition-all duration-200 px-3 py-1.5 rounded-full border border-white/10"
                style="color: white;">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </div>



        <!-- Quick Demo Login Accounts Section -->
        <div class="mb-5 p-3 sm:p-3.5 rounded-xl bg-white/10 border border-white/15 backdrop-blur-md shadow-lg">
            <div class="flex items-center justify-between mb-2">
                <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-emerald-300 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Demo Login
                </span>
                <span class="text-[10px] sm:text-[11px] text-gray-300 font-medium">Auto-fill</span>
            </div>

            <div class="grid grid-cols-3 gap-1.5 sm:gap-2">
                <!-- Admin Button -->
                <button type="button" onclick="fillQuickLogin('admin@eturismo.com', 'omsi2026')"
                    class="group flex flex-col items-center justify-center p-1.5 sm:p-2 rounded-lg bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 hover:border-red-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-red-400 animate-pulse"></span>
                        <span class="text-[11px] sm:text-xs font-bold text-red-100 group-hover:text-white">Admin</span>
                    </div>
                    <span
                        class="text-[9px] sm:text-[10px] text-red-200/80 truncate w-full text-center mt-0.5 font-medium">admin@...</span>
                </button>

                <!-- Staff Button -->
                <button type="button" onclick="fillQuickLogin('staff@eturismo.com', 'password')"
                    class="group flex flex-col items-center justify-center p-1.5 sm:p-2 rounded-lg bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/40 hover:border-blue-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-blue-400"></span>
                        <span class="text-[11px] sm:text-xs font-bold text-blue-100 group-hover:text-white">Staff</span>
                    </div>
                    <span
                        class="text-[9px] sm:text-[10px] text-blue-200/80 truncate w-full text-center mt-0.5 font-medium">staff@...</span>
                </button>

                <!-- Tourist Button -->
                <button type="button" onclick="fillQuickLogin('jylsam123@gmail.com', 'password')"
                    class="group flex flex-col items-center justify-center p-1.5 sm:p-2 rounded-lg bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 hover:border-emerald-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-400"></span>
                        <span class="text-[11px] sm:text-xs font-bold text-emerald-100 group-hover:text-white">Tourist</span>
                    </div>
                    <span
                        class="text-[9px] sm:text-[10px] text-emerald-200/80 truncate w-full text-center mt-0.5 font-medium">jylsam@...</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" style="color: white;" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-200 font-semibold" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" style="color: white;" />

                <div class="relative mt-1">
                    <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required
                        autocomplete="current-password" />
                    <button type="button" onclick="togglePassword('password', this)"
                        class="password-toggle-btn toggled-hidden" aria-label="Show password" aria-pressed="false">
                        <svg class="w-5 h-5 eye-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path class="eye-lid" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
                            <circle class="eye-pupil" cx="12" cy="12" r="3"></circle>
                            <line class="eye-slash" x1="4" y1="20" x2="20" y2="4"></line>
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-200 font-semibold" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                    <span class="ms-2 text-xs sm:text-sm" style="color: white;">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-xs sm:text-sm hover:text-emerald-300 transition-colors"
                        style="color: white;" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Log In Submit Button -->
            <div class="mt-5">
                <button type="submit" id="login-submit-btn"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl font-bold uppercase tracking-wide text-sm transition-all duration-200"
                    style="background-color: #10b981; color: #fff; border: none; cursor: pointer; box-shadow: 0 4px 14px rgba(16,185,129,0.35);">
                    <span id="btn-text" class="flex items-center gap-2">
                        {{ __('Log in') }}
                    </span>
                    <span id="btn-spinner" class="flex items-center gap-2" style="display: none;">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span>Validating credentials...</span>
                    </span>
                </button>
            </div>

            @if (Route::has('register'))
                <div class="mt-6 text-center pt-4 border-t border-white/15">
                    <p class="text-xs sm:text-sm" style="color: white;">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}"
                            class="font-semibold text-emerald-400 hover:text-emerald-300 hover:underline transition-colors duration-200 ml-1">
                            {{ __('Register here') }}
                        </a>
                    </p>
                </div>
            @endif
        </form>
    </div>

    <script>
        // Quick Fill Helper for Demo Accounts
        window.fillQuickLogin = function (email, password) {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            if (emailInput && passwordInput) {
                emailInput.value = email;
                passwordInput.value = password;

                emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                emailInput.dispatchEvent(new Event('change', { bubbles: true }));
                passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
                passwordInput.dispatchEvent(new Event('change', { bubbles: true }));

                [emailInput, passwordInput].forEach(el => {
                    el.style.transition = 'all 0.3s ease';
                    el.style.borderColor = '#34d399';
                    el.style.boxShadow = '0 0 14px rgba(52, 211, 153, 0.5)';
                    setTimeout(() => {
                        el.style.borderColor = '';
                        el.style.boxShadow = '';
                    }, 600);
                });
            }
        };

        (function () {
            const form = document.getElementById('login-form');
            let isSubmitting = false;

            if (form) {
                form.addEventListener('submit', function (e) {
                    if (isSubmitting) {
                        e.preventDefault();
                        return;
                    }

                    isSubmitting = true;

                    const submitBtn = document.getElementById('login-submit-btn');
                    const btnText = document.getElementById('btn-text');
                    const btnSpin = document.getElementById('btn-spinner');

                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.style.opacity = '0.75';
                        submitBtn.style.cursor = 'not-allowed';
                    }
                    if (btnText) btnText.style.display = 'none';
                    if (btnSpin) btnSpin.style.display = 'inline-flex';
                });
            }

            // Realtime Lockout Countdown Timer
            document.addEventListener('DOMContentLoaded', function () {
                const errorElements = document.querySelectorAll('.text-rose-200, .text-red-600, ul li, p');
                errorElements.forEach(function (el) {
                    const text = el.textContent || '';
                    const match = text.match(/in\s+(\d+)\s+seconds?/i);
                    if (match && match[1]) {
                        let remaining = parseInt(match[1], 10);
                        const submitBtn = document.getElementById('login-submit-btn');

                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.style.opacity = '0.5';
                            submitBtn.style.cursor = 'not-allowed';
                        }

                        const interval = setInterval(function () {
                            remaining--;
                            if (remaining > 0) {
                                el.textContent = text.replace(/in\s+\d+\s+seconds?/i, `in ${remaining} seconds`);
                            } else {
                                clearInterval(interval);
                                el.textContent = "Lockout expired. You may now try logging in again.";
                                el.className = "mt-2 text-emerald-300 font-bold";
                                if (submitBtn) {
                                    submitBtn.disabled = false;
                                    submitBtn.style.opacity = '1';
                                    submitBtn.style.cursor = 'pointer';
                                }
                            }
                        }, 1000);
                    }
                });
            });
        })();
    </script>
</x-guest-layout>