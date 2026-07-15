<div class="space-y-6">
    @if (session('success'))
        <div role="status" class="p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center">
        <p class="text-sm text-slate-500">{{ $slides->count() }} foto slide</p>
        @if (!$editingId)
            <button wire:click="startCreate"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white text-sm font-semibold rounded-lg transition">
                <x-admin.icon name="plus" class="w-4 h-4" />
                Tambah Slide
            </button>
        @endif
    </div>

    @if ($editingId === 'new')
        <div class="bg-white rounded-xl border border-slate-200 p-4 space-y-3">
            <div>
                <label class="text-sm font-medium text-slate-700">Alt Text (deskripsi gambar)</label>
                <input type="text" wire:model="alt" placeholder="Gedung Sekolah Darul Fikri"
                       class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('alt') border-red-500 @enderror">
                @error('alt')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
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

    @if ($slides->isEmpty() && !$editingId)
        <div class="bg-white rounded-xl border border-slate-200 p-12 text-center">
            <p class="text-4xl mb-3" aria-hidden="true">🖼️</p>
            <h3 class="text-sm font-medium text-slate-900">Belum ada slide carousel</h3>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($slides as $slide)
                @if ($editingId === $slide->id)
                    <div class="col-span-full bg-white rounded-xl border border-slate-200 p-4 space-y-3">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Alt Text (deskripsi gambar)</label>
                            <input type="text" wire:model="alt"
                                   class="w-full mt-1 px-3 py-2 border border-slate-300 rounded-lg text-sm @error('alt') border-red-500 @enderror">
                            @error('alt')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        @include('livewire.admin.partials.image-upload-field', [
                            'modelName' => 'image',
                            'label' => 'Ganti Gambar',
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
                    <div class="group relative bg-white rounded-xl border border-slate-200 overflow-hidden">
                        @if ($slide->image)
                            <img src="{{ $slide->image }}" alt="{{ $slide->alt }}" class="w-full h-36 object-cover bg-slate-100">
                        @else
                            <x-image-placeholder :label="$slide->alt" class="w-full h-36" />
                        @endif

                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition">
                            <button wire:click="startEdit({{ $slide->id }})"
                                    class="p-1.5 rounded-md bg-white/90 backdrop-blur text-slate-700 hover:text-primary-700 shadow-sm transition"
                                    aria-label="Edit slide {{ $slide->alt ?: $slide->id }}">
                                <x-admin.icon name="pencil" class="w-4 h-4" />
                            </button>
                            <button wire:click="delete({{ $slide->id }})"
                                    wire:confirm="Hapus slide ini? Tindakan tidak bisa dibatalkan."
                                    class="p-1.5 rounded-md bg-white/90 backdrop-blur text-slate-700 hover:text-red-600 shadow-sm transition"
                                    aria-label="Hapus slide {{ $slide->alt ?: $slide->id }}">
                                <x-admin.icon name="trash" class="w-4 h-4" />
                            </button>
                        </div>

                        <div class="flex items-center justify-between gap-2 px-3 py-2">
                            <p class="text-sm text-slate-700 truncate">{{ $slide->alt ?: '-' }}</p>
                            <div class="flex items-center gap-0.5 shrink-0" role="group" aria-label="Ubah urutan slide {{ $slide->alt ?: $slide->id }}">
                                <button wire:click="moveUp({{ $slide->id }})"
                                        class="p-1 rounded text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                        aria-label="Naikkan urutan">
                                    <x-admin.icon name="chevron-up" class="w-3.5 h-3.5" />
                                </button>
                                <button wire:click="moveDown({{ $slide->id }})"
                                        class="p-1 rounded text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                        aria-label="Turunkan urutan">
                                    <x-admin.icon name="chevron-down" class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
