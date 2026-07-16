<?php

namespace App\Services;

use App\Models\AcademicYear;

class AcademicYearContext
{
    private const SESSION_KEY = 'current_academic_year_id';

    public function current(): ?AcademicYear
    {
        $id = session(self::SESSION_KEY);

        if ($id) {
            $year = AcademicYear::find($id);

            if ($year) {
                return $year;
            }
        }

        $active = AcademicYear::active()->first();

        if ($active) {
            session([self::SESSION_KEY => $active->id]);
        }

        return $active;
    }

    public function set(int $id): void
    {
        AcademicYear::findOrFail($id);

        session([self::SESSION_KEY => $id]);
    }
}
