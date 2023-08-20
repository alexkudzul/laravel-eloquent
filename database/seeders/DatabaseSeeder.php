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
        \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Destination::factory(10)->create();
        \App\Models\Flight::factory(100)->create();

        \App\Models\Phone::factory(10)->create();
        \App\Models\Course::factory(10)->create();
        \App\Models\Section::factory(10)->create();
        \App\Models\Lesson::factory(20)->create();

        \App\Models\Mechanic::factory(5)->create();
        \App\Models\Car::factory(10)->create();
        \App\Models\Owner::factory(10)->create();
    }
}
