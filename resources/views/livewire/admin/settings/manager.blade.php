<div class="max-w-xl space-y-6">
    <form wire:submit="save" class="space-y-6">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Identitas Sekolah</h2>

            <div class="space-y-4">
                <div>
                    <label for="schoolName" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Sekolah</label>
                    <input type="text" id="schoolName" wire:model="schoolName"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('schoolName') border-red-500 @enderror">
                    @error('schoolName')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Logo Sekolah</h2>

            @include('livewire.admin.partials.image-upload-field', [
                'modelName' => 'image',
                'label' => 'Logo',
                'existingImage' => $existingImage,
            ])
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Kontak</h2>

            <div class="space-y-4">
                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-700 mb-1.5">Telepon</label>
                    <input type="text" id="phone" wire:model="phone" autocomplete="tel"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="whatsappNumber" class="block text-sm font-medium text-slate-700 mb-1.5">Nomor WhatsApp</label>
                    <input type="text" id="whatsappNumber" wire:model="whatsappNumber" placeholder="62812xxxxxxx"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('whatsappNumber') border-red-500 @enderror">
                    @error('whatsappNumber')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" id="email" wire:model="email" autocomplete="email"
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                    <textarea id="address" wire:model="address" rows="3"
                              class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('address') border-red-500 @enderror"></textarea>
                    @error('address')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-4">Media Sosial</h2>

            <div class="space-y-4">
                <div>
                    <label for="instagramUrl" class="block text-sm font-medium text-slate-700 mb-1.5">Instagram</label>
                    <input type="url" id="instagramUrl" wire:model="instagramUrl" placeholder="https://instagram.com/..."
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('instagramUrl') border-red-500 @enderror">
                    @error('instagramUrl')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="facebookUrl" class="block text-sm font-medium text-slate-700 mb-1.5">Facebook</label>
                    <input type="url" id="facebookUrl" wire:model="facebookUrl" placeholder="https://facebook.com/..."
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('facebookUrl') border-red-500 @enderror">
                    @error('facebookUrl')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="youtubeUrl" class="block text-sm font-medium text-slate-700 mb-1.5">YouTube</label>
                    <input type="url" id="youtubeUrl" wire:model="youtubeUrl" placeholder="https://youtube.com/..."
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('youtubeUrl') border-red-500 @enderror">
                    @error('youtubeUrl')
                        <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-base font-semibold text-slate-900 mb-1.5">Lokasi (Google Maps)</h2>
            <ol class="text-sm text-slate-500 mb-4 list-decimal list-inside space-y-1">
                <li>Buka <strong>Google Maps</strong> di browser komputer, cari lokasi sekolah.</li>
                <li>Klik tombol <strong>Bagikan</strong> (Share), lalu pilih tab <strong>Sematkan peta</strong> (Embed a map).</li>
                <li>Klik <strong>SALIN HTML</strong> (Copy HTML), lalu tempel semuanya di kolom di bawah ini.</li>
            </ol>

            <div>
                <label for="mapsEmbedUrl" class="block text-sm font-medium text-slate-700 mb-1.5">Kode Peta dari Google Maps</label>
                <textarea id="mapsEmbedUrl" wire:model="mapsEmbedUrl" rows="3" placeholder="Tempel hasil salin dari Google Maps di sini"
                          class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('mapsEmbedUrl') border-red-500 @enderror"></textarea>
                @error('mapsEmbedUrl')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if (str_starts_with($mapsEmbedUrl, 'https://www.google.com/maps/embed'))
                <div class="mt-4 rounded-lg overflow-hidden border border-slate-200 aspect-video">
                    <iframe src="{{ $mapsEmbedUrl }}" class="w-full h-full" style="border:0;" loading="lazy" title="Pratinjau lokasi"></iframe>
                </div>
            @endif
        </div>

        <button type="submit" wire:loading.attr="disabled" wire:target="save"
                class="py-2.5 px-4 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition disabled:opacity-50">
            <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </button>
    </form>
</div>
