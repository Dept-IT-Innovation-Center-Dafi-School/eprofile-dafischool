<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local')) {
            $this->command->error('AdminUserSeeder only runs in the local environment. Aborting.');
            return;
        }

        $email = 'admin@eprofiledafischool.com';
        $password = 'admin';

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
