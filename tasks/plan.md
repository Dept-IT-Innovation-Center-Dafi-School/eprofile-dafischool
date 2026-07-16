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
- [ ] Task 2: Migration + model — kolom `logo` di `school_settings`

### Checkpoint: Foundation
- [ ] `composer run test` hijau
- [ ] Tombol WA jalan di browser (manual)
- [ ] Kolom `logo` ada di DB, model bisa fillable

### Phase 2: Core feature — logo end-to-end
- [ ] Task 3: Admin bisa upload/ganti/hapus logo di `/admin/settings`
- [ ] Task 4: Homepage — logo overlay + headline/tagline visible

### Checkpoint: Core Feature
- [ ] `composer run test` hijau
- [ ] Upload logo di admin → langsung kelihatan di beranda (manual end-to-end)
- [ ] Fallback teks jalan kalau logo belum/dihapus

### Phase 3: Polish visual
- [ ] Task 5: Pagination premium (numbered/progress bar)
- [ ] Task 6: Ken Burns effect + `prefers-reduced-motion` guard

### Checkpoint: Complete
- [ ] `composer run test` full green, `vendor/bin/pint` bersih
- [ ] End-to-end manual: logo+fallback, headline, WA button, pagination, Ken Burns,
      toggle `prefers-reduced-motion`
- [ ] Viewport pertama tetap fullscreen carousel, tidak ada footer/section baru
- [ ] Semua Success Criteria di `docs/spec-homepage-hero-polish.md` terpenuhi

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
- [ ] Migration baru menambah kolom `logo` (`nullable string`) ke `school_settings`
- [ ] `SchoolSetting::$fillable` mencakup `logo`
- [ ] `SchoolSetting::current()->logo` bisa diisi & dibaca tanpa error

**Verification:**
- [ ] `php artisan migrate` sukses
- [ ] `composer run test` — semua test lama tetap hijau, tidak ada breaking change

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
- [ ] Admin bisa upload logo baru, preview muncul sebelum submit
- [ ] Admin bisa hapus logo — kolom `logo` jadi `null`, file lama ke-delete dari storage
- [ ] Validasi: `nullable|image|mimes:jpg,jpeg,png,webp|max:2048`
- [ ] Card baru di settings form konsisten dengan style card lain (`bg-white rounded-xl border ...`)

**Verification:**
- [ ] Test baru di `tests/Feature/SchoolSettingsPageTest.php`: `Storage::fake('public')` +
      `Livewire::actingAs($user)->test(Manager::class)->set('logo', UploadedFile::fake()->image('logo.png'))->call('save')->assertHasNoErrors()`,
      assert `SchoolSetting::current()->logo` terisi & file ada di storage fake
- [ ] Test hapus logo: assert kolom jadi null & file lama ke-delete
- [ ] `composer run test` hijau
- [ ] Manual: login admin, upload logo, cek preview & tombol hapus jalan

**Dependencies:** Task 2

**Files likely touched:**
- `app/Livewire/Admin/Settings/Manager.php`
- `resources/views/livewire/admin/settings/manager.blade.php`
- `tests/Feature/SchoolSettingsPageTest.php`

**Estimated scope:** Medium (3 files)

---

## Task 4: Homepage — logo overlay + headline/tagline visible

**Description:** Tampilkan logo sekolah di pojok kiri atas hero (fixed, background
glass/blur), fallback ke teks nama sekolah kalau `logo` belum diupload. Ubah H1
`sr-only` yang sudah ada jadi visible sebagai headline, tambah tagline singkat,
dengan fade-in animation yang menghormati `prefers-reduced-motion`.

**Acceptance criteria:**
- [ ] Logo tampil pojok kiri atas kalau `SchoolSetting::current()->logo` terisi
- [ ] Fallback teks nama sekolah (bukan broken image) kalau logo kosong
- [ ] Headline (nama sekolah) + tagline terlihat jelas di atas carousel, fade-in halus
- [ ] Animasi fade-in nonaktif total untuk `prefers-reduced-motion: reduce`
- [ ] Viewport pertama tetap fullscreen (`h-screen` tidak berubah), tidak ada footer/section baru

**Verification:**
- [ ] Test baru di `tests/Feature/HomePageHeroTest.php`: assert logo `<img>` muncul saat `logo` terisi,
      assert fallback text muncul saat `logo` null
- [ ] `composer run test` hijau
- [ ] Manual: buka `/`, cek logo & fallback (hapus logo di admin lalu reload), cek headline/tagline,
      toggle `prefers-reduced-motion` di devtools dan pastikan animasi mati

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
- [ ] Pagination custom tampil menggantikan dots bawaan, tetap `clickable`
- [ ] Style pakai warna dari `@theme` yang sudah ada (`primary-*`/`gold-*`), bukan warna baru

**Verification:**
- [ ] Manual: buka `/`, cek pagination custom tampil & berfungsi (klik ganti slide)
- [ ] `composer run test` tetap hijau (pastikan tidak ada regresi Blade/render)

**Dependencies:** None (independen), dijadwalkan setelah Task 4 supaya tidak bentrok
edit file yang sama.

**Files likely touched:**
- `resources/js/hero-swiper.js`
- `resources/css/app.css`

**Estimated scope:** Small (2 files)

---

## Task 6: Ken Burns effect + `prefers-reduced-motion` guard

**Description:** Tambah efek zoom pelan (Ken Burns, `scale(1) → scale(1.08)`) pada
foto slide yang sedang aktif, definisikan keyframes di `@layer components` pada
`app.css`, dan pastikan animasi mati total untuk `prefers-reduced-motion: reduce`.

**Acceptance criteria:**
- [ ] Foto slide aktif zoom pelan selama durasi slide (match `autoplay.delay` di `hero-swiper.js`)
- [ ] Animasi berhenti/skip total (bukan cuma diperlambat) untuk `prefers-reduced-motion: reduce`

**Verification:**
- [ ] Manual: buka `/`, amati efek zoom per slide
- [ ] Manual: devtools → emulate `prefers-reduced-motion: reduce` → pastikan animasi benar-benar mati

**Dependencies:** Task 5 (menyentuh file yang sama — `app.css`/`hero-swiper.js` —
dikerjakan sequential supaya tidak konflik)

**Files likely touched:**
- `resources/css/app.css`
- `resources/js/hero-swiper.js` atau `resources/views/home.blade.php` (class trigger per slide aktif)

**Estimated scope:** Small (2 files)

---

## Risks and Mitigations
| Risk | Impact | Mitigation |
|------|--------|------------|
| `HandlesImageUpload` didesain untuk 1 gambar/komponen — aman untuk logo (cuma 1 gambar), tapi tidak langsung reusable kalau Settings butuh field gambar ke-2 nanti | Low | Dicatat di Task 3, bukan blocker sekarang |
| Ken Burns + fade-in adalah pola CSS baru, belum ada preseden di repo | Medium | Task 6 dipisah & diverifikasi manual khusus, ikuti struktur `@layer components` yang sudah ada |
| Copy headline/tagline final belum dikonfirmasi tim marketing | Low | Task 4 pakai teks yang sudah ada di kode sekarang, gampang diganti kalau ada copy baru |

## Open Questions
- Konfirmasi copy headline/tagline final dari tim marketing (lihat `docs/spec-homepage-hero-polish.md`).
