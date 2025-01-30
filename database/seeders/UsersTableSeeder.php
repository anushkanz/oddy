<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a test user
        User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'phone' => '1234567890',
            'status'=>1,
            'role' => 'customer',
        ]);

        // Add more users if needed
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => Hash::make('password123'),
            'phone' => '0987654321',
            'status'=>1,
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'tutor@example.com',
            'password' => Hash::make('password123'),
            'phone' => '0987654321',
            'status'=>1,
            'role' => 'tutor',
        ]);
    }
}