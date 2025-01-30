<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;

class UserVerificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserVerify::create([
            'user_id' => $user->_id,
            'token' => Str::random(64),
        ]);

        UserVerify::create([
            'user_id' => $user->_id,
            'token' => Str::random(64),
        ]);

        UserVerify::create([
            'user_id' => $user->_id,
            'token' => Str::random(64),
        ]);
    }
}
