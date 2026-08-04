@php
    $previousUrl = url()->previous();
    $backUrl = $previousUrl !== url()->current() ? $previousUrl : route('home');
@endphp

<x-layout title="Halaman Tidak Ditemukan - Darul Fikri" description="Halaman yang Anda cari tidak ditemukan.">
    <main class="max-w-xl mx-auto px-4 py-24 text-center">
        <div class="w-20 h-20 rounded-full bg-primary-50 flex items-center justify-center mx-auto mb-5 text-4xl">🔍</div>
        <h1 class="font-display text-2xl font-bold text-primary-800 mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-slate-500 mb-8">
            Maaf, halaman yang Anda cari tidak tersedia.
        </p>
        <a href="{{ $backUrl }}"
           class="inline-flex items-center justify-center min-h-[44px] px-6 py-3 rounded-full bg-primary-700 hover:bg-primary-800 text-white font-semibold shadow-md transition">
            &larr; Kembali ke Halaman Sebelumnya
        </a>
    </main>
</x-layout>
