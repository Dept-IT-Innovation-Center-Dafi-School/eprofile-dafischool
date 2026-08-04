<?php

namespace Database\Seeders;

use App\Models\SchoolSetting;
use Illuminate\Database\Seeder;

class SchoolSettingSeeder extends Seeder
{
    public function run(): void
    {
        SchoolSetting::updateOrCreate(['id' => 1], [
            'phone' => config('school.phone'),
            'address' => config('school.address'),
            'email' => config('school.email'),
            'whatsapp_number' => config('school.whatsapp_number'),
            'maps_embed_url' => config('school.maps_embed_url'),
            'instagram_url' => config('school.social.instagram'),
            'facebook_url' => config('school.social.facebook'),
            'youtube_url' => config('school.social.youtube'),
        ]);
    }
}
