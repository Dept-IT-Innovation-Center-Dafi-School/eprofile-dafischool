<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\EducationLevels\Form;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EducationLevelsFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_trimmed_when_saving(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Form::class)
            ->set('name', 'Inklusi')
            ->set('slug', 'inklusi ')
            ->set('tagline', 'Tagline')
            ->set('program', 'Program')
            ->set('order', 5)
            ->call('save');

        $this->assertDatabaseHas('education_levels', ['slug' => 'inklusi']);
        $this->assertDatabaseMissing('education_levels', ['slug' => 'inklusi ']);
    }
}
