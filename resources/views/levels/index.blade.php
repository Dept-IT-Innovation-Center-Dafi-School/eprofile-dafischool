<x-layout :title="'Pilihan Jenjang - ' . ($setting->school_name ?? 'Darul Fikri')" :description="'Pilih jenjang pendidikan di Sekolah Islam ' . ($setting->school_name ?? 'Darul Fikri') . ': RTK, TK, SD, SMP, dan SMA.'" :showFooter="true">
    <main>
        <div class="relative bg-primary-900">
            <a href="{{ route('home') }}"
               class="absolute top-4 left-4 sm:top-6 sm:left-6 z-10 inline-flex items-center gap-2 min-h-[44px] pl-4 pr-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 border border-white/25 text-white font-semibold text-sm transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Beranda
            </a>

            <div class="max-w-6xl mx-auto px-4 py-14 sm:py-20 text-center">
                <span class="inline-flex items-center gap-2 text-gold-300 text-xs font-bold uppercase tracking-[0.2em] mb-3">
                    <span class="w-6 h-px bg-gold-400"></span> Darul Fikri <span class="w-6 h-px bg-gold-400"></span>
                </span>
                <h1 class="font-display text-3xl sm:text-5xl font-extrabold text-white">Pilihan Jenjang Pendidikan</h1>
                <p class="text-primary-100 mt-3 max-w-xl mx-auto">
                    Darul Fikri menyediakan jenjang pendidikan lengkap mulai dari usia dini hingga
                    menengah atas, dengan kurikulum yang menyatukan akademik dan nilai-nilai Islami.
                </p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-4 -mt-8 sm:-mt-10 pb-14 sm:pb-20">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @foreach ($levels as $level)
                    <x-level-card :level="$level" />
                @endforeach
            </div>
        </div>
    </main>
</x-layout>
