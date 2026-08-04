<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassStat extends Model
{
    protected $table = 'class_stats';
    protected $fillable = ['education_level_id', 'academic_year_id', 'name', 'image', 'order'];

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
