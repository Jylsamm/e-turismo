<div x-data="toastNotificationManager()"
     @toast.window="addToast($event.detail)"
     class="fixed top-4 inset-x-4 sm:inset-x-auto sm:top-auto sm:bottom-6 sm:right-6 z-[99999] flex flex-col gap-3 max-w-md w-auto sm:w-full pointer-events-none"
     aria-live="polite">

    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.visible"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-4 sm:translate-y-6 opacity-0 scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-x-0"
             x-transition:leave-end="opacity-0 scale-90 translate-x-8"
             @mouseenter="pauseTimer(toast)"
             @mouseleave="resumeTimer(toast)"
             class="pointer-events-auto relative overflow-hidden rounded-2xl bg-white/95 backdrop-blur-md p-4 shadow-2xl border transition-all duration-200"
             :class="{
                 'border-amber-300 ring-1 ring-amber-400/40': toast.type === 'warning' || toast.type === 'capacity',
                 'border-red-400 ring-2 ring-red-500/30 shadow-red-500/10': toast.type === 'emergency' || toast.type === 'broadcast',
                 'border-red-300 ring-1 ring-red-400/40': toast.type === 'error',
                 'border-emerald-300 ring-1 ring-emerald-400/40': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                 'border-blue-300 ring-1 ring-blue-400/40': toast.type === 'info' || toast.type === 'identity'
             }">

            <!-- Accent Left Border Indicator -->
            <div class="absolute left-0 top-0 bottom-0 w-1.5"
                 :class="{
                     'bg-amber-500': toast.type === 'warning' || toast.type === 'capacity',
                     'bg-red-600 animate-pulse': toast.type === 'emergency' || toast.type === 'broadcast',
                     'bg-red-500': toast.type === 'error',
                     'bg-emerald-600': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                     'bg-blue-600': toast.type === 'info' || toast.type === 'identity'
                 }"></div>

            <div class="flex items-start gap-3.5 pl-1.5">
                <!-- Icon Badge -->
                <div class="flex items-center justify-center w-10 h-10 rounded-xl border shrink-0 shadow-xs"
                     :class="{
                         'bg-amber-50 text-amber-700 border-amber-200': toast.type === 'warning' || toast.type === 'capacity',
                         'bg-red-100 text-red-700 border-red-300': toast.type === 'emergency' || toast.type === 'broadcast',
                         'bg-red-50 text-red-700 border-red-200': toast.type === 'error',
                         'bg-emerald-50 text-emerald-700 border-emerald-200': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                         'bg-blue-50 text-blue-700 border-blue-200': toast.type === 'info' || toast.type === 'identity'
                     }">
                    
                    <!-- Custom or Dynamic Icon -->
                    <template x-if="toast.icon">
                        <i :class="toast.icon" class="text-xl"></i>
                    </template>
                    <template x-if="!toast.icon">
                        <span>
                            <template x-if="toast.type === 'warning'">
                                <i class="ti ti-shield-lock text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'emergency' || toast.type === 'broadcast'">
                                <i class="ti ti-alert-triangle text-xl animate-bounce"></i>
                            </template>
                            <template x-if="toast.type === 'booking'">
                                <i class="ti ti-ticket text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'checkin'">
                                <i class="ti ti-user-check text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'capacity'">
                                <i class="ti ti-users text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'identity'">
                                <i class="ti ti-id-badge-2 text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'error'">
                                <i class="ti ti-alert-circle text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'success'">
                                <i class="ti ti-circle-check text-xl"></i>
                            </template>
                            <template x-if="toast.type === 'info'">
                                <i class="ti ti-info-circle text-xl"></i>
                            </template>
                        </span>
                    </template>
                </div>

                <!-- Text Content -->
                <div class="flex-1 min-w-0 pr-1">
                    <div class="flex items-center gap-1.5 mb-0.5">
                        <h4 class="text-sm font-bold tracking-tight"
                            :class="{
                                'text-amber-950': toast.type === 'warning' || toast.type === 'capacity',
                                'text-red-950': toast.type === 'emergency' || toast.type === 'broadcast' || toast.type === 'error',
                                'text-emerald-950': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                                'text-blue-950': toast.type === 'info' || toast.type === 'identity'
                            }"
                            x-text="toast.title"></h4>

                        <template x-if="toast.type === 'emergency' || toast.type === 'broadcast'">
                            <span class="px-1.5 py-0.5 text-[9px] font-black uppercase tracking-wider bg-red-600 text-white rounded-full">
                                Priority
                            </span>
                        </template>
                    </div>
                    
                    <p class="text-xs leading-relaxed mt-0.5"
                       :class="{
                           'text-amber-900/90': toast.type === 'warning' || toast.type === 'capacity',
                           'text-red-900/95 font-medium': toast.type === 'emergency' || toast.type === 'broadcast',
                           'text-red-900/90': toast.type === 'error',
                           'text-emerald-900/90': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                           'text-blue-900/90': toast.type === 'info' || toast.type === 'identity'
                       }"
                       x-text="toast.message"></p>

                    <!-- Optional Action Button Link -->
                    <template x-if="toast.actionUrl && toast.actionText">
                        <div class="mt-2.5">
                            <a :href="toast.actionUrl"
                               class="inline-flex items-center gap-1 text-xs font-bold px-3 py-1 rounded-lg border transition shadow-xs"
                               :class="{
                                   'bg-emerald-600 text-white border-emerald-700 hover:bg-emerald-700': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                                   'bg-amber-600 text-white border-amber-700 hover:bg-amber-700': toast.type === 'warning' || toast.type === 'capacity',
                                   'bg-red-600 text-white border-red-700 hover:bg-red-700': toast.type === 'emergency' || toast.type === 'broadcast' || toast.type === 'error',
                                   'bg-blue-600 text-white border-blue-700 hover:bg-blue-700': toast.type === 'info' || toast.type === 'identity'
                               }">
                                <span x-text="toast.actionText"></span>
                                <i class="ti ti-arrow-right text-[11px]"></i>
                            </a>
                        </div>
                    </template>
                </div>

                <!-- Close Action Button -->
                <button type="button"
                        @click="removeToast(toast.id, toast.alertId)"
                        class="text-gray-400 hover:text-gray-700 p-1 rounded-lg hover:bg-gray-100 transition shrink-0"
                        aria-label="Dismiss notification">
                    <i class="ti ti-x text-sm"></i>
                </button>
            </div>

            <!-- Auto-dismiss Countdown Progress Bar -->
            <div class="absolute bottom-0 left-0 right-0 h-1 bg-gray-100/60 overflow-hidden">
                <div class="h-full transition-all linear"
                     :style="`width: ${toast.progress}%; transition-duration: 50ms;`"
                     :class="{
                         'bg-amber-500': toast.type === 'warning' || toast.type === 'capacity',
                         'bg-red-600': toast.type === 'emergency' || toast.type === 'broadcast',
                         'bg-red-500': toast.type === 'error',
                         'bg-emerald-600': toast.type === 'success' || toast.type === 'booking' || toast.type === 'checkin',
                         'bg-blue-600': toast.type === 'info' || toast.type === 'identity'
                     }"></div>
            </div>
        </div>
    </template>
</div>

<script>
function toastNotificationManager() {
    return {
        toasts: [],
        init() {
            window.showToast = (options) => {
                this.addToast(options);
            };

            // Global adapter for Emergency SSE notifications
            window.renderEmergencyToast = (alertId, message) => {
                const existing = this.toasts.find(t => t.alertId === alertId);
                if (!existing) {
                    this.addToast({
                        type: 'emergency',
                        title: 'Emergency Advisory',
                        message: message,
                        alertId: alertId,
                        duration: 15000
                    });
                }
            };

            // Auto-process flashed server session messages
            @if(session('warning'))
                this.addToast({
                    type: 'warning',
                    title: @json(session('warning_title', 'Access Restricted (1 Staff = 1 Spot Policy)')),
                    message: @json(session('warning')),
                    duration: 7500
                });
            @endif

            @if(session('error'))
                this.addToast({
                    type: 'error',
                    title: @json(session('error_title', 'Action Denied')),
                    message: @json(session('error')),
                    duration: 6000
                });
            @endif

            @if(session('success'))
                this.addToast({
                    type: @json(session('toast_type', 'success')),
                    title: @json(session('success_title', 'Success')),
                    message: @json(session('success')),
                    duration: 6000
                });
            @endif

            @if(session('info'))
                this.addToast({
                    type: 'info',
                    title: @json(session('info_title', 'System Notice')),
                    message: @json(session('info')),
                    duration: 5000
                });
            @endif
        },
        addToast({ type = 'info', title = '', message = '', icon = '', actionUrl = '', actionText = '', alertId = null, duration = 6000 }) {
            const id = Date.now() + Math.random();
            
            let defaultTitle = type.charAt(0).toUpperCase() + type.slice(1);
            if (type === 'warning') defaultTitle = 'Access Restricted (1 Staff = 1 Spot Policy)';
            if (type === 'emergency' || type === 'broadcast') defaultTitle = 'Emergency Advisory';
            if (type === 'booking') defaultTitle = 'Booking Update';
            if (type === 'checkin') defaultTitle = 'Check-in Verified';
            if (type === 'capacity') defaultTitle = 'Capacity Advisory';
            if (type === 'identity') defaultTitle = 'Identity Verification';

            const toast = {
                id,
                alertId,
                type,
                title: title || defaultTitle,
                message,
                icon,
                actionUrl,
                actionText,
                duration,
                remaining: duration,
                progress: 100,
                visible: true,
                timer: null,
                paused: false
            };

            this.toasts.unshift(toast);
            this.startTimer(toast);
        },
        startTimer(toast) {
            const step = 50;
            toast.timer = setInterval(() => {
                if (!toast.paused) {
                    toast.remaining -= step;
                    toast.progress = (toast.remaining / toast.duration) * 100;
                    if (toast.remaining <= 0) {
                        clearInterval(toast.timer);
                        this.removeToast(toast.id, toast.alertId);
                    }
                }
            }, step);
        },
        pauseTimer(toast) {
            toast.paused = true;
        },
        resumeTimer(toast) {
            toast.paused = false;
        },
        removeToast(id, alertId = null) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index !== -1) {
                this.toasts[index].visible = false;
                if (this.toasts[index].timer) clearInterval(this.toasts[index].timer);
                
                // If it's a dismissible server alert, call backend dismissal endpoint
                if (alertId && window.dismissGlobalEmergencyAlert) {
                    window.dismissGlobalEmergencyAlert(alertId);
                }

                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 300);
            }
        }
    };
}
</script>
