@props(['testimonial'])

<article class="testimonial-card group h-full flex flex-col bg-white rounded-2xl overflow-hidden shadow-lg ring-1 ring-slate-900/5">
    <div class="relative aspect-[4/3] overflow-hidden bg-slate-100">
        @if ($testimonial->image)
            <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                 decoding="async" class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
        @else
            <x-image-placeholder label="Foto {{ $testimonial->name }}" class="w-full h-full" />
        @endif
    </div>

    <div class="flex flex-col flex-1 px-5 py-6 sm:px-6">
        <span class="font-serif text-4xl leading-none text-gold-300 select-none" aria-hidden="true">&ldquo;</span>

        <blockquote class="mt-2 font-serif text-slate-700 text-[15px] sm:text-base leading-relaxed flex-1">
            {{ $testimonial->quote }}
        </blockquote>

        <footer class="mt-5 pt-4 border-t border-slate-100">
            <p class="font-display font-semibold text-slate-900">{{ $testimonial->name }}</p>
            <p class="text-slate-500">{{ $testimonial->campus }}</p>
            <p class="text-sm font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
        </footer>
    </div>
</article>