<div
    id="image-lightbox"
    class="hidden fixed inset-0 z-50 flex flex-col items-center justify-center gap-4 p-4 sm:p-8 bg-black/90 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out"
    role="dialog"
    aria-modal="true"
    aria-label="Preview gambar"
>
    <button type="button" data-lightbox-close
            class="absolute top-4 right-4 sm:top-6 sm:right-6 inline-flex items-center justify-center w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 active:scale-90 text-white transition"
            aria-label="Tutup preview gambar">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <div class="relative max-w-full max-h-[80vh] flex items-center justify-center">
        <div data-lightbox-spinner class="absolute w-8 h-8 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
        <img data-lightbox-image src="" alt=""
             class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl scale-95 opacity-0 transition-all duration-300 ease-out cursor-zoom-out">
    </div>

    <p data-lightbox-caption class="hidden text-sm text-white/80 text-center max-w-xl px-4"></p>
</div>
