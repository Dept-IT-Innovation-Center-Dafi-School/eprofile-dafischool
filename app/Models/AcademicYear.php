<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AcademicYear extends Model
{
    protected $fillable = ['label', 'is_active'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public static function setActive(int $id): self
    {
        return DB::transaction(function () use ($id) {
            static::where('is_active', true)->update(['is_active' => false]);

            $year = static::findOrFail($id);
            $year->update(['is_active' => true]);

            return $year;
        });
    }
}
