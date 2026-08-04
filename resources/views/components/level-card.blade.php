@props(['level'])

<a href="{{ route('levels.show', $level->slug) }}"
   class="group flex flex-col h-full rounded-2xl overflow-hidden bg-white shadow-md ring-1 ring-slate-900/5 hover:shadow-xl hover:-translate-y-1 active:scale-95 transition duration-300 min-h-[44px]">
    <div class="h-40 overflow-hidden relative shrink-0">
        @if ($level->image)
            <img src="{{ $level->image }}" alt="{{ $level->name }}" loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
        @else
            <x-image-placeholder :label="$level->name" class="w-full h-full" />
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
    </div>
    <div class="flex flex-col flex-1 p-4 sm:p-4 border-t-2 border-gold-400">
        <h3 class="font-display font-bold text-base sm:text-lg text-primary-800 line-clamp-2">{{ $level->name }}</h3>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 line-clamp-2">{{ $level->tagline }}</p>
        <span class="inline-flex items-center gap-1 mt-auto pt-2 text-gold-600 font-semibold text-xs sm:text-sm group-hover:gap-2 transition-all">
            Lihat Detail <span aria-hidden="true">&rarr;</span>
        </span>
    </div>
</a>
