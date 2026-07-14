<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-800">Your E-Ticket</h1>
    </x-slot>

    <div class="py-12 max-w-xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Ticket Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 print:shadow-none print:border-none">
            <!-- Header Banner -->
            <div class="bg-et-gradient px-6 py-6 text-white text-center">
                <span class="text-xs font-semibold uppercase tracking-wider bg-white/20 px-3 py-1 rounded-full">E-Turismo Digital Pass</span>
                <h2 class="text-2xl font-bold mt-2">{{ $booking->destination?->name }}</h2>
                <p class="text-brand-100 text-sm mt-1">{{ $booking->destination?->location }}</p>
            </div>

            <!-- Content -->
            <div class="p-8 space-y-6 text-center">
                <!-- QR Code Wrapper -->
                <div class="inline-block p-4 bg-gray-50 border border-gray-100 rounded-2xl shadow-inner">
                    {!! QrCode::size(200)->generate($ticket->qr_code) !!}
                </div>
                
                <div class="space-y-1">
                    <p class="text-xs uppercase text-gray-400 font-semibold tracking-wider">Ticket Code</p>
                    <p class="text-xl font-mono font-bold text-brand-800">{{ $ticket->qr_code }}</p>
                </div>

                <div class="border-t border-dashed border-gray-200 my-6"></div>

                <!-- Info Fields -->
                <div class="grid grid-cols-2 gap-4 text-left">
                    <div class="space-y-0.5">
                        <span class="text-xs text-gray-400 font-medium">Visitor Name</span>
                        <p class="text-sm font-semibold text-gray-800">{{ $booking->tourist?->name }}</p>
                    </div>
                    <div class="space-y-0.5">
                        <span class="text-xs text-gray-400 font-medium">Visitor Type</span>
                        <p class="text-sm font-semibold text-gray-800">{{ $booking->tourist?->classification ?? 'Local' }} Tourist</p>
                    </div>
                    <div class="space-y-0.5 mt-2">
                        <span class="text-xs text-gray-400 font-medium">Visit Date</span>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($booking->visit_date)->format('F j, Y') }}</p>
                    </div>
                    <div class="space-y-0.5 mt-2">
                        <span class="text-xs text-gray-400 font-medium">Status</span>
                        <p class="text-sm font-semibold text-green-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500 inline-block animate-pulse"></span>
                            Confirmed / Active
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer / Action Buttons -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between gap-4 border-t border-gray-100 print:hidden">
                <a href="{{ route('bookings.index') }}" class="flex-1 text-center bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2.5 px-4 rounded-xl text-sm transition">
                    Back to Bookings
                </a>
                <button onclick="window.print()" class="flex-1 bg-brand-700 hover:bg-brand-800 text-white font-medium py-2.5 px-4 rounded-xl text-sm transition shadow-lg shadow-brand-700/20">
                    Print Ticket
                </button>
            </div>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6 print:hidden">
            Present this QR code to the destination staff upon entry.
        </p>
    </div>
</x-app-layout>
