<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobType; // Make sure to import JobType if you're using it
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'user_id' => 11,
            'job_type_id' => rand(1,7),
            'category_id' => rand(1,7),
            'vacancy' => rand(1,7),
            'location' => fake()->city,
            'description' => fake()->text,
            'experience' => rand(1,9),
            'company_name' => fake()->name,
        ];
    }
}
