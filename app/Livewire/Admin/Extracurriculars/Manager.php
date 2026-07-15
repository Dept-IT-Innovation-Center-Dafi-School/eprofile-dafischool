<?php

namespace App\Livewire\Admin\Extracurriculars;

use App\Livewire\Concerns\ManagesNamedChildRecords;
use App\Models\Extracurricular;
use Livewire\Component;

class Manager extends Component
{
    use ManagesNamedChildRecords;

    protected function modelClass(): string
    {
        return Extracurricular::class;
    }

    protected function uploadDirectory(): string
    {
        return 'uploads/extracurriculars';
    }

    public function render()
    {
        return view('livewire.admin.extracurriculars.manager', [
            'extracurriculars' => $this->query()->orderBy('order')->get(),
        ]);
    }
}
