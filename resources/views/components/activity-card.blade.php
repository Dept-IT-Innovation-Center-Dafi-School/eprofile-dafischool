@props(['activity'])

<div class="group rounded-xl overflow-hidden bg-white shadow-sm ring-1 ring-slate-900/5 hover:shadow-md hover:-translate-y-0.5 transition duration-300">
    @if ($activity->image)
        <button type="button"
                data-lightbox-trigger
                data-lightbox-src="{{ $activity->image }}"
                data-lightbox-alt="{{ $activity->activity }}"
                class="block w-full aspect-[4/3] overflow-hidden relative cursor-zoom-in"
                aria-label="Perbesar gambar {{ $activity->activity }}">
            <img src="{{ $activity->image }}" alt="{{ $activity->activity }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
            <span class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/20 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white opacity-0 group-hover:opacity-100 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m-3-3h6" />
                </svg>
            </span>
        </button>
    @else
        <div class="aspect-[4/3] overflow-hidden">
            <x-image-placeholder :label="$activity->activity" class="w-full h-full" />
        </div>
    @endif
    <div class="p-3">
        <p class="text-slate-700 text-sm font-medium">{{ $activity->activity }}</p>
    </div>
</div>
