<x-layout :title="'Darul Fikri - Sekolah Islam Terpadu'" :useSwiper="true" :showBackToTop="false">
    <main class="relative">
        <h1 class="sr-only">Darul Fikri - Sekolah Islam Terpadu</h1>

        <div class="swiper hero-swiper h-screen w-full">
            <div class="swiper-wrapper">
                @foreach ($slides as $slide)
                    <div class="swiper-slide relative bg-slate-900">
                        @if ($slide->image)
                            {{-- Blurred backdrop: only shown at lg+, fills the space the
                                 contained foreground image leaves empty on wide screens
                                 so a single upload never needs a hard crop that could cut
                                 off the subject. --}}
                            <img src="{{ $slide->image }}" alt="" aria-hidden="true"
                                 loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                                 class="hidden lg:block absolute inset-0 w-full h-full object-cover scale-110 blur-2xl opacity-50">
                            <img src="{{ $slide->image }}" alt="{{ $slide->alt }}"
                                 @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                                 class="relative w-full h-full object-cover lg:object-contain">
                        @else
                            <x-image-placeholder :label="$slide->alt" class="w-full h-full" />
                        @endif
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
        </div>

        <!-- CTA button -->
        <a href="{{ route('levels.index') }}" id="hero-next-btn"
           class="fixed top-4 right-4 sm:top-6 sm:right-6 z-40 inline-flex items-center gap-2 min-h-[44px] pl-5 pr-4 py-2.5 rounded-full bg-black/35 hover:bg-black/55 backdrop-blur-sm border border-white/30 shadow-md active:scale-95 text-white font-semibold transition">
            Jenjang Pendidikan
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </main>
</x-layout>
