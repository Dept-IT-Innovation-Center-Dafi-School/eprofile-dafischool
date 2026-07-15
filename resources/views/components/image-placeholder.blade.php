@props(['label' => null, 'compact' => false])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center gap-1.5 bg-slate-100 text-slate-400']) }}>
    <svg xmlns="http://www.w3.org/2000/svg" class="{{ $compact ? 'w-4 h-4' : 'w-7 h-7' }} shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" />
        <circle cx="9" cy="9" r="1.25" fill="currentColor" stroke="none" />
    </svg>
    @unless ($compact)
        <span class="text-xs font-medium text-center px-2 line-clamp-2">{{ $label ?: 'Belum ada gambar' }}</span>
    @endunless
</div>
