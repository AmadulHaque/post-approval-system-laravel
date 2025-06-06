<?php

namespace Database\Factories;

use App\Enum\PostStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->slug(),
            'user_id' => null,
            'content' => fake()->paragraph(),
            'status' => PostStatus::DRAFT->value,
            'published_at' => null,
        ];
    }
}
