<?php

namespace App\Http\Controllers;

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
        $educationLevel->load('facilities', 'classStats', 'extracurriculars', 'activities');
        return view('levels.show', [
            'level' => $educationLevel,
            'allLevels' => $levels,
        ]);
    }
}
