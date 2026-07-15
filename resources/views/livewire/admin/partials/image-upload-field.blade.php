@props(['modelName' => 'image', 'label' => 'Gambar', 'existingImage' => null])

@php
    $inputId = \Illuminate\Support\Str::slug($modelName) . '-' . \Illuminate\Support\Str::random(6);
    $errorId = $inputId . '-error';
@endphp

<div class="space-y-2" x-data="{ preview: null, dragging: false, existing: @js($existingImage) }">
    <label for="{{ $inputId }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>

    <div class="relative rounded-lg border-2 border-dashed transition overflow-hidden"
         :class="dragging ? 'border-primary-400 bg-primary-50' : 'border-slate-300 hover:border-primary-300'">
        <input type="file" id="{{ $inputId }}" wire:model="{{ $modelName }}" accept="image/*"
               @error($modelName) aria-invalid="true" aria-describedby="{{ $errorId }}" @enderror
               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
               @dragover.prevent="dragging = true" @dragleave.prevent="dragging = false" @drop="dragging = false"
               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

        <template x-if="preview || existing">
            <div class="p-3 pointer-events-none">
                <img :src="preview || existing" alt="" class="max-h-40 rounded-lg mx-auto object-contain">
                <p class="text-xs text-center text-slate-500 mt-2" x-show="preview">Gambar baru — klik Simpan untuk menerapkan</p>
            </div>
        </template>
        <template x-if="!preview && !existing">
            <div class="py-8 text-center pointer-events-none">
                <x-admin.icon name="upload" class="w-7 h-7 mx-auto text-slate-400" />
                <p class="text-sm text-slate-500 mt-2">Klik atau seret gambar ke sini</p>
                <p class="text-xs text-slate-400 mt-0.5">JPG, PNG, atau WEBP, maks 2MB</p>
            </div>
        </template>
    </div>

    <div wire:loading wire:target="{{ $modelName }}" class="text-sm text-slate-500" role="status">
        Mengunggah...
    </div>

    @error($modelName)
        <p id="{{ $errorId }}" class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
