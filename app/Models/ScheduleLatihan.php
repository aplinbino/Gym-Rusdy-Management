<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleLatihan extends Model
{
    protected $table = 'schedule_latihan';

    protected $fillable = [
        'user_id',
        'pt_id',
        'transaksi_id',
        'pt_availability_id',
        'tanggal',
        'jam',
        'jenis_latihan',
        'status',
        'catatan',
        'jam_mulai',
'jam_selesai',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    // Member pemilik jadwal
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // PT pembimbing
    public function pt(): BelongsTo
    {
        return $this->belongsTo(Pt::class);
    }

    // Transaksi pembelian sesi PT
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    // Slot ketersediaan PT yang dipesan
    public function ptAvailability(): BelongsTo
    {
        return $this->belongsTo(PtAvailability::class);
    }
}
