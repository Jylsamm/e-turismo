<x-guest-layout>
    <style>
        /* ── Hide Edge's native password reveal eye to prevent duplication with custom toggle ── */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

<<<<<<< Updated upstream
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
=======
    <!-- Container holding the login form -->
    <div id="login-form-container" class="auth-fade">
        <!-- Back Button -->
        <div class="mb-5 md:mb-6">
            <a href="{{ route('home') }}"
                class="group inline-flex items-center gap-2 text-sm sm:text-base font-semibold bg-white/10 hover:bg-white/20 transition-all duration-200 px-4 py-2 rounded-full border border-white/15"
                style="color: white;">
                <svg class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-200 group-hover:-translate-x-0.5" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back
            </a>
        </div>

        <!-- Quick Demo Login Accounts Section -->
        <div class="mb-5 md:mb-6 p-3.5 sm:p-4 md:p-5 rounded-xl md:rounded-2xl bg-white/10 border border-white/15 backdrop-blur-md shadow-lg">
            <div class="flex items-center justify-between mb-2.5 md:mb-3">
                <span class="text-xs sm:text-sm md:text-base font-bold uppercase tracking-wider text-emerald-300 flex items-center gap-2">
                    <svg class="w-4 h-4 md:w-5 md:h-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Demo Login
                </span>
                <span class="text-xs sm:text-sm text-gray-300 font-medium">Auto-fill</span>
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-2.5 md:gap-3">
                <!-- Admin Button -->
                <button type="button" onclick="fillQuickLogin('admin@eturismo.com', 'omsi2026')"
                    class="group flex flex-col items-center justify-center p-2.5 sm:p-3 md:p-3.5 rounded-xl bg-red-500/20 hover:bg-red-500/30 border border-red-500/40 hover:border-red-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-400 animate-pulse"></span>
                        <span class="text-xs sm:text-sm md:text-base font-bold text-red-100 group-hover:text-white">Admin</span>
                    </div>
                    <span
                        class="text-xs sm:text-sm text-red-200/80 truncate w-full text-center mt-0.5 md:mt-1 font-medium">admin@...</span>
                </button>

                <!-- Staff Button -->
                <button type="button" onclick="fillQuickLogin('staff@eturismo.com', 'password')"
                    class="group flex flex-col items-center justify-center p-2.5 sm:p-3 md:p-3.5 rounded-xl bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/40 hover:border-blue-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                        <span class="text-xs sm:text-sm md:text-base font-bold text-blue-100 group-hover:text-white">Staff</span>
                    </div>
                    <span
                        class="text-xs sm:text-sm text-blue-200/80 truncate w-full text-center mt-0.5 md:mt-1 font-medium">staff@...</span>
                </button>

                <!-- Tourist Button -->
                <button type="button" onclick="fillQuickLogin('jylsam123@gmail.com', 'password')"
                    class="group flex flex-col items-center justify-center p-2.5 sm:p-3 md:p-3.5 rounded-xl bg-emerald-500/20 hover:bg-emerald-500/30 border border-emerald-500/40 hover:border-emerald-400 transition-all duration-200 text-center cursor-pointer">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <span class="text-xs sm:text-sm md:text-base font-bold text-emerald-100 group-hover:text-white">Tourist</span>
                    </div>
                    <span
                        class="text-xs sm:text-sm text-emerald-200/80 truncate w-full text-center mt-0.5 md:mt-1 font-medium">jylsam@...</span>
                </button>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <x-input-label for="email" :value="__('Email')" class="text-base sm:text-lg md:text-xl font-extrabold" style="color: white;" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-200 font-semibold text-xs sm:text-sm" />
            </div>

            <!-- Password -->
            <div class="mt-5 md:mt-6 space-y-2">
                <x-input-label for="password" :value="__('Password')" class="text-base sm:text-lg md:text-xl font-extrabold" style="color: white;" />

                <div class="relative mt-1">
                    <x-text-input id="password" class="block w-full pr-14 md:pr-16" type="password" name="password" required
                        autocomplete="current-password" />
                    <button type="button" onclick="togglePassword('password', this)"
                        class="password-toggle-btn toggled-hidden" aria-label="Show password" aria-pressed="false">
                        <svg class="w-6 h-6 md:w-7 md:h-7 eye-icon-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path class="eye-lid" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path>
                            <circle class="eye-pupil" cx="12" cy="12" r="3"></circle>
                            <line class="eye-slash" x1="4" y1="20" x2="20" y2="4"></line>
                        </svg>
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-200 font-semibold text-xs sm:text-sm" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between mt-4 md:mt-5">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" type="checkbox"
                        class="w-4 h-4 sm:w-5 sm:h-5 rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                    <span class="ms-2 text-sm sm:text-base font-medium" style="color: white;">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm sm:text-base font-medium hover:text-emerald-300 transition-colors"
                        style="color: white;" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Log In Submit Button -->
            <div class="mt-6 md:mt-7">
                <button type="submit" id="login-submit-btn"
                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 sm:py-4 rounded-xl md:rounded-2xl font-bold uppercase tracking-wide text-base sm:text-lg transition-all duration-200 cursor-pointer"
                    style="background-color: #10b981; color: #fff; border: none; box-shadow: 0 4px 16px rgba(16,185,129,0.35);">
                    <span id="btn-text" class="flex items-center gap-2">
                        {{ __('Log in') }}
                    </span>
                    <span id="btn-spinner" class="flex items-center gap-2" style="display: none;">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
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
                <div class="mt-6 md:mt-8 text-center pt-4 md:pt-5 border-t border-white/15">
                    <p class="text-sm sm:text-base font-medium" style="color: white;">
                        {{ __("Don't have an account?") }}
                        <a href="{{ route('register') }}"
                            class="font-semibold text-emerald-400 hover:text-emerald-300 hover:underline transition-colors duration-200 ml-1">
                            {{ __('Register here') }}
                        </a>
                    </p>
                </div>
            @endif
        </form>
>>>>>>> Stashed changes
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" style="color: white;" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" style="color: white;" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required
                    autocomplete="current-password" />
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

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500" name="remember">
                <span class="ms-2 text-sm" style="color: white;">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500" style="color: white;"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="mt-8 text-center pt-4 border-t border-white/20">
                <p class="text-sm" style="color: white;">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="font-semibold text-emerald-400 hover:text-emerald-300 hover:underline transition-colors duration-200 ml-1">
                        {{ __('Register here') }}
                    </a>
                </p>
            </div>
        @endif
    </form>


</x-guest-layout>