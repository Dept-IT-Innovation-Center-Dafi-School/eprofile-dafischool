@php
    // Unlike other public views, this partial fetches its own data instead of
    // receiving it from a controller — it's shared across pages that don't all
    // pass school-info down, and there's no View Composer set up in this app
    // yet to do it more conventionally. Keep this the only exception; move to
    // a View Composer if more shared partials end up needing their own data.
    $setting = \App\Models\SchoolSetting::current();
    $social = collect([
        'instagram' => $setting->instagram_url,
        'facebook' => $setting->facebook_url,
        'youtube' => $setting->youtube_url,
    ])->filter();
@endphp

<footer class="bg-primary-950 text-primary-100">
    <div class="max-w-6xl mx-auto px-4 py-14 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        <div class="lg:col-span-1">
            <span class="font-display text-white text-xl font-extrabold">{{ $setting->school_name }}</span>
            <p class="mt-3 text-sm text-primary-200 leading-relaxed">
                Sekolah Islam Terpadu yang menyatukan akademik dan nilai-nilai Islami,
                dari jenjang RTK/KB hingga SMA.
            </p>
            @if ($social->isNotEmpty())
                <div class="flex items-center gap-3 mt-5">
                    @if ($social->get('instagram'))
                        <a href="{{ $social->get('instagram') }}" target="_blank" rel="noopener noreferrer"
                           aria-label="Instagram {{ $setting->school_name }}"
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-gold-500 hover:text-primary-950 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    @endif
                    @if ($social->get('facebook'))
                        <a href="{{ $social->get('facebook') }}" target="_blank" rel="noopener noreferrer"
                           aria-label="Facebook {{ $setting->school_name }}"
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-gold-500 hover:text-primary-950 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 9h3V6h-3a3 3 0 00-3 3v3H9v3h2v6h3v-6h3l1-3h-4v-2a1 1 0 011-1z" />
                            </svg>
                        </a>
                    @endif
                    @if ($social->get('youtube'))
                        <a href="{{ $social->get('youtube') }}" target="_blank" rel="noopener noreferrer"
                           aria-label="YouTube {{ $setting->school_name }}"
                           class="w-9 h-9 flex items-center justify-center rounded-full bg-white/10 hover:bg-gold-500 hover:text-primary-950 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="2.5" y="5.5" width="19" height="13" rx="3.5" />
                                <path d="M10.5 9.5l5 2.5-5 2.5v-5z" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <nav aria-label="Tautan cepat">
            <h2 class="font-display text-white text-sm font-bold uppercase tracking-wider mb-4">Tautan</h2>
            <ul class="space-y-2.5 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-gold-300 transition">Beranda</a></li>
                <li><a href="{{ route('levels.index') }}" class="hover:text-gold-300 transition">Jenjang Pendidikan</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="font-display text-white text-sm font-bold uppercase tracking-wider mb-4">Kontak</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mt-0.5 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>{{ $setting->address }}</span>
                </li>
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.163 21 3 14.837 3 7V6z" />
                    </svg>
                    <a href="https://wa.me/{{ $setting->whatsapp_number }}" target="_blank" rel="noopener noreferrer" class="hover:text-gold-300 transition">{{ $setting->phone }}</a>
                </li>
                <li class="flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0 text-gold-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <a href="mailto:{{ $setting->email }}" class="hover:text-gold-300 transition">{{ $setting->email }}</a>
                </li>
            </ul>
        </div>

        <div class="lg:col-span-1">
            <h2 class="font-display text-white text-sm font-bold uppercase tracking-wider mb-4">Lokasi</h2>
            <div class="rounded-xl overflow-hidden border border-white/10 aspect-video">
                <iframe
                    src="{{ $setting->maps_embed_url }}"
                    class="w-full h-full"
                    style="border:0;"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="strict-origin-when-cross-origin"
                    title="Lokasi {{ $setting->school_name }} di Google Maps"></iframe>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="max-w-6xl mx-auto px-4 py-5 text-xs text-primary-300 text-center">
            &copy; {{ now()->year }} {{ $setting->school_name }}. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>
