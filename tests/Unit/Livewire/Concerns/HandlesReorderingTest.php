<?php

namespace Tests\Unit\Livewire\Concerns;

use App\Livewire\Concerns\HandlesReordering;
use App\Models\EducationLevel;
use App\Models\Facility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandlesReorderingTest extends TestCase
{
    use RefreshDatabase;

    private EducationLevel $level;

    private object $reorderer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->level = EducationLevel::create([
            'name' => 'SD',
            'slug' => 'sd',
            'tagline' => 'Tagline',
            'program' => 'Program',
        ]);

        $level = $this->level;

        $this->reorderer = new class($level) {
            use HandlesReordering;

            public function __construct(private EducationLevel $level)
            {
            }

            protected function reorderQuery(): Builder
            {
                return Facility::where('education_level_id', $this->level->id);
            }
        };
    }

    private function createFacility(string $name, int $order): Facility
    {
        return $this->level->facilities()->create(['name' => $name, 'order' => $order]);
    }

    public function test_move_up_swaps_order_with_previous_item(): void
    {
        $first = $this->createFacility('First', 1);
        $second = $this->createFacility('Second', 2);

        $this->reorderer->moveUp($second->id);

        $this->assertSame(1, $second->fresh()->order);
        $this->assertSame(2, $first->fresh()->order);
    }

    public function test_move_down_swaps_order_with_next_item(): void
    {
        $first = $this->createFacility('First', 1);
        $second = $this->createFacility('Second', 2);

        $this->reorderer->moveDown($first->id);

        $this->assertSame(2, $first->fresh()->order);
        $this->assertSame(1, $second->fresh()->order);
    }

    public function test_move_up_on_first_item_does_nothing(): void
    {
        $first = $this->createFacility('First', 1);
        $this->createFacility('Second', 2);

        $this->reorderer->moveUp($first->id);

        $this->assertSame(1, $first->fresh()->order);
    }

    public function test_move_down_on_last_item_does_nothing(): void
    {
        $this->createFacility('First', 1);
        $second = $this->createFacility('Second', 2);

        $this->reorderer->moveDown($second->id);

        $this->assertSame(2, $second->fresh()->order);
    }
}
