<div class="space-y-6">
    <div class="flex flex-wrap gap-3 justify-between items-center">
        <p class="text-sm text-slate-500">{{ $levels->count() }} jenjang terdaftar</p>
        <a href="{{ route('admin.education-levels.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold rounded-lg transition">
            <x-admin.icon name="plus" class="w-4 h-4" />
            Tambah Jenjang
        </a>
    </div>

    @if ($levels->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
            <p class="text-4xl mb-3" aria-hidden="true">🏫</p>
            <h3 class="text-sm font-medium text-slate-900">Belum ada jenjang pendidikan</h3>
            <p class="mt-1 text-sm text-slate-500">Mulai dengan menambahkan jenjang pertama.</p>
            <a href="{{ route('admin.education-levels.create') }}"
               class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold rounded-lg transition">
                <x-admin.icon name="plus" class="w-4 h-4" />
                Tambah Jenjang
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
            @foreach ($levels as $level)
                <div class="flex items-center gap-4 px-5 py-3.5">
                    @if ($level->image)
                        <img src="{{ $level->image }}" alt="" class="w-12 h-12 rounded-lg object-cover shrink-0 bg-slate-100">
                    @else
                        <x-image-placeholder compact class="w-12 h-12 rounded-lg shrink-0" />
                    @endif

                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-slate-900 truncate">{{ $level->name }}</p>
                        <p class="text-sm text-slate-500 truncate">/{{ $level->slug }} · {{ $level->tagline }}</p>
                    </div>

                    <div class="flex items-center gap-0.5 shrink-0" role="group" aria-label="Ubah urutan {{ $level->name }}">
                        <button wire:click="moveUp({{ $level->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Naikkan urutan {{ $level->name }}">
                            <x-admin.icon name="chevron-up" class="w-4 h-4" />
                        </button>
                        <button wire:click="moveDown({{ $level->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Turunkan urutan {{ $level->name }}">
                            <x-admin.icon name="chevron-down" class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="flex items-center gap-0.5 shrink-0 pl-1 border-l border-slate-100">
                        <a href="{{ route('admin.education-levels.edit', $level) }}"
                           class="p-2 rounded-md text-slate-500 hover:text-primary-700 hover:bg-primary-50 transition"
                           aria-label="Edit {{ $level->name }}">
                            <x-admin.icon name="pencil" class="w-4 h-4" />
                        </a>
                        <button type="button"
                                x-on:click="$store.confirm.show({ message: 'Hapus \'{{ $level->name }}\'? Tindakan tidak bisa dibatalkan.', onConfirm: () => $wire.deleteLevel({{ $level->id }}) })"
                                class="p-2 rounded-md text-slate-500 hover:text-red-600 hover:bg-red-50 transition"
                                aria-label="Hapus {{ $level->name }}">
                            <x-admin.icon name="trash" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
