<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Instructor;
use App\Models\User;

class InstructorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a test user (if not already exists)
        $user = User::firstOrCreate([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
            'password' => bcrypt('password123'),
            'role' => 'instructor',
        ]);

        // Create a test instructor
        Instructor::create([
            'user_id' => $user->_id,
            'name' => 'John Doe',
            'bio' => 'Experienced yoga instructor with 10 years of practice.',
            'skills' => ['yoga', 'meditation'],
            'profile_picture' => 'https://example.com/profile.jpg',
        ]);

        // Add more instructors if needed
        Instructor::create([
            'user_id' => $user->_id,
            'name' => 'Jane Smith',
            'bio' => 'Professional artist specializing in watercolor painting.',
            'skills' => ['painting', 'drawing'],
            'profile_picture' => 'https://example.com/profile2.jpg',
        ]);
    }
}