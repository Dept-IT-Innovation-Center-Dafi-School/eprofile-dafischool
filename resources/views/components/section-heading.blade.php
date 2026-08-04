@props(['eyebrow', 'title'])

<div class="mb-5">
    <p class="text-gold-600 text-xs font-bold uppercase tracking-[0.2em] mb-1">{{ $eyebrow }}</p>
    <div class="flex items-center gap-3">
        <h2 class="font-display text-xl sm:text-2xl font-bold text-primary-800">{{ $title }}</h2>
        <span class="flex-1 h-px bg-primary-100"></span>
    </div>
</div>
