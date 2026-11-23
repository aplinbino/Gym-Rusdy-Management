<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PtProfile;

class PtProfileSeeder extends Seeder
{
    public function run(): void
    {
        $descriptions = [
            'Alfin' => 'S1 Ilmu Keolahragaan – Universitas Negeri Jakarta (2012) · Pengalaman 5 tahun',
            'Adit' => 'S1 Pendidikan Kepelatihan Olahraga – Universitas Negeri Yogyakarta (2015) · Pengalaman 7 tahun',
            'Ihwan' => 'S1 Ilmu Keolahragaan – Universitas Pendidikan Indonesia (2016) · Pengalaman 6 tahun',
            'Dani' => 'S1 Pendidikan Jasmani – Universitas Negeri Semarang (2014) · Pengalaman 8 tahun',
            'Eep' => 'S1 Pendidikan Kepelatihan Olahraga – Universitas Negeri Surabaya (2017) · Pengalaman 5 tahun',
        ];

        $pts = User::where('role', 'pt')->get();

        foreach ($pts as $pt) {
            PtProfile::updateOrCreate(
                ['user_id' => $pt->id],
                [
                    'description' => $descriptions[$pt->name] ?? 'Personal Trainer GYMBRO',
                    'price_per_session' => 100000,
                ]
            );
        }
    }
}
