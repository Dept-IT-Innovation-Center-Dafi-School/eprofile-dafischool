<?php

namespace App\Livewire\Admin\Settings;

use App\Livewire\Concerns\HandlesImageUpload;
use App\Models\SchoolSetting;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Title('Pengaturan Sekolah')]
#[Layout('components.admin.layout', ['title' => 'Pengaturan Sekolah'])]
class Manager extends Component
{
    use HandlesImageUpload, WithFileUploads;

    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $existingImage = null;

    public string $schoolName = '';

    public string $phone = '';

    public string $address = '';

    public string $email = '';

    public string $whatsappNumber = '';

    public string $mapsEmbedUrl = '';

    public string $instagramUrl = '';

    public string $facebookUrl = '';

    public string $youtubeUrl = '';

    public function mount(): void
    {
        $setting = SchoolSetting::current();

        $this->existingImage = $setting->logo;
        $this->schoolName = (string) $setting->school_name;
        $this->phone = (string) $setting->phone;
        $this->address = (string) $setting->address;
        $this->email = (string) $setting->email;
        $this->whatsappNumber = (string) $setting->whatsapp_number;
        $this->mapsEmbedUrl = (string) $setting->maps_embed_url;
        $this->instagramUrl = (string) $setting->instagram_url;
        $this->facebookUrl = (string) $setting->facebook_url;
        $this->youtubeUrl = (string) $setting->youtube_url;
    }

    public function save(): void
    {
        // Google's "Embed a map" dialog only offers a "Copy HTML" button, which
        // copies a full <iframe src="..."> tag — not a bare URL. Accept that
        // directly so admins don't have to manually pick the URL out of it.
        if (str_contains($this->mapsEmbedUrl, '<iframe') && preg_match('/src="([^"]+)"/', $this->mapsEmbedUrl, $matches)) {
            $this->mapsEmbedUrl = $matches[1];
        }

        $validated = $this->validate([
            'schoolName' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'whatsappNumber' => 'nullable|string|max:20',
            'mapsEmbedUrl' => 'nullable|url|starts_with:https://www.google.com/maps/embed',
            'instagramUrl' => 'nullable|url|max:255',
            'facebookUrl' => 'nullable|url|max:255',
            'youtubeUrl' => 'nullable|url|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $logoUrl = $this->resolveImageUrl('uploads/school-settings');

        SchoolSetting::current()->update([
            'school_name' => $validated['schoolName'],
            'logo' => $logoUrl,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'email' => $validated['email'],
            'whatsapp_number' => $validated['whatsappNumber'],
            'maps_embed_url' => $validated['mapsEmbedUrl'],
            'instagram_url' => $validated['instagramUrl'],
            'facebook_url' => $validated['facebookUrl'],
            'youtube_url' => $validated['youtubeUrl'],
        ]);

        $this->existingImage = $logoUrl;
        $this->image = null;
        $this->imageRemoved = false;

        $this->dispatch('toast', type: 'success', message: 'Pengaturan sekolah berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.settings.manager');
    }
}
