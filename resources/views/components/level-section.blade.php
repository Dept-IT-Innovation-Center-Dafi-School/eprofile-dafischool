@props(['eyebrow', 'title', 'items', 'emptyMessage' => 'Belum ada data.'])

<section id="{{ \Illuminate\Support\Str::slug($title) }}" class="max-w-6xl mx-auto px-4 mt-12 scroll-mt-20">
    <x-section-heading :eyebrow="$eyebrow" :title="$title" />

    @if ($items->isEmpty())
        <div role="status" class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 p-8 text-center">
            <p class="text-sm text-slate-400">{{ $emptyMessage }}</p>
        </div>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            {{ $slot }}
        </div>
    @endif
</section>
