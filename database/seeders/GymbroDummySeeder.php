<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GymbroDummySeeder extends Seeder
{
    /**
     * Seeder aman dijalankan berulang kali:
     * - Data yang sudah ada akan digunakan kembali.
     * - Konflik unique akan dilewati.
     * - Relasi dibuat berdasarkan ID hasil insert/pencarian, bukan ID tebakan.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            $now = now();
            $timestamp = $now->toDateTimeString();

            // 1. Buat akun admin, PT, dan member.
            $adminUserId = $this->ensureUser([
                'name' => 'Administrator GYMBRO',
                'email' => 'admin.dummy@gymbro.test',
                'phone' => '081200000001',
                'role' => 'admin',
                'membership_status' => 'inactive',
                'membership_start' => null,
                'membership_end' => null,
            ], $timestamp);

            $adminId = null;
            if ($adminUserId !== null) {
                $adminId = $this->ensureRow('admin', ['user_id' => $adminUserId], [
                    'admin_name' => 'Admin GYMBRO',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            $ptData = [
                ['name' => 'Andi Pratama', 'email' => 'pt.andi@gymbro.test', 'phone' => '081200000011', 'split' => 'Push Day', 'description' => 'Fokus latihan dada, bahu, dan trisep.'],
                ['name' => 'Budi Santoso', 'email' => 'pt.budi@gymbro.test', 'phone' => '081200000012', 'split' => 'Pull Day', 'description' => 'Fokus latihan punggung dan bisep.'],
                ['name' => 'Citra Maharani', 'email' => 'pt.citra@gymbro.test', 'phone' => '081200000013', 'split' => 'Leg Day', 'description' => 'Fokus kekuatan dan pembentukan otot kaki.'],
                ['name' => 'Dimas Saputra', 'email' => 'pt.dimas@gymbro.test', 'phone' => '081200000014', 'split' => 'Full Body', 'description' => 'Program latihan seluruh kelompok otot.'],
            ];

            $ptIds = [];
            foreach ($ptData as $index => $pt) {
                $userId = $this->ensureUser([
                    'name' => $pt['name'],
                    'email' => $pt['email'],
                    'phone' => $pt['phone'],
                    'role' => 'pt',
                    'membership_status' => 'inactive',
                    'membership_start' => null,
                    'membership_end' => null,
                ], $timestamp);

                if ($userId === null) {
                    continue;
                }

                $ptId = $this->ensureRow('pt', ['user_id' => $userId], [
                    'pt_name' => $pt['name'],
                    'split_gym' => $pt['split'],
                    'price_per_session' => 100000,
                    'description' => $pt['description'],
                    'photo' => null,
                    'status' => 'active',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                if ($ptId !== null) {
                    $ptIds[$index] = $ptId;
                }
            }

            $ptIds = array_values($ptIds);

            // 2. Buat 10 member dummy.
            $memberNames = [
                'Rizky Ramadhan', 'Nadia Putri', 'Fajar Maulana', 'Siti Aisyah',
                'Rangga Firmansyah', 'Dewi Anggraini', 'Yoga Pratama', 'Intan Permata',
                'Arif Hidayat', 'Maya Safitri',
            ];

            $members = [];
            foreach ($memberNames as $i => $name) {
                $emailNumber = str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT);
                $start = $now->copy()->subDays(10 + $i)->toDateString();
                $end = $now->copy()->addMonths(1 + ($i % 4))->toDateString();

                $userId = $this->ensureUser([
                    'name' => $name,
                    'email' => "member{$emailNumber}@gymbro.test",
                    'phone' => '0821' . str_pad((string) ($i + 1), 8, '0', STR_PAD_LEFT),
                    'role' => 'member',
                    'membership_status' => 'active',
                    'membership_start' => $start,
                    'membership_end' => $end,
                ], $timestamp);

                if ($userId !== null) {
                    $members[] = ['id' => $userId, 'name' => $name, 'index' => $i];
                }
            }

            // Hubungkan beberapa member ke PT aktif (jika belum punya current_pt_id).
            foreach ($members as $i => $member) {
                $ptId = $ptIds[$i % max(count($ptIds), 1)] ?? null;
                if ($ptId !== null) {
                    DB::table('users')->where('id', $member['id'])
                        ->whereNull('current_pt_id')
                        ->update(['current_pt_id' => $ptId, 'updated_at' => $timestamp]);
                }
            }

            // 3. Buat transaksi membership dan pembelian sesi PT.
            $membershipPackages = [
                1 => 150000,
                3 => 400000,
                6 => 700000,
                12 => 1200000,
            ];

            $transactions = [];
            foreach ($members as $i => $member) {
                $months = [1, 3, 6, 12][$i % 4];
                $price = $membershipPackages[$months];
                $transactionDate = $now->copy()->subDays(20 - $i)->startOfDay()->addHours(10)->toDateTimeString();

                $transactionId = $this->ensureRow('transaksi', [
                    'user_id' => $member['id'],
                    'jenis_transaksi' => 'membership',
                    'membership_months' => $months,
                    'pt_id' => null,
                    'tanggal_transaksi' => $transactionDate,
                ], [
                    'jumlah_sesi' => null,
                    'harga_satuan' => $price,
                    'total_harga' => $price,
                    'metode_pembayaran' => ['Transfer Bank', 'QRIS', 'Tunai'][$i % 3],
                    'bukti_pembayaran' => null,
                    'status' => 'approved',
                    'approved_by' => $adminId,
                    'created_at' => $transactionDate,
                    'updated_at' => $transactionDate,
                ]);

                if ($transactionId !== null) {
                    $transactions[$member['id']]['membership'] = $transactionId;
                }

                // Tidak semua member membeli sesi PT.
                if ($i % 2 === 0 && count($ptIds) > 0) {
                    $ptId = $ptIds[$i % count($ptIds)];
                    $sessions = ($i % 3) + 1;
                    $ptDate = $now->copy()->subDays(12 - $i)->startOfDay()->addHours(11)->toDateTimeString();
                    $ptTransactionId = $this->ensureRow('transaksi', [
                        'user_id' => $member['id'],
                        'jenis_transaksi' => 'pt_session',
                        'membership_months' => null,
                        'jumlah_sesi' => $sessions,
                        'pt_id' => $ptId,
                        'tanggal_transaksi' => $ptDate,
                    ], [
                        'harga_satuan' => 100000,
                        'total_harga' => 100000 * $sessions,
                        'metode_pembayaran' => ['Transfer Bank', 'QRIS'][$i % 2],
                        'bukti_pembayaran' => null,
                        'status' => 'approved',
                        'approved_by' => $adminId,
                        'created_at' => $ptDate,
                        'updated_at' => $ptDate,
                    ]);

                    if ($ptTransactionId !== null) {
                        $transactions[$member['id']]['pt'] = $ptTransactionId;
                    }
                }
            }

            // 4. Buat jadwal latihan. Sebagian mandiri, sebagian bersama PT.
            $workoutTypes = ['Chest & Triceps', 'Back & Biceps', 'Leg Workout', 'Upper Body', 'Full Body'];
            foreach ($members as $i => $member) {
                $usePt = ($i % 2 === 0 && count($ptIds) > 0);
                $ptId = $usePt ? $ptIds[$i % count($ptIds)] : null;
                $transactionId = $usePt
                    ? ($transactions[$member['id']]['pt'] ?? null)
                    : ($transactions[$member['id']]['membership'] ?? null);

                $date = $now->copy()->addDays($i + 1)->toDateString();
                $time = ['08:00:00', '10:00:00', '13:00:00', '15:00:00', '17:00:00'][$i % 5];

                $this->ensureRow('schedule_latihan', [
                    'user_id' => $member['id'],
                    'pt_id' => $ptId,
                    'tanggal' => $date,
                    'jam' => $time,
                    'jenis_latihan' => $workoutTypes[$i % count($workoutTypes)],
                ], [
                    'transaksi_id' => $transactionId,
                    'status' => $usePt ? 'approved' : 'scheduled',
                    'catatan' => $usePt ? 'Jadwal latihan bersama personal trainer.' : 'Jadwal latihan mandiri member.',
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }

            // 5. Buat review gym dan PT.
            foreach ($members as $i => $member) {
                $this->ensureRow('reviews', [
                    'user_id' => $member['id'],
                    'target_type' => 'gym',
                    'target_id' => 1, // ID target gym dummy; tabel gym belum tersedia.
                ], [
                    'rating' => [5, 4, 5, 4, 5][$i % 5],
                    'comment' => [
                        'Tempat gym nyaman dan peralatannya lengkap.',
                        'Pelayanan ramah, suasana latihan menyenangkan.',
                        'Fasilitas bagus dan tempatnya bersih.',
                        'Cocok untuk latihan rutin.',
                        'Pengalaman latihan sangat memuaskan.',
                    ][$i % 5],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);

                if (count($ptIds) > 0 && $i % 2 === 0) {
                    $ptId = $ptIds[$i % count($ptIds)];
                    $this->ensureRow('reviews', [
                        'user_id' => $member['id'],
                        'target_type' => 'pt',
                        'target_id' => $ptId,
                    ], [
                        'rating' => 5,
                        'comment' => 'Personal trainer profesional dan program latihannya jelas.',
                        'created_at' => $timestamp,
                        'updated_at' => $timestamp,
                    ]);
                }
            }
        });

        $this->command?->info('Seeder dummy GYMBRO selesai. Data yang sudah ada atau bentrok akan digunakan/dilewati.');
    }

    /** Buat user; email yang sudah dipakai role lain tidak akan ditimpa. */
    private function ensureUser(array $data, string $timestamp): ?int
    {
        $existing = DB::table('users')->where('email', $data['email'])->first();
        if ($existing) {
            return $existing->role === $data['role'] ? (int) $existing->id : null;
        }

        $insert = $data + [
            'password' => Hash::make('Password123!'),
            'remember_token' => null,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];

        try {
            return (int) DB::table('users')->insertGetId($insert);
        } catch (QueryException $e) {
            // Menangani kemungkinan email dibuat proses lain sesaat sebelum insert.
            $existing = DB::table('users')->where('email', $data['email'])->first();
            if ($existing) {
                return $existing->role === $data['role'] ? (int) $existing->id : null;
            }
            throw $e;
        }
    }

    /**
     * Cari record berdasarkan identitas logis, lalu buat jika belum ada.
     * Jika terjadi duplicate-key race, ambil record yang sudah terbentuk.
     */
    private function ensureRow(string $table, array $identity, array $values): ?int
    {
        $query = DB::table($table);
        foreach ($identity as $column => $value) {
            $value === null ? $query->whereNull($column) : $query->where($column, $value);
        }

        $existing = $query->first();
        if ($existing) {
            return isset($existing->id) ? (int) $existing->id : null;
        }

        try {
            return (int) DB::table($table)->insertGetId($identity + $values);
        } catch (QueryException $e) {
            $query = DB::table($table);
            foreach ($identity as $column => $value) {
                $value === null ? $query->whereNull($column) : $query->where($column, $value);
            }

            $existing = $query->first();
            if ($existing) {
                return isset($existing->id) ? (int) $existing->id : null;
            }
            throw $e;
        }
    }
}
