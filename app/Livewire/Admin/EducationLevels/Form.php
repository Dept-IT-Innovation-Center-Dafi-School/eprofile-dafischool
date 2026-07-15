<?php

namespace App\Livewire\Admin\EducationLevels;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Models\EducationLevel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('components.admin.layout')]
class Form extends Component
{
    use WithFileUploads, HandlesImageUpload;

    #[Locked]
    public ?EducationLevel $level = null;

    #[Locked]
    public ?int $educationLevelId = null;

    #[Validate('required|string|max:255')]
    public string $name = '';

    public string $slug = '';

    #[Validate('required|string|max:255')]
    public string $tagline = '';

    #[Validate('required|string')]
    public string $program = '';

    #[Validate('required|integer|min:0')]
    public int $order = 0;

    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $existingImage = null;

    #[Title('Tambah Jenjang Pendidikan')]
    public function mount(?int $educationLevelId = null): void
    {
        if ($educationLevelId) {
            $this->educationLevelId = $educationLevelId;
            $this->level = EducationLevel::findOrFail($educationLevelId);
            $this->name = $this->level->name;
            $this->slug = $this->level->slug;
            $this->tagline = $this->level->tagline;
            $this->program = $this->level->program;
            $this->order = $this->level->order;
            $this->existingImage = $this->level->image;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('education_levels', 'slug')->ignore($this->level?->id),
            ],
            'tagline' => 'required|string|max:255',
            'program' => 'required|string',
            'order' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageUrl = $this->existingImage;

        if ($this->image) {
            $this->deleteImageIfExists($this->existingImage);
            $imageUrl = $this->uploadImage($this->image, 'uploads/education-levels');
        }

        if ($this->level) {
            $this->level->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'tagline' => $this->tagline,
                'program' => $this->program,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
            $message = 'Jenjang berhasil diperbarui.';
        } else {
            EducationLevel::create([
                'name' => $this->name,
                'slug' => $this->slug,
                'tagline' => $this->tagline,
                'program' => $this->program,
                'order' => $this->order,
                'image' => $imageUrl,
            ]);
            $message = 'Jenjang berhasil ditambahkan.';
        }

        session()->flash('success', $message);
        return redirect()->route('admin.education-levels.index');
    }

    public function render()
    {
        $title = $this->level ? "Edit {$this->level->name}" : 'Tambah Jenjang Pendidikan';
        return view('livewire.admin.education-levels.form')->with('title', $title);
    }
}
