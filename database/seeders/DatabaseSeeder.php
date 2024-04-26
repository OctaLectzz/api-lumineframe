<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        $this->call(UserSeeder::class);

        // Category Seeder
        // $this->call(CategorySeeder::class);

        // Tag Seeder
        // $this->call(TagSeeder::class);

        // Photo Seeder
        // $this->call(PhotoSeeder::class);
    }
}
