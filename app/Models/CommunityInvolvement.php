<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityInvolvement extends Model
{
    protected $table = 'community_involvements';

    protected $fillable = [
        'alumnus_id',
        'organization',
        'role',
        'years_active',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }
}
