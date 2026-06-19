<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            'Jobifi Technologies',
            'TechVerse',
            'CloudNest',
            'ABC Solutions',
            'Time Variance Authority'
        ];

        foreach ($companies as $name) {

            $user = User::create([
                'name' => $name . ' Recruiter',
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password123'),
                'role' => 'recruiter',
            ]);

            Company::create([
                'user_id' => $user->id,
                'name' => $name,
                'description' => fake()->paragraph(),
                'website' => fake()->url(),
                'headquarters_location' => fake()->city(),
            ]);
        }
    }
}
