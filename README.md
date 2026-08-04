# E-Profile DafiSchool

Sistem profil digital (digital brochure) untuk Dafi School Makassar. Membantu tim marketing mempresentasikan profil sekolah, program unggulan, dan informasi pendaftaran secara interaktif kepada calon orang tua siswa, lengkap dengan panel admin untuk mengelola konten tanpa perlu sentuh kode.

## Daftar Isi

- [Tech Stack](#tech-stack)
- [Prasyarat](#prasyarat)
- [Instalasi](#instalasi)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Testing](#testing)
- [Struktur Proyek](#struktur-proyek)
- [Environment Variables](#environment-variables)
- [Alur Kontribusi](#alur-kontribusi)

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | PHP 8.3+, Laravel 13 |
| Admin Panel | Livewire 4 |
| Frontend | Blade, Tailwind CSS 4, Vite, Swiper |
| Database | MySQL 8 |
| Testing | PHPUnit |

## Prasyarat

- PHP >= 8.3 dengan ekstensi standar Laravel (`pdo_mysql`, `mbstring`, dll.)
- Composer 2
- Node.js >= 18 dan npm
- MySQL 8 (lokal atau via Docker)

## Instalasi

```bash
git clone git@github.com:dafischoolmakassar/e-profile-dafischool.git
cd e-profile-dafischool

composer install
cp .env.example .env
php artisan key:generate

npm install
```

Sesuaikan kredensial database di `.env` (`DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`), lalu buat databasenya:

```bash
mysql -u root -e "CREATE DATABASE e_profile_dafischool CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate
```

Alternatifnya, jalankan semua langkah di atas sekaligus lewat Composer script:

```bash
composer run setup
```

## Menjalankan Aplikasi

Mode development (server, queue listener, log viewer, dan Vite berjalan bersamaan):

```bash
composer run dev
```

Aplikasi dapat diakses di `http://localhost:8000`, panel admin di `/admin/login`.

Build aset untuk production:

```bash
npm run build
```

## Testing

```bash
composer run test
```

## Struktur Proyek

```
app/
  Livewire/Admin/   # Komponen panel admin (education levels, hero slides, akun, dsb.)
  Http/Controllers/ # Controller halaman publik
  Models/           # Eloquent models
resources/
  views/            # Blade views (public site + komponen)
  js/, css/         # Aset frontend (Vite)
routes/
  web.php           # Route publik & admin
database/
  migrations/       # Skema database
  seeders/          # Seeder (mis. AdminUserSeeder)
```

## Environment Variables

Variabel penting yang perlu diisi di `.env` (lihat `.env.example` untuk daftar lengkap):

| Variabel | Keterangan |
|---|---|
| `APP_URL` | URL aplikasi |
| `DB_*` | Koneksi database MySQL |
| `MAIL_*` | Konfigurasi email (opsional, default `log`) |

## Alur Kontribusi

1. Branch dari `develop`, gunakan penamaan `feature/...` atau `fix/...`
2. Commit mengikuti [Conventional Commits](https://www.conventionalcommits.org/) (`feat:`, `fix:`, `chore:`, dst.)
3. Buka Pull Request ke `develop`, pastikan `composer run test` lulus
4. `develop` di-PR ke `main` untuk rilis

## Kontak

Kendala akses atau kebutuhan update konten, hubungi tim IT/PIC terkait.
