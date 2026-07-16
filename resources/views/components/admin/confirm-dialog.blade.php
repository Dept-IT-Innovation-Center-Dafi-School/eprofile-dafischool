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
    <div x-on:click.outside="$store.confirm.close()"
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
            <div class="flex-1 pt-1.5">
                <p class="text-sm text-slate-700 leading-relaxed" x-text="$store.confirm.message"></p>
            </div>
        </div>

        <div class="flex justify-end gap-2.5 mt-6">
            <button type="button" x-on:click="$store.confirm.close()"
                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <button type="button" x-on:click="$store.confirm.confirm()"
                    :class="$store.confirm.variant === 'danger' ? 'bg-red-600 hover:bg-red-700' : 'bg-primary-700 hover:bg-primary-800'"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-white shadow-sm transition"
                    x-text="$store.confirm.confirmLabel">
            </button>
        </div>
    </div>
</div>
