<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        JobType::factory(7)->create();
        Category::factory(7)->create();
    }
}
