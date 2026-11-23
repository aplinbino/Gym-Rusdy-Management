<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);

        $totalMember = DB::table('users')
            ->where('role', 'member')
            ->count();

        $totalPt = DB::table('pt')->count();

        $totalTransaksi = DB::table('transaksi')->count();

        $membershipAktif = DB::table('users')
            ->where('role', 'member')
            ->where('membership_status', 'active')
            ->count();

        $transaksiBerhasil = DB::table('transaksi')
            ->where('status', 'approved')
            ->count();

        $jadwalAktif = DB::table('schedule_latihan')
            ->whereIn('status', ['pending', 'approved', 'scheduled'])
            ->count();

        $transaksiTerbaru = DB::table('transaksi as t')
            ->leftJoin('users as u', 'u.id', '=', 't.user_id')
            ->select([
                't.id',
                't.jenis_transaksi',
                't.total_harga',
                't.status',
                't.tanggal_transaksi',
                'u.name as nama_member',
            ])
            ->orderByDesc('t.id')
            ->limit(5)
            ->get();

        
        $jadwalTerbaru = DB::table('schedule_latihan as s')
            ->leftJoin('users as u', 'u.id', '=', 's.user_id')
            ->leftJoin('pt as p', 'p.id', '=', 's.pt_id')
            ->select([
                's.id',
                's.tanggal',
                's.jam',
                's.jenis_latihan',
                's.status',
                'u.name as nama_member',
                'p.pt_name as nama_pt',
            ])
            ->whereNotNull('s.pt_id')
            ->orderBy('s.tanggal', 'asc')
            ->orderBy('s.jam', 'asc')
            ->limit(5)
            ->get();


        return view('admin.dashboard', compact(
            'totalMember',
            'totalPt',
            'totalTransaksi',
            'membershipAktif',
            'transaksiBerhasil',
            'jadwalAktif',
            'transaksiTerbaru',
            'jadwalTerbaru'
        ));
    }
}
