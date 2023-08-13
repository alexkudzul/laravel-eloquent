<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number' => $this->faker->randomNumber(5, true),
            'legs' => $this->faker->numberBetween(1, 9),
            'active' => $this->faker->numberBetween(0, 1),
            'departed' => $this->faker->numberBetween(0, 1),
            'arrived_at' => $this->faker->dateTimeBetween('-10 year', 'now'),
            'destination_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
