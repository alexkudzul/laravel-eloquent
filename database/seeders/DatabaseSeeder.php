<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create()->each(function ($user) {
            \App\Models\Phone::factory(1)->create([
                'user_id' => $user->id,
            ]);
        });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Destination::factory(10)->create();
        \App\Models\Flight::factory(100)->create();

        \App\Models\Course::factory(10)->create()->each(function ($course) {
            \App\Models\Image::factory(1)->create([
                'imageable_id' => $course->id,
                'imageable_type' => 'App\\Models\\Course',
            ]);

            \App\Models\Comment::factory(5)->create([
                'commentable_id' => $course->id,
                'commentable_type' => 'App\\Models\\Course',
            ]);
        });
        \App\Models\Section::factory(50)->create();
        \App\Models\Lesson::factory(100)->create();

        \App\Models\Mechanic::factory(10)->create()->each(function ($mechanic) {
            \App\Models\Car::factory(1)->create(['mechanic_id' => $mechanic->id])->each(function ($car) {
                \App\Models\Owner::factory(1)->create(['car_id' => $car->id]);
            });
        });

        $this->call([
            RoleSeeder::class,
        ]);

        \App\Models\Post::factory(10)->create()->each(function ($post) {
            \App\Models\Image::factory(1)->create([
                'imageable_id' => $post->id,
                'imageable_type' => 'App\\Models\\Post',
            ]);

            \App\Models\Comment::factory(5)->create([
                'commentable_id' => $post->id,
                'commentable_type' => 'App\\Models\\Post',
            ]);
        });

        \App\Models\Tag::factory(10)->create();
    }
}
