<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\EducationLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationLevelPublicFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_only_shows_facilities_from_the_active_academic_year(): void
    {
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $oldYear = AcademicYear::create(['label' => '2025/2026']);
        $activeYear = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        $level->facilities()->create(['name' => 'Lab Lama', 'order' => 0, 'academic_year_id' => $oldYear->id]);
        $level->facilities()->create(['name' => 'Lab Baru', 'order' => 0, 'academic_year_id' => $activeYear->id]);

        $response = $this->get(route('levels.show', $level->slug));

        $response->assertOk();
        $response->assertSee('Lab Baru');
        $response->assertDontSee('Lab Lama');
    }

    public function test_public_page_shows_nothing_when_no_active_academic_year_exists(): void
    {
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $year = AcademicYear::create(['label' => '2025/2026']);
        $level->facilities()->create(['name' => 'Lab Lama', 'order' => 0, 'academic_year_id' => $year->id]);

        $response = $this->get(route('levels.show', $level->slug));

        $response->assertOk();
        $response->assertDontSee('Lab Lama');
    }
}
