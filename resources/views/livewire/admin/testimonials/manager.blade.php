<div class="space-y-3">
    <div class="flex justify-between items-center">
        <h3 class="text-base font-semibold text-slate-900">Testimoni Alumni</h3>
        @if (!$editingId)
            <button wire:click="startCreate"
                    class="inline-flex items-center gap-1.5 text-sm px-3 py-1.5 bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-lg font-medium transition">
                <x-admin.icon name="plus" class="w-4 h-4" />
                Tambah
            </button>
        @endif
    </div>

    <div class="bg-white rounded-xl border border-slate-200 divide-y divide-slate-100">
        @if ($editingId === 'new')
            <div class="p-4 bg-slate-50 space-y-3">
                <div>
                    <label class="text-sm font-medium text-slate-700">Nama Alumni</label>
                    <input type="text" wire:model="name" placeholder="Herman"
                           class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('name') border-red-500 @enderror">
                    @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Kampus Sekarang</label>
                        <input type="text" wire:model="campus" placeholder="Universitas Indonesia"
                               class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('campus') border-red-500 @enderror">
                        @error('campus')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-700">Angkatan</label>
                        <input type="text" wire:model="batch" placeholder="2018"
                               class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('batch') border-red-500 @enderror">
                        @error('batch')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Kata-kata Testimoni</label>
                    <textarea wire:model="quote" rows="3" placeholder="Alhamdulillah saya belajar banyak di SIT Darul Fikri Makassar..."
                              class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('quote') border-red-500 @enderror"></textarea>
                    @error('quote')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                </div>

                @include('livewire.admin.partials.image-upload-field', [
                    'modelName' => 'image',
                    'label' => 'Foto Alumni',
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

        @forelse ($testimonials as $testimonial)
            @if ($editingId === $testimonial->id)
                <div class="p-4 bg-slate-50 space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-700">Nama Alumni</label>
                        <input type="text" wire:model="name"
                               class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('name') border-red-500 @enderror">
                        @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Kampus Sekarang</label>
                            <input type="text" wire:model="campus"
                                   class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('campus') border-red-500 @enderror">
                            @error('campus')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="text-sm font-medium text-slate-700">Angkatan</label>
                            <input type="text" wire:model="batch"
                                   class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('batch') border-red-500 @enderror">
                            @error('batch')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Kata-kata Testimoni</label>
                        <textarea wire:model="quote" rows="3"
                                  class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('quote') border-red-500 @enderror"></textarea>
                        @error('quote')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    @include('livewire.admin.partials.image-upload-field', [
                        'modelName' => 'image',
                        'label' => 'Foto Alumni',
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
                    @if ($testimonial->image)
                        <img src="{{ $testimonial->image }}" alt="" class="w-10 h-10 rounded-full object-cover shrink-0 bg-slate-100">
                    @else
                        <x-image-placeholder compact class="w-10 h-10 rounded-full shrink-0" />
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-slate-900 truncate">{{ $testimonial->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ $testimonial->campus }} &middot; Angkatan {{ $testimonial->batch }}</p>
                    </div>

                    <div class="flex items-center gap-0.5 shrink-0" role="group" aria-label="Ubah urutan {{ $testimonial->name }}">
                        <button wire:click="moveUp({{ $testimonial->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Naikkan urutan {{ $testimonial->name }}">
                            <x-admin.icon name="chevron-up" class="w-4 h-4" />
                        </button>
                        <button wire:click="moveDown({{ $testimonial->id }})"
                                class="p-1.5 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                aria-label="Turunkan urutan {{ $testimonial->name }}">
                            <x-admin.icon name="chevron-down" class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="flex items-center gap-0.5 shrink-0 pl-1 border-l border-slate-100">
                        <button wire:click="startEdit({{ $testimonial->id }})"
                                class="p-2 rounded-md text-slate-500 hover:text-primary-700 hover:bg-primary-50 transition"
                                aria-label="Edit {{ $testimonial->name }}">
                            <x-admin.icon name="pencil" class="w-4 h-4" />
                        </button>
                        <button type="button"
                                x-on:click="$store.confirm.show({ title: 'Hapus {{ $testimonial->name }}?', message: 'Data yang sudah dihapus tidak dapat dikembalikan. Ketik nama di bawah untuk konfirmasi.', confirmText: @js($testimonial->name), onConfirm: () => $wire.delete({{ $testimonial->id }}) })"
                                class="p-2 rounded-md text-slate-500 hover:text-red-600 hover:bg-red-50 transition"
                                aria-label="Hapus {{ $testimonial->name }}">
                            <x-admin.icon name="trash" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            @endif
        @empty
            <div class="px-4 py-8 text-center text-sm text-slate-500">
                Belum ada data
            </div>
        @endforelse
    </div>
</div>