<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'user_id' => 3,
            'job_type_id' => rand(1,5),
            'category_id' => rand(1,5),
            'vacancy' => rand(1,5),
            'location' => fake()->city,
            'description' => fake()->text,
            'experience' => rand(1,10),
            'company_name' => fake()->name,   
            'status' => 1, // Set default status
            'isFeatured' => rand(0, 1), // Randomly assign featured status         
        ];
    }
}
