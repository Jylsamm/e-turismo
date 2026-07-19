<x-app-layout>
    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .tab-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 12px 4px;
            font-size: 14px;
            font-weight: 500;
            color: #9ca3af;
            border-bottom: 2px solid transparent;
            text-decoration: none;
        }
        .tab-link.active {
            color: #15803d;
            border-color: #15803d;
            font-weight: 600;
        }
        .gallery-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .gallery-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.08);
        }
    </style>

    <div x-data="{ deleteUrl: '' }" class="pb-8 pt-0 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Sub-Navigation Tabs -->
        <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3 mb-6">
            <a href="{{ route('spots.index') }}"
                class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.index') || request()->routeIs('spots.dashboard') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                <i class="ti ti-chart-bar mr-1"></i> Spot Status
            </a>
            @php
                $activeDestinationId = Auth::check() ? Auth::user()->assigned_destination_id : null;
            @endphp
            @if($activeDestinationId)
                <a href="{{ route('spots.edit', $activeDestinationId) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.edit') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-edit mr-1"></i> Edit Details
                </a>
                <a href="{{ route('spots.gallery', $activeDestinationId) }}"
                    class="px-4 py-2 text-sm font-semibold rounded-xl transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0 {{ request()->routeIs('spots.gallery') ? 'bg-green-700 text-white shadow-md shadow-green-700/15' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-100 hover:shadow-sm' }}">
                    <i class="ti ti-photo mr-1"></i> Image Gallery
                </a>
            @endif
        </div>

        {{-- Upload Area --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm mb-6">
            <form action="{{ route('spots.images.upload', $spot) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <label class="block text-sm font-semibold text-gray-700">Upload New Photo</label>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    <input type="file" name="image" accept="image/*" 
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-200 rounded-xl p-1" required>
                    <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-semibold rounded-xl px-5 py-2.5 transition text-sm shrink-0 flex items-center justify-center gap-1.5">
                        <i class="ti ti-upload"></i> Upload Photo
                    </button>
                </div>
            </form>
        </div>

        {{-- Photo List --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($spot->images as $img)
                <div class="gallery-card relative group bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                    <img src="{{ asset('storage/' . $img->path) }}" class="w-full h-48 object-cover" alt="Spot photo">
                    <div class="p-4 flex items-center justify-between border-t border-gray-50">
                        <div class="flex items-center gap-1.5">
                            @if($img->is_primary)
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-700 bg-green-50 px-2.5 py-1 rounded-full border border-green-100">
                                    <i class="ti ti-star-filled" style="font-size: 11px;"></i> Primary Cover
                                </span>
                            @else
                                <form action="{{ route('spots.images.primary', $img) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-gray-500 hover:text-green-700 font-semibold flex items-center gap-1">
                                        <i class="ti ti-star"></i> Set as Cover
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <button type="button" 
                                @click="deleteUrl = '{{ route('spots.images.delete', $img) }}'; $dispatch('open-confirm-modal', { id: 'delete-photo-modal' })"
                                class="text-red-500 hover:text-red-700 p-1.5 rounded-lg hover:bg-red-50 transition" 
                                title="Delete image">
                            <i class="ti ti-trash" style="font-size:16px;"></i>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-sm">
                    <div class="flex flex-col items-center gap-2 text-gray-400">
                        <i class="ti ti-photo" style="font-size:36px;"></i>
                        <span class="text-sm">No photos uploaded yet for this spot.</span>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Delete Photo Confirmation Modal --}}
        <x-confirm-modal id="delete-photo-modal" title="Delete Photo" message="Are you sure you want to delete this photo? This action cannot be undone.">
            <form method="POST" :action="deleteUrl">
                @csrf
                @method('DELETE')
                <button type="submit" @click.stop class="px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete
                </button>
            </form>
        </x-confirm-modal>
    </div>
</x-app-layout>
