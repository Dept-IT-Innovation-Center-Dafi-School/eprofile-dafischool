<?php

namespace App\Livewire\Admin;

use App\Models\EducationLevel;
use App\Models\HeroSlide;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Dashboard')]
#[Layout('components.admin.layout', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'levels' => EducationLevel::orderBy('order')->withCount([
                'facilities', 'classStats', 'extracurriculars', 'activities',
            ])->get(),
            'slideCount' => HeroSlide::count(),
        ]);
    }
}
