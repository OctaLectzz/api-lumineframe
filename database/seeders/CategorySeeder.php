<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Meme'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Mountain'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Beach'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'House'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Black White'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Game'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Technology'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Electronic'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Task'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Wallpaper'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Aesthetic'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Wedding'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Anime'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'name' => 'Movie'
        ]);
    }
}
