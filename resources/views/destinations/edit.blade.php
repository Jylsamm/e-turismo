<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('destinations.index') }}" class="text-gray-400 hover:text-gray-600">← Back</a>
            <h1 class="text-2xl font-bold text-gray-800">Edit — {{ $destination->name }}</h1>
        </div>
    </x-slot>

    <div class="py-10 max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-lg p-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm mb-6">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf @method('PATCH')

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destination Name *</label>
                        <input type="text" name="name" value="{{ old('name', $destination->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 outline-none"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Daily Capacity *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', $destination->capacity) }}" min="0"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 outline-none"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Availability</label>
                        <select name="availability_status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 outline-none">
                            <option value="Available" {{ $destination->availability_status === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Unavailable" {{ $destination->availability_status === 'Unavailable' ? 'selected' : '' }}>Unavailable</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                        <input type="text" name="location" value="{{ old('location', $destination->location) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 outline-none"
                            required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 outline-none resize-none">{{ old('description', $destination->description) }}</textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Replace Cover Photo</label>
                        @if($destination->photos)
                        <div class="mb-2">
                            <img src="{{ Storage::url($destination->photos) }}" class="h-24 rounded-lg object-cover">
                        </div>
                        @endif
                        <input type="file" name="photo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl py-3 transition text-sm">
                        Save Changes
                    </button>
                    <a href="{{ route('destinations.index') }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl py-3 transition text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
