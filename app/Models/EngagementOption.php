<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EngagementOption extends Model
{
    protected $table = 'engagement_options';

    protected $fillable = [
        'code',
        'label',
    ];

    public function alumni(): BelongsToMany
    {
        return $this->belongsToMany(
            Alumnus::class,
            'alumnus_engagement',
            'engagement_option_id',
            'alumnus_id'
        )->withTimestamps();
    }
}
