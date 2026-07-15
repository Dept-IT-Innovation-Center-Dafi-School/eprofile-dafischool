<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Extracurricular extends Model
{
    protected $table = 'extracurriculars';
    protected $fillable = ['education_level_id', 'name', 'image', 'order'];

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
