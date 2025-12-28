<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Employment extends Model
{
    protected $table = 'employments';

    protected $fillable = [
        'alumnus_id',
        'position',
        'company',
        'org_type',
        'office_address',
        'office_contact',
        'office_email',
        'start_date',
        'licenses',
        'achievements',
    ];

    protected $casts = [
        'start_date' => 'date',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }
}
