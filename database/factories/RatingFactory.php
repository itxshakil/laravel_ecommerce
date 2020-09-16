<?php

namespace Database\Factories;

use App\Product;
use App\Rating;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(),
            'description' => $this->faker->paragraph(),
            'rating' => $this->faker->numberBetween(1, 5),
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
        ];
    }
}
