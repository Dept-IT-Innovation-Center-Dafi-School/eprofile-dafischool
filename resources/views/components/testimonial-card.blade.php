@props(['testimonial'])

<div class="h-full rounded-2xl bg-white shadow-sm ring-1 ring-slate-900/5 p-6 flex flex-col">
    <div class="text-gold-400 text-4xl leading-none mb-3" aria-hidden="true">&ldquo;</div>
    <blockquote class="flex-1 text-slate-700 leading-relaxed">{{ $testimonial->quote }}</blockquote>
    <footer class="mt-5 pt-5 border-t border-slate-100 flex items-center gap-3">
        <div class="w-12 h-12 rounded-full overflow-hidden shrink-0 bg-slate-100 ring-2 ring-gold-100">
            @if ($testimonial->image)
                <img src="{{ $testimonial->image }}" alt="{{ $testimonial->name }}" loading="lazy"
                     decoding="async" class="w-full h-full object-cover">
            @else
                <x-image-placeholder compact class="w-full h-full" />
            @endif
        </div>
        <div class="min-w-0">
            <p class="font-semibold text-slate-900 truncate">{{ $testimonial->name }}</p>
            <p class="text-sm text-slate-500 truncate">{{ $testimonial->campus }}</p>
            <p class="text-xs font-semibold text-gold-600">Angkatan {{ $testimonial->batch }}</p>
        </div>
    </footer>
</div>