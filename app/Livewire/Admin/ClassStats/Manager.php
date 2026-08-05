<?php

namespace App\Livewire\Admin\ClassStats;

use App\Livewire\Concerns\ManagesNamedChildRecords;
use App\Models\ClassStat;
use Livewire\Component;

class Manager extends Component
{
    use ManagesNamedChildRecords;

    protected function modelClass(): string
    {
        return ClassStat::class;
    }

    protected function uploadDirectory(): string
    {
        return 'uploads/class-stats';
    }

    public function render()
    {
        return view('livewire.admin.class-stats.manager', [
            'classStats' => $this->query()->orderBy('order')->get(),
            'isBoarding' => \App\Models\EducationLevel::whereKey($this->educationLevelId)->value('slug') === 'boarding smpit-smait',
            'isInklusi' => \App\Models\EducationLevel::whereKey($this->educationLevelId)->value('slug') === 'inklusi',
        ]);
    }
}
