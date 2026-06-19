<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeekerLanguage extends Model
{
    protected $table = 'seeker_languages';

    protected $fillable = [
        'seeker_profile_id',
        'language',
        'proficiency',
    ];

    public function seekerProfile(): BelongsTo
    {
        return $this->belongsTo(SeekerProfile::class);
    }
}
