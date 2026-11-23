<?php

namespace App\Http\Controllers;

use App\Models\ScheduleLatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AdminScheduleController extends Controller
{
    // Menampilkan jadwal latihan yang memiliki Personal Trainer.
    public function index()
    {
        $jadwal = ScheduleLatihan::with([
                'user:id,name',
                'pt:id,user_id,pt_name',
                'pt.user:id,name',
            ])
            ->whereNotNull('pt_id')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam', 'asc')
            ->get([
                'id',
                'user_id',
                'pt_id',
                'transaksi_id',
                'tanggal',
                'jam',
                'jenis_latihan',
                'status',
                'catatan',
            ]);

        return response()->json($jadwal);
    }

    // Memperbarui informasi jadwal latihan.
    public function update(Request $request, ScheduleLatihan $schedule)
    {
        $validated = $request->validate([
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'jenis_latihan' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],
            'catatan' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($schedule, $validated) {
            // Jika jadwal terhubung ke slot PT, geser waktu slot dengan durasi yang sama.
            if ($schedule->pt_availability_id) {
                $slot = DB::table('pt_availabilities')
                    ->where('id', $schedule->pt_availability_id)
                    ->lockForUpdate()
                    ->first();

                if ($slot) {
                    $oldStart = Carbon::parse($slot->start_at);
                    $oldEnd = Carbon::parse($slot->end_at);
                    $durationSeconds = max(0, $oldEnd->diffInSeconds($oldStart));

                    $newStart = Carbon::parse($validated['tanggal'] . ' ' . $validated['jam']);
                    $newEnd = $newStart->copy()->addSeconds($durationSeconds);

                    DB::table('pt_availabilities')
                        ->where('id', $slot->id)
                        ->update([
                            'start_at' => $newStart,
                            'end_at' => $newEnd,
                            'updated_at' => now(),
                        ]);
                }
            }

            // Assignment satu per satu agar tidak bergantung pada $fillable model.
            $schedule->tanggal = $validated['tanggal'];
            $schedule->jam = $validated['jam'];
            $schedule->jenis_latihan = $validated['jenis_latihan'] ?? null;
            $schedule->status = $validated['status'];
            $schedule->catatan = $validated['catatan'] ?? null;
            $schedule->save();
        });

        return response()->json([
            'message' => 'Jadwal latihan berhasil diperbarui.',
            'data' => $schedule->fresh(),
        ]);
    }

    // Menghapus jadwal dan membuka kembali slot PT terkait.
    public function destroy(ScheduleLatihan $schedule)
    {
        DB::transaction(function () use ($schedule) {
            if ($schedule->pt_availability_id) {
                DB::table('pt_availabilities')
                    ->where('id', $schedule->pt_availability_id)
                    ->where('status', 'booked')
                    ->update([
                        'status' => 'available',
                        'updated_at' => now(),
                    ]);
            }

            $schedule->delete();
        });

        return response()->json([
            'message' => 'Jadwal latihan berhasil dihapus dan slot PT terkait dibuka kembali jika tersedia.',
        ]);
    }
}
