<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    private const CURRENT_BINDING = 'school-setting.current';

    protected $fillable = [
        'school_name',
        'logo',
        'phone',
        'address',
        'email',
        'whatsapp_number',
        'maps_embed_url',
        'instagram_url',
        'facebook_url',
        'youtube_url',
    ];

    /**
     * Memoized per request/test via the container (not a static property),
     * so it can't leak stale data across HTTP requests or PHPUnit tests
     * sharing the same PHP process.
     */
    public static function current(): self
    {
        if (app()->bound(self::CURRENT_BINDING)) {
            return app(self::CURRENT_BINDING);
        }

        $instance = static::firstOrCreate(['id' => 1]);
        app()->instance(self::CURRENT_BINDING, $instance);

        return $instance;
    }
}
