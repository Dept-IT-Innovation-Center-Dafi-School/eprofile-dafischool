<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationLevel;

class EducationLevelController extends Controller
{
    public function edit(EducationLevel $educationLevel)
    {
        return view('admin.education-levels-edit', [
            'educationLevel' => $educationLevel,
        ]);
    }
}
