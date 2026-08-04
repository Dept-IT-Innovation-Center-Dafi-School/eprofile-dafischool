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
2. **Pagination premium** — ganti dots Swiper bawaan jadi bullet premium (pill-shaped
   saat aktif) + counter angka (`01 / 08`) yang disinkronkan lewat event `slideChange`.
3. **Floating WhatsApp quick-action button** — tombol melayang pojok kanan bawah,
   selalu tampil (beda dari back-to-top yang scroll-dependent & memang di-hide di
   halaman ini), link ke `https://wa.me/{whatsapp_number}` dari `SchoolSetting`.
4. **Foto slide full-bleed di semua ukuran layar** (direvisi 2026-07-16) — `object-cover`
   di semua breakpoint (bukan cuma mobile), foto selalu memenuhi 1 layar penuh tanpa
   letterbox. Trik blurred-backdrop duplikat (`scale-110 blur-2xl`) yang sebelumnya
   dipakai untuk mengisi ruang kosong di desktop (`object-contain`) dihapus karena
   sudah tidak diperlukan.

**Eksplisit di luar scope:**
- Footer TIDAK ditambahkan ke beranda (halaman tetap pola "cover/splash", footer
  lengkap tetap di halaman `/levels` seperti sekarang).
- Favicon (`public/favicon.ico`, saat ini 0 byte) tidak disentuh — beda konteks dari
  "logo di halaman", bisa jadi task terpisah kalau diperlukan.
- Caption per-slide TIDAK ditambahkan.
- **Efek zoom/Ken Burns pada foto slide TIDAK dipakai** (direvisi 2026-07-16, sempat
  diimplementasi lalu dicabut) — foto dari tim marketing sudah diedit dengan teks
  tertanam di gambar (mis. nama gedung, keterangan fasilitas). Zoom/pan apa pun bikin
  teks itu sulit dibaca selagi foto bergerak. Foto slide harus statis, tidak ada
  transform/animation apa pun pada `<img>`-nya.
- **Headline + tagline overlay DIHAPUS TOTAL** (direvisi 2026-07-16, sempat
  diimplementasi lalu dicabut) — awalnya ditambahkan sebagai teks besar di tengah
  hero ("Darul Fikri" + tagline). Dicabut karena foto dari marketing sudah punya
  teks sendiri yang tertanam di gambar; teks overlay tambahan bikin dua lapis teks
  bertumpuk di atas foto yang sama dan malah menyulitkan pembacaan — kebalikan dari
  tujuan awal (bikin lebih premium). Badge logo+nama sekolah kecil di pojok kiri
  atas TETAP ADA (itu elemen berbeda dari headline/tagline, bukan teks besar yang
  menimpa tengah foto).

## Assumptions
1. Logo diupload lewat halaman admin `/admin/settings` (pola sama seperti field lain
   di `SchoolSetting`), disimpan sebagai path via `HandlesImageUpload` trait yang
   sudah ada — bukan file statis di `public/`.
2. Kalau `SchoolSetting::current()->logo` kosong (belum upload), overlay logo
   nge-fallback ke teks nama sekolah aja (tanpa gambar) — jangan tampilkan broken
   image atau placeholder aneh di hero.
3. Fade-in animation cuma untuk badge logo/nama sekolah di pojok kiri atas (headline/
   tagline besar di tengah sudah dihapus, lihat revisi di atas), di-skip untuk user
   dengan `prefers-reduced-motion: reduce`. Foto slide sendiri tidak punya animasi
   apa pun.
4. Nomor WhatsApp floating button ambil dari `SchoolSetting::current()->whatsapp_number`
   yang sudah ada (field sama yang dipakai footer) — kalau kosong, tombol disembunyikan.
5. **Foto boleh terpotong (crop) di tepi pada rasio layar tertentu** akibat
   `object-cover` full-bleed di semua breakpoint — dikonfirmasi user sebagai trade-off
   yang diterima demi tampilan full-screen konsisten, meskipun berpotensi memotong
   teks yang tertanam di foto di sebagian rasio layar. Tim marketing perlu tahu ini
   saat menyiapkan foto (hindari menaruh teks penting terlalu dekat ke tepi gambar).

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
resources/views/home.blade.php                         → overlay logo badge, WA button, foto full-bleed object-cover (tanpa headline/tagline, tanpa blurred backdrop)
resources/js/hero-swiper.js                             → pagination numbered/progress bar
resources/css/app.css                                   → keyframes fade-in (badge logo) + prefers-reduced-motion guard (foto slide statis, tanpa animasi)
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
- Test regresi: assert halaman TIDAK menampilkan headline/tagline besar (mis. tidak
  ada string tagline lama seperti "Pendidikan berkualitas dari RTK hingga SMA") —
  supaya kalau ada yang nambah lagi teks overlay besar di masa depan, test gagal duluan.
- Test regresi: assert foto slide pakai `object-cover` di semua breakpoint (tidak ada
  class `lg:object-contain` atau backdrop blur duplikat lagi).
- Animasi murni CSS lain (fade-in badge logo) tidak perlu test otomatis — cek
  manual di browser (`composer run dev`) termasuk cek `prefers-reduced-motion`.
- Jalankan `composer run test` sebelum commit, harus tetap hijau.

## Boundaries
- **Always do:** jalankan `composer run test` & `vendor/bin/pint` sebelum commit;
  reuse `HandlesImageUpload` trait untuk logo, jangan bikin logic upload baru;
  hormati `prefers-reduced-motion` untuk semua animasi baru.
- **Ask first:** kalau ternyata perlu ubah tinggi/struktur hero (`h-screen`) atau
  nambah section baru di bawahnya — itu di luar spec ini, konfirmasi dulu.
- **Never do:** ubah carousel jadi non-fullscreen, tambah footer/section scroll baru
  di beranda, bikin caption per-slide, sentuh `public/favicon.ico`, tambahkan efek
  zoom/pan/transform animasi apa pun ke foto slide (`<img>` di dalam `.swiper-slide`),
  atau tambahkan teks overlay besar (headline/tagline) di atas foto — foto sudah
  berisi teks tertanam dari tim marketing, dua lapis teks bikin susah dibaca.

## Success Criteria
- Logo sekolah (kalau sudah diupload admin) tampil di pojok kiri atas hero (badge
  kecil), dengan fallback teks nama sekolah kalau logo belum diupload.
- TIDAK ADA headline/tagline besar di atas foto — foto tampil bersih tanpa teks
  overlay tambahan, supaya teks yang sudah tertanam di foto tetap mudah dibaca.
- Pagination custom (bullet premium + counter angka) jalan di semua slide.
- Foto slide statis (tidak ada efek zoom/pan/transform) DAN full-bleed `object-cover`
  di semua ukuran layar (tidak ada letterbox/blurred-backdrop lagi di desktop).
- Tombol WhatsApp melayang muncul di beranda kalau nomor WA terisi di admin settings.
- Viewport pertama tetap fullscreen carousel, TIDAK ada footer/section baru di bawahnya.
- `composer run test` tetap hijau, dengan test regresi untuk: tidak ada efek zoom,
  tidak ada headline/tagline, dan foto pakai `object-cover` di semua breakpoint.

## Open Questions
(tidak ada — headline/tagline sudah dihapus total, jadi pertanyaan soal copy final
sudah tidak relevan lagi)

## Revision Log
- **2026-07-16 (awal):** Spec awal — logo overlay, headline/tagline, pagination
  premium + Ken Burns, floating WA button.
- **2026-07-16 (revisi 1):** Ken Burns dicabut — foto marketing sudah ada teks
  tertanam, zoom bikin teks susah dibaca.
- **2026-07-16 (revisi 2):** Headline/tagline overlay dicabut total (alasan sama:
  dua lapis teks di atas foto yang sama susah dibaca), dan foto slide diganti jadi
  full-bleed `object-cover` di semua ukuran layar (hapus trik blurred-backdrop
  `object-contain` di desktop) — foto boleh crop di tepi, trade-off diterima demi
  tampilan full-screen konsisten.
