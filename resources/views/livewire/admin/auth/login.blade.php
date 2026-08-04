<div class="min-h-screen flex items-center justify-center bg-primary-950 px-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
            <div class="text-center">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-gold-500 text-primary-950 font-display font-bold text-lg mb-4">DF</span>
                <h1 class="text-2xl font-bold text-slate-900">{{ $setting->school_name ?? 'Darul Fikri' }}</h1>
                <p class="text-slate-500 mt-1 text-sm">Masuk ke Admin Panel</p>
            </div>

            <form wire:submit="login" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" id="email" wire:model="email" autocomplete="username" required
                           @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                           class="w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror"
                           placeholder="admin@example.com">
                    @error('email')
                        <p id="email-error" role="alert" class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div x-data="{ show: false }">
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input :type="show ? 'text' : 'password'" id="password" wire:model="password" autocomplete="current-password" required
                               class="w-full px-4 py-2.5 pr-11 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                               placeholder="••••••••">
                        <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600"
                                :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                            <x-admin.icon name="eye" class="w-5 h-5" x-show="!show" />
                            <x-admin.icon name="eye-slash" class="w-5 h-5" x-show="show" x-cloak />
                        </button>
                    </div>
                </div>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" wire:model="remember"
                           class="w-4 h-4 text-primary-600 border-slate-300 rounded focus:ring-primary-500">
                    <span class="text-sm text-slate-600">Ingat saya</span>
                </label>

                <button type="submit" wire:loading.attr="disabled"
                        class="w-full py-2.5 px-4 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition disabled:opacity-50">
                    <span wire:loading.remove>Masuk</span>
                    <span wire:loading>Memproses...</span>
                </button>
            </form>
        </div>
    </div>
</div>
