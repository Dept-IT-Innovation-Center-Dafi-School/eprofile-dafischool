<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\EducationLevel;

class EducationLevelController extends Controller
{
    public function index()
    {
        $levels = EducationLevel::orderBy('order')->get();
        return view('levels.index', compact('levels'));
    }

    public function show(EducationLevel $educationLevel)
    {
        $levels = EducationLevel::orderBy('order')->get(['id', 'name', 'slug']);
        $activeYearId = AcademicYear::active()->value('id');

        $educationLevel->load([
            'facilities' => fn ($query) => $query->where('academic_year_id', $activeYearId),
            'classStats' => fn ($query) => $query->where('academic_year_id', $activeYearId),
            'extracurriculars' => fn ($query) => $query->where('academic_year_id', $activeYearId),
            'activities' => fn ($query) => $query->where('academic_year_id', $activeYearId),
            'testimonials',
        ]);

        // Hide extracurriculars section for RTK unit (order=1)
        if ($educationLevel->order === 1) {
            $educationLevel->show_extracurriculars = false;
        }

        $isBoarding = $educationLevel->slug === 'boarding smpit-smait';
        $isInklusi = $educationLevel->slug === 'inklusi';
        $isSmait = $educationLevel->slug === 'smait';

        return view('levels.show', [
            'level' => $educationLevel,
            'allLevels' => $levels,
            'isBoarding' => $isBoarding,
            'isInklusi' => $isInklusi,
            'isSmait' => $isSmait,
        ]);
    }
}
