<x-layout :title="$level->name . ' - Darul Fikri'" :description="$level->tagline" :showFooter="true">
    <main>
        <!-- Hero section -->
        <section class="max-w-6xl mx-auto px-4 pt-6">
            <div class="relative rounded-2xl overflow-hidden shadow-lg">
                @if ($level->image)
                    <img src="{{ $level->image }}" alt="{{ $level->name }}" fetchpriority="high"
                         class="w-full h-64 sm:h-96 object-cover">
                @else
                    <x-image-placeholder :label="$level->name" class="w-full h-64 sm:h-96" />
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex items-end">
                    <div class="p-5 sm:p-8">
                        <span class="inline-block text-gold-300 text-xs font-bold uppercase tracking-[0.2em] mb-2">Jenjang Pendidikan</span>
                        <h1 class="font-display text-white text-2xl sm:text-4xl font-extrabold">{{ $level->name }}</h1>
                        <p class="text-gold-100 mt-1">{{ $level->tagline }}</p>
                    </div>
                </div>

                <a href="{{ route('levels.index') }}"
                   class="absolute top-4 left-4 sm:top-6 sm:left-6 inline-flex items-center gap-2 min-h-[44px] pl-4 pr-5 py-2.5 rounded-full bg-black/35 hover:bg-black/55 backdrop-blur-sm border border-white/30 shadow-md active:scale-95 text-white font-semibold text-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </section>

        <!-- Sticky nav: lompat ke bagian + pindah jenjang, sejajar dalam satu baris — selalu bisa diakses tanpa scroll balik ke atas -->
        <div class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-slate-100 mt-6">
            <div class="max-w-6xl mx-auto px-4 py-2.5 flex flex-col sm:flex-row sm:items-center gap-2 sm:justify-between">
                <nav aria-label="Navigasi bagian jenjang" class="flex gap-1.5 overflow-x-auto sm:min-w-0">
                    <a href="#program" class="shrink-0 px-3 py-1.5 rounded-full text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary-700 transition">Program</a>
                    <a href="#fasilitas-sekolah" class="shrink-0 px-3 py-1.5 rounded-full text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary-700 transition">Fasilitas</a>
                    <a href="#fasilitas-kelas" class="shrink-0 px-3 py-1.5 rounded-full text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary-700 transition">Kelas</a>
                    @if ($level->show_extracurriculars)
                        <a href="#ekstrakurikuler" class="shrink-0 px-3 py-1.5 rounded-full text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary-700 transition">Ekskul</a>
                    @endif
                    <a href="#aktivitas-belajar" class="shrink-0 px-3 py-1.5 rounded-full text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-primary-700 transition">Aktivitas</a>
                </nav>
                <div class="shrink-0 overflow-x-auto">
                    <x-level-switcher :current="$level" :all="$allLevels" />
                </div>
            </div>
        </div>

        <!-- Program -->
        <section id="program" class="max-w-6xl mx-auto px-4 mt-10 scroll-mt-20">
            <x-section-heading eyebrow="Kurikulum & Pendekatan" title="Program" />
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5 p-5 sm:p-6">
                <div class="rich-text-content text-slate-600 leading-relaxed">{!! $level->program !!}</div>
            </div>
        </section>

        <!-- Facilities -->
        <x-level-section eyebrow="Sarana & Prasarana" title="Fasilitas Jenjang" :items="$level->facilities"
                          empty-message="Fasilitas jenjang belum ditambahkan.">
            @foreach ($level->facilities as $facility)
                <x-image-card :item="$facility" />
            @endforeach
        </x-level-section>

        <!-- Class Facilities -->
        <x-level-section eyebrow="{{ $isInklusi ? 'Sarana Terapi' : ($isBoarding ? 'Sarana Boarding' : 'Sarana Belajar') }}" title="{{ $isInklusi ? 'Fasilitas Terapi' : ($isBoarding ? 'Fasilitas Boarding' : 'Fasilitas Kelas') }}" :items="$level->classStats"
                          empty-message="{{ $isInklusi ? 'Fasilitas terapi belum ditambahkan.' : ($isBoarding ? 'Fasilitas boarding belum ditambahkan.' : 'Fasilitas kelas belum ditambahkan.') }}">
            @foreach ($level->classStats as $stat)
                <x-image-card :item="$stat" />
            @endforeach
        </x-level-section>

        <!-- Extracurriculars -->
        @if ($level->show_extracurriculars)
            <x-level-section eyebrow="Minat & Bakat" title="Ekstrakurikuler" :items="$level->extracurriculars"
                              empty-message="Ekstrakurikuler belum ditambahkan.">
                @foreach ($level->extracurriculars as $extracurricular)
                    <x-image-card :item="$extracurricular" />
                @endforeach
            </x-level-section>
        @endif

        <!-- Activities -->
        <x-level-section eyebrow="{{ $isInklusi ? 'Kegiatan Terapi' : ($isBoarding ? 'Keseharian di Asrama' : 'Keseharian di Sekolah') }}" title="{{ $isInklusi ? 'Aktivitas Terapi' : ($isBoarding ? 'Aktivitas Boarding' : 'Aktivitas Belajar') }}" :items="$level->activities"
                          empty-message="{{ $isInklusi ? 'Aktivitas terapi belum ditambahkan.' : ($isBoarding ? 'Aktivitas boarding belum ditambahkan.' : 'Aktivitas belajar belum ditambahkan.') }}">
            @foreach ($level->activities as $activity)
                <x-activity-card :activity="$activity" />
            @endforeach
        </x-level-section>

        <!-- Testimonials (hanya unit SMA) -->
        @if ($isSma && $level->testimonials->isNotEmpty())
            <section id="testimoni-alumni" class="max-w-6xl mx-auto px-4 mt-12 scroll-mt-20">
                <x-section-heading eyebrow="Kata Mereka" title="Testimoni Alumni" />
                <div class="swiper testimonial-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($level->testimonials as $testimonial)
                            <div class="swiper-slide !h-auto pb-6">
                                <x-testimonial-card :testimonial="$testimonial" />
                            </div>
                        @endforeach
                    </div>
                    <div class="testimonial-swiper-pagination swiper-pagination !static mt-2"></div>
                </div>
                <div class="flex items-center justify-center gap-3 mt-5">
                    <button type="button" class="testimonial-prev btn-testimonial" aria-label="Testimoni sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button type="button" class="testimonial-next btn-testimonial" aria-label="Testimoni berikutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </section>
        @endif

        <!-- CTA Daftar -->
        <section class="max-w-6xl mx-auto px-4 mt-14 mb-16 text-center">
            <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary-700 via-primary-800 to-primary-950 px-6 py-12 sm:py-16 shadow-xl">
                <span class="inline-block text-gold-300 text-3xl mb-3">✦</span>
                <h2 class="font-display text-white text-xl sm:text-3xl font-bold mb-3">Tertarik Bergabung dengan Darul Fikri?</h2>
                <p class="text-primary-100 mb-7 max-w-lg mx-auto">
                    Daftarkan putra-putri Anda sekarang di jenjang {{ $level->name }}.
                </p>
                <a href="{{ $level->whatsapp_url }}"
                   target="_blank" rel="noopener"
                   class="inline-flex items-center justify-center min-h-[44px] px-8 py-3 rounded-full bg-gold-500 hover:bg-gold-600 text-white font-bold shadow-glow transition hover:scale-105">
                    Daftar Sekarang &rarr;
                </a>
            </div>
        </section>
    </main>
</x-layout>
