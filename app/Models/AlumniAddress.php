<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniAddress extends Model
{
    protected $table = 'alumni_addresses';

    protected $fillable = [
        'alumnus_id',
        'type',
        'line1',
        'line2',
        'city',
        'province',
        'country',
        'postal_code',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }
}
