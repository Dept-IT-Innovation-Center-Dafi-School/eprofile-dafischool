<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\HeroSlides\Manager;
use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HeroSlidesManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_saving_a_slide_dispatches_a_toast(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('startCreate')
            ->set('alt', 'Gedung Sekolah')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseHas('hero_slides', ['alt' => 'Gedung Sekolah']);
    }

    public function test_deleting_a_slide_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        $slide = HeroSlide::create(['alt' => 'Slide Lama', 'order' => 0]);

        Livewire::actingAs($user)
            ->test(Manager::class)
            ->call('delete', $slide->id)
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseMissing('hero_slides', ['id' => $slide->id]);
    }
}
