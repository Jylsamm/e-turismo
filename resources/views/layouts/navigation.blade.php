<nav class="bg-transparent border-none py-4 px-6 md:px-10 flex justify-end">
    @php
        $unreadCount = \App\Models\Notification::where('recipient_id', Auth::id())->where('is_read', false)->count();
    @endphp

    {{-- Floating control widget (the pill) --}}
    <div class="bg-white shadow-[0_4px_20px_-4px_rgba(16,185,129,0.15)] rounded-full flex items-center p-1.5 gap-2 border border-gray-100 relative z-40">
        {{-- Notifications Bell Link --}}
        <div class="relative group bell-ring-hover">
            <a href="{{ route('notifications.index') }}"
                class="relative flex items-center justify-center text-gray-500 hover:text-amber-600 hover:bg-amber-100 p-2 rounded-full transition-all duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                @if($unreadCount > 0)
                <span class="absolute top-1.5 right-1.5 bg-red-500 text-white text-[9px] rounded-full h-3.5 w-3.5 flex items-center justify-center font-bold">
                    {{ $unreadCount }}
                </span>
                @endif
            </a>
            {{-- Tooltip --}}
            <div class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                Notifications
            </div>
        </div>

        <div class="h-6 w-[1px] bg-gray-200"></div>

        {{-- Settings Gear Dropdown --}}
        <div class="relative group">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition-all focus:outline-none duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 ease-in-out group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-gray-700 hover:text-green-700 hover:bg-green-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <x-dropdown-link href="#"
                            @click.prevent="$dispatch('open-confirm-modal', { id: 'logout-modal' })"
                            class="flex items-center gap-2 text-gray-700 hover:text-red-750 hover:bg-red-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
            {{-- Tooltip --}}
            <div class="absolute invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 bg-gray-900 text-white text-[11px] font-semibold px-2 py-1 rounded-md top-12 left-1/2 -translate-x-1/2 whitespace-nowrap shadow-md z-50">
                Settings
            </div>
        </div>
    </div>
</nav>
