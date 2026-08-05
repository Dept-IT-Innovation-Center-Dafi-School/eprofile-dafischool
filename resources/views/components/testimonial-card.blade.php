@props(['testimonial'])

<div class="md:grid md:grid-cols-12 md:items-end max-w-5xl mx-auto">
    <div class="md:col-span-7">
        <div class="relative aspect-[4/5] md:aspect-[3/4] rounded-3xl overflow-hidden shadow-2xl ring-1 ring-slate-900/10 bg-slate-100">
            @if ($testimonial->image)
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                     decoding="async" class="w-full h-full object-cover">
            @else
                <x-image-placeholder label="Foto {{ $testimonial->name }}" class="w-full h-full" />
            @endif
        </div>
    </div>

    <div class="relative z-10 md:col-span-7 md:col-start-6 -mt-10 md:-mt-32">
        <div class="relative rounded-3xl bg-white shadow-xl ring-1 ring-slate-900/5 px-6 sm:px-10 py-8 sm:py-10 overflow-hidden">
            <span class="absolute -top-7 -left-2 font-serif text-[110px] leading-none text-gold-200 select-none pointer-events-none" aria-hidden="true">&ldquo;</span>

            <blockquote class="relative font-serif text-slate-700 text-xl sm:text-2xl leading-relaxed">
                {{ $testimonial->quote }}
            </blockquote>

            <footer class="relative mt-7 pt-6 border-t border-slate-100">
                <p class="font-semibold text-slate-900">{{ $testimonial->name }}</p>
                <p class="text-slate-500">{{ $testimonial->campus }}</p>
                <p class="text-sm font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
            </footer>
        </div>
    </div>
</div>