<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\AcademicYears\Manager;
use App\Models\AcademicYear;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AcademicYearManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_clicking_add_generates_the_next_year_automatically(): void
    {
        $user = User::factory()->create();
        AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('create');

        $this->assertDatabaseHas('academic_years', ['label' => '2027/2028']);
    }

    public function test_editing_rejects_a_duplicate_label(): void
    {
        $user = User::factory()->create();
        AcademicYear::create(['label' => '2026/2027']);
        $other = AcademicYear::create(['label' => '2027/2028']);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('startEdit', $other->id)
            ->set('label', '2026/2027')
            ->call('save')
            ->assertHasErrors(['label']);
    }

    public function test_setting_a_year_active_unsets_the_previous_active_year(): void
    {
        $user = User::factory()->create();
        $old = AcademicYear::create(['label' => '2025/2026', 'is_active' => true]);
        $new = AcademicYear::create(['label' => '2026/2027']);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('setActive', $new->id);

        $this->assertTrue($new->fresh()->is_active);
        $this->assertFalse($old->fresh()->is_active);
    }

    public function test_cannot_delete_the_active_year(): void
    {
        $user = User::factory()->create();
        $active = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('delete', $active->id);

        $this->assertDatabaseHas('academic_years', ['id' => $active->id]);
    }
}
