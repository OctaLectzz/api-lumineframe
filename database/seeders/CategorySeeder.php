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
            'image' => 'meme.png',
            'name' => 'Meme'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'mountain.jpg',
            'name' => 'Mountain'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'beach.jpg',
            'name' => 'Beach'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'house.jpg',
            'name' => 'House'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'blackwhite.jpg',
            'name' => 'Black White'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'game.jpg',
            'name' => 'Game'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'technology.jpg',
            'name' => 'Technology'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'electronic.jpg',
            'name' => 'Electronic'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'task.jpg',
            'name' => 'Task'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'wallpaper.jpeg',
            'name' => 'Wallpaper'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'aesthetic.jpg',
            'name' => 'Aesthetic'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'wedding.png',
            'name' => 'Wedding'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'anime.jpg',
            'name' => 'Anime'
        ]);
        Category::create([
            'category_code' => Str::random(10),
            'image' => 'movie.jpg',
            'name' => 'Movie'
        ]);
    }
}
