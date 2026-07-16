<?php

namespace App\Livewire\Admin\HeroSlides;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Livewire\Concerns\HandlesReordering;
use App\Models\HeroSlide;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Title('Carousel Beranda')]
#[Layout('components.admin.layout', ['title' => 'Carousel Beranda'])]
class Manager extends Component
{
    use WithFileUploads, HandlesImageUpload, HandlesReordering;

    #[Locked]
    public int|string|null $editingId = null;

    #[Validate('nullable|string|max:255')]
    public string $alt = '';

    #[Validate('required|integer|min:0')]
    public int $order = 0;

    #[Validate('nullable|image|mimes:jpg,jpeg,png,webp|max:2048')]
    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $existingImage = null;

    public function startCreate()
    {
        $this->reset(['alt', 'order', 'image', 'existingImage', 'editingId']);
        $this->editingId = 'new';
    }

    public function startEdit(int $id)
    {
        $slide = HeroSlide::findOrFail($id);
        $this->editingId = $id;
        $this->alt = $slide->alt ?? '';
        $this->order = $slide->order;
        $this->existingImage = $slide->image;
        $this->image = null;
    }

    public function save()
    {
        $this->validate();

        $imageUrl = $this->existingImage;

        if ($this->image) {
            $this->deleteImageIfExists($this->existingImage);
            $imageUrl = $this->uploadImage($this->image, 'uploads/hero-slides');
        }

        if ($this->editingId === 'new') {
            HeroSlide::create([
                'image' => $imageUrl,
                'alt' => $this->alt,
                'order' => $this->order,
            ]);
        } else {
            HeroSlide::findOrFail($this->editingId)->update([
                'image' => $imageUrl,
                'alt' => $this->alt,
                'order' => $this->order,
            ]);
        }

        $this->dispatch('toast', type: 'success', message: 'Slide berhasil disimpan.');
        $this->cancel();
    }

    public function cancel()
    {
        $this->reset(['alt', 'order', 'image', 'existingImage', 'editingId']);
    }

    public function delete(int $id)
    {
        $slide = HeroSlide::findOrFail($id);
        $this->deleteImageIfExists($slide->image);
        $slide->delete();
        $this->dispatch('toast', type: 'success', message: 'Slide dihapus.');
        $this->cancel();
    }

    protected function reorderQuery(): Builder
    {
        return HeroSlide::query();
    }

    public function render()
    {
        return view('livewire.admin.hero-slides.manager', [
            'slides' => HeroSlide::orderBy('order')->get(),
        ]);
    }
}
