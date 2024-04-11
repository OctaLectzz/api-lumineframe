<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = glob(public_path('images/*'));
        $tags = Tag::pluck('id')->toArray();

        Photo::factory(count($images))->create()->each(function ($photo) use ($images, $tags) {
            $imagePath = $images[array_rand($images)];

            $photo->update(['image' => basename($imagePath)]);

            $photo->tags()->attach(
                collect($tags)->random(rand(4, 10))
            );
        });
    }
}
