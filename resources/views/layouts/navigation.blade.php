<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo / Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <x-application-logo class="h-12 w-auto object-contain" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->isStaff())
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('staff.bookings.index')" :active="request()->routeIs('staff.bookings.*')">
                            Bookings
                        </x-nav-link>
                        <x-nav-link :href="route('checkins.create')" :active="request()->routeIs('checkins.*')">
                            Check-In
                        </x-nav-link>
                        <x-nav-link :href="route('spots.index')" :active="request()->routeIs('spots.*')">
                            Spot Status
                        </x-nav-link>
                        <x-nav-link :href="route('staff.walkins.create')" :active="request()->routeIs('staff.walkins.*')">
                            Walk-In
                        </x-nav-link>

                    @else
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')">
                            Destinations
                        </x-nav-link>
                        @if(!Auth::user()->isAdmin())
                            <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')">
                                Bookings
                            </x-nav-link>
                        @endif
                    @endif

                    @if(Auth::user()->isTourist())
                        <x-nav-link :href="route('bookings.my-tickets')" :active="request()->routeIs('bookings.my-tickets')">
                            My Tickets
                        </x-nav-link>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <x-nav-link :href="route('verification.admin')" :active="request()->routeIs('verification.admin')">
                            Accounts &amp; Verification
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            Reports
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Right side: Notifications + User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">

                {{-- Notifications Bell --}}
                @php
                    $unreadCount = \App\Models\Notification::where('recipient_id', Auth::id())->where('is_read', false)->count();
                @endphp
                <a href="{{ route('notifications.index') }}"
                    class="relative inline-flex items-center text-gray-500 hover:text-brand-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 10-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if($unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center font-bold">
                        {{ $unreadCount }}
                    </span>
                    @endif
                </a>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-750 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-505 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            @if(Auth::user()->isStaff())
                <x-responsive-nav-link :href="route('staff.bookings.index')" :active="request()->routeIs('staff.bookings.*')">Bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('checkins.create')" :active="request()->routeIs('checkins.*')">Check-In</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('spots.index')" :active="request()->routeIs('spots.*')">Spot Status</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('staff.walkins.create')" :active="request()->routeIs('staff.walkins.*')">Walk-In</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('destinations.index')" :active="request()->routeIs('destinations.*')">Destinations</x-responsive-nav-link>
                @if(!Auth::user()->isAdmin())
                    <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')">Bookings</x-responsive-nav-link>
                @endif
            @endif

            @if(Auth::user()->isTourist())
                <x-responsive-nav-link :href="route('bookings.my-tickets')" :active="request()->routeIs('bookings.my-tickets')">My Tickets</x-responsive-nav-link>
            @endif

            @if(Auth::user()->isAdmin())
            <x-responsive-nav-link :href="route('verification.admin')" :active="request()->routeIs('verification.admin')">Accounts &amp; Verification</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">Reports</x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('notifications.index')">
                Notifications @if($unreadCount > 0) ({{ $unreadCount }}) @endif
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                <div class="text-xs bg-brand-100 text-brand-700 px-1.5 py-0.5 rounded-full capitalize inline-block mt-1">{{ Auth::user()->role }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
