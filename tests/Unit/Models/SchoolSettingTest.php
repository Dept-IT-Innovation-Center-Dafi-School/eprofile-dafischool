<?php

namespace Tests\Unit\Models;

use App\Models\SchoolSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolSettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_logo_is_fillable_and_persists(): void
    {
        $setting = SchoolSetting::current();
        $setting->update(['logo' => 'https://example.test/storage/uploads/school-settings/logo.png']);

        $this->assertSame(
            'https://example.test/storage/uploads/school-settings/logo.png',
            $setting->fresh()->logo
        );
    }

    public function test_logo_defaults_to_null(): void
    {
        $setting = SchoolSetting::current();

        $this->assertNull($setting->logo);
    }
}
