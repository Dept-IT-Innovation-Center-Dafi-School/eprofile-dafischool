<?php

namespace App\Livewire\Admin\Auth;

use App\Models\SchoolSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.admin.guest-layout')]
class Login extends Component
{
    #[Validate('required|email')]
    public string $email = '';

    #[Validate('required')]
    public string $password = '';

    public bool $remember = false;

    public SchoolSetting $setting;

    public function mount()
    {
        $this->setting = SchoolSetting::current();

        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
    }

    public function login()
    {
        $this->validate();

        $throttleKey = Str::lower($this->email) . '|' . request()->ip();
        $ipThrottleKey = 'login-ip|' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5) || RateLimiter::tooManyAttempts($ipThrottleKey, 20)) {
            $seconds = max(
                RateLimiter::availableIn($throttleKey),
                RateLimiter::availableIn($ipThrottleKey),
            );
            $this->addError('email', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);
        RateLimiter::hit($ipThrottleKey, 60);
        $this->addError('email', 'Kredensial tidak valid.');
    }

    public function render()
    {
        return view('livewire.admin.auth.login');
    }
}
