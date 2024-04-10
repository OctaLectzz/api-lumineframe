<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test Account
        User::create([
            'username' => 'admin',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
        ]);

        // My Account
        User::create([
            'username' => 'octalectzz',
            'first_name' => 'Octavyan Putra',
            'last_name' => 'Ramadhan',
            'email' => 'octalectzz@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'about' => 'Octa pacarnya Floraa',
            'pronouns' => 'he/him',
            'birthday' => '10-04-06',
            'gender' => 'man',
            'phone' => '089690220404',
            'url' => 'https://octalectzz.vercel.app',
            'address' => 'Jl.Seta No.32 Larangan RT4/RW4 Gayam Sukoharjo',
            'status' => 1
        ]);
    }
}
