<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'membership_status',
        'membership_start',
        'membership_end',
        'current_pt_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_start' => 'date',
            'membership_end' => 'date',
        ];
    }

    // Profil admin
    public function adminProfile(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    // Profil PT
    public function ptProfile(): HasOne
    {
        return $this->hasOne(Pt::class);
    }

    // PT yang sedang dipilih member
    public function currentPt(): BelongsTo
    {
        return $this->belongsTo(Pt::class, 'current_pt_id');
    }

    // Semua transaksi milik user
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    // Semua jadwal latihan milik user
    public function scheduleLatihan(): HasMany
    {
        return $this->hasMany(ScheduleLatihan::class);
    }

    // Semua review yang dibuat user
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
