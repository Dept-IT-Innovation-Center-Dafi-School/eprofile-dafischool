<div class="space-y-6 max-w-2xl">
    @if (session('error'))
        <div role="alert" class="p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-between items-center">
        <p class="text-sm text-slate-500">{{ $years->count() }} tahun ajaran</p>
        <button wire:click="create"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold rounded-lg transition">
            <x-admin.icon name="plus" class="w-4 h-4" />
            Tambah Tahun Ajaran
        </button>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
        @forelse ($years as $year)
            @if ($editingId === $year->id)
                <div class="p-4 bg-slate-50 space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Label (mis. 2026/2027)</label>
                        <input type="text" wire:model="label"
                               class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('label') border-red-500 @enderror">
                        @error('label')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button wire:click="save"
                                class="inline-flex items-center gap-1.5 text-sm px-3 py-1.5 bg-primary-700 hover:bg-primary-800 text-white rounded-lg font-medium transition">
                            <x-admin.icon name="check" class="w-4 h-4" />
                            Simpan
                        </button>
                        <button wire:click="cancel"
                                class="text-sm px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-lg font-medium transition">
                            Batal
                        </button>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-3 px-4 py-3">
                    <p class="min-w-0 flex-1 text-sm font-medium text-slate-900">{{ $year->label }}</p>

                    @if ($year->is_active)
                        <span class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                            <x-admin.icon name="check" class="w-3.5 h-3.5" />
                            Aktif
                        </span>
                    @else
                        <button wire:click="setActive({{ $year->id }})"
                                wire:confirm="Jadikan {{ $year->label }} sebagai tahun ajaran aktif?"
                                class="shrink-0 px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 hover:bg-primary-50 hover:text-primary-700 text-xs font-semibold transition">
                            Jadikan Aktif
                        </button>
                    @endif

                    <div class="flex items-center gap-0.5 shrink-0 pl-1 border-l border-slate-100">
                        <button wire:click="startEdit({{ $year->id }})"
                                class="p-2 rounded-md text-slate-500 hover:text-primary-700 hover:bg-primary-50 transition"
                                aria-label="Edit {{ $year->label }}">
                            <x-admin.icon name="pencil" class="w-4 h-4" />
                        </button>
                        <button wire:click="delete({{ $year->id }})"
                                wire:confirm="Hapus {{ $year->label }}? Tindakan tidak bisa dibatalkan."
                                class="p-2 rounded-md text-slate-500 hover:text-red-600 hover:bg-red-50 transition"
                                aria-label="Hapus {{ $year->label }}">
                            <x-admin.icon name="trash" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
        @empty
            <div class="px-4 py-8 text-center text-sm text-slate-500">
                Belum ada tahun ajaran
            </div>
        @endforelse
    </div>
</div>
