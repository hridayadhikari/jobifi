<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SeekerProfile extends Model
{
    use HasFactory;

    protected $table = 'seeker_profiles';

    protected $fillable = [
        'user_id',
        'headline',
        'phone',
        'address',
        'bio',
        'cover_photo',
        'resume_path',
        'resume_original_name',
        'linkedin_url',
        'github_url',
        'portfolio_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'seeker_skill');
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(SeekerExperience::class)->orderByDesc('start_date');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(SeekerEducation::class)->orderByDesc('start_year');
    }

    public function languages(): HasMany
    {
        return $this->hasMany(SeekerLanguage::class);
    }
}