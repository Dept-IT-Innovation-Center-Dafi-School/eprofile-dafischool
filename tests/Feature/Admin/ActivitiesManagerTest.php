<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Activities\Manager;
use App\Models\AcademicYear;
use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ActivitiesManagerTest extends TestCase
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

    public function test_saving_an_activity_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('startCreate')
            ->set('activity', 'Upacara Bendera')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseHas('activities', ['activity' => 'Upacara Bendera']);
    }

    public function test_deleting_an_activity_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        $year = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);
        $activity = $this->level->activities()->create(['activity' => 'Senam Pagi', 'order' => 0, 'academic_year_id' => $year->id]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('delete', $activity->id)
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseMissing('activities', ['id' => $activity->id]);
    }
}
