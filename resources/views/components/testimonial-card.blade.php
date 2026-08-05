@props(['testimonial'])

<article class="testimonial-card h-full flex flex-col bg-white rounded-2xl shadow-lg ring-1 ring-slate-900/5 px-6 py-7 sm:px-8">
    <span class="font-serif text-5xl leading-none text-gold-200 select-none" aria-hidden="true">&ldquo;</span>

    <blockquote class="mt-3 flex-1 text-slate-700 leading-relaxed">
        {{ $testimonial->quote }}
    </blockquote>

    <footer class="mt-6 pt-5 border-t border-slate-100">
        <p class="font-semibold text-slate-900">{{ $testimonial->name }}</p>
        <p class="text-slate-500">{{ $testimonial->campus }}</p>
        <p class="text-sm font-semibold tracking-wide text-gold-600">Angkatan {{ $testimonial->batch }}</p>
    </footer>
</article>