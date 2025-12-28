<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    protected $table = 'programs';

    protected $fillable = [
        'college_id',
        'name',
        'level',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }
}
