<?php

namespace App\Livewire\Admin;

use App\Models\EducationLevel;
use App\Models\HeroSlide;
use App\Services\AcademicYearContext;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
#[Layout('components.admin.layout', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        $yearId = app(AcademicYearContext::class)->current()?->id;
        $scoped = fn ($query) => $query->where('academic_year_id', $yearId);

        return view('livewire.admin.dashboard', [
            'levels' => EducationLevel::orderBy('order')->withCount([
                'facilities' => $scoped,
                'classStats' => $scoped,
                'extracurriculars' => $scoped,
                'activities' => $scoped,
            ])->get(),
            'slideCount' => HeroSlide::count(),
        ]);
    }
}
