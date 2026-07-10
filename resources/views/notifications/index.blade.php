<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800">🔔 Notifications</h1>
            @if($notifications->total() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button class="text-sm text-indigo-600 hover:underline">Mark all as read</button>
            </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $notif)
        <div class="bg-white rounded-xl shadow-sm border-l-4 {{ $notif->is_read ? 'border-gray-200' : 'border-indigo-500' }} p-5 flex items-start justify-between gap-4">
            <div class="flex-1">
                <p class="text-sm {{ $notif->is_read ? 'text-gray-500' : 'text-gray-800 font-medium' }}">
                    @php
                    $icons = ['booking_alert'=>'📋','capacity_alert'=>'⚠️','info'=>'ℹ️'];
                    echo ($icons[$notif->type] ?? '🔔') . ' ' . $notif->message;
                    @endphp
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
            </div>
            @if(!$notif->is_read)
            <form action="{{ route('notifications.read', $notif) }}" method="POST">
                @csrf @method('PATCH')
                <button class="text-xs text-indigo-500 hover:text-indigo-700 whitespace-nowrap">Mark read</button>
            </form>
            @else
            <span class="text-xs text-gray-300">Read</span>
            @endif
        </div>
        @empty
        <div class="text-center py-20 text-gray-400">
            <p class="text-5xl mb-4">🔕</p>
            <p class="text-lg font-medium">No notifications yet.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>
