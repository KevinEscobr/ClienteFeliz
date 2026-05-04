<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Recruiter',
            'email' => 'recruiter@test.com',
            'password' => Hash::make('123456'),
            'role' => 'recruiter'
        ]);

        User::create([
            'name' => 'Candidate',
            'email' => 'candidate@test.com',
            'password' => Hash::make('123456'),
            'role' => 'candidate'
        ]);
    }
}
