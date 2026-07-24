<x-guest-layout>
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('login') }}"
            class="group inline-flex items-center gap-1.5 text-sm font-medium bg-white/10 hover:bg-white/20 transition-all duration-200 px-3 py-1.5 rounded-full border border-white/10" style="color: white;">
            <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="currentColor"
                viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Back to Login
        </a>
    </div>

    <div class="mb-4 text-sm" style="color: white; opacity: 0.9;">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" style="color: white;" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
