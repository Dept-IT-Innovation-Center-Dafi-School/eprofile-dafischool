<?php

namespace App\Livewire\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
    public bool $imageRemoved = false;

    public function uploadImage(UploadedFile $file, string $directory): string
    {
        $extension = $file->guessExtension() ?? 'bin';
        $filename = Str::random(20) . '.' . $extension;
        $path = $file->storeAs($directory, $filename, 'public');
        return Storage::disk('public')->url($path);
    }

    public function deleteImageIfExists(?string $imageUrl): void
    {
        if (! $imageUrl) {
            return;
        }

        $marker = '/storage/';
        $position = strpos($imageUrl, $marker);

        if ($position === false) {
            return;
        }

        $path = substr($imageUrl, $position + strlen($marker));
        Storage::disk('public')->delete($path);
    }

    public function removeExistingImage(): void
    {
        $this->image = null;
        $this->imageRemoved = true;
    }

    /**
     * Resolves the image URL to persist on save: a freshly uploaded file wins,
     * an explicit removal clears it, otherwise the existing image is kept.
     */
    protected function resolveImageUrl(string $directory): ?string
    {
        if ($this->image) {
            $this->deleteImageIfExists($this->existingImage);
            return $this->uploadImage($this->image, $directory);
        }

        if ($this->imageRemoved) {
            $this->deleteImageIfExists($this->existingImage);
            return null;
        }

        return $this->existingImage;
    }
}
