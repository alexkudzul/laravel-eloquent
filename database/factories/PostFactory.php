<?php

namespace Database\Factories;

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
            'title' => $this->faker->text(30),
            'body' => $this->faker->text(),
            'active' => $this->faker->numberBetween(0, 1),
            'likes' => $this->faker->randomNumber(3, true),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
