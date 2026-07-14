<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Add New Destination</h1>
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

            <form action="{{ route('destinations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Destination Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-400 outline-none transition"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Initials / Code *</label>
                        <input type="text" name="initials" value="{{ old('initials') }}" maxlength="10"
                            placeholder="e.g. BTL"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm uppercase focus:ring-2 focus:ring-brand-400 outline-none transition"
                            required>
                        <p class="text-xs text-gray-400 mt-1">Used as prefix for QR ticket codes.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Daily Capacity *</label>
                        <input type="number" name="capacity" value="{{ old('capacity', 50) }}" min="1"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-400 outline-none transition"
                            required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Location *</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            placeholder="Municipality, Province"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-400 outline-none transition"
                            required>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-brand-400 outline-none transition resize-none">{{ old('description') }}</textarea>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cover Photo</label>
                        <input type="file" name="photo" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-brand-50 file:text-brand-700 hover:file:bg-brand-100">
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="submit"
                        class="flex-1 bg-brand-700 hover:bg-brand-800 text-white font-semibold rounded-xl py-3 transition text-sm">
                        Register Destination
                    </button>
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-xl py-3 transition text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
