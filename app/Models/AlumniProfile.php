<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniProfile extends Model
{
    protected $table = 'alumni_profiles';

    protected $fillable = [
        'alumnus_id',
        'contact_number',
        'email',
        'facebook_handle',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }
}
