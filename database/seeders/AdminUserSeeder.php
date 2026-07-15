<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'hermanxphp@gmail.com');
        $password = env('ADMIN_PASSWORD');

        if (! $password) {
            if (! app()->environment('local')) {
                $this->command->error('ADMIN_PASSWORD env var is required outside local environment. Aborting.');
                return;
            }

            $password = Str::random(16);
            $this->command->warn("ADMIN_PASSWORD not set — generated random password for local use: {$password}");
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
            ]
        );

        $this->command->info("Admin user ready: {$email}");
    }
}
