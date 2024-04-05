<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'name' => 'memes'
        ]);
        Tag::create([
            'name' => 'photography'
        ]);
        Tag::create([
            'name' => 'sunset'
        ]);
        Tag::create([
            'name' => 'sunrise'
        ]);
        Tag::create([
            'name' => 'pantai'
        ]);
        Tag::create([
            'name' => 'mountain'
        ]);
        Tag::create([
            'name' => 'gunung'
        ]);
        Tag::create([
            'name' => 'house'
        ]);
        Tag::create([
            'name' => 'rumah'
        ]);
        Tag::create([
            'name' => 'bunga'
        ]);
        Tag::create([
            'name' => 'flora'
        ]);
        Tag::create([
            'name' => 'jkt48'
        ]);
        Tag::create([
            'name' => 'fauna'
        ]);
    }
}
