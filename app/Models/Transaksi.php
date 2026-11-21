<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'user_id',
        'pt_id',
        'jenis_transaksi',
        'membership_months',
        'jumlah_sesi',
        'harga_satuan',
        'total_harga',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
        'approved_by',
        'tanggal_transaksi',
    ];

    protected function casts(): array
    {
        return [
            'harga_satuan' => 'decimal:2',
            'total_harga' => 'decimal:2',
            'tanggal_transaksi' => 'datetime',
        ];
    }

    // Member pemilik transaksi
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // PT yang dipilih dalam transaksi
    public function pt(): BelongsTo
    {
        return $this->belongsTo(Pt::class);
    }

    // Admin yang menyetujui transaksi
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    // Jadwal yang berasal dari transaksi PT
    public function scheduleLatihan(): HasMany
    {
        return $this->hasMany(ScheduleLatihan::class);
    }
}
