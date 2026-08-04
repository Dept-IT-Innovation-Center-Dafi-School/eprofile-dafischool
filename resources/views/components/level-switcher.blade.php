@props(['current', 'all'])

<nav aria-label="Pilih jenjang lain" class="flex gap-2 overflow-x-auto">
    @foreach ($all as $level)
        @php $isActive = $level->id === $current->id; @endphp
        <a href="{{ route('levels.show', $level->slug) }}"
           title="{{ $level->name }}"
           @if ($isActive) aria-current="page" @endif
           class="shrink-0 px-4 py-1.5 rounded-full text-sm font-bold transition
                  {{ $isActive
                      ? 'bg-primary-700 text-white shadow-sm'
                      : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-primary-700' }}">
            {{ strtoupper($level->slug) }}
        </a>
    @endforeach
</nav>
