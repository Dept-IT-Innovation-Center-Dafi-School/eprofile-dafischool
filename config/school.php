<?php

// Only used as the initial seed for the `school_settings` table
// (see database/seeders/SchoolSettingSeeder.php). Once seeded, admins edit
// school info from /admin/settings, which reads and writes App\Models\SchoolSetting
// instead — this file does not affect the live site after that point.
return [
    'whatsapp_number' => env('SCHOOL_WHATSAPP_NUMBER', '6281234567890'),
    'phone' => env('SCHOOL_PHONE', '(0411) 000-000'),
    'email' => env('SCHOOL_EMAIL', 'info@darulfikri.sch.id'),
    'address' => env('SCHOOL_ADDRESS', 'Alamat sekolah belum diisi, Makassar, Sulawesi Selatan'),
    'maps_embed_url' => env('SCHOOL_MAPS_EMBED_URL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.6637582041335!2d119.45006887596624!3d-5.157690894819631!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xc090238295a7ff7%3A0x121fd23dffc82713!2sSIT%20DARUL%20FIKRI%20MAKASSAR%20%5B%20RTK%2FKB%20-%20TK%20-SD%20-%20SMP%20-%20SMA%20-%20INKLUSI%20%5D%20(DAFI%20SCHOOL)!5e0!3m2!1sen!2sid!4v1784186777892!5m2!1sen!2sid'),
    'social' => [
        'instagram' => env('SCHOOL_INSTAGRAM_URL'),
        'facebook' => env('SCHOOL_FACEBOOK_URL'),
        'youtube' => env('SCHOOL_YOUTUBE_URL'),
    ],
];
