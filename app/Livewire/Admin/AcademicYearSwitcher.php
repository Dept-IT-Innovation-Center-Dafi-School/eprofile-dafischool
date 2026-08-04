<?php

namespace App\Livewire\Admin;

use App\Models\AcademicYear;
use App\Services\AcademicYearContext;
use Livewire\Component;

class AcademicYearSwitcher extends Component
{
    public function switchTo(int $id): void
    {
        app(AcademicYearContext::class)->set($id);

        $this->redirect(request()->header('Referer') ?: route('admin.dashboard'), navigate: false);
    }

    public function render()
    {
        return view('livewire.admin.academic-year-switcher', [
            'years' => AcademicYear::orderByDesc('label')->get(),
            'current' => app(AcademicYearContext::class)->current(),
        ]);
    }
}
