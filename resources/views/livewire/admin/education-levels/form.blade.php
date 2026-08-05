<div class="max-w-full space-y-6" @if($level) x-data="{ tab: 'info' }" @endif>
    <a href="{{ route('admin.education-levels.index') }}"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-primary-700 transition"
       aria-label="Kembali ke daftar jenjang pendidikan">
        <x-admin.icon name="arrow-left" class="w-4 h-4" />
        Jenjang Pendidikan
    </a>

    @if ($level)
        <div class="border-b border-slate-200">
            <nav aria-label="Bagian jenjang" role="tablist" class="flex flex-wrap gap-1 -mb-px">
                @foreach (array_filter([
                    'info' => 'Info Dasar',
                    'facilities' => 'Fasilitas Jenjang',
                    'class-stats' => $level?->slug === 'inklusi' ? 'Fasilitas Terapi' : ($level?->slug === 'boarding smpit-smait' ? 'Fasilitas Boarding' : 'Fasilitas Kelas'),
                    'extracurriculars' => 'Ekstrakurikuler',
                    'activities' => $level?->slug === 'inklusi' ? 'Aktivitas Terapi' : ($level?->slug === 'boarding smpit-smait' ? 'Aktivitas Boarding' : 'Aktivitas Belajar'),
                    'testimonials' => $level?->slug === 'smait' ? 'Testimoni Alumni' : null,
                ]) as $tabKey => $tabLabel)
                    <button type="button" @click="tab = '{{ $tabKey }}'"
                            :class="tab === '{{ $tabKey }}' ? 'border-primary-600 text-primary-700' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
                            :aria-selected="tab === '{{ $tabKey }}'" role="tab"
                            class="px-4 py-2.5 text-sm font-medium border-b-2 transition">
                        {{ $tabLabel }}
                    </button>
                @endforeach
            </nav>
        </div>
    @endif

    <div @if($level) x-show="tab === 'info'" x-cloak role="tabpanel" @endif class="bg-white rounded-lg shadow p-6 space-y-4">
        <form wire:submit="save" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Jenjang</label>
                <input type="text" id="name" wire:model="name"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-slate-700 mb-1">Slug (URL)</label>
                <input type="text" id="slug" wire:model="slug"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('slug') border-red-500 @enderror">
                @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tagline" class="block text-sm font-medium text-slate-700 mb-1">Tagline</label>
                <input type="text" id="tagline" wire:model="tagline"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('tagline') border-red-500 @enderror">
                @error('tagline')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Program</label>
                <textarea id="program" wire:model="program" class="hidden"></textarea>
                <div x-data="richTextEditor()" wire:ignore>
                    <div x-ref="editor"></div>
                </div>
                @error('program')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                <input type="number" id="order" wire:model="order" min="0"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('order') border-red-500 @enderror">
                @error('order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="whatsappNumber" class="block text-sm font-medium text-slate-700 mb-1">Nomor WhatsApp Tombol "Daftar Sekarang"</label>
                <input type="text" id="whatsappNumber" wire:model="whatsappNumber" placeholder="628xxxxxxxxxx"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 @error('whatsappNumber') border-red-500 @enderror">
                <p class="mt-1 text-xs text-slate-500">Kosongkan untuk memakai nomor WhatsApp default sekolah.</p>
                @error('whatsappNumber')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @include('livewire.admin.partials.image-upload-field', [
                'modelName' => 'image',
                'label' => 'Gambar',
                'existingImage' => $existingImage,
            ])

            <div class="flex gap-3 pt-4">
                <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-2 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition disabled:opacity-50">
                    <span wire:loading.remove>{{ $level ? 'Perbarui' : 'Simpan' }}</span>
                    <span wire:loading>Memproses...</span>
                </button>
                <a href="{{ route('admin.education-levels.index') }}"
                   class="px-6 py-2 bg-slate-200 hover:bg-slate-300 text-slate-900 font-semibold rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    @if ($level)
        <div x-show="tab === 'facilities'" x-cloak role="tabpanel">
            <livewire:admin.facilities.manager :education-level-id="$level->id" :key="'facilities-'.$level->id" />
        </div>
        <div x-show="tab === 'class-stats'" x-cloak role="tabpanel">
            <livewire:admin.class-stats.manager :education-level-id="$level->id" :key="'class-stats-'.$level->id" />
        </div>
        <div x-show="tab === 'extracurriculars'" x-cloak role="tabpanel">
            <livewire:admin.extracurriculars.manager :education-level-id="$level->id" :key="'extracurriculars-'.$level->id" />
        </div>
        <div x-show="tab === 'activities'" x-cloak role="tabpanel">
            <livewire:admin.activities.manager :education-level-id="$level->id" :key="'activities-'.$level->id" />
        </div>
        @if ($level?->slug === 'smait')
            <div x-show="tab === 'testimonials'" x-cloak role="tabpanel">
                <livewire:admin.testimonials.manager :education-level-id="$level->id" :key="'testimonials-'.$level->id" />
            </div>
        @endif
    @endif
</div>
