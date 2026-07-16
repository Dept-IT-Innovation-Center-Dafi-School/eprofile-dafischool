<?php

namespace Tests\Feature;

use App\Models\HeroSlide;
use App\Models\SchoolSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageHeroTest extends TestCase
{
    use RefreshDatabase;

    public function test_shows_whatsapp_button_when_number_is_set(): void
    {
        SchoolSetting::current()->update(['whatsapp_number' => '6281234567890']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('https://wa.me/6281234567890', false);
    }

    public function test_hides_whatsapp_button_when_number_is_empty(): void
    {
        SchoolSetting::current()->update(['whatsapp_number' => null]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('wa.me', false);
    }

    public function test_shows_school_logo_overlay_when_configured(): void
    {
        SchoolSetting::current()->update(['logo' => 'https://example.test/storage/uploads/school-settings/logo.png']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('id="hero-logo"', false);
        $response->assertSee('https://example.test/storage/uploads/school-settings/logo.png', false);
    }

    public function test_falls_back_to_text_when_logo_is_not_configured(): void
    {
        SchoolSetting::current()->update(['logo' => null]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('id="hero-logo"', false);
        $response->assertSee('Darul Fikri', false);
    }

    public function test_shows_visible_headline_and_tagline(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('sr-only', false);
        $response->assertSee('Pendidikan berkualitas dari RTK hingga SMA', false);
    }

    public function test_shows_numbered_pagination_counter_matching_slide_count(): void
    {
        HeroSlide::create(['alt' => 'Slide 1', 'order' => 0]);
        HeroSlide::create(['alt' => 'Slide 2', 'order' => 1]);
        HeroSlide::create(['alt' => 'Slide 3', 'order' => 2]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('hero-counter-current', false);
        $response->assertSee('class="hero-counter-total">03', false);
    }

    public function test_slide_photo_has_no_zoom_or_animation_class(): void
    {
        HeroSlide::create(['alt' => 'Gedung Sekolah', 'image' => 'https://example.test/gedung.jpg', 'order' => 0]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('animate-kenburns', false);
    }
}
