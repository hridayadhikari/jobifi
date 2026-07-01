<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeekerEducation extends Model
{
    protected $table = 'seeker_educations';

    protected $fillable = [
        'seeker_profile_id',
        'degree',
        'institution',
        'description',
        'start_year',
        'end_year',
    ];

    public function seekerProfile(): BelongsTo
    {
        return $this->belongsTo(SeekerProfile::class);
    }
}
