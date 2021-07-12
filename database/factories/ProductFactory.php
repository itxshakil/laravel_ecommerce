<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'details' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 99),
            'quantity' => $this->faker->randomNumber(),
            'image' => 'https://source.unsplash.com/collection/307591/400x300',
        ];
    }

    /**
     * Indicate that the product is featured
     *
     * @return Factory
     */
    public function featured()
    {
        return $this->state([
            'featured' => true,
        ]);
    }
}
