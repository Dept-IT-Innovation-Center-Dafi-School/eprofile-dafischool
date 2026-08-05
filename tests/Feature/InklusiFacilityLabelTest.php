<?php

namespace Tests\Feature;

use App\Livewire\Admin\ClassStats\Manager;
use App\Livewire\Admin\Activities\Manager as ActivitiesManager;
use App\Models\AcademicYear;
use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InklusiFacilityLabelTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_page_labels_inklusi_class_stats_as_terapi(): void
    {
        $level = EducationLevel::create([
            'name' => 'Unit Inklusi',
            'slug' => 'inklusi',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $year = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);
        $level->classStats()->create(['name' => 'Terapi Wicara', 'order' => 0, 'academic_year_id' => $year->id]);
        $level->activities()->create(['activity' => 'Stimulasi Motorik', 'order' => 0, 'academic_year_id' => $year->id]);

        $response = $this->get(route('levels.show', $level->slug));

        $response->assertOk();
        $response->assertSee('Sarana Terapi');
        $response->assertSee('Fasilitas Terapi');
        $response->assertDontSee('Fasilitas Kelas');
        $response->assertSee('Kegiatan Terapi');
        $response->assertSee('Aktivitas Terapi');
        $response->assertDontSee('Aktivitas Belajar');
    }

    public function test_admin_class_stats_manager_labels_inklusi_class_stats_as_terapi(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'Unit Inklusi',
            'slug' => 'inklusi',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $level->id])
            ->assertSee('Fasilitas Terapi')
            ->assertDontSee('Fasilitas Kelas');
    }

    public function test_admin_activities_manager_labels_inklusi_activities_as_terapi(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'Unit Inklusi',
            'slug' => 'inklusi',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        Livewire::actingAs($user)
            ->test(ActivitiesManager::class, ['educationLevelId' => $level->id])
            ->assertSee('Aktivitas Terapi')
            ->assertDontSee('Aktivitas Belajar');
    }
}
