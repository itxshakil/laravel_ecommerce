<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount =  $this->faker->numberBetween(100, 1000);
        return [
            'id' => $this->faker->uuid,
            'entity' => 'order',
            'amount' => $amount,
            'amount_paid' => 0,
            'amount_due' => $amount,
            'currency' => 'INR',
            'receipt' => 'Receipt #20',
            'status' => 'created',
            'attempts' => 0,
            'notes' => [],
            'created_at' => 1572502745
        ];
    }
}
