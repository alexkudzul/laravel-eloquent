<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->text(),

            // 'commentable_id' => function () {
            //     // Aquí debes retornar el ID de algún modelo relacionado.
            //     return rand(1, 10); // Por ejemplo, un ID entre 1 y 10.
            // },
            // 'commentable_type' => function () {
            //     // Aquí debes retornar el tipo de modelo relacionado.
            //     return 'App\\Models\\Post'; // Por ejemplo, la clase de algún modelo.
            // },
        ];
    }
}
