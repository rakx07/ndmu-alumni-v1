<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'alumnus_id',
        'context',
        'college_id',
        'program_id',
        'strand_id',
        'level_label',
        'institution_name',
        'institution_location',
        'year_entered',
        'year_graduated',
        'thesis_title',
        'honors',
        'remarks',
    ];

    /**
     * ✅ Expose a unified display field for Filament/table views:
     * - prefer Program relation label
     * - fallback to level_label
     */
    protected $appends = [
        'degree_program',
    ];

    public function alumnus(): BelongsTo
    {
        return $this->belongsTo(Alumnus::class, 'alumnus_id');
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function strand(): BelongsTo
    {
        return $this->belongsTo(Strand::class);
    }

    /**
     * ✅ Accessor: $education->degree_program
     * Adjust the program column name if needed.
     */
    public function getDegreeProgramAttribute(): string
    {
        // If your programs table uses a different column, change 'name' below:
        // e.g. $this->program?->program_name
        $programName = $this->program?->name;

        return $programName
            ?: ($this->level_label ?: '');
    }
}
