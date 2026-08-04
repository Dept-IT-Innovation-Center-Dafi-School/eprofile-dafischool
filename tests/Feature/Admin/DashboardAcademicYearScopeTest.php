<?php

namespace Tests\Feature\Admin;

use App\Livewire\Admin\Dashboard;
use App\Models\AcademicYear;
use App\Models\EducationLevel;
use App\Models\User;
use App\Services\AcademicYearContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardAcademicYearScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_content_counts_change_when_switching_academic_year(): void
    {
        $user = User::factory()->create();
        $level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $yearA = AcademicYear::create(['label' => '2025/2026', 'is_active' => true]);
        $yearB = AcademicYear::create(['label' => '2026/2027']);

        $level->facilities()->create(['name' => 'Lab A', 'order' => 0, 'academic_year_id' => $yearA->id]);
        $level->facilities()->create(['name' => 'Lab B1', 'order' => 0, 'academic_year_id' => $yearB->id]);
        $level->facilities()->create(['name' => 'Lab B2', 'order' => 1, 'academic_year_id' => $yearB->id]);

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertSee('1 fasilitas');

        app(AcademicYearContext::class)->set($yearB->id);

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertSee('2 fasilitas');
    }
}
