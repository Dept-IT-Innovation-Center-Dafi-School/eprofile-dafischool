<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $slides = [
            'Gedung Sekolah Darul Fikri',
            'Kolam Renang Sekolah',
            'Lapangan Olahraga',
            'Area Parkir',
            'Aula Serbaguna',
            'Mushollah Sekolah',
            'Laboratorium',
            'Play Ground',
            'Visi & Misi Sekolah',
        ];

        foreach ($slides as $index => $alt) {
            HeroSlide::create([
                'alt' => $alt,
                'order' => $index,
            ]);
        }
    }
}
