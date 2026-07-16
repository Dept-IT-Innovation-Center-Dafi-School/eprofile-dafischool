# Spec: Homepage Hero Polish

## Objective
Halaman beranda (`/`) saat ini cuma hero carousel fullscreen (foto fasilitas sekolah,
sesuai kemauan tim marketing) + 1 tombol CTA — gak ada logo, gak ada teks, pagination
polos bawaan Swiper. Dari sisi developer, tampilan ini terasa terlalu polos.

Tujuan: nambah polesan UI/UX **di atas** carousel fullscreen yang sudah disetujui
marketing, tanpa mengubah konsepnya (tetap 1 layar penuh, foto fasilitas sebagai
elemen utama, tanpa footer/section tambahan di bawahnya).

Sukses = beranda terasa lebih premium/niat, tapi first-impression (fullscreen photo
carousel) tetap seperti yang diminta marketing.

## Scope
1. **Logo + nama sekolah overlay** — pojok kiri atas, fixed, background glass/blur.
2. **Headline + tagline overlay** — teks nama sekolah (sudah ada tapi `sr-only`) dan
   tagline singkat, ditampilkan visual dengan fade-in, posisi lower-third hero.
3. **Pagination premium** — ganti dots Swiper bawaan jadi bullet premium (pill-shaped
   saat aktif) + counter angka (`01 / 08`) yang disinkronkan lewat event `slideChange`.
4. **Floating WhatsApp quick-action button** — tombol melayang pojok kanan bawah,
   selalu tampil (beda dari back-to-top yang scroll-dependent & memang di-hide di
   halaman ini), link ke `https://wa.me/{whatsapp_number}` dari `SchoolSetting`.

**Eksplisit di luar scope:**
- Footer TIDAK ditambahkan ke beranda (halaman tetap pola "cover/splash", footer
  lengkap tetap di halaman `/levels` seperti sekarang).
- Favicon (`public/favicon.ico`, saat ini 0 byte) tidak disentuh — beda konteks dari
  "logo di halaman", bisa jadi task terpisah kalau diperlukan.
- Caption per-slide TIDAK ditambahkan — headline/tagline bersifat statis site-wide,
  bukan per-foto, supaya gak nambah beban admin isi caption tiap upload slide baru.
- **Efek zoom/Ken Burns pada foto slide TIDAK dipakai** (direvisi 2026-07-16, sempat
  diimplementasi lalu dicabut) — foto dari tim marketing sudah diedit dengan teks
  tertanam di gambar (mis. nama gedung, keterangan fasilitas). Zoom/pan apa pun bikin
  teks itu sulit dibaca selagi foto bergerak. Foto slide harus statis, tidak ada
  transform/animation apa pun pada `<img>`-nya.

## Assumptions
1. Logo diupload lewat halaman admin `/admin/settings` (pola sama seperti field lain
   di `SchoolSetting`), disimpan sebagai path via `HandlesImageUpload` trait yang
   sudah ada — bukan file statis di `public/`.
2. Headline & tagline teks **statis/hardcoded** di Blade (`home.blade.php`), bukan
   admin-editable — konsisten dengan sr-only H1 yang sudah hardcoded sekarang. Kalau
   nanti marketing mau ubah teksnya, itu perubahan kode kecil, bukan lewat admin panel.
3. Kalau `SchoolSetting::current()->logo` kosong (belum upload), overlay logo
   nge-fallback ke teks nama sekolah aja (tanpa gambar) — jangan tampilkan broken
   image atau placeholder aneh di hero.
4. Fade-in animation (logo/headline/tagline) di-skip untuk user dengan
   `prefers-reduced-motion: reduce` (aksesibilitas). Foto slide sendiri tidak punya
   animasi apa pun (lihat revisi di atas), jadi tidak perlu guard reduced-motion
   khusus untuk foto.
5. Nomor WhatsApp floating button ambil dari `SchoolSetting::current()->whatsapp_number`
   yang sudah ada (field sama yang dipakai footer) — kalau kosong, tombol disembunyikan.

→ Koreksi kalau ada asumsi yang salah, sebelum saya lanjut ke Plan.

## Tech Stack
Tidak ada dependency baru. Tetap Laravel 13 + Livewire 4 + Blade + Tailwind CSS 4 +
Vite + Swiper (sudah terpasang, lihat `resources/js/hero-swiper.js`).

## Commands
```bash
composer run dev     # server + queue + pail + vite (dev mode)
npm run build         # build asset production
composer run test     # PHPUnit (Feature + Unit)
vendor/bin/pint       # format PHP sebelum commit
```

## Project Structure (bagian yang disentuh)
```
app/Models/SchoolSetting.php                          → tambah kolom `logo` ke $fillable
app/Livewire/Admin/Settings/Manager.php                → tambah upload logo (pakai HandlesImageUpload)
resources/views/livewire/admin/settings/manager.blade.php → tambah field upload logo
database/migrations/xxxx_add_logo_to_school_settings_table.php → migration baru
resources/views/home.blade.php                         → overlay logo, headline, tagline, WA button
resources/views/components/hero-overlay.blade.php      → (baru) komponen overlay logo+headline, reusable
resources/js/hero-swiper.js                             → pagination numbered/progress bar
resources/css/app.css                                   → keyframes fade-in + prefers-reduced-motion guard (foto slide statis, tanpa animasi)
routes/web.php                                           → tambah `logo` ke data yang dikirim ke view `home` (via SchoolSetting)
tests/Feature/Admin/SchoolSettingsPageTest.php          → tambah case upload/hapus logo
tests/Feature/HomePageHeroTest.php (baru)                → assert logo/headline/WA button muncul sesuai kondisi
```

## Code Style
Ikuti pola yang sudah ada di file sejenis. Contoh floating button (dari
`resources/views/components/back-to-top.blade.php`), tombol WA baru mengikuti pola
yang sama tapi warna WhatsApp-brand dan selalu terlihat (gak pakai class `hidden`
yang di-toggle JS):

```blade
<a href="https://wa.me/{{ $setting->whatsapp_number }}" target="_blank" rel="noopener noreferrer"
   class="fixed bottom-5 right-3 sm:right-5 z-40 inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#25D366] hover:bg-[#1ebc59] text-white shadow-lg active:scale-90 transition"
   aria-label="Hubungi via WhatsApp">
    <svg ...></svg>
</a>
```

Upload logo di Settings Manager mengikuti pola `HandlesImageUpload` yang sudah dipakai
di komponen admin lain (mis. `HeroSlides/Manager.php`) — reuse trait, jangan tulis
ulang logic upload/delete image.

## Testing Strategy
- **Feature test baru** (`tests/Feature/HomePageHeroTest.php`): assert elemen logo
  overlay muncul saat `SchoolSetting::logo` terisi, dan fallback teks saat kosong;
  assert tombol WA muncul/hilang sesuai `whatsapp_number`.
- **Feature test existing** (`SchoolSettingsPageTest.php`): tambah case upload logo
  baru, ganti logo, hapus logo — ikuti pola test upload yang sudah ada untuk
  hero slides/education levels.
- Test regresi: assert foto slide TIDAK punya class animasi/transform apa pun
  (mis. `animate-kenburns` sudah dihapus permanen) — supaya kalau ada yang nambah
  efek zoom lagi di masa depan tanpa baca spec ini, test-nya gagal duluan.
- Animasi murni CSS lain (fade-in logo/headline) tidak perlu test otomatis — cek
  manual di browser (`composer run dev`) termasuk cek `prefers-reduced-motion`.
- Jalankan `composer run test` sebelum commit, harus tetap hijau.

## Boundaries
- **Always do:** jalankan `composer run test` & `vendor/bin/pint` sebelum commit;
  reuse `HandlesImageUpload` trait untuk logo, jangan bikin logic upload baru;
  hormati `prefers-reduced-motion` untuk semua animasi baru.
- **Ask first:** kalau ternyata perlu ubah tinggi/struktur hero (`h-screen`) atau
  nambah section baru di bawahnya — itu di luar spec ini, konfirmasi dulu.
- **Never do:** ubah carousel jadi non-fullscreen, tambah footer/section scroll baru
  di beranda, bikin caption per-slide, sentuh `public/favicon.ico`, atau tambahkan
  efek zoom/pan/transform animasi apa pun ke foto slide (`<img>` di dalam
  `.swiper-slide`) — foto sudah berisi teks tertanam dari tim marketing yang harus
  tetap terbaca statis.

## Success Criteria
- Logo sekolah (kalau sudah diupload admin) tampil di pojok kiri atas hero, dengan
  fallback teks nama sekolah kalau logo belum diupload.
- Headline + tagline sekolah terlihat jelas di atas carousel (bukan lagi `sr-only`).
- Pagination custom (bullet premium + counter angka) jalan di semua slide.
- Foto slide statis — tidak ada efek zoom/pan/transform animasi apa pun, supaya teks
  yang tertanam di foto (dari tim marketing) tetap mudah dibaca.
- Tombol WhatsApp melayang muncul di beranda kalau nomor WA terisi di admin settings.
- Viewport pertama tetap fullscreen carousel, TIDAK ada footer/section baru di bawahnya.
- `composer run test` tetap hijau, ada test baru untuk logo overlay, upload logo, dan
  regresi "foto slide tidak punya efek zoom".

## Open Questions
- Teks headline & tagline final — pakai yang sudah ada ("Darul Fikri - Sekolah Islam
  Terpadu" + deskripsi meta yang sudah ada), atau ada copy baru dari tim marketing?
