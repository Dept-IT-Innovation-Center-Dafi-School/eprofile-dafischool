<?php

namespace Tests\Unit\Livewire\Concerns;

use App\Livewire\Concerns\HandlesImageUpload;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HandlesImageUploadTest extends TestCase
{
    private object $uploader;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->uploader = new class {
            use HandlesImageUpload;

            public mixed $image = null;
            public ?string $existingImage = null;

            public function resolve(string $directory): ?string
            {
                return $this->resolveImageUrl($directory);
            }
        };
    }

    public function test_upload_image_stores_file_and_returns_public_url(): void
    {
        $file = UploadedFile::fake()->create('facility.jpg', 10, 'image/jpeg');

        $url = $this->uploader->uploadImage($file, 'facilities');

        $this->assertStringContainsString('/storage/facilities/', $url);

        $path = 'facilities/' . basename(parse_url($url, PHP_URL_PATH));
        Storage::disk('public')->assertExists($path);
    }

    public function test_delete_image_if_exists_removes_stored_file(): void
    {
        Storage::disk('public')->put('facilities/example.jpg', 'contents');
        $url = Storage::disk('public')->url('facilities/example.jpg');

        $this->uploader->deleteImageIfExists($url);

        Storage::disk('public')->assertMissing('facilities/example.jpg');
    }

    public function test_delete_image_if_exists_does_nothing_when_url_is_null(): void
    {
        $this->uploader->deleteImageIfExists(null);

        $this->expectNotToPerformAssertions();
    }

    public function test_delete_image_if_exists_does_nothing_for_url_without_storage_marker(): void
    {
        Storage::disk('public')->put('facilities/example.jpg', 'contents');

        $this->uploader->deleteImageIfExists('https://example.com/not-a-storage-path.jpg');

        Storage::disk('public')->assertExists('facilities/example.jpg');
    }

    public function test_resolve_image_url_uploads_new_file_and_deletes_the_old_one(): void
    {
        Storage::disk('public')->put('facilities/old.jpg', 'contents');
        $this->uploader->existingImage = Storage::disk('public')->url('facilities/old.jpg');
        $this->uploader->image = UploadedFile::fake()->create('new.jpg', 10, 'image/jpeg');

        $url = $this->uploader->resolve('facilities');

        $this->assertStringContainsString('/storage/facilities/', $url);
        Storage::disk('public')->assertMissing('facilities/old.jpg');
    }

    public function test_resolve_image_url_keeps_existing_image_when_untouched(): void
    {
        $this->uploader->existingImage = 'https://example.com/storage/facilities/keep.jpg';

        $url = $this->uploader->resolve('facilities');

        $this->assertSame('https://example.com/storage/facilities/keep.jpg', $url);
    }

    public function test_resolve_image_url_returns_null_and_deletes_file_when_removed(): void
    {
        Storage::disk('public')->put('facilities/remove-me.jpg', 'contents');
        $this->uploader->existingImage = Storage::disk('public')->url('facilities/remove-me.jpg');
        $this->uploader->removeExistingImage();

        $url = $this->uploader->resolve('facilities');

        $this->assertNull($url);
        Storage::disk('public')->assertMissing('facilities/remove-me.jpg');
    }
}
