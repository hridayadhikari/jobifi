<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\User;



class SeekerController extends Controller
{
    public function show(User $user)
    {
        $user  = $user;
        $profile = $user->seekerProfile()->firstOrCreate(['user_id' => $user->id]);

        $profile->load(['experiences', 'educations', 'skills', 'languages']);

        return view('admin.seeker.show', compact('user', 'profile'));
    }
}
