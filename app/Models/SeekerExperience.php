<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeekerExperience extends Model
{
    protected $table = 'seeker_experiences';

    protected $fillable = [
        'seeker_profile_id',
        'job_title',
        'company_name',
        'description',
        'start_date',
        'end_date',
        'is_current',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_current' => 'boolean',
    ];

    public function seekerProfile(): BelongsTo
    {
        return $this->belongsTo(SeekerProfile::class);
    }
}
