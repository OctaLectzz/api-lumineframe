<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        return [
            'photo_number' => str_pad(rand(1, 999999999), 9, '0', STR_PAD_LEFT),
            'user_id' => fake()->randomElement($users),
            'image' => basename(collect(glob(public_path('images/*')))->random()),
            'category_id' => fake()->randomElement($categories)
        ];
    }
}
