<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert roles into the roles table
        // DB::table('roles')->insert([
        //     ['name' => 'admin'],
        //     ['name' => 'teacher'],
        //     ['name' => 'student'],
        // ]);

        // Insert roles using the Role model
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'teacher']);
        Role::create(['name' => 'student']);
    }
}
