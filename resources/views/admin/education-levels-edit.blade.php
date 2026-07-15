<x-admin.layout :title="'Edit ' . $educationLevel->name">
    @livewire('admin.education-levels.form', ['educationLevelId' => $educationLevel->id], key('form-' . $educationLevel->id))
</x-admin.layout>
