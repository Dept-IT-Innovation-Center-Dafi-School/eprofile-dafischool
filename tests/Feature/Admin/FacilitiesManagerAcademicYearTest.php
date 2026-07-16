<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Facilities\Manager;
use App\Models\AcademicYear;
use App\Models\EducationLevel;
use App\Models\User;
use App\Services\AcademicYearContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class FacilitiesManagerAcademicYearTest extends TestCase
{
    use RefreshDatabase;

    private EducationLevel $level;

    protected function setUp(): void
    {
        parent::setUp();

        $this->level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);
    }

    public function test_created_facility_is_tagged_with_the_current_academic_year(): void
    {
        $user = User::factory()->create();
        $year = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('startCreate')
            ->set('name', 'Perpustakaan')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseHas('facilities', [
            'name' => 'Perpustakaan',
            'academic_year_id' => $year->id,
        ]);
    }

    public function test_deleting_a_facility_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        $year = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);
        $facility = $this->level->facilities()->create(['name' => 'Kantin', 'order' => 0, 'academic_year_id' => $year->id]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('delete', $facility->id)
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseMissing('facilities', ['id' => $facility->id]);
    }

    public function test_facility_list_is_scoped_to_the_current_academic_year(): void
    {
        $user = User::factory()->create();
        $yearA = AcademicYear::create(['label' => '2025/2026']);
        $yearB = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        $this->level->facilities()->create(['name' => 'Old Facility', 'order' => 0, 'academic_year_id' => $yearA->id]);
        $this->level->facilities()->create(['name' => 'New Facility', 'order' => 0, 'academic_year_id' => $yearB->id]);

        $component = Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id]);

        $component->assertSee('New Facility')->assertDontSee('Old Facility');
    }

    public function test_save_is_blocked_when_no_academic_year_exists(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('startCreate')
            ->set('name', 'Perpustakaan')
            ->call('save')
            ->assertHasErrors(['name']);

        $this->assertDatabaseMissing('facilities', ['name' => 'Perpustakaan']);
    }

    public function test_switching_academic_year_changes_the_visible_list(): void
    {
        $user = User::factory()->create();
        $yearA = AcademicYear::create(['label' => '2025/2026', 'is_active' => true]);
        $yearB = AcademicYear::create(['label' => '2026/2027']);

        $this->level->facilities()->create(['name' => 'Facility A', 'order' => 0, 'academic_year_id' => $yearA->id]);
        $this->level->facilities()->create(['name' => 'Facility B', 'order' => 0, 'academic_year_id' => $yearB->id]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->assertSee('Facility A')
            ->assertDontSee('Facility B');

        app(AcademicYearContext::class)->set($yearB->id);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->assertSee('Facility B')
            ->assertDontSee('Facility A');
    }
}
