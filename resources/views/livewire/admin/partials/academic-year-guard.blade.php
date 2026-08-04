@if (! app(App\Services\AcademicYearContext::class)->current())
    <div role="alert" class="p-3 bg-amber-50 border border-amber-200 rounded-lg text-amber-700 text-sm">
        Pilih atau
        <a href="{{ route('admin.academic-years.index') }}" class="font-semibold underline">buat tahun ajaran dulu</a>
        sebelum menambah data.
    </div>
@endif
