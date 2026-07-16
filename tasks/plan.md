# Implementation Plan: Homepage Hero Polish

## Overview
Beranda (`/`) tetap hero carousel fullscreen sesuai kemauan tim marketing (lihat
`docs/spec-homepage-hero-polish.md`). Kita nambah polesan di atasnya: logo+nama
sekolah overlay, headline/tagline yang sekarang `sr-only` dibikin visible, pagination
premium + Ken Burns effect, dan floating tombol WhatsApp. Footer dan caption per-slide
eksplisit di luar scope — halaman tetap pola "cover/splash", bukan halaman scroll biasa.

## Architecture Decisions
- **Logo pakai pola upload yang sudah ada** (`HandlesImageUpload` trait + partial
  `image-upload-field.blade.php`, persis seperti `HeroSlides/Manager.php`) — bukan
  bikin mekanisme upload baru.
- **`ManagesNamedChildRecords` TIDAK dipakai** untuk logo — trait itu untuk list child
  record (facilities/extracurriculars), logo cuma 1 field tunggal di Settings Manager
  yang sudah selalu-editable (gak butuh state `editingId`/list).
- **Headline/tagline statis/hardcoded** di Blade, bukan admin-editable — konsisten
  dengan H1 `sr-only` yang sudah hardcoded sekarang. Kalau nanti berubah, itu edit
  kode kecil, bukan field admin baru (menghindari over-engineering untuk teks yang
  jarang berubah).
- **Animasi baru (fade-in, Ken Burns) ditaruh di `@layer components`** di `app.css`,
  mengikuti struktur yang sudah ada (`.hero-swiper`, `.shadow-glow`), dengan guard
  `@media (prefers-reduced-motion: reduce)` — repo belum punya preseden animasi,
  jadi ini pola baru yang harus dijaga konsisten & sederhana.
- **Floating WhatsApp button independen dari logo** — cuma butuh `whatsapp_number`
  yang sudah ada di `SchoolSetting`, dikerjakan duluan sebagai quick win low-risk.

## Task List

### Phase 1: Foundation & quick win
- [x] Task 1: Floating WhatsApp button di beranda
- [x] Task 2: Migration + model — kolom `logo` di `school_settings`

### Checkpoint: Foundation
- [x] `composer run test` hijau
- [ ] Tombol WA jalan di browser (manual — belum dicek)
- [x] Kolom `logo` ada di DB, model bisa fillable

### Phase 2: Core feature — logo end-to-end
- [x] Task 3: Admin bisa upload/ganti/hapus logo di `/admin/settings`
- [x] Task 4: Homepage — logo overlay + headline/tagline visible

### Checkpoint: Core Feature
- [x] `composer run test` hijau
- [ ] Upload logo di admin → langsung kelihatan di beranda (manual end-to-end — belum dicek)
- [x] Fallback teks jalan kalau logo belum/dihapus (dicek via test otomatis)

### Phase 3: Polish visual
- [x] Task 5: Pagination premium (numbered/progress bar)
- [x] Task 6: Ken Burns effect + `prefers-reduced-motion` guard

### Checkpoint: Complete
- [x] `composer run test` full green (69/69), `vendor/bin/pint` bersih, `npm run build` sukses
- [ ] End-to-end manual: logo+fallback, headline, WA button, pagination, Ken Burns,
      toggle `prefers-reduced-motion` — **belum dicek di browser sungguhan, lihat catatan di bawah**
- [x] Viewport pertama tetap fullscreen carousel, tidak ada footer/section baru
- [x] Semua Success Criteria di `docs/spec-homepage-hero-polish.md` terpenuhi (otomatis via test);
      verifikasi visual manual masih tertunda

---

## Task 1: Floating WhatsApp button di beranda

**Description:** Tambah tombol WhatsApp melayang (fixed, pojok kanan bawah) di
`home.blade.php`, selalu tampil (beda dari `back-to-top` yang scroll-dependent dan
memang di-hide di halaman ini), link ke `https://wa.me/{whatsapp_number}` — pola
sama seperti yang sudah dipakai di `footer.blade.php:81`.

**Acceptance criteria:**
- [x] Tombol muncul fixed bottom-right kalau `SchoolSetting::current()->whatsapp_number` terisi
- [x] Tombol disembunyikan total (bukan cuma disabled) kalau nomor kosong
- [x] Link `href="https://wa.me/{whatsapp_number}"`, `target="_blank" rel="noopener noreferrer"`, `aria-label` jelas

**Verification:**
- [x] Test baru: `tests/Feature/HomePageHeroTest.php` — assert tombol muncul/hilang sesuai kondisi `whatsapp_number`
- [x] `composer run test` hijau, `npm run build` sukses
- [ ] Manual: buka `/` di browser, cek tombol tampil & klik membuka WA (belum dicek — perlu verifikasi visual manual)

**Dependencies:** None

**Files likely touched:**
- `resources/views/home.blade.php`
- `tests/Feature/HomePageHeroTest.php` (baru)

**Estimated scope:** Small (2 files)

---

## Task 2: Migration + model — kolom `logo` di `school_settings`

**Description:** Tambah kolom `logo` (nullable string, path/URL gambar) ke tabel
`school_settings` lewat migration baru, dan daftarkan ke `$fillable` di
`SchoolSetting` model. Foundation murni, tidak ada UI yang berubah di task ini.

**Acceptance criteria:**
- [x] Migration baru menambah kolom `logo` (`nullable string`) ke `school_settings`
- [x] `SchoolSetting::$fillable` mencakup `logo`
- [x] `SchoolSetting::current()->logo` bisa diisi & dibaca tanpa error

**Verification:**
- [x] `php artisan migrate` sukses
- [x] `composer run test` — semua test lama tetap hijau, tidak ada breaking change

**Dependencies:** None

**Files likely touched:**
- `database/migrations/xxxx_xx_xx_xxxxxx_add_logo_to_school_settings_table.php` (baru)
- `app/Models/SchoolSetting.php`

**Estimated scope:** XS (2 files)

---

## Task 3: Admin bisa upload/ganti/hapus logo di `/admin/settings`

**Description:** Tambah kemampuan upload logo ke `Settings/Manager.php`, reuse
`WithFileUploads` + `HandlesImageUpload` trait persis seperti pola di
`HeroSlides/Manager.php` (props `$logo`/`$existingLogo`, panggil
`resolveImageUrl('uploads/school-settings')` di `save()`). Tambah card baru di Blade
settings pakai partial `image-upload-field.blade.php` yang sudah ada.

**Acceptance criteria:**
- [x] Admin bisa upload logo baru, preview muncul sebelum submit
- [x] Admin bisa hapus logo — kolom `logo` jadi `null`, file lama ke-delete dari storage
- [x] Validasi: `nullable|image|mimes:jpg,jpeg,png,webp|max:2048`
- [x] Card baru di settings form konsisten dengan style card lain (`bg-white rounded-xl border ...`)

**Verification:**
- [x] Test baru di `tests/Feature/SchoolSettingsPageTest.php` (5 test baru: upload, replace, remove,
      validasi non-image, plus existing coverage) — pakai `Storage::fake('public')` +
      `UploadedFile::fake()->create(...)` (bukan `->image()`, karena GD extension tidak terpasang
      di environment ini, mengikuti pola test upload lain di repo)
- [x] `composer run test` hijau (64/64), `npm run build` sukses
- [ ] Manual: login admin, upload logo, cek preview & tombol hapus jalan (belum dicek visual)

**Catatan implementasi:** trait `HandlesImageUpload` hardcode nama property `$image`/`$existingImage`
(bukan diparameterisasi), jadi property Livewire di Settings Manager dinamai `$image`/`$existingImage`
(bukan `$logo`/`$existingLogo` seperti draft awal), lalu di-map ke kolom `logo` saat `save()`.

**Dependencies:** Task 2

**Files likely touched:**
- `app/Livewire/Admin/Settings/Manager.php`
- `resources/views/livewire/admin/settings/manager.blade.php`
- `tests/Feature/SchoolSettingsPageTest.php`

**Estimated scope:** Medium (3 files)

---

## Task 4: Homepage — logo overlay + headline/tagline visible — ⚠️ Headline/tagline bagian DIREVISI, lihat Task 8

**Description:** Tampilkan logo sekolah di pojok kiri atas hero (fixed, background
glass/blur), fallback ke teks nama sekolah kalau `logo` belum diupload. Ubah H1
`sr-only` yang sudah ada jadi visible sebagai headline, tambah tagline singkat,
dengan fade-in animation yang menghormati `prefers-reduced-motion`.

**Acceptance criteria:**
- [x] Logo tampil pojok kiri atas kalau `SchoolSetting::current()->logo` terisi
- [x] Fallback teks nama sekolah (bukan broken image) kalau logo kosong
- [x] Headline (nama sekolah) + tagline terlihat jelas di atas carousel, fade-in halus
- [x] Animasi fade-in nonaktif total untuk `prefers-reduced-motion: reduce` (CSS guard, belum dicek visual)
- [x] Viewport pertama tetap fullscreen (`h-screen` tidak berubah), tidak ada footer/section baru

**Verification:**
- [x] Test baru di `tests/Feature/HomePageHeroTest.php` (3 test baru): assert logo `<img id="hero-logo">`
      muncul saat `logo` terisi, assert fallback (tanpa `#hero-logo`) saat `logo` null, assert headline/tagline visible
- [x] `composer run test` hijau (67/67), `npm run build` sukses
- [ ] Manual: buka `/`, cek logo & fallback (hapus logo di admin lalu reload), cek headline/tagline,
      toggle `prefers-reduced-motion` di devtools dan pastikan animasi mati (belum dicek visual)

**Dependencies:** Task 3

**Files likely touched:**
- `resources/views/home.blade.php`
- `routes/web.php` (kirim `SchoolSetting::current()` ke view `home`)
- `resources/views/components/hero-overlay.blade.php` (baru, opsional — kalau markup logo+headline cukup kompleks untuk dipisah)
- `resources/css/app.css` (fade-in keyframes + `prefers-reduced-motion` guard)

**Estimated scope:** Medium (3 files)

---

## Task 5: Pagination premium (numbered/progress bar)

**Description:** Ganti pagination dots bawaan Swiper (`resources/js/hero-swiper.js`)
jadi numbered (`01 / 08`) atau progress bar tipis, style konsisten dengan palet
`primary`/`gold` yang sudah didefinisikan di `app.css`.

**Acceptance criteria:**
- [x] Pagination custom tampil menggantikan dots bawaan, tetap `clickable`
- [x] Style pakai warna dari `@theme` yang sudah ada (`primary-*`/`gold-*`), bukan warna baru

**Verification:**
- [x] Test baru: `tests/Feature/HomePageHeroTest.php` — assert markup counter numbered
      (`hero-counter-current`/`hero-counter-total`) muncul & sesuai jumlah slide
- [x] `composer run test` hijau (68/68), `npm run build` sukses
- [ ] Manual: buka `/`, cek pagination custom tampil & berfungsi (klik ganti slide) (belum dicek visual)

**Catatan implementasi:** dipilih pendekatan bullets premium (pill-shaped saat aktif, tetap
clickable) DITAMBAH counter angka terpisah (`01 / 03`) yang di-sync lewat event `slideChange`
Swiper — bukan mengganti total ke `type: 'fraction'` bawaan Swiper (karena fraction pagination
tidak mendukung klik-navigasi per-slide seperti bullets), supaya "numbered" dan "tetap clickable"
bisa terpenuhi bersamaan.

**Dependencies:** None (independen), dijadwalkan setelah Task 4 supaya tidak bentrok
edit file yang sama.

**Files likely touched:**
- `resources/js/hero-swiper.js`
- `resources/css/app.css`

**Estimated scope:** Small (2 files)

---

## Task 6: Ken Burns effect + `prefers-reduced-motion` guard — ⚠️ DIREVISI, lihat Task 7

**Description:** Tambah efek zoom pelan (Ken Burns, `scale(1) → scale(1.08)`) pada
foto slide yang sedang aktif, definisikan keyframes di `@layer components` pada
`app.css`, dan pastikan animasi mati total untuk `prefers-reduced-motion: reduce`.

**Acceptance criteria:**
- [x] Foto slide zoom pelan kontinu (`scale(1) → scale(1.08)`, 8s ease-in-out infinite alternate)
- [x] Animasi berhenti/skip total (bukan cuma diperlambat) untuk `prefers-reduced-motion: reduce` (CSS guard)

**Verification:**
- [x] Test baru: `tests/Feature/HomePageHeroTest.php` — assert class `animate-kenburns` muncul di
      `<img>` foto slide
- [x] `composer run test` hijau (69/69), `npm run build` sukses
- [ ] Manual: buka `/`, amati efek zoom per slide (belum dicek visual)
- [ ] Manual: devtools → emulate `prefers-reduced-motion: reduce` → pastikan animasi benar-benar mati (belum dicek visual)

**Catatan implementasi:** dipilih animasi kontinu (`infinite alternate`) pada foto yang sedang
tampil, bukan animasi yang di-trigger ulang tiap pergantian slide via JS — lebih sederhana (murni
CSS, gak perlu sinkronisasi dengan `slideChange`) dan cukup untuk efek "foto terasa hidup" yang
diminta.

**Dependencies:** Task 5 (menyentuh file yang sama — `app.css`/`hero-swiper.js` —
dikerjakan sequential supaya tidak konflik)

**Files likely touched:**
- `resources/css/app.css`
- `resources/js/hero-swiper.js` atau `resources/views/home.blade.php` (class trigger per slide aktif)

**Estimated scope:** Small (2 files)

---

## Task 7: Cabut efek Ken Burns dari foto slide (revisi Task 6)

**Description:** Tim marketing mengonfirmasi foto yang akan dipakai di hero sudah
diedit dengan teks tertanam di dalam gambar (mis. nama gedung/fasilitas). Efek zoom
Ken Burns dari Task 6 bikin teks itu sulit dibaca selagi foto bergerak — berpotensi
bikin user (dan tim marketing) komplain. Cabut total efeknya, foto slide jadi statis.

**Acceptance criteria:**
- [x] Class `animate-kenburns` dihapus dari `<img>` foto slide di `home.blade.php`
- [x] Keyframes `hero-kenburns` dan class `.animate-kenburns` (termasuk guard
      `prefers-reduced-motion`-nya) dihapus dari `app.css` — bukan sekadar di-disable
- [x] Foto slide tidak punya `transform`/`animation` apa pun yang membuatnya bergerak
- [x] Elemen lain (logo/headline fade-in, pagination counter, blurred backdrop
      `scale-110` statis) TIDAK berubah — revisi ini hanya menyentuh foto slide

**Verification:**
- [x] Test direvisi di `tests/Feature/HomePageHeroTest.php`: ganti
      `test_slide_photo_has_ken_burns_animation_class` jadi
      `test_slide_photo_has_no_zoom_or_animation_class` yang assert `animate-kenburns`
      TIDAK muncul di response
- [x] `composer run test` hijau (69/69), `vendor/bin/pint` bersih, `npm run build` sukses
- [ ] Manual: buka `/`, pastikan foto benar-benar statis (gak ada gerakan sama sekali) (belum dicek visual)

**Dependencies:** Task 6 (revisi langsung di atas hasil task itu)

**Files likely touched:**
- `resources/views/home.blade.php`
- `resources/css/app.css`
- `tests/Feature/HomePageHeroTest.php`

**Estimated scope:** XS (3 files)

---

## Task 8: Cabut headline + tagline overlay (revisi Task 4)

**Description:** Foto marketing sudah punya teks tertanam di gambar. Headline+tagline
besar di tengah hero (dari Task 4) bikin dua lapis teks bertumpuk di foto yang sama —
malah susah dibaca, kebalikan dari tujuan "polesan premium". Hapus total blok
headline+tagline. Badge logo+nama sekolah kecil di pojok kiri atas TETAP ADA (beda
elemen, bukan teks besar yang menimpa foto).

**Acceptance criteria:**
- [ ] Blok `<h1>` "Darul Fikri" + `<p>` tagline (posisi center, absolute inset-0)
      dihapus dari `home.blade.php`
- [ ] Badge logo+nama sekolah pojok kiri atas TIDAK berubah
- [ ] Tidak ada sisa CSS/markup mati terkait headline/tagline yang dihapus

**Verification:**
- [ ] Test direvisi di `tests/Feature/HomePageHeroTest.php`:
      `test_shows_visible_headline_and_tagline` diganti jadi assert tagline text
      ("Pendidikan berkualitas dari RTK hingga SMA") TIDAK muncul lagi di halaman
- [ ] `composer run test` hijau, `vendor/bin/pint` bersih, `npm run build` sukses
- [ ] Manual: buka `/`, pastikan tidak ada teks besar di tengah foto, badge logo
      pojok kiri atas masih ada

**Dependencies:** Task 4 (revisi langsung di atas hasil task itu)

**Files likely touched:**
- `resources/views/home.blade.php`
- `tests/Feature/HomePageHeroTest.php`

**Estimated scope:** XS (2 files)

---

## Task 9: Foto slide full-bleed `object-cover` di semua breakpoint

**Description:** Ganti foto slide dari `object-cover` (mobile) / `object-contain`
(desktop, lg+) jadi `object-cover` di semua ukuran layar — foto selalu memenuhi 1
layar penuh, boleh crop di tepi (dikonfirmasi user). Hapus `<img>` blurred-backdrop
duplikat (`scale-110 blur-2xl`, `hidden lg:block`) yang sebelumnya dipakai untuk
mengisi ruang kosong di desktop — sudah tidak diperlukan karena foto utama sekarang
selalu full-bleed.

**Acceptance criteria:**
- [ ] Foto utama slide pakai `object-cover` di semua breakpoint (hapus `lg:object-contain`)
- [ ] `<img>` blurred-backdrop duplikat dihapus total dari markup
- [ ] Foto selalu memenuhi 1 layar penuh (`w-full h-full`) tanpa letterbox di desktop

**Verification:**
- [ ] Test direvisi di `tests/Feature/HomePageHeroTest.php`: assert markup TIDAK
      mengandung `lg:object-contain` atau `blur-2xl` (backdrop duplikat) lagi
- [ ] `composer run test` hijau, `vendor/bin/pint` bersih, `npm run build` sukses
- [ ] Manual: buka `/` di lebar layar desktop, pastikan foto full-bleed tanpa area
      kosong/blur di sisi kiri-kanan

**Dependencies:** Task 8 (sama-sama menyentuh `home.blade.php`, dikerjakan sequential)

**Files likely touched:**
- `resources/views/home.blade.php`
- `tests/Feature/HomePageHeroTest.php`

**Estimated scope:** XS (2 files)

---

## Risks and Mitigations
| Risk | Impact | Mitigation |
|------|--------|------------|
| `HandlesImageUpload` didesain untuk 1 gambar/komponen — aman untuk logo (cuma 1 gambar), tapi tidak langsung reusable kalau Settings butuh field gambar ke-2 nanti | Low | Dicatat di Task 3, bukan blocker sekarang |
| Fade-in adalah pola CSS baru, belum ada preseden di repo | Medium | Diverifikasi manual khusus, ikuti struktur `@layer components` yang sudah ada |
| ~~Ken Burns bikin teks di foto sulit dibaca~~ **TERJADI** — foto marketing sudah ada teks tertanam | — | Direvisi via Task 7: efek dicabut total, foto slide statis |
| ~~Headline/tagline overlay bikin dua lapis teks di foto~~ **TERJADI** — sama akar masalahnya dengan Ken Burns | — | Direvisi via Task 8: headline/tagline dicabut total |
| Foto full-bleed `object-cover` (Task 9) bisa motong teks yang tertanam di foto di tepi, tergantung rasio layar | Medium | Trade-off diterima eksplisit oleh user (bukan blocker); tim marketing perlu diberi tahu supaya hindari taruh teks penting dekat tepi foto |

## Open Questions
(tidak ada lagi — pertanyaan copy headline/tagline sudah tidak relevan setelah Task 8)

## Revision Log
- **2026-07-16 (revisi 1):** Task 6 (Ken Burns zoom effect) dicabut via Task 7. Tim
  marketing mengonfirmasi foto hero sudah diedit dengan teks tertanam (nama
  gedung/fasilitas), sehingga efek zoom bikin teks itu sulit dibaca. Spec diperbarui:
  foto slide sekarang eksplisit harus statis, tanpa transform/animation apa pun.
- **2026-07-16 (revisi 2):** Task 4 bagian headline/tagline dicabut via Task 8 (alasan
  sama: dua lapis teks di atas foto yang sama bikin susah dibaca). Ditambah Task 9:
  foto slide diganti jadi full-bleed `object-cover` di semua ukuran layar, trik
  blurred-backdrop desktop dihapus. User mengonfirmasi menerima risiko foto ter-crop
  di tepi pada rasio layar tertentu sebagai trade-off demi tampilan full-screen
  konsisten.
