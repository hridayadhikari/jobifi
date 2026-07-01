<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function jobs()
    {
        return $this->belongsToMany(
            Job::class,
            'job_skill'
        );
    }

    public function seekerProfiles()
{
    return $this->belongsToMany(
        SeekerProfile::class,
        'seeker_skill'
    );
}
}