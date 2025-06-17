<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@aquafin.be',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Test',
            'email' => 'jan@aquafin.be',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now()
        ]);
    }
}