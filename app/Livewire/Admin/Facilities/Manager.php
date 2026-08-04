<?php

namespace App\Livewire\Admin\Facilities;

use App\Livewire\Concerns\ManagesNamedChildRecords;
use App\Models\Facility;
use Livewire\Component;

class Manager extends Component
{
    use ManagesNamedChildRecords;

    protected function modelClass(): string
    {
        return Facility::class;
    }

    protected function uploadDirectory(): string
    {
        return 'uploads/facilities';
    }

    public function render()
    {
        return view('livewire.admin.facilities.manager', [
            'facilities' => $this->query()->orderBy('order')->get(),
        ]);
    }
}
