@props(['testimonial'])

<article class="testimonial-card h-full flex flex-col bg-white rounded-2xl shadow-lg ring-1 ring-slate-900/5 px-7 py-8 sm:px-8">
    <span class="font-serif text-5xl leading-none text-gold-300 select-none text-center" aria-hidden="true">&ldquo;</span>

    <blockquote class="mt-3 font-serif font-medium text-slate-800 text-lg sm:text-xl leading-snug text-center flex-1 flex flex-col justify-center">
        <span>{{ $testimonial->quote }}</span>
    </blockquote>

    <footer class="mt-6 pt-5 border-t border-slate-100 flex items-center gap-3">
        <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-slate-100 ring-2 ring-gold-400 ring-offset-2 ring-offset-white">
            @if ($testimonial->image)
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                     decoding="async" class="w-full h-full object-cover object-top">
            @else
                <x-image-placeholder compact class="w-full h-full" />
            @endif
        </div>
        <div class="min-w-0">
            <p class="font-display text-sm font-semibold text-slate-900 truncate">{{ $testimonial->name }}</p>
            <p class="text-xs text-slate-400 truncate">{{ $testimonial->campus }}</p>
            <p class="text-xs font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
        </div>
    </footer>
</article>