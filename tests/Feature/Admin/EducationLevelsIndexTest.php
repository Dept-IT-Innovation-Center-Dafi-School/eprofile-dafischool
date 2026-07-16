<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\EducationLevels\Index;
use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EducationLevelsIndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_a_level_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        Livewire::actingAs($user)
            ->test(Index::class)
            ->call('deleteLevel', $level->id)
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseMissing('education_levels', ['id' => $level->id]);
    }
}
