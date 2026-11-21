<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PTSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Personal Trainer
        User::updateOrCreate(
            ['email' => 'dina@gmail.com'],
            [
                'name' => 'Dina',
                'password' => Hash::make('dinacantik'),
                'role' => 'pt',
                'membership_status' => 'inactive',
            ]
        );
    }
}
