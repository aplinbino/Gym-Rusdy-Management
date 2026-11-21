<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class AdminTransaksiController extends Controller
{
    public function index()
    {
       $transaksi = Transaksi::with(['user', 'pt'])
        ->orderBy('id', 'asc')
        ->get();
        return response()->json($transaksi);
    }
}
    