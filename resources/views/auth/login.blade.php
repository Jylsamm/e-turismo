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
            class="group inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 transition-all duration-200 px-3 py-1.5 rounded-full">
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
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1">
                <x-text-input id="password" class="block w-full pr-12" type="password" name="password" required
                    autocomplete="current-password" />
                <button type="button" onclick="togglePassword('password', this)"
                    class="text-gray-400 hover:text-gray-600 focus:outline-none"
                    style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);">
                    <svg class="w-5 h-5 eye-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M128,56C48,56,16,128,16,128s32,72,112,72,112-72,112-72S208,56,128,56Z"
                            fill="currentColor" opacity="0.2"></path>
                        <path d="M128,56C48,56,16,128,16,128s32,72,112,72,112-72,112-72S208,56,128,56Z" fill="none"
                            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16">
                        </path>
                        <circle cx="128" cy="128" r="32" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="16"></circle>
                    </svg>
                    <svg class="w-5 h-5 eye-slash-icon hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                        <path d="M53.9,190.4A105.8,105.8,0,0,1,16,128s32-72,112-72a114.3,114.3,0,0,1,55.3,14.2"
                            fill="currentColor" opacity="0.2"></path>
                        <path d="M109.8,155.6a32,32,0,0,1-37.4-37.4M240,128s-32,72-112,72a114.3,114.3,0,0,1-55.3-14.2"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16"></path>
                        <path d="M53.9,190.4A105.8,105.8,0,0,1,16,128s32-72,112-72a114.3,114.3,0,0,1,55.3,14.2"
                            fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="16"></path>
                        <path d="M150.6,150.6a32,32,0,0,1-40.8-40.8" fill="none" stroke="currentColor"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="16"></path>
                        <line x1="40" y1="40" x2="216" y2="216" fill="none" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="16"></line>
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
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="mt-8 text-center pt-4 border-t border-gray-100">
                <p class="text-sm text-gray-600">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-800 hover:underline transition-colors duration-200 ml-1">
                        {{ __('Register here') }}
                    </a>
                </p>
            </div>
        @endif
    </form>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const eye = btn.querySelector('.eye-icon');
            const eyeSlash = btn.querySelector('.eye-slash-icon');
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.add('hidden');
                eyeSlash.classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.classList.remove('hidden');
                eyeSlash.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>