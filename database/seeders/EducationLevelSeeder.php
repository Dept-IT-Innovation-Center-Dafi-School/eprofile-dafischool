<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ClassStat;
use App\Models\EducationLevel;
use App\Models\Extracurricular;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'    => 'RTK (Raudhatul Athfal / Kelompok Bermain)',
                'slug'    => 'rtk',
                'tagline' => 'Menanamkan Fondasi Akhlak Sejak Usia Dini',
                'program' => 'Program bermain sambil belajar untuk usia 2-4 tahun yang menstimulasi motorik, sensorik, dan pengenalan nilai-nilai Islami secara menyenangkan. Kurikulum berbasis sentra bermain dengan pendampingan penuh dari guru bersertifikat PAUD.',
                'facilities' => [
                    ['name' => 'Ruang Sensory Play'],
                    ['name' => 'Playground Indoor'],
                    ['name' => 'Ruang Tidur Siang'],
                    ['name' => 'Kolam Bola'],
                ],
                'classes' => [
                    ['name' => 'Ruang Kelas ber-AC'],
                    ['name' => 'Meja & Kursi Sesuai Usia'],
                    ['name' => 'Karpet & Area Bermain Dalam Kelas'],
                ],
                'extracurriculars' => [
                    ['name' => 'Musik & Gerak'],
                    ['name' => 'Melukis'],
                    ['name' => 'Renang Dasar'],
                ],
                'activities' => [
                    ['activity' => 'Penyambutan & doa pagi'],
                    ['activity' => 'Sentra bermain kreatif'],
                    ['activity' => 'Snack time & sosialisasi'],
                    ['activity' => 'Stimulasi motorik & musik'],
                    ['activity' => 'Cerita islami & penjemputan'],
                ],
            ],
            [
                'name'    => 'TK (Taman Kanak-Kanak)',
                'slug'    => 'tk',
                'tagline' => 'Membangun Karakter dan Kesiapan Belajar',
                'program' => 'Program untuk usia 4-6 tahun yang memadukan calistung dasar, hafalan doa harian dan surat pendek, serta pengembangan karakter mandiri. Persiapan matang menuju jenjang Sekolah Dasar.',
                'facilities' => [
                    ['name' => 'Ruang Kelas Tematik'],
                    ['name' => 'Perpustakaan Mini'],
                    ['name' => 'Taman Baca Outdoor'],
                    ['name' => 'Playground'],
                ],
                'classes' => [
                    ['name' => 'Ruang Kelas ber-AC'],
                    ['name' => 'Meja & Kursi Sesuai Usia'],
                    ['name' => 'Papan Tulis Interaktif'],
                ],
                'extracurriculars' => [
                    ['name' => 'Tahfidz Anak'],
                    ['name' => 'Menari'],
                    ['name' => 'Mewarnai & Kerajinan'],
                    ['name' => 'Renang'],
                ],
                'activities' => [
                    ['activity' => 'Ikrar pagi & muroja\'ah'],
                    ['activity' => 'Calistung tematik'],
                    ['activity' => 'Istirahat & snack'],
                    ['activity' => 'Eksplorasi sains sederhana'],
                    ['activity' => 'Hafalan doa & surat pendek'],
                ],
            ],
            [
                'name'    => 'SD (Sekolah Dasar)',
                'slug'    => 'sd',
                'tagline' => 'Akademik Kuat, Akhlak Terjaga',
                'program' => 'Kurikulum nasional dipadukan dengan program tahfidz Al-Qur\'an dan Bahasa Arab untuk usia 6-12 tahun. Menekankan kemandirian belajar, literasi, dan kemampuan berpikir kritis sejak dini.',
                'facilities' => [
                    ['name' => 'Laboratorium Komputer'],
                    ['name' => 'Perpustakaan'],
                    ['name' => 'Lapangan Olahraga'],
                    ['name' => 'Ruang Tahfidz'],
                ],
                'classes' => [
                    ['name' => 'Ruang Kelas ber-AC'],
                    ['name' => 'Papan Tulis Interaktif'],
                    ['name' => 'Loker Siswa'],
                ],
                'extracurriculars' => [
                    ['name' => 'Tahfidz Qur\'an'],
                    ['name' => 'Pramuka'],
                    ['name' => 'Robotik'],
                    ['name' => 'Futsal'],
                    ['name' => 'Panahan'],
                ],
                'activities' => [
                    ['activity' => 'Sholat Dhuha berjamaah'],
                    ['activity' => 'KBM sesi 1 (Tematik & Matematika)'],
                    ['activity' => 'Istirahat'],
                    ['activity' => 'KBM sesi 2 & tahfidz'],
                    ['activity' => 'Sholat Dzuhur & makan siang'],
                    ['activity' => 'Ekstrakurikuler pilihan'],
                ],
            ],
            [
                'name'    => 'SMP (Sekolah Menengah Pertama)',
                'slug'    => 'smp',
                'tagline' => 'Membentuk Generasi Berprestasi dan Berkepribadian',
                'program' => 'Program akademik intensif berbasis kurikulum nasional dengan penguatan sains, teknologi, dan kepemimpinan (leadership) untuk usia 12-15 tahun. Siswa dibekali soft skill organisasi lewat OSIS dan kegiatan sosial.',
                'facilities' => [
                    ['name' => 'Laboratorium IPA'],
                    ['name' => 'Laboratorium Komputer'],
                    ['name' => 'Ruang OSIS'],
                    ['name' => 'Lapangan Multifungsi'],
                ],
                'classes' => [
                    ['name' => 'Ruang Kelas ber-AC'],
                    ['name' => 'Proyektor & Layar LCD'],
                    ['name' => 'Loker Siswa'],
                ],
                'extracurriculars' => [
                    ['name' => 'Karya Ilmiah Remaja'],
                    ['name' => 'Basket'],
                    ['name' => 'Jurnalistik'],
                    ['name' => 'Tahfidz Qur\'an'],
                    ['name' => 'Pencak Silat'],
                ],
                'activities' => [
                    ['activity' => 'Sholat Dhuha & tilawah'],
                    ['activity' => 'KBM sesi 1'],
                    ['activity' => 'Istirahat'],
                    ['activity' => 'KBM sesi 2'],
                    ['activity' => 'Sholat Dzuhur & makan siang'],
                    ['activity' => 'KBM sesi 3 & ekskul'],
                ],
            ],
            [
                'name'    => 'SMA (Sekolah Menengah Atas)',
                'slug'    => 'sma',
                'tagline' => 'Menyiapkan Generasi Unggul Menuju Perguruan Tinggi',
                'program' => 'Program peminatan IPA/IPS dengan bimbingan intensif persiapan perguruan tinggi (SNBT, ujian mandiri) untuk usia 15-18 tahun. Dilengkapi program pengembangan kepemimpinan dan kewirausahaan syariah.',
                'facilities' => [
                    ['name' => 'Laboratorium Komputer'],
                    ['name' => 'Laboratorium Fisika & Kimia'],
                    ['name' => 'Ruang OSIS & Aula'],
                    ['name' => 'Perpustakaan Digital'],
                ],
                'classes' => [
                    ['name' => 'Ruang Kelas ber-AC'],
                    ['name' => 'Proyektor & Layar LCD'],
                    ['name' => 'Loker Siswa'],
                ],
                'extracurriculars' => [
                    ['name' => 'Karya Ilmiah Remaja'],
                    ['name' => 'Debat Bahasa Inggris'],
                    ['name' => 'Basket'],
                    ['name' => 'Tahfidz Qur\'an'],
                    ['name' => 'Kewirausahaan'],
                ],
                'activities' => [
                    ['activity' => 'Sholat Dhuha & kajian pagi'],
                    ['activity' => 'KBM sesi 1 (peminatan)'],
                    ['activity' => 'Istirahat'],
                    ['activity' => 'KBM sesi 2'],
                    ['activity' => 'Sholat Dzuhur & makan siang'],
                    ['activity' => 'Bimbingan SNBT & ekskul'],
                ],
            ],
        ];

        foreach ($data as $levelOrder => $levelData) {
            $level = EducationLevel::create([
                'name'    => $levelData['name'],
                'slug'    => $levelData['slug'],
                'tagline' => $levelData['tagline'],
                'program' => $levelData['program'],
                'order'   => $levelOrder,
            ]);

            foreach ($levelData['facilities'] as $order => $facility) {
                Facility::create([
                    'education_level_id' => $level->id,
                    'name'               => $facility['name'],
                    'order'              => $order,
                ]);
            }

            foreach ($levelData['classes'] as $order => $class) {
                ClassStat::create([
                    'education_level_id' => $level->id,
                    'name'               => $class['name'],
                    'order'              => $order,
                ]);
            }

            foreach ($levelData['extracurriculars'] as $order => $extracurricular) {
                Extracurricular::create([
                    'education_level_id' => $level->id,
                    'name'               => $extracurricular['name'],
                    'order'              => $order,
                ]);
            }

            foreach ($levelData['activities'] as $order => $activity) {
                Activity::create([
                    'education_level_id' => $level->id,
                    'activity'           => $activity['activity'],
                    'order'              => $order,
                ]);
            }
        }
    }
}
