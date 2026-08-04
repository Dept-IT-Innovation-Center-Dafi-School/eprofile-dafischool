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

    /**
     * The next "YYYY/YYYY+1" label following the latest existing year,
     * or a label derived from the current date if none exist yet.
     */
    public static function nextLabel(): string
    {
        $latestStart = static::query()
            ->get(['label'])
            ->map(fn (self $year) => (int) substr($year->label, 0, 4))
            ->max();

        if ($latestStart) {
            return ($latestStart + 1) . '/' . ($latestStart + 2);
        }

        $year = (int) now()->format('Y');
        $month = (int) now()->format('n');
        $start = $month >= 7 ? $year : $year - 1;

        return "{$start}/" . ($start + 1);
    }
}
