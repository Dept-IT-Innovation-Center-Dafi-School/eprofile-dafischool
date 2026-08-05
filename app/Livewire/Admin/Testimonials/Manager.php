<?php

namespace App\Livewire\Admin\Testimonials;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Livewire\Concerns\HandlesReordering;
use App\Models\Testimonial;
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
    public string $name = '';

    #[Validate('required|string|max:255')]
    public string $campus = '';

    #[Validate('required|string|max:255')]
    public string $batch = '';

    #[Validate('required|string')]
    public string $quote = '';

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
        $this->reset(['name', 'campus', 'batch', 'quote', 'order', 'image', 'existingImage', 'imageRemoved', 'editingId']);
        $this->editingId = 'new';
    }

    public function startEdit(int $id)
    {
        $testimonial = $this->query()->findOrFail($id);
        $this->editingId = $id;
        $this->name = $testimonial->name;
        $this->campus = $testimonial->campus;
        $this->batch = $testimonial->batch;
        $this->quote = $testimonial->quote;
        $this->order = $testimonial->order;
        $this->existingImage = $testimonial->image;
        $this->image = null;
        $this->imageRemoved = false;
    }

    public function save()
    {
        $this->validate();

        $imageUrl = $this->resolveImageUrl('uploads/testimonials');

        if ($this->editingId === 'new') {
            Testimonial::create([
                'education_level_id' => $this->educationLevelId,
                'name' => $this->name,
                'campus' => $this->campus,
                'batch' => $this->batch,
                'quote' => $this->quote,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        } else {
            $this->query()->findOrFail($this->editingId)->update([
                'name' => $this->name,
                'campus' => $this->campus,
                'batch' => $this->batch,
                'quote' => $this->quote,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
        }

        $this->dispatch('toast', type: 'success', message: 'Data berhasil disimpan.');
        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['name', 'campus', 'batch', 'quote', 'order', 'image', 'existingImage', 'imageRemoved', 'editingId']);
    }

    public function delete(int $id)
    {
        $testimonial = $this->query()->findOrFail($id);
        $this->deleteImageIfExists($testimonial->image);
        $testimonial->delete();
        $this->dispatch('toast', type: 'success', message: 'Data berhasil dihapus.');
        $this->cancel();
    }

    protected function reorderQuery(): Builder
    {
        return $this->query();
    }

    protected function query(): Builder
    {
        return Testimonial::where('education_level_id', $this->educationLevelId);
    }

    public function render()
    {
        return view('livewire.admin.testimonials.manager', [
            'testimonials' => $this->query()->orderBy('order')->get(),
        ]);
    }
}
