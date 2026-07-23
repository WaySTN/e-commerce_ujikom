<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@wahyugadget.com'],
            [
                'name' => 'Wahyu (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Customer Account for Testing
        User::updateOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Budi Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );
    }
}
