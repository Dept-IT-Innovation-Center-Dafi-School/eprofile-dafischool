<div x-data
     x-show="$store.confirm.open"
     x-cloak
     x-on:keydown.escape.window="$store.confirm.close()"
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     role="alertdialog"
     aria-modal="true"
     aria-label="Konfirmasi"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-150"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    <div x-trap.noscroll="$store.confirm.open"
         x-on:click.outside="$store.confirm.close()"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6">
        <div class="flex items-start gap-4">
            <span class="shrink-0 flex items-center justify-center w-11 h-11 rounded-full"
                  :class="$store.confirm.variant === 'danger' ? 'bg-red-50 text-red-600' : 'bg-primary-50 text-primary-700'">
                <x-admin.icon name="exclamation-triangle" class="w-6 h-6" x-show="$store.confirm.variant === 'danger'" />
                <x-admin.icon name="check-circle" class="w-6 h-6" x-show="$store.confirm.variant !== 'danger'" />
            </span>
            <div class="flex-1 pt-1 min-w-0">
                <p class="text-sm font-semibold text-slate-900" x-show="$store.confirm.title" x-text="$store.confirm.title"></p>
                <p class="text-sm text-slate-600 leading-relaxed mt-1" x-text="$store.confirm.message"></p>

                <template x-if="$store.confirm.confirmText !== null">
                    <div class="mt-3">
                        <label class="block text-xs font-medium text-slate-500 mb-1">
                            Ketik <span class="font-semibold text-slate-700" x-text="$store.confirm.confirmText"></span> untuk konfirmasi
                        </label>
                        <input type="text"
                               x-model="$store.confirm.typed"
                               x-on:keydown.enter="$store.confirm.canConfirm && $store.confirm.confirm()"
                               autocomplete="off"
                               class="w-full px-3 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                    </div>
                </template>
            </div>
        </div>

        <div class="flex justify-end gap-2.5 mt-6">
            <button type="button" x-on:click="$store.confirm.close()"
                    :disabled="$store.confirm.loading"
                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Batal
            </button>
            <button type="button" x-on:click="$store.confirm.confirm()"
                    :disabled="!$store.confirm.canConfirm"
                    :class="$store.confirm.variant === 'danger' ? 'bg-red-600 hover:bg-red-700' : 'bg-primary-700 hover:bg-primary-800'"
                    class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold rounded-lg text-white shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                <svg x-show="$store.confirm.loading" class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span x-text="$store.confirm.confirmLabel"></span>
            </button>
        </div>
    </div>
</div>
