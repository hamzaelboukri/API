<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\job_offer;
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
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'company' => $this->faker->company,
            'location' => $this->faker->city,
            'salary' => $this->faker->randomFloat(2, 30000, 150000),
            'is_active' => $this->faker->boolean,
            'expires_at' => $this->faker->date('Y-m-d', '2025-12-31'),
            'requirements' => json_encode([
                'degree' => $this->faker->randomElement(['Bachelor', 'Master', 'PhD']),
                'experience' => $this->faker->numberBetween(0, 10) . ' years',
                'skills' => $this->faker->words(5, true)
            ]),
            'contact_email' => $this->faker->email,
            'user_id' => User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
        ];
    }
}