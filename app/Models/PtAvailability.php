<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PtAvailability extends Model
{
    use HasFactory;

    protected $table = 'pt_availabilities';

    protected $fillable = [
        'pt_profile_id',
        'start_at',
        'end_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function ptProfile()
    {
        return $this->belongsTo(PtProfile::class);
    }

    public function scheduleLatihan()
{
    return $this->hasOne(ScheduleLatihan::class, 'pt_availability_id');
}
}
