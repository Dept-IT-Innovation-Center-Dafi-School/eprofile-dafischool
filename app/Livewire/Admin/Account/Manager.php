<?php

namespace App\Livewire\Admin\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Akun Saya')]
#[Layout('components.admin.layout', ['title' => 'Akun Saya'])]
class Manager extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    public string $currentPassword = '';

    public string $newPassword = '';

    public string $newPasswordConfirmation = '';

    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    public function updateProfile(): void
    {
        $user = Auth::user();

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(): void
    {
        $user = Auth::user();

        $this->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
            'newPasswordConfirmation' => 'required|same:newPassword',
        ]);

        if (! Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->update(['password' => $this->newPassword]);

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);
        session()->flash('success', 'Password berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.account.manager');
    }
}
