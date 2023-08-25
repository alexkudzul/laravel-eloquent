<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'url' => $this->faker->imageUrl(),

            // 'imageable_id' => function () {
            //     // Aquí debes retornar el ID de algún modelo relacionado.
            //     return rand(1, 10); // Por ejemplo, un ID entre 1 y 10.
            // },
            // 'imageable_type' => function () {
            //     // Aquí debes retornar el tipo de modelo relacionado.
            //     return 'App\\Models\\Post'; // Por ejemplo, la clase de algún modelo.
            // },
        ];
    }
}
