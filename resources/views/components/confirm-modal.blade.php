@props(['id', 'title', 'message'])

<div x-data="{ open: false }"
     @open-confirm-modal.window="if ($event.detail.id === '{{ $id }}') open = true"
     @close-confirm-modal.window="if ($event.detail.id === '{{ $id }}') open = false">
    
    <template x-teleport="body">
        <div x-show="open"
             class="fixed inset-0 z-[100] flex items-center justify-center p-4"
             style="display: none;"
             role="dialog"
             aria-modal="true"
             x-cloak>
            
            {{-- Backdrop overlay with blur --}}
            <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="open = false"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"></div>

    {{-- Dialog box --}}
    <div x-show="open"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         @keydown.escape.window="open = false"
         class="bg-white border border-gray-150 rounded-2xl max-w-md w-full p-6 shadow-2xl relative z-10 transition-all">
        
        {{-- Icon & Header --}}
        <div class="flex items-center gap-3.5 mb-3">
            <div class="h-10 w-10 rounded-full bg-red-50 flex items-center justify-center text-red-650 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-950">{{ $title }}</h3>
        </div>

        {{-- Message Description --}}
        <p class="text-sm text-gray-600 mb-6 leading-relaxed">{{ $message }}</p>

        {{-- Actions Buttons --}}
        <div class="flex justify-end gap-3">
            <button type="button" 
                    @click="open = false"
                    class="px-4 py-2.5 rounded-xl border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-sm transition-all duration-200 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                Cancel
            </button>
            
            {{-- Confirm action --}}
            <div @click="open = false">
                {{ $slot }}
            </div>
        </div>
        </div>
    </template>
</div>
