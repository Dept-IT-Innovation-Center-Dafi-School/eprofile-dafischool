<?php

namespace Tests\Feature;

use App\Models\EducationLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FooterVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_does_not_show_footer(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('<footer', false);
    }

    public function test_levels_index_shows_footer(): void
    {
        $response = $this->get(route('levels.index'));

        $response->assertOk();
        $response->assertSee('<footer', false);
    }

    public function test_level_detail_shows_footer(): void
    {
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $response = $this->get(route('levels.show', $level->slug));

        $response->assertOk();
        $response->assertSee('<footer', false);
    }
}
