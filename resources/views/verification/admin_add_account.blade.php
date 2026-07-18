<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Add Account (Tourist/Staff)
            </h2>
        </div>
    </x-slot>

    <div class="pb-12 pt-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Error Alerts --}}
            @if ($errors->any())
            <div class="bg-red-50 border border-red-300 text-red-700 rounded-lg px-4 py-3 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-700 rounded-lg px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
            @endif

            <div class="space-y-6">
                <div class="bg-white shadow rounded-xl overflow-hidden max-w-3xl mx-auto">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Register New Tourist or Staff</h3>
                        <p class="text-sm text-gray-500 font-medium">Input fields will dynamically change based on the chosen role.</p>
                    </div>

                    <form method="POST" action="{{ route('admin.accounts.store') }}" class="p-6 space-y-6">
                        @csrf

                        {{-- Role / Type --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Account Role</label>
                            <select id="reg-role" name="role" onchange="toggleFormRoleFields()" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required>
                                <option value="tourist" selected>Tourist</option>
                                <option value="staff">Staff (Tourist Spot Staff)</option>
                            </select>
                        </div>

                        {{-- Name Grid --}}
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Middle Initial</label>
                                <input type="text" name="middle_initial" placeholder="e.g. A" maxlength="2" value="{{ old('middle_initial') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                            </div>
                        </div>

                        {{-- Email & Contact --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number (Optional)</label>
                                <input type="text" name="contact" placeholder="e.g. 09123456789" value="{{ old('contact') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                            </div>
                        </div>

                        {{-- Passwords --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                                <input type="password" name="password" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" required />
                            </div>
                        </div>

                        {{-- ── TOURIST ONLY FIELDS ── --}}
                        <div id="tourist-fields" class="space-y-6 border-t pt-4">
                            <h4 class="font-bold text-sm text-brand-700">Tourist Identity details</h4>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Classification</label>
                                    <select name="classification" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                        <option value="Local" selected>Local (Municipal Resident)</option>
                                        <option value="Domestic">Domestic (National Resident)</option>
                                        <option value="Foreign">Foreign (International Visitor)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">ID Type</label>
                                    <select name="id_type" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                        <option value="National ID" selected>National ID (PhilSys)</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driver's License">Driver's License</option>
                                        <option value="Voter ID">Voter's ID</option>
                                        <option value="School ID">School / Student ID</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">ID Number / School Name</label>
                                    <input type="text" name="id_number" placeholder="e.g. 2022-041633" value="{{ old('id_number') }}" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm" />
                                </div>
                            </div>
                        </div>

                        {{-- ── STAFF ONLY FIELDS ── --}}
                        <div id="staff-fields" class="space-y-6 border-t pt-4 hidden">
                            <h4 class="font-bold text-sm text-brand-700">Staff Assignment details</h4>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Assigned Destination Spot</label>
                                <select name="assigned_destination_id" class="w-full border-gray-300 focus:border-brand-500 focus:ring-brand-500 rounded-md shadow-sm">
                                    <option value="">None / Unassigned</option>
                                    @foreach($destinations as $dest)
                                        <option value="{{ $dest->id }}">{{ $dest->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t">
                            <button type="submit" class="px-6 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                                Create Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    
    <script>
        function toggleFormRoleFields() {
            const role = document.getElementById('reg-role').value;
            const touristSection = document.getElementById('tourist-fields');
            const staffSection = document.getElementById('staff-fields');

            if (role === 'tourist') {
                touristSection.classList.remove('hidden');
                staffSection.classList.add('hidden');
            } else {
                touristSection.classList.add('hidden');
                staffSection.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            toggleFormRoleFields();
        });
    </script>
</x-app-layout>