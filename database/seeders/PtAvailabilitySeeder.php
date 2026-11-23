<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PtProfile;
use App\Models\PtAvailability;
use Carbon\Carbon;

class PtAvailabilitySeeder extends Seeder
{
    public function run(): void
    {
        // Jam ketersediaan PT (contoh jadwal)
        $slots = [
            ['08:00:00', '09:00:00'],
            ['10:00:00', '11:00:00'],
            ['13:00:00', '14:00:00'],
            ['15:00:00', '16:00:00'],
            ['17:00:00', '18:00:00'],
        ];

        // Ambil semua profil PT
        $ptProfiles = PtProfile::all();

        foreach ($ptProfiles as $ptProfile) {

            // Buat jadwal untuk 7 hari ke depan
            for ($day = 1; $day <= 7; $day++) {

                $date = Carbon::today()->addDays($day);

                foreach ($slots as $slot) {

                    $startAt = Carbon::parse(
                        $date->format('Y-m-d') . ' ' . $slot[0]
                    );

                    $endAt = Carbon::parse(
                        $date->format('Y-m-d') . ' ' . $slot[1]
                    );

                    PtAvailability::firstOrCreate(
                        [
                            'pt_profile_id' => $ptProfile->id,
                            'start_at' => $startAt,
                        ],
                        [
                            'end_at' => $endAt,
                            'status' => 'available',
                        ]
                    );
                }
            }
        }
    }
}
