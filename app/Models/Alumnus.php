<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Alumnus extends Model
{
    protected $table = 'alumni';

    protected $fillable = [
        'user_id',
        'track',
        'full_name',
        'nickname',
        'sex',
        'date_of_birth',
        'civil_status',
        'nationality',
        'religion',
        'student_number',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(AlumniProfile::class, 'alumnus_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(AlumniAddress::class, 'alumnus_id');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class, 'alumnus_id');
    }

    public function employments(): HasMany
    {
        return $this->hasMany(Employment::class, 'alumnus_id');
    }

    public function communityInvolvements(): HasMany
    {
        return $this->hasMany(CommunityInvolvement::class, 'alumnus_id');
    }

    public function engagementOptions(): BelongsToMany
    {
        return $this->belongsToMany(
            EngagementOption::class,
            'alumnus_engagement',
            'alumnus_id',
            'engagement_option_id'
        )->withTimestamps();
    }

    public function consent(): HasOne
    {
        return $this->hasOne(Consent::class, 'alumnus_id');
    }
}
