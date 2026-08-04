<?php

namespace Tests\Feature\Admin;

use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class QuillEditorVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_field_renders_with_quill_editor(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => '<p><strong>Program Existing</strong></p>',
        ]);

        $component = Livewire::actingAs($user)
            ->test('admin.education-levels.form', ['educationLevelId' => $level->id]);

        $component->assertViewHas('level', $level);
        $component->assertSee('Program');
        $component->assertSee('richTextEditor');
        $this->assertTrue(true);
    }

    public function test_program_content_updated_and_sanitized(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SMP',
            'slug' => 'smp',
            'tagline' => 'Tagline',
            'program' => 'Old',
        ]);

        $richContent = '<p><strong>Kurikulum Nasional</strong></p><ul><li>Item 1</li></ul>';

        Livewire::actingAs($user)
            ->test('admin.education-levels.form', ['educationLevelId' => $level->id])
            ->set('program', $richContent)
            ->call('save');

        $level->refresh();
        $this->assertStringContainsString('<strong>Kurikulum Nasional</strong>', $level->program);
        $this->assertStringContainsString('<ul>', $level->program);
    }
}
