<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    protected $table = 'facilities';
    protected $fillable = ['education_level_id', 'academic_year_id', 'name', 'image', 'order'];

    public function educationLevel(): BelongsTo
    {
        return $this->belongsTo(EducationLevel::class);
    }
}
