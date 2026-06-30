<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{

  protected $fillable = [
        'seeker_id',
        'recruiter_id',
    ];

     public function seeker()
    {
        return $this->belongsTo(User::class, 'seeker_id');
    }

    public function recruiter()
    {
        return $this->belongsTo(User::class, 'recruiter_id');
    }
   
}

