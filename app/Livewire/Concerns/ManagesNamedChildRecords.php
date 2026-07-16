<?php

namespace App\Livewire\Concerns;

use App\Services\AcademicYearContext;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

/**
 * Shared CRUD for education-level child records that only have a
 * name + order + image (e.g. Facility, Extracurricular).
 */
trait ManagesNamedChildRecords
{
    use WithFileUploads, HandlesImageUpload, HandlesReordering;

    #[Locked]
    public int $educationLevelId;

    #[Locked]
    public int|string|null $editingId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|integer|min:0')]
    public int $order = 0;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $existingImage = null;

    abstract protected function modelClass(): string;

    abstract protected function uploadDirectory(): string;

    public function mount(int $educationLevelId)
    {
        $this->educationLevelId = $educationLevelId;
    }

    public function startCreate()
    {
        $this->reset(['name', 'order', 'image', 'existingImage', 'editingId']);
        $this->editingId = 'new';
    }

    public function startEdit(int $id)
    {
        $item = $this->query()->findOrFail($id);
        $this->editingId = $id;
        $this->name = $item->name;
        $this->order = $item->order;
        $this->existingImage = $item->image;
        $this->image = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId === 'new' && ! $this->currentAcademicYearId()) {
            $this->addError('name', 'Pilih atau buat tahun ajaran terlebih dahulu.');
            return;
        }

        $imageUrl = $this->existingImage;

        if ($this->image) {
            $this->deleteImageIfExists($this->existingImage);
            $imageUrl = $this->uploadImage($this->image, $this->uploadDirectory());
        }

        if ($this->editingId === 'new') {
            $this->modelClass()::create([
                'education_level_id' => $this->educationLevelId,
                'academic_year_id' => $this->currentAcademicYearId(),
                'name' => $this->name,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        } else {
            $this->query()->findOrFail($this->editingId)->update([
                'name' => $this->name,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        }

        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['name', 'order', 'image', 'existingImage', 'editingId']);
    }

    public function delete(int $id)
    {
        $item = $this->query()->findOrFail($id);
        $this->deleteImageIfExists($item->image);
        $item->delete();
        $this->cancel();
    }

    protected function reorderQuery(): Builder
    {
        return $this->query();
    }

    protected function query(): Builder
    {
        return $this->modelClass()::where('education_level_id', $this->educationLevelId)
            ->where('academic_year_id', $this->currentAcademicYearId());
    }

    protected function currentAcademicYearId(): ?int
    {
        return app(AcademicYearContext::class)->current()?->id;
    }
}
