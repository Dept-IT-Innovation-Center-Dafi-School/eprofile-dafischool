<?php

namespace Tests\Unit\Models;

use App\Models\AcademicYear;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicYearTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_one_year_can_be_active_at_a_time(): void
    {
        $first = AcademicYear::create(['label' => '2025/2026', 'is_active' => true]);
        $second = AcademicYear::create(['label' => '2026/2027']);
        AcademicYear::create(['label' => '2027/2028']);

        AcademicYear::setActive($second->id);

        $this->assertSame(1, AcademicYear::active()->count());
        $this->assertTrue($second->fresh()->is_active);
        $this->assertFalse($first->fresh()->is_active);
    }

    public function test_active_scope_returns_only_active_years(): void
    {
        AcademicYear::create(['label' => '2025/2026']);
        $active = AcademicYear::create(['label' => '2026/2027', 'is_active' => true]);

        $this->assertTrue(AcademicYear::active()->first()->is($active));
    }

    public function test_next_label_increments_from_the_latest_existing_year(): void
    {
        AcademicYear::create(['label' => '2025/2026']);
        AcademicYear::create(['label' => '2026/2027']);

        $this->assertSame('2027/2028', AcademicYear::nextLabel());
    }

    public function test_next_label_falls_back_to_current_date_when_no_years_exist(): void
    {
        $this->assertMatchesRegularExpression('#^\d{4}/\d{4}$#', AcademicYear::nextLabel());
    }
}
