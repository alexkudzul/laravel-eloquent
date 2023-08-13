<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Destination>
 */
class DestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'México',
                'Puebla',
                'Jalisco',
                'Nuevo León',
                'Sonora',
                'Yucatán',
                'Campeche',
                'Chiapas',
                'Tabasco',
                'Durango',
            ])
        ];
    }
}
