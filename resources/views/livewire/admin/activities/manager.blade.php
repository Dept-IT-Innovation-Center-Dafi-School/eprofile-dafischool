<div class="space-y-3">
    <div class="flex justify-between items-center">
        <h3 class="text-base font-semibold text-slate-900">{{ $isInklusi ? 'Aktivitas Terapi' : ($isBoarding ? 'Aktivitas Boarding' : 'Aktivitas Belajar') }}</h3>
        @if (!$editingId && app(App\Services\AcademicYearContext::class)->current())
            <button wire:click="startCreate"
                    class="inline-flex items-center gap-1.5 text-sm px-3 py-1.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-lg font-medium transition">
                <x-admin.icon name="plus" class="w-4 h-4" />
                Tambah
            </button>
        @endif
    </div>

    @include('livewire.admin.partials.academic-year-guard')

    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
        @if ($editingId === 'new')
            <div class="p-4 bg-slate-50 space-y-3">
                <div>
                    <label class="text-sm font-medium text-slate-700">Kegiatan</label>
                    <input type="text" wire:model="activity"
                           class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('activity') border-red-500 @enderror">
                    @error('activity')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                @include('livewire.admin.partials.image-upload-field', [
                    'modelName' => 'image',
                    'label' => 'Gambar',
                    'existingImage' => null,
                ])

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
        @endif

        @forelse ($activities as $item)
            @if ($editingId === $item->id)
                <div class="p-4 bg-slate-50 space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Kegiatan</label>
                        <input type="text" wire:model="activity"
                               class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('activity') border-red-500 @enderror">
                        @error('activity')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    @include('livewire.admin.partials.image-upload-field', [
                        'modelName' => 'image',
                        'label' => 'Gambar',
                        'existingImage' => $existingImage,
                    ])

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
                    @if ($item->image)
                        <img src="{{ $item->image }}" alt="" class="w-10 h-10 rounded-lg object-cover shrink-0 bg-slate-100">
                    @else
                        <x-image-placeholder compact class="w-10 h-10 rounded-lg shrink-0" />
                    @endif
                    <p class="min-w-0 flex-1 text-sm text-slate-700 truncate">{{ $item->activity }}</p>

                    <div class="flex items-center gap-0.5 shrink-0" role="group" aria-label="Ubah urutan {{ $item->activity }}">
                        <button wire:click="moveUp({{ $item->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Naikkan urutan {{ $item->activity }}">
                            <x-admin.icon name="chevron-up" class="w-4 h-4" />
                        </button>
                        <button wire:click="moveDown({{ $item->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Turunkan urutan {{ $item->activity }}">
                            <x-admin.icon name="chevron-down" class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="flex items-center gap-0.5 shrink-0 pl-1 border-l border-slate-100">
                        <button wire:click="startEdit({{ $item->id }})"
                                class="p-2 rounded-md text-slate-500 hover:text-primary-700 hover:bg-primary-50 transition"
                                aria-label="Edit {{ $item->activity }}">
                            <x-admin.icon name="pencil" class="w-4 h-4" />
                        </button>
                        <button type="button"
                                x-on:click="$store.confirm.show({ title: 'Hapus {{ $item->activity }}?', message: 'Data yang sudah dihapus tidak dapat dikembalikan. Ketik nama di bawah untuk konfirmasi.', confirmText: @js($item->activity), onConfirm: () => $wire.delete({{ $item->id }}) })"
                                class="p-2 rounded-md text-slate-500 hover:text-red-600 hover:bg-red-50 transition"
                                aria-label="Hapus {{ $item->activity }}">
                            <x-admin.icon name="trash" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
        @empty
            <div class="px-4 py-8 text-center text-sm text-slate-500">
                Belum ada aktivitas
            </div>
        @endforelse
    </div>
</div>
