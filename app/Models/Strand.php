<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Strand extends Model
{
    protected $table = 'strands';

    protected $fillable = [
        'name',
    ];

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }
}
