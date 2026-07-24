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