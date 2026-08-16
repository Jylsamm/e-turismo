<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="contact" :value="__('Phone Number')" />
            <x-text-input id="contact" name="contact" type="text" class="mt-1 block w-full" :value="old('contact', $user->contact)" placeholder="e.g. 09123456789" />
            <x-input-error class="mt-2" :messages="$errors->get('contact')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="" disabled {{ old('gender', $user->gender) ? '' : 'selected' }}>Select Gender</option>
                    <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('gender')" />
            </div>

            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" name="dob" type="date" class="mt-1 block w-full" :value="old('dob', $user->dob ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '')" />
                <x-input-error class="mt-2" :messages="$errors->get('dob')" />
            </div>

            <div>
                <x-input-label for="classification" :value="__('Visitor Classification')" />
                <select id="classification" name="classification" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="" disabled {{ old('classification', $user->classification) ? '' : 'selected' }}>Select Classification</option>
                    <option value="Local" {{ old('classification', $user->classification) === 'Local' ? 'selected' : '' }}>Local (General Trias)</option>
                    <option value="Domestic" {{ old('classification', $user->classification) === 'Domestic' ? 'selected' : '' }}>Domestic (Philippines)</option>
                    <option value="Foreign" {{ old('classification', $user->classification) === 'Foreign' ? 'selected' : '' }}>Foreign Tourist</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('classification')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
