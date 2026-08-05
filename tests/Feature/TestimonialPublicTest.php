<?php

namespace Tests\Feature;

use App\Models\EducationLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialPublicTest extends TestCase
{
    use RefreshDatabase;

    private function level(string $slug): EducationLevel
    {
        return EducationLevel::create([
            'name' => ucfirst($slug),
            'slug' => $slug,
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);
    }

    public function test_smait_unit_page_shows_testimonial_carousel(): void
    {
        $smait = $this->level('smait');
        $smait->testimonials()->create([
            'name' => 'Herman',
            'campus' => 'Universitas Indonesia',
            'batch' => '2018',
            'quote' => 'Alhamdulillah saya belajar banyak di SIT Darul Fikri Makassar.',
            'order' => 0,
        ]);

        $response = $this->get(route('levels.show', $smait->slug));

        $response->assertOk();
        $response->assertSee('Testimoni Alumni');
        $response->assertSee('Herman');
        $response->assertSee('Universitas Indonesia');
        $response->assertSee('Angkatan 2018');
        $response->assertSee('testimonial-swiper');
    }

    public function test_non_sma_unit_page_does_not_show_testimonials(): void
    {
        $sd = $this->level('sd');
        $sd->testimonials()->create([
            'name' => 'Herman',
            'campus' => 'Universitas Indonesia',
            'batch' => '2018',
            'quote' => 'Alhamdulillah saya belajar banyak.',
            'order' => 0,
        ]);

        $response = $this->get(route('levels.show', $sd->slug));

        $response->assertOk();
        $response->assertDontSee('Testimoni Alumni');
        $response->assertDontSee('testimonial-swiper');
    }

    public function test_smait_unit_page_hides_section_when_no_testimonials_exist(): void
    {
        $smait = $this->level('smait');

        $response = $this->get(route('levels.show', $smait->slug));

        $response->assertOk();
        $response->assertDontSee('Testimoni Alumni');
        $response->assertDontSee('testimonial-swiper');
    }
}
