<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostModel>
 */
class PostModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'title' => fake()->text(50),
            'slug' =>  Str::slug(fake()->name(), '-'),
            'thumbnail' => "https://dummyimage.com/300",
            'is_published' => "1",
            'description' => fake()->text(),
        ];
    }
}
