<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Skill;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Laravel Developer',
            'Frontend Developer',
            'Backend Developer',
            'Full Stack Developer',
            'UI/UX Designer',
            'HR Executive',
            'Sales Executive',
            'Marketing Specialist',
            'Data Analyst',
            'DevOps Engineer'
        ];

        for ($i = 0; $i < 50; $i++) {

            $job = Job::create([
                'company_id' => Company::inRandomOrder()->first()->id,
                'category_id' => Category::inRandomOrder()->first()->id,
                'title' => fake()->randomElement($titles),
                'description' => fake()->paragraphs(5, true),
                'type' => fake()->randomElement([
                    'full-time',
                    'part-time',
                    'contract',
                    'internship'
                ]),
                'location' => fake()->city(),
                'salary_range' => '₹' .
                    rand(3, 15) .
                    ' LPA - ₹' .
                    rand(16, 30) .
                    ' LPA',
                'is_active' => true,
            ]);

            $job->skills()->attach(
                Skill::inRandomOrder()
                    ->take(rand(2, 5))
                    ->pluck('id')
            );
        }
    }
}
