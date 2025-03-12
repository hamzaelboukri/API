<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\job_offer;
use App\Models\JobOffer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobOfferFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = job_offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'category_id' => Category::factory(),
            'recruiter_id' => User::factory(),
            'location' => $this->faker->city(),
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'expiration_date' => $this->faker->dateTimeBetween('+2 months', '+6 months'),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
