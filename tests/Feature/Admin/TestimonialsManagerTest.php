<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\EducationLevels\Form;
use App\Livewire\Admin\Testimonials\Manager;
use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TestimonialsManagerTest extends TestCase
{
    use RefreshDatabase;

    private EducationLevel $level;

    protected function setUp(): void
    {
        parent::setUp();

        $this->level = EducationLevel::create([
            'name' => 'SMAIT (Sekolah Menengah Atas Islam Terpadu)',
            'slug' => 'smait',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);
    }

    public function test_saving_a_testimonial_dispatches_a_toast(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('startCreate')
            ->set('name', 'Herman')
            ->set('campus', 'Universitas Indonesia')
            ->set('batch', '2018')
            ->set('quote', 'Alhamdulillah saya belajar banyak di SIT Darul Fikri.')
            ->call('save')
            ->assertHasNoErrors()
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseHas('testimonials', [
            'education_level_id' => $this->level->id,
            'name' => 'Herman',
            'campus' => 'Universitas Indonesia',
            'batch' => '2018',
        ]);
    }

    public function test_required_fields_are_validated(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('startCreate')
            ->call('save')
            ->assertHasErrors(['name', 'campus', 'batch', 'quote']);
    }

    public function test_deleting_a_testimonial_dispatches_a_toast(): void
    {
        $user = User::factory()->create();
        $testimonial = $this->level->testimonials()->create([
            'name' => 'Herman',
            'campus' => 'Universitas Indonesia',
            'batch' => '2018',
            'quote' => 'Alhamdulillah saya belajar banyak.',
            'order' => 0,
        ]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('delete', $testimonial->id)
            ->assertDispatched('toast', type: 'success');

        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }

    public function test_reordering_swaps_orders(): void
    {
        $user = User::factory()->create();
        $first = $this->level->testimonials()->create([
            'name' => 'Pertama', 'campus' => 'UI', 'batch' => '2018', 'quote' => 'q', 'order' => 0,
        ]);
        $second = $this->level->testimonials()->create([
            'name' => 'Kedua', 'campus' => 'ITB', 'batch' => '2019', 'quote' => 'q', 'order' => 1,
        ]);

        Livewire::actingAs($user)
            ->test(Manager::class, ['educationLevelId' => $this->level->id])
            ->call('moveDown', $first->id);

        $this->assertDatabaseHas('testimonials', ['id' => $first->id, 'order' => 1]);
        $this->assertDatabaseHas('testimonials', ['id' => $second->id, 'order' => 0]);
    }

    public function test_testimonial_tab_only_appears_for_smait_unit(): void
    {
        $user = User::factory()->create();
        $sd = EducationLevel::create([
            'name' => 'SD (Sekolah Dasar)',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        Livewire::actingAs($user)
            ->test(Form::class, ['educationLevelId' => $this->level->id])
            ->assertSee('Testimoni Alumni');

        Livewire::actingAs($user)
            ->test(Form::class, ['educationLevelId' => $sd->id])
            ->assertDontSee('Testimoni Alumni');
    }
}
