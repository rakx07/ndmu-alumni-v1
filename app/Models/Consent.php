<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consent extends Model
{
    protected $table = 'consents';

    protected $fillable = [
        'alumnus_id',
        'policy_version',
        'accepted',
        'accepted_at',
        'accepted_ip',
    ];

    protected $casts = [
        'accepted' => 'boolean',
        'accepted_at' => 'datetime',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }
}
