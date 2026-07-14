<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ti ti-user-plus text-green-700"></i> Walk-In Registration
        </h1>
        <p class="text-sm text-gray-500 mt-1">Register walk-in visitors for immediate entry</p>
    </x-slot>

    @push('head')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    @endpush

    <style>
        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .stat-label {
            font-size: 11px;
            color: #9ca3af;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }
    </style>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6" x-data="walkinForm({{ $destination->capacity }}, {{ $currentVisitors }})">
        
        {{-- Flash Messages --}}
        @if(session('error'))
            <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg flex items-center gap-2">
                <i class="ti ti-alert-triangle" style="font-size:18px;"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- 1. Header Quick Stats Row --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card shadow-sm">
                <div class="stat-icon bg-green-50 text-green-700">
                    <i class="ti ti-user-check"></i>
                </div>
                <div>
                    <div class="stat-label">Walk-ins Today</div>
                    <div class="stat-value">{{ $todayWalkins }}</div>
                </div>
            </div>
            <div class="stat-card shadow-sm">
                <div class="stat-icon bg-blue-50 text-blue-700">
                    <i class="ti ti-users"></i>
                </div>
                <div>
                    <div class="stat-label">Total This Month</div>
                    <div class="stat-value">{{ $totalWalkinsMonth }}</div>
                </div>
            </div>
            <div class="stat-card shadow-sm">
                <div class="stat-icon bg-purple-50 text-purple-700">
                    <i class="ti ti-map-pin"></i>
                </div>
                <div>
                    <div class="stat-label">Destination Capacity</div>
                    <div class="stat-value">
                        <span x-text="currentCount"></span> / <span x-text="capacity"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Main Form & Side Capacity Alert column --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            {{-- Left/Primary Form Column --}}
            <form action="{{ route('staff.walkins.store') }}" method="POST" class="lg:col-span-8 space-y-4">
                @csrf

                {{-- Capacity Warning Banner --}}
                <div class="bg-amber-50 border border-amber-300 text-amber-800 px-4 py-3 rounded-xl flex items-start gap-3" x-show="isOverCapacity" style="display: none;">
                    <i class="ti ti-alert-triangle text-xl shrink-0 mt-0.5"></i>
                    <div>
                        <div class="font-bold">Destination Limit Check</div>
                        <p class="text-sm">This destination is at capacity. Submitting this registration will exceed the maximum threshold.</p>
                    </div>
                </div>

                {{-- Dynamic Visitors Repeat List --}}
                <div class="space-y-4">
                    <template x-for="(visitor, index) in visitors" :key="index">
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4 relative">
                            
                            {{-- Header index badge & Remove Action --}}
                            <div class="flex justify-between items-center border-b border-gray-100 pb-3">
                                <h3 class="font-bold text-gray-800 text-sm flex items-center gap-2">
                                    <i class="ti ti-user text-green-700"></i> Visitor #<span x-text="index + 1"></span>
                                </h3>
                                <button type="button" x-show="visitors.length > 1" @click="removeVisitor(index)" class="text-red-500 hover:text-red-700 text-xs font-semibold flex items-center gap-1">
                                    <i class="ti ti-trash"></i> Remove
                                </button>
                            </div>

                            {{-- Input Fields --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" :name="'visitors['+index+'][name]'" x-model="visitor.name" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Age *</label>
                                    <input type="number" :name="'visitors['+index+'][age]'" x-model.number="visitor.age" min="1" max="150" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <input type="tel" :name="'visitors['+index+'][contact_number]'" x-model="visitor.contact_number" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                    <input type="email" :name="'visitors['+index+'][email]'" x-model="visitor.email" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Classification *</label>
                                    <div class="relative">
                                        <select :name="'visitors['+index+'][classification]'" x-model="visitor.classification" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-green-400 outline-none appearance-none" required>
                                            <option value="Local">Local</option>
                                            <option value="Domestic Tourist">Domestic Tourist</option>
                                            <option value="International Tourist">International Tourist</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
                                            <i class="ti ti-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Add Another Visitor trigger button --}}
                <div class="flex justify-start">
                    <button type="button" @click="addVisitor()" class="bg-green-50 hover:bg-green-100 text-green-700 font-bold py-2.5 px-5 rounded-xl text-xs flex items-center gap-1.5 border border-green-200 transition">
                        <i class="ti ti-plus"></i> Add Another Visitor
                    </button>
                </div>

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-6 py-2.5 rounded-xl text-sm flex items-center gap-1.5 transition">
                        <i class="ti ti-x"></i> Cancel
                    </a>
                    <button type="submit" :disabled="isOverCapacity" :class="isOverCapacity ? 'opacity-50 cursor-not-allowed bg-green-700' : 'bg-green-700 hover:bg-green-800'" class="text-white font-bold px-6 py-2.5 rounded-xl text-sm flex items-center gap-1.5 transition shadow-sm">
                        <i class="ti ti-check"></i> Register Walk-In
                    </button>
                </div>
            </form>

            {{-- Right Column: Live spot status / detail card --}}
            <div class="lg:col-span-4 bg-white border border-gray-200 rounded-2xl p-6 shadow-sm space-y-4">
                <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                    <i class="ti ti-map-pin text-green-700"></i> Spot Info
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tourist Spot:</span>
                        <span class="font-bold text-gray-900">{{ $destination->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Daily Max Cap:</span>
                        <span class="font-bold text-gray-900">{{ $destination->capacity }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Current Occupancy:</span>
                        <span class="font-bold text-gray-900"><span x-text="currentCount"></span> / <span x-text="capacity"></span></span>
                    </div>
                    <div>
                        <div class="w-full bg-gray-100 rounded-full h-2 mt-1">
                            <div class="h-2 rounded-full bg-green-700" :style="'width: ' + Math.min(100, Math.round((currentCount / capacity) * 100)) + '%'"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function walkinForm(cap, current) {
                return {
                    capacity: cap,
                    initialCount: current,
                    visitors: [
                        { name: '', age: '', contact_number: '', email: '', classification: 'Local' }
                    ],
                    get currentCount() {
                        return this.initialCount + this.visitors.length;
                    },
                    get isOverCapacity() {
                        return this.currentCount > this.capacity;
                    },
                    addVisitor() {
                        this.visitors.push({ name: '', age: '', contact_number: '', email: '', classification: 'Local' });
                    },
                    removeVisitor(index) {
                        this.visitors.splice(index, 1);
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
