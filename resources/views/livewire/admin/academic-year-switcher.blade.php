<div>
    @if ($years->isEmpty())
        <a href="{{ route('admin.academic-years.index') }}"
           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 text-xs font-semibold hover:bg-amber-100 transition">
            <x-admin.icon name="calendar" class="w-4 h-4" />
            Belum ada tahun ajaran, tambah dulu
        </a>
    @else
        <label class="sr-only" for="academic-year-switcher">Tahun ajaran yang sedang dikelola</label>
        <div class="relative">
            <x-admin.icon name="calendar" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none" />
            <select id="academic-year-switcher"
                    wire:change="switchTo($event.target.value)"
                    class="pl-9 pr-8 py-1.5 text-sm font-medium border border-slate-300 rounded-lg bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-primary-500 appearance-none">
                @foreach ($years as $year)
                    <option value="{{ $year->id }}" @selected($current?->id === $year->id)>
                        {{ $year->label }}{{ $year->is_active ? ' (Aktif)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    @endif
</div>
