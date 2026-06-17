<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::query()
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.skills', compact('skills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:skills,name'],
        ]);

        $skill = Skill::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
        ]);
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'SKILL_CREATED',
            'description' => 'Skill Created: ' . $skill->name,
        ]);
        return Redirect::route('skills.index')
            ->with('success', 'Skill added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'SKILL_DELETED',
            'description' => 'Skill Deleted: ' . $skill->name,
        ]);
        return Redirect::route('skills.index')
            ->with('success', 'Skill deleted successfully.');
    }
}
