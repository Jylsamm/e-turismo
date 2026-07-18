<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="ti ti-bell-ringing text-green-700"></i> Notifications
            </h1>
            @if($notifications->total() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button class="text-sm text-brand-700 hover:underline">Mark all as read</button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $notif)
        <div class="bg-white rounded-xl shadow-sm border-l-4 {{ $notif->is_read ? 'border-gray-200' : 'border-brand-600' }} p-5 flex items-start justify-between gap-4">
            <div class="flex-1">
                <p class="text-sm {{ $notif->is_read ? 'text-gray-500' : 'text-gray-800 font-medium' }}">
                    @php
                    $icons = [
                        'booking_alert' => '<i class="ti ti-file-text text-blue-500 mr-1.5"></i>',
                        'capacity_alert' => '<i class="ti ti-alert-triangle text-amber-500 mr-1.5"></i>',
                        'info' => '<i class="ti ti-info-circle text-blue-500 mr-1.5"></i>'
                    ];
                    echo ($icons[$notif->type] ?? '<i class="ti ti-bell text-gray-500 mr-1.5"></i>') . ' ' . $notif->message;
                    @endphp
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
            </div>
            @if(!$notif->is_read)
            <form action="{{ route('notifications.read', $notif) }}" method="POST">
                @csrf @method('PATCH')
                <button class="text-xs text-brand-600 hover:text-brand-800 whitespace-nowrap">Mark read</button>
            </form>
            @else
            <span class="text-xs text-gray-300">Read</span>
            @endif
        </div>
        @empty
        <div class="text-center py-20 text-gray-400">
            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4 text-gray-400">
                <i class="ti ti-bell-off text-3xl"></i>
            </div>
            <p class="text-lg font-medium">No notifications yet.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
