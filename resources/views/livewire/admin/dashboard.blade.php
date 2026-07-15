<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Selamat datang, {{ auth()->user()->name }} 👋</h2>
        <p class="text-slate-500 mt-1">Ringkasan konten situs Darul Fikri saat ini.</p>
    </div>

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4">
            <span class="flex items-center justify-center w-11 h-11 rounded-lg bg-primary-50 text-primary-700 shrink-0">
                <x-admin.icon name="academic-cap" class="w-6 h-6" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $levels->count() }}</p>
                <p class="text-sm text-slate-500">Jenjang Pendidikan</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4">
            <span class="flex items-center justify-center w-11 h-11 rounded-lg bg-gold-50 text-gold-600 shrink-0">
                <x-admin.icon name="photo" class="w-6 h-6" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $slideCount }}</p>
                <p class="text-sm text-slate-500">Slide Carousel Beranda</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4">
            <span class="flex items-center justify-center w-11 h-11 rounded-lg bg-primary-50 text-primary-700 shrink-0">
                <x-admin.icon name="pencil" class="w-6 h-6" />
            </span>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $levels->sum(fn ($l) => $l->facilities_count + $l->class_stats_count + $l->extracurriculars_count + $l->activities_count) }}</p>
                <p class="text-sm text-slate-500">Total Item Konten</p>
            </div>
        </div>
    </div>

    <!-- Levels overview -->
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between">
            <h3 class="font-semibold text-slate-900">Jenjang Pendidikan</h3>
            <a href="{{ route('admin.education-levels.index') }}"
               class="text-sm font-medium text-primary-600 hover:text-primary-800">Kelola semua →</a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($levels as $level)
                <a href="{{ route('admin.education-levels.edit', $level) }}"
                   class="flex items-center gap-4 px-5 py-3.5 hover:bg-slate-50 transition">
                    @if ($level->image)
                        <img src="{{ $level->image }}" alt="" class="w-11 h-11 rounded-lg object-cover shrink-0">
                    @else
                        <x-image-placeholder compact class="w-11 h-11 rounded-lg shrink-0" />
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="font-medium text-slate-900 truncate">{{ $level->name }}</p>
                        <p class="text-sm text-slate-500 truncate">{{ $level->tagline }}</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-3 text-xs text-slate-400 shrink-0">
                        <span>{{ $level->facilities_count }} fasilitas</span>
                        <span>·</span>
                        <span>{{ $level->activities_count }} aktivitas</span>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <p class="text-4xl mb-3" aria-hidden="true">🏫</p>
                    <h3 class="text-sm font-medium text-slate-900">Belum ada jenjang pendidikan</h3>
                    <a href="{{ route('admin.education-levels.create') }}"
                       class="inline-block mt-4 px-4 py-2 bg-primary-700 hover:bg-primary-800 text-white font-semibold rounded-lg transition">
                        + Tambah Jenjang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
