<div x-data
     x-init="(window.__flashToasts || []).forEach((t) => $store.toast.push(t.type, t.message))"
     x-on:toast.window="$store.toast.push($event.detail.type, $event.detail.message)"
     class="fixed top-4 right-4 z-[60] flex flex-col gap-3 w-[calc(100%-2rem)] max-w-sm"
     aria-live="polite" aria-atomic="true">
    <template x-for="item in $store.toast.items" :key="item.id">
        <div x-show="true"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-4"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-4"
             class="relative flex items-start gap-3 rounded-xl bg-white pl-4 pr-3 py-3.5 shadow-lg ring-1 ring-slate-900/10 overflow-hidden"
             role="status">
            <span class="absolute inset-y-0 left-0 w-1" :class="item.type === 'error' ? 'bg-red-500' : 'bg-green-500'"></span>

            <span class="shrink-0 flex items-center justify-center w-8 h-8 rounded-full"
                  :class="item.type === 'error' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600'">
                <x-admin.icon name="x-circle" class="w-5 h-5" x-show="item.type === 'error'" />
                <x-admin.icon name="check-circle" class="w-5 h-5" x-show="item.type !== 'error'" />
            </span>

            <p class="flex-1 pt-1 text-sm font-medium text-slate-800 leading-snug" x-text="item.message"></p>

            <button type="button" x-on:click="$store.toast.dismiss(item.id)"
                    class="shrink-0 -m-1 p-1.5 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition"
                    aria-label="Tutup notifikasi">
                <x-admin.icon name="x" class="w-4 h-4" />
            </button>
        </div>
    </template>
</div>
