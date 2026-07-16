<div x-data
     x-on:toast.window="$store.toast.push($event.detail.type, $event.detail.message)"
     class="fixed top-4 right-4 z-[60] flex flex-col gap-2 w-[calc(100%-2rem)] max-w-sm"
     aria-live="polite" aria-atomic="true">
    <template x-for="item in $store.toast.items" :key="item.id">
        <div x-show="true" x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             :class="item.type === 'error' ? 'bg-red-50 text-red-700 ring-red-600/10' : 'bg-green-50 text-green-700 ring-green-600/10'"
             class="flex items-start gap-2.5 rounded-lg px-4 py-3 text-sm font-medium shadow-lg ring-1" role="status">
            <span x-show="item.type === 'error'" class="shrink-0 mt-0.5">
                <x-admin.icon name="x" class="w-4 h-4" />
            </span>
            <span x-show="item.type !== 'error'" class="shrink-0 mt-0.5">
                <x-admin.icon name="check" class="w-4 h-4" />
            </span>
            <span class="flex-1" x-text="item.message"></span>
            <button type="button" x-on:click="$store.toast.dismiss(item.id)"
                    class="shrink-0 -m-1 p-1 rounded hover:bg-black/5 transition" aria-label="Tutup notifikasi">
                <x-admin.icon name="x" class="w-3.5 h-3.5" />
            </button>
        </div>
    </template>
</div>
