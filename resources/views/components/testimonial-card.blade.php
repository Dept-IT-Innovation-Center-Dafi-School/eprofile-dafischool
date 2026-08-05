@props(['testimonial'])

<article class="testimonial-card h-full flex flex-col bg-white rounded-2xl shadow-lg ring-1 ring-slate-900/5 px-6 py-7 sm:px-8">
    <span class="font-serif text-4xl leading-none text-gold-300 select-none" aria-hidden="true">&ldquo;</span>

    <blockquote class="mt-2 font-serif text-slate-700 text-[15px] sm:text-base leading-relaxed flex-1">
        {{ $testimonial->quote }}
    </blockquote>

    <footer class="mt-6 pt-5 border-t border-slate-100 flex items-center gap-3">
        <div class="w-14 h-14 rounded-full overflow-hidden shrink-0 bg-slate-100 ring-2 ring-gold-400 ring-offset-2 ring-offset-white">
            @if ($testimonial->image)
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                     decoding="async" class="w-full h-full object-cover object-top">
            @else
                <x-image-placeholder compact class="w-full h-full" />
            @endif
        </div>
        <div class="min-w-0">
            <p class="font-display font-semibold text-slate-900 truncate">{{ $testimonial->name }}</p>
            <p class="text-slate-500 truncate">{{ $testimonial->campus }}</p>
            <p class="text-sm font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
        </div>
    </footer>
</article>