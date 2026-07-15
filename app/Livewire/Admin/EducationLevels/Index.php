<?php

namespace App\Livewire\Admin\EducationLevels;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Livewire\Concerns\HandlesReordering;
use App\Models\EducationLevel;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Jenjang Pendidikan')]
#[Layout('components.admin.layout', ['title' => 'Jenjang Pendidikan'])]
class Index extends Component
{
    use HandlesImageUpload, HandlesReordering;

    public function deleteLevel(int $id)
    {
        $level = EducationLevel::with(['facilities', 'classStats', 'extracurriculars', 'activities'])
            ->findOrFail($id);

        $this->deleteImageIfExists($level->image);

        foreach ([$level->facilities, $level->classStats, $level->extracurriculars, $level->activities] as $children) {
            foreach ($children as $child) {
                $this->deleteImageIfExists($child->image);
            }
        }

        $level->delete();
        session()->flash('success', 'Jenjang berhasil dihapus.');
    }

    protected function reorderQuery(): Builder
    {
        return EducationLevel::query();
    }

    public function render()
    {
        return view('livewire.admin.education-levels.index', [
            'levels' => EducationLevel::orderBy('order')->get(),
        ]);
    }
}
