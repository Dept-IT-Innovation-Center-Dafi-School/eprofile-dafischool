@props(['testimonial'])

<div class="mx-auto max-w-3xl px-2">
    <div class="relative rounded-3xl bg-white shadow-xl ring-1 ring-slate-900/5 px-6 sm:px-12 py-10 sm:py-12 overflow-hidden">
        <span class="absolute -top-7 -left-2 font-serif text-[130px] leading-none text-gold-200 select-none pointer-events-none" aria-hidden="true">&ldquo;</span>

        <blockquote class="relative font-serif text-slate-700 text-xl sm:text-2xl leading-relaxed sm:leading-relaxed">
            {{ $testimonial->quote }}
        </blockquote>

        <footer class="relative mt-8 pt-7 border-t border-slate-100 flex flex-col sm:flex-row items-center sm:items-center gap-4">
            <div class="w-16 h-16 rounded-full overflow-hidden shrink-0 bg-slate-100 ring-2 ring-gold-400 ring-offset-2 ring-offset-white">
                @if ($testimonial->image)
                    <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                         decoding="async" class="w-full h-full object-cover">
                @else
                    <x-image-placeholder compact class="w-full h-full" />
                @endif
            </div>
            <div class="text-center sm:text-left">
                <p class="font-semibold text-slate-900">{{ $testimonial->name }}</p>
                <p class="text-slate-500">{{ $testimonial->campus }}</p>
                <p class="text-sm font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
            </div>
        </footer>
    </div>
</div>