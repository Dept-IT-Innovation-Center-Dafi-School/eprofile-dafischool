# e-profile-dafischool Agent Guide

## Why
Sistem profil digital (digital brochure) untuk Dafi School Makassar — bantu tim
marketing presentasikan profil sekolah, program unggulan, dan info pendaftaran
ke calon orang tua siswa, lengkap dengan panel admin untuk kelola konten tanpa
sentuh kode.

## What (project map)
- `app/Http/Controllers/` - controller halaman publik (+ `Admin/` untuk redirect tipis)
- `app/Livewire/Admin/` - logic panel admin, satu folder per fitur (EducationLevels,
  HeroSlides, AcademicYears, Facilities, Extracurriculars, Activities, Settings, Account, Auth)
- `app/Livewire/Concerns/` - trait CRUD yang dipakai bareng (`ManagesNamedChildRecords`,
  `HandlesImageUpload`, `HandlesReordering`) — pakai ini dulu sebelum bikin logic baru
- `app/Models/` - Eloquent models
- `app/Services/AcademicYearContext.php` - service scoping "tahun ajaran aktif"
- `resources/views/` - Blade views (public site + `components/admin/`)
- `routes/web.php` - semua route publik & admin (tidak ada `api.php`)
- `database/migrations/`, `database/seeders/` - skema & seed data
- `tests/Feature/`, `tests/Unit/` - PHPUnit, sudah ada coverage lumayan untuk admin/Livewire

Stack: PHP 8.3+/Laravel 13, Livewire 4, Blade + Tailwind CSS 4 + Vite + Swiper, MySQL 8, PHPUnit.
Dev: `composer run dev`. Test: `composer run test`.

## Non-Negotiable
- Semua perubahan skema database lewat migration (`database/migrations/`), jangan raw SQL
- Konten sekolah (kontak, alamat, sosmed) diedit lewat `/admin/settings` →
  `App\Models\SchoolSetting`, BUKAN lewat `config/school.php` (file itu cuma seed awal,
  tidak berpengaruh ke live site setelah di-seed)
- Auth pakai session-based `Auth` facade bawaan Laravel + rate limiting manual di
  `Livewire/Admin/Auth/Login.php` — jangan tambah Sanctum/JWT/pattern auth lain
- Fitur CRUD child-record baru (nama + urutan + gambar) reuse trait
  `ManagesNamedChildRecords`/`HandlesImageUpload`/`HandlesReordering`, jangan duplikasi
- Tulis test (Feature/Unit, PHPUnit) untuk logic penting sebelum commit; pastikan
  `composer run test` lulus
- Commit ikut Conventional Commits, branch dari `develop`, PR ke `develop` (lihat
  bagian "Alur Kontribusi" di README.md)
