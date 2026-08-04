<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('facilities')
            ->whereRaw("image LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/public/storage', '/storage')")]);

        DB::table('hero_slides')
            ->whereRaw("image LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/public/storage', '/storage')")]);

        DB::table('extracurriculars')
            ->whereRaw("image LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/public/storage', '/storage')")]);

        DB::table('activities')
            ->whereRaw("image LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/public/storage', '/storage')")]);

        DB::table('school_settings')
            ->whereRaw("logo LIKE '%/public/storage%'")
            ->update(['logo' => DB::raw("REPLACE(logo, '/public/storage', '/storage')")]);
    }

    public function down(): void
    {
        DB::table('facilities')
            ->whereRaw("image LIKE '%/storage%' AND image NOT LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/storage', '/public/storage')")]);

        DB::table('hero_slides')
            ->whereRaw("image LIKE '%/storage%' AND image NOT LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/storage', '/public/storage')")]);

        DB::table('extracurriculars')
            ->whereRaw("image LIKE '%/storage%' AND image NOT LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/storage', '/public/storage')")]);

        DB::table('activities')
            ->whereRaw("image LIKE '%/storage%' AND image NOT LIKE '%/public/storage%'")
            ->update(['image' => DB::raw("REPLACE(image, '/storage', '/public/storage')")]);

        DB::table('school_settings')
            ->whereRaw("logo LIKE '%/storage%' AND logo NOT LIKE '%/public/storage%'")
            ->update(['logo' => DB::raw("REPLACE(logo, '/storage', '/public/storage')")]);
    }
};
