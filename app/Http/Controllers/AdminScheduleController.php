<?php

namespace App\Http\Controllers;

use App\Models\ScheduleLatihan;

class AdminScheduleController extends Controller
{
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
}