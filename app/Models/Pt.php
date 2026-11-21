<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pt extends Model
{
    protected $table = 'pt';

    protected $fillable = [
        'user_id',
        'pt_name',
        'split_gym',
        'price_per_session',
        'description',
        'photo',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'price_per_session' => 'decimal:2',
        ];
    }

    // Akun user pemilik profil PT
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Member yang sedang memilih PT ini
    public function currentMembers(): HasMany
    {
        return $this->hasMany(User::class, 'current_pt_id');
    }

    // Transaksi pembelian sesi PT
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    // Jadwal latihan bersama PT
    public function scheduleLatihan(): HasMany
    {
        return $this->hasMany(ScheduleLatihan::class);
    }

    // Review yang ditujukan kepada PT ini
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'target_id')
                    ->where('target_type', 'pt');
    }
}
