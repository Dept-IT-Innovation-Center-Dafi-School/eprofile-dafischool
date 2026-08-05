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
use Mews\Purifier\Facades\Purifier;

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

    #[Validate('nullable|string|max:20')]
    public ?string $whatsappNumber = null;

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
            $this->whatsappNumber = $this->level->whatsapp_number;
            $this->existingImage = $this->level->image;
        }
    }

    public function save()
    {
        $this->slug = trim($this->slug);

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
            'whatsappNumber' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imageUrl = $this->resolveImageUrl('uploads/education-levels');
        $sanitizedProgram = Purifier::clean($this->program, 'program_editor');

        // Convert empty <p> tags (with or without <br>) to <br> for line breaks
        $sanitizedProgram = preg_replace('/<p>\s*(?:<br\s*\/?>\s*)?<\/p>/i', '<br>', $sanitizedProgram);

        // Remove leading/trailing <br> tags
        $sanitizedProgram = preg_replace('/^<br\s*\/?>\s*|<br\s*\/?>\s*$/i', '', $sanitizedProgram);

        if ($this->level) {
            $this->level->update([
                'name' => $this->name,
                'slug' => $this->slug,
                'tagline' => $this->tagline,
                'program' => $sanitizedProgram,
                'order' => $this->order,
                'whatsapp_number' => $this->whatsappNumber,
                'image' => $imageUrl,
            ]);
            $this->existingImage = $imageUrl;
            $this->image = null;
            $this->imageRemoved = false;
            $this->dispatch('toast', type: 'success', message: 'Jenjang berhasil diperbarui.');
            return;
        }

        EducationLevel::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'tagline' => $this->tagline,
            'program' => $sanitizedProgram,
            'order' => $this->order,
            'whatsapp_number' => $this->whatsappNumber,
            'image' => $imageUrl,
        ]);

        session()->flash('success', 'Jenjang berhasil ditambahkan.');
        return redirect()->route('admin.education-levels.index');
    }

    public function render()
    {
        $title = $this->level ? "Edit {$this->level->name}" : 'Tambah Jenjang Pendidikan';
        return view('livewire.admin.education-levels.form')->with('title', $title);
    }
}
