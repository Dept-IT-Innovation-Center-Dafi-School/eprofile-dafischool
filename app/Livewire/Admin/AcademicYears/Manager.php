<?php

namespace App\Livewire\Admin\AcademicYears;

use App\Models\AcademicYear;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Tahun Ajaran')]
#[Layout('components.admin.layout', ['title' => 'Tahun Ajaran'])]
class Manager extends Component
{
    #[Locked]
    public int|string|null $editingId = null;

    #[Validate('required|string|max:20')]
    public string $label = '';

    public function startCreate(): void
    {
        $this->reset(['label', 'editingId']);
        $this->editingId = 'new';
    }

    public function startEdit(int $id): void
    {
        $year = AcademicYear::findOrFail($id);
        $this->editingId = $id;
        $this->label = $year->label;
    }

    public function save(): void
    {
        $this->validate([
            'label' => [
                'required',
                'string',
                'max:20',
                Rule::unique('academic_years', 'label')->ignore(
                    $this->editingId === 'new' ? null : $this->editingId
                ),
            ],
        ]);

        if ($this->editingId === 'new') {
            AcademicYear::create(['label' => $this->label]);
        } else {
            AcademicYear::findOrFail($this->editingId)->update(['label' => $this->label]);
        }

        $this->cancel();
    }

    public function cancel(): void
    {
        $this->reset(['label', 'editingId']);
    }

    public function setActive(int $id): void
    {
        AcademicYear::setActive($id);
    }

    public function delete(int $id): void
    {
        $year = AcademicYear::findOrFail($id);

        if ($year->is_active) {
            session()->flash('error', 'Tahun ajaran yang sedang aktif tidak bisa dihapus.');
            return;
        }

        $year->delete();
    }

    public function render()
    {
        return view('livewire.admin.academic-years.manager', [
            'years' => AcademicYear::orderByDesc('label')->get(),
        ]);
    }
}
