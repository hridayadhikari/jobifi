<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            'Laravel',
            'PHP',
            'MySQL',
            'JavaScript',
            'React',
            'Vue.js',
            'Node.js',
            'Python',
            'Java',
            'Git',
            'Docker',
            'AWS',
            'Tailwind CSS',
            'Figma',
            'UI/UX',
        ];

        foreach ($skills as $skill) {
            Skill::create([
                'name' => $skill,
                'slug' => Str::slug($skill),
            ]);
        }
    }
}