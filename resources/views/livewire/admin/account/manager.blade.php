<div class="max-w-xl space-y-6">
    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-base font-semibold text-slate-900 mb-4">Profil</h2>

        <form wire:submit="updateProfile" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama</label>
                <input type="text" id="name" wire:model="name" autocomplete="name" required
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" id="email" wire:model="email" autocomplete="username" required
                       class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="updateProfile"
                    class="py-2.5 px-4 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition disabled:opacity-50">
                <span wire:loading.remove wire:target="updateProfile">Simpan Profil</span>
                <span wire:loading wire:target="updateProfile">Menyimpan...</span>
            </button>
        </form>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <h2 class="text-base font-semibold text-slate-900 mb-4">Ganti Password</h2>

        <form wire:submit="updatePassword" class="space-y-4">
            <div x-data="{ show: false }">
                <label for="currentPassword" class="block text-sm font-medium text-slate-700 mb-1.5">Password Saat Ini</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="currentPassword" wire:model="currentPassword" autocomplete="current-password" required
                           class="w-full px-4 py-2.5 pr-11 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('currentPassword') border-red-500 @enderror">
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600"
                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                        <x-admin.icon name="eye" class="w-5 h-5" x-show="!show" />
                        <x-admin.icon name="eye-slash" class="w-5 h-5" x-show="show" x-cloak />
                    </button>
                </div>
                @error('currentPassword')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ show: false }">
                <label for="newPassword" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="newPassword" wire:model="newPassword" autocomplete="new-password" required
                           class="w-full px-4 py-2.5 pr-11 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('newPassword') border-red-500 @enderror">
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600"
                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                        <x-admin.icon name="eye" class="w-5 h-5" x-show="!show" />
                        <x-admin.icon name="eye-slash" class="w-5 h-5" x-show="show" x-cloak />
                    </button>
                </div>
                @error('newPassword')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div x-data="{ show: false }">
                <label for="newPasswordConfirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input :type="show ? 'text' : 'password'" id="newPasswordConfirmation" wire:model="newPasswordConfirmation" autocomplete="new-password" required
                           class="w-full px-4 py-2.5 pr-11 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('newPasswordConfirmation') border-red-500 @enderror">
                    <button type="button" @click="show = !show"
                            class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600"
                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                        <x-admin.icon name="eye" class="w-5 h-5" x-show="!show" />
                        <x-admin.icon name="eye-slash" class="w-5 h-5" x-show="show" x-cloak />
                    </button>
                </div>
                @error('newPasswordConfirmation')
                    <p role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="updatePassword"
                    class="py-2.5 px-4 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition disabled:opacity-50">
                <span wire:loading.remove wire:target="updatePassword">Ganti Password</span>
                <span wire:loading wire:target="updatePassword">Menyimpan...</span>
            </button>
        </form>
    </div>
</div>
