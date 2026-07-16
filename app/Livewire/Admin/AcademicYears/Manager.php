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
    public ?int $editingId = null;

    #[Validate('required|string|max:20')]
    public string $label = '';

    public function create(): void
    {
        $year = AcademicYear::create(['label' => AcademicYear::nextLabel()]);
        $this->dispatch('toast', type: 'success', message: "Tahun ajaran {$year->label} ditambahkan.");
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
                Rule::unique('academic_years', 'label')->ignore($this->editingId),
            ],
        ]);

        AcademicYear::findOrFail($this->editingId)->update(['label' => $this->label]);

        $this->dispatch('toast', type: 'success', message: 'Tahun ajaran diperbarui.');
        $this->cancel();
    }

    public function cancel(): void
    {
        $this->reset(['label', 'editingId']);
    }

    public function setActive(int $id): void
    {
        $year = AcademicYear::setActive($id);
        $this->dispatch('toast', type: 'success', message: "{$year->label} dijadikan tahun ajaran aktif.");
    }

    public function delete(int $id): void
    {
        $year = AcademicYear::findOrFail($id);

        if ($year->is_active) {
            $this->dispatch('toast', type: 'error', message: 'Tahun ajaran yang sedang aktif tidak bisa dihapus.');
            return;
        }

        $year->delete();
        $this->dispatch('toast', type: 'success', message: "{$year->label} dihapus.");
    }

    public function render()
    {
        return view('livewire.admin.academic-years.manager', [
            'years' => AcademicYear::orderByDesc('label')->get(),
        ]);
    }
}
