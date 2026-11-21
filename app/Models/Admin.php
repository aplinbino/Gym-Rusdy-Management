<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Model
{
    protected $table = 'admin';

    protected $fillable = [
        'user_id',
        'admin_name',
    ];

    // Akun user pemilik profil admin
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Transaksi yang disetujui admin
    public function approvedTransactions(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'approved_by');
    }
}
