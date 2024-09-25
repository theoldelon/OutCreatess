<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Users first
        User::factory(10)->create(); // Adjust the number of users as needed

        // Create Job Types and Categories
        JobType::factory(7)->create(); // Adjust the number as needed
        Category::factory(7)->create(); // Adjust the number as needed

        // Then create jobs
        Job::factory()->count(15)->create(); // Adjust the count as needed
    }
}
