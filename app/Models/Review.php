<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'target_type',
        'target_id',
        'rating',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // Member yang memberikan review
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // PT yang menerima review (jika target_type = pt)
    public function pt(): BelongsTo
    {
        return $this->belongsTo(Pt::class, 'target_id')
                    ->where('target_type', 'pt');
    }
}
