<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun admin
        $user = User::updateOrCreate(
            ['email' => 'admin@gymbro.com'],
            [
                'name' => 'Administrator',
                'password' => 'Admin12345',
                'phone' => '081234567890',
                'role' => 'admin',
                'membership_status' => 'inactive',
            ]
        );

        // Membuat profil admin
        Admin::updateOrCreate(
            ['user_id' => $user->id],
            [
                'admin_name' => 'Administrator',
            ]
        );
    }
}
