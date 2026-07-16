<?php

namespace Tests\Unit\Models;

use App\Models\EducationLevel;
use App\Models\SchoolSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationLevelTest extends TestCase
{
    use RefreshDatabase;

    public function test_whatsapp_url_contains_encoded_message_with_level_name(): void
    {
        SchoolSetting::current()->update(['whatsapp_number' => '6281111111111']);

        $level = new EducationLevel(['name' => 'SD']);

        $url = $level->whatsapp_url;

        $this->assertStringStartsWith('https://wa.me/6281111111111?text=', $url);
        $this->assertStringContainsString(urlencode('jenjang SD Darul Fikri'), $url);
    }

    public function test_route_binding_resolves_slug_case_insensitively(): void
    {
        $level = EducationLevel::create([
            'name' => 'Sekolah Dasar',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $resolved = (new EducationLevel)->resolveRouteBinding('SD', 'slug');

        $this->assertTrue($resolved->is($level));
    }

    public function test_route_binding_throws_when_slug_not_found(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        (new EducationLevel)->resolveRouteBinding('does-not-exist', 'slug');
    }

    public function test_relations_are_ordered_by_order_column(): void
    {
        $level = EducationLevel::create([
            'name' => 'TK',
            'slug' => 'tk',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $level->facilities()->create(['name' => 'Second', 'order' => 2]);
        $level->facilities()->create(['name' => 'First', 'order' => 1]);

        $this->assertSame(['First', 'Second'], $level->facilities()->pluck('name')->all());
    }
}
