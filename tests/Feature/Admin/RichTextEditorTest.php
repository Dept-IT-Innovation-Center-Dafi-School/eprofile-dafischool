<?php

namespace Tests\Feature\Admin;

use App\Models\EducationLevel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class RichTextEditorTest extends TestCase
{
    use RefreshDatabase;
    public function test_program_field_accepts_rich_text_html(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Old content',
        ]);

        $richHtml = '<p><strong>Program Unggulan</strong></p><ul><li>Kurikulum nasional</li><li>Pendekatan islami</li></ul>';

        Livewire::actingAs($user)
            ->test('admin.education-levels.form', ['educationLevelId' => $level->id])
            ->set('program', $richHtml)
            ->call('save');

        $level->refresh();
        $this->assertStringContainsString('<strong>Program Unggulan</strong>', $level->program);
        $this->assertStringContainsString('<ul>', $level->program);
    }

    public function test_program_field_sanitizes_dangerous_html(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SMP',
            'slug' => 'smp',
            'tagline' => 'Tagline',
            'program' => 'Old content',
        ]);

        $dangerousHtml = '<p>Safe text</p><script>alert("XSS")</script><img src=x onerror="alert(1)">';

        Livewire::actingAs($user)
            ->test('admin.education-levels.form', ['educationLevelId' => $level->id])
            ->set('program', $dangerousHtml)
            ->call('save');

        $level->refresh();
        $this->assertStringNotContainsString('<script>', $level->program);
        $this->assertStringNotContainsString('onerror', $level->program);
        $this->assertStringContainsString('Safe text', $level->program);
    }

    public function test_program_allows_safe_links(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SMA',
            'slug' => 'sma',
            'tagline' => 'Tagline',
            'program' => 'Old content',
        ]);

        $htmlWithLink = '<p>Baca <a href="https://example.com" target="_blank">panduan kami</a></p>';

        Livewire::actingAs($user)
            ->test('admin.education-levels.form', ['educationLevelId' => $level->id])
            ->set('program', $htmlWithLink)
            ->call('save');

        $level->refresh();
        $this->assertStringContainsString('<a href="https://example.com"', $level->program);
        $this->assertStringContainsString('target="_blank"', $level->program);
    }
}
