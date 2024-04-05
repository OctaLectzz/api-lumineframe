<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Meme'
        ]);
        Category::create([
            'name' => 'Mountain'
        ]);
        Category::create([
            'name' => 'Beach'
        ]);
        Category::create([
            'name' => 'House'
        ]);
        Category::create([
            'name' => 'Black White'
        ]);
        Category::create([
            'name' => 'Game'
        ]);
        Category::create([
            'name' => 'Technology'
        ]);
        Category::create([
            'name' => 'Electronic'
        ]);
        Category::create([
            'name' => 'Task'
        ]);
        Category::create([
            'name' => 'Wallpaper'
        ]);
        Category::create([
            'name' => 'Aesthetic'
        ]);
        Category::create([
            'name' => 'Wedding'
        ]);
        Category::create([
            'name' => 'Anime'
        ]);
        Category::create([
            'name' => 'Movie'
        ]);
    }
}
