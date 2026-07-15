<?php

namespace App\Livewire\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesImageUpload
{
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
}
