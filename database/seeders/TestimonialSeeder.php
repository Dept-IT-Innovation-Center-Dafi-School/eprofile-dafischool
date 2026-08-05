<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $level = EducationLevel::where('slug', 'sma')->first();

        if (! $level) {
            return;
        }

        $samples = [
            [
                'name'  => 'Herman',
                'campus' => 'Universitas Indonesia',
                'batch' => '2018',
                'quote' => 'Alhamdulillah, saya belajar banyak di SIT Darul Fikri Makassar. Pembinaan akhlak dan akademiknya sangat membekas hingga sekarang.',
            ],
            [
                'name'  => 'Aisyah Ramadhani',
                'campus' => 'Institut Teknologi Bandung',
                'batch' => '2019',
                'quote' => 'Guru-guru Darul Fikri selalu mendampingi dan memotivasi. Ilmu yang saya dapat tidak hanya untuk ujian, tapi untuk kehidupan.',
            ],
            [
                'name'  => 'Muhammad Fauzan',
                'campus' => 'Universitas Hasanuddin',
                'batch' => '2020',
                'quote' => 'Lingkungan sekolah yang islami membuat saya terbiasa disiplin dan mandiri. Kini semua itu sangat berguna di perkuliahan.',
            ],
            [
                'name'  => 'Nurul Aulia',
                'campus' => 'Universitas Gadjah Mada',
                'batch' => '2021',
                'quote' => 'Dari tahfidz hingga pelajaran sains, semuanya berjalan seimbang. Saya bangga menjadi alumni SIT Darul Fikri.',
            ],
        ];

        foreach ($samples as $order => $sample) {
            $exists = Testimonial::where('education_level_id', $level->id)
                ->where('name', $sample['name'])
                ->exists();

            if ($exists) {
                continue;
            }

            Testimonial::create([
                'education_level_id' => $level->id,
                'name'               => $sample['name'],
                'campus'             => $sample['campus'],
                'batch'              => $sample['batch'],
                'quote'              => $sample['quote'],
                'order'              => $order,
            ]);
        }
    }
}
