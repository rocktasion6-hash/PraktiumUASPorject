<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Menambahkan Admin
        User::create([
            'name' => 'Administrator SIMANJA',
            'email' => 'admin@simanja.com',
            'password' => Hash::make('password123'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);

        // Menambahkan contoh User biasa (Opsional)
        User::create([
            'name' => 'User Staff',
            'email' => 'staff@simanja.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]);
    }
}