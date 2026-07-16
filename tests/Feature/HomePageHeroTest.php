<?php

namespace Tests\Feature;

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
}
