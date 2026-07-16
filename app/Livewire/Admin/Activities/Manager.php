<?php

namespace App\Livewire\Admin\Activities;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Livewire\Concerns\HandlesReordering;
use App\Models\Activity;
use App\Services\AcademicYearContext;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Manager extends Component
{
    use WithFileUploads, HandlesImageUpload, HandlesReordering;

    #[Locked]
    public int $educationLevelId;

    #[Locked]
    public int|string|null $editingId = null;

    #[Validate('required|string|max:255')]
    public string $activity = '';

    #[Validate('required|integer|min:0')]
    public int $order = 0;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $existingImage = null;

    public function mount(int $educationLevelId)
    {
        $this->educationLevelId = $educationLevelId;
    }

    public function startCreate()
    {
        $this->reset(['activity', 'order', 'image', 'existingImage', 'editingId']);
        $this->editingId = 'new';
    }

    public function startEdit(int $id)
    {
        $activity = $this->query()->findOrFail($id);
        $this->editingId = $id;
        $this->activity = $activity->activity;
        $this->order = $activity->order;
        $this->existingImage = $activity->image;
        $this->image = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId === 'new' && ! $this->currentAcademicYearId()) {
            $this->addError('activity', 'Pilih atau buat tahun ajaran terlebih dahulu.');
            return;
        }

        $imageUrl = $this->existingImage;

        if ($this->image) {
            $this->deleteImageIfExists($this->existingImage);
            $imageUrl = $this->uploadImage($this->image, 'uploads/activities');
        }

        if ($this->editingId === 'new') {
            Activity::create([
                'education_level_id' => $this->educationLevelId,
                'academic_year_id' => $this->currentAcademicYearId(),
                'activity' => $this->activity,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        } else {
            $this->query()->findOrFail($this->editingId)->update([
                'activity' => $this->activity,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        }

        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['activity', 'order', 'image', 'existingImage', 'editingId']);
    }

    public function delete(int $id)
    {
        $activity = $this->query()->findOrFail($id);
        $this->deleteImageIfExists($activity->image);
        $activity->delete();
        $this->cancel();
    }

    protected function reorderQuery(): Builder
    {
        return $this->query();
    }

    protected function query(): Builder
    {
        return Activity::where('education_level_id', $this->educationLevelId)
            ->where('academic_year_id', $this->currentAcademicYearId());
    }

    protected function currentAcademicYearId(): ?int
    {
        return app(AcademicYearContext::class)->current()?->id;
    }

    public function render()
    {
        return view('livewire.admin.activities.manager', [
            'activities' => $this->query()->orderBy('order')->get(),
        ]);
    }
}
