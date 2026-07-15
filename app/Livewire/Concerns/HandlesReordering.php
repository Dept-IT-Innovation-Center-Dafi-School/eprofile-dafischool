<?php

namespace App\Livewire\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HandlesReordering
{
    abstract protected function reorderQuery(): Builder;

    public function moveUp(int $id): void
    {
        $this->swapOrder($id, -1);
    }

    public function moveDown(int $id): void
    {
        $this->swapOrder($id, 1);
    }

    protected function swapOrder(int $id, int $direction): void
    {
        $items = $this->reorderQuery()->orderBy('order')->orderBy('id')->get();
        $index = $items->search(fn ($item) => $item->id === $id);
        $targetIndex = $index + $direction;

        if ($index === false || $targetIndex < 0 || $targetIndex >= $items->count()) {
            return;
        }

        $current = $items[$index];
        $target = $items[$targetIndex];

        $currentOrder = $current->order;
        $current->update(['order' => $target->order]);
        $target->update(['order' => $currentOrder]);
    }
}
