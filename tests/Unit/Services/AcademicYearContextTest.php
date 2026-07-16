<?php

namespace Tests\Unit\Services;

use App\Models\AcademicYear;
use App\Services\AcademicYearContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicYearContextTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_falls_back_to_the_active_year_when_session_is_empty(): void
    {
        $active = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        $current = (new AcademicYearContext)->current();

        $this->assertTrue($current->is($active));
    }

    public function test_current_returns_null_when_no_years_exist(): void
    {
        $this->assertNull((new AcademicYearContext)->current());
    }

    public function test_set_stores_the_chosen_year_in_session(): void
    {
        AcademicYear::create(['label' => '2025/2026', 'is_active' => true]);
        $other = AcademicYear::create(['label' => '2026/2027']);

        $context = new AcademicYearContext;
        $context->set($other->id);

        $this->assertTrue($context->current()->is($other));
    }
}
