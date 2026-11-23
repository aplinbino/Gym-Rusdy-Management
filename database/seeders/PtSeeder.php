<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pt;
use Illuminate\Support\Facades\Hash;

class PTSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = [
            [
                'name' => 'Alfin',
                'email' => 'alfin@gmail.com',
                'education' => 'S1 Ilmu Keolahragaan – Universitas Negeri Jakarta (2012)',
                'experience' => 'Pengalaman 5 tahun',
            ],
            [
                'name' => 'Adit',
                'email' => 'adit@gmail.com',
                'education' => 'S1 Pendidikan Kepelatihan Olahraga – Universitas Negeri Yogyakarta (2015)',
                'experience' => 'Pengalaman 7 tahun',
            ],
            [
                'name' => 'Ihwan',
                'email' => 'ihwan@gmail.com',
                'education' => 'S1 Ilmu Keolahragaan – Universitas Pendidikan Indonesia (2016)',
                'experience' => 'Pengalaman 6 tahun',
            ],
            [
                'name' => 'Dani',
                'email' => 'dani@gmail.com',
                'education' => 'S1 Pendidikan Jasmani – Universitas Negeri Semarang (2014)',
                'experience' => 'Pengalaman 8 tahun',
            ],
            [
                'name' => 'Eep',
                'email' => 'eep@gmail.com',
                'education' => 'S1 Pendidikan Kepelatihan Olahraga – Universitas Negeri Surabaya (2017)',
                'experience' => 'Pengalaman 5 tahun',
            ],
        ];

        // Pertahankan ID akun Dina lama dan relasi jadwalnya dengan mengubahnya
        // menjadi akun Alfin, selama email Alfin belum digunakan.
        $legacyDina = User::where('email', 'dina@gmail.com')
            ->where('role', 'pt')
            ->first();

        $existingAlfin = User::where('email', 'alfin@gmail.com')->first();

        if ($legacyDina && !$existingAlfin) {
            $legacyDina->name = 'Alfin';
            $legacyDina->email = 'alfin@gmail.com';
            $legacyDina->save();
        }

        foreach ($trainers as $trainer) {
            $user = User::firstOrNew(['email' => $trainer['email']]);

            $isNewUser = !$user->exists;

            $user->name = $trainer['name'];
            $user->role = 'pt';
            $user->membership_status = 'inactive';

            // Password default hanya dipasang saat akun baru dibuat.
            if ($isNewUser) {
                $user->password = Hash::make('gymbro123');
            }

            $user->save();

            $description = $trainer['education'] . ' · ' . $trainer['experience'];

            Pt::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'pt_name' => $trainer['name'],
                    'price_per_session' => 100000,
                    'description' => $description,
                    'status' => 'active',
                ]
            );
        }
    }
}
