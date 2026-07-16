<div x-data
     x-show="$store.confirm.open"
     x-cloak
     x-on:keydown.escape.window="$store.confirm.close()"
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm"
     role="alertdialog"
     aria-modal="true"
     aria-label="Konfirmasi"
     x-transition.opacity>
    <div x-on:click.outside="$store.confirm.close()"
         class="w-full max-w-sm bg-white rounded-2xl shadow-xl p-6 space-y-4">
        <p class="text-sm text-slate-700" x-text="$store.confirm.message"></p>
        <div class="flex justify-end gap-2">
            <button type="button" x-on:click="$store.confirm.close()"
                    class="px-4 py-2 text-sm font-semibold rounded-lg bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 transition">
                Batal
            </button>
            <button type="button" x-on:click="$store.confirm.confirm()"
                    :class="$store.confirm.variant === 'danger' ? 'bg-red-600 hover:bg-red-700' : 'bg-primary-700 hover:bg-primary-800'"
                    class="px-4 py-2 text-sm font-semibold rounded-lg text-white transition"
                    x-text="$store.confirm.confirmLabel">
            </button>
        </div>
    </div>
</div>
