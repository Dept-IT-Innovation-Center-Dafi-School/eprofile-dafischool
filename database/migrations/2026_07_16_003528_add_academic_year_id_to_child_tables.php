<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['facilities', 'class_stats', 'extracurriculars', 'activities'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('academic_year_id')->nullable()->after('education_level_id')
                    ->constrained('academic_years')->nullOnDelete();
            });
        }

        $needsBackfill = collect($this->tables)
            ->contains(fn (string $table) => DB::table($table)->whereNull('academic_year_id')->exists());

        if (! $needsBackfill) {
            return;
        }

        $defaultYearId = DB::table('academic_years')->where('is_active', true)->value('id');

        if (! $defaultYearId) {
            $defaultYearId = DB::table('academic_years')->insertGetId([
                'label' => $this->defaultLabel(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($this->tables as $table) {
            DB::table($table)->whereNull('academic_year_id')->update(['academic_year_id' => $defaultYearId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropConstrainedForeignId('academic_year_id');
            });
        }
    }

    private function defaultLabel(): string
    {
        $year = (int) now()->format('Y');
        $month = (int) now()->format('n');

        return $month >= 7 ? "{$year}/" . ($year + 1) : ($year - 1) . "/{$year}";
    }
};
