<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@aquafin.be'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now()
            ]
        );

        User::firstOrCreate(
            ['email' => 'jan@aquafin.be'],
            [
                'name' => 'Test',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now()
            ]
        );
    }
}
