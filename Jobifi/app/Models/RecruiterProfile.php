<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecruiterProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'designation',
        'phone',
        'linkedin_url'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}