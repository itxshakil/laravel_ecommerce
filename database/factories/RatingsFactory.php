<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Rating;
use App\User;
use Faker\Generator as Faker;

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'description' => $faker->paragraph(),
        'rating' => $faker->numberBetween(1, 5),
        // 'user_id' => (factory(User::class)->create())->id,
        // 'product_id' => (factory(Product::class)->create())->id
    ];
});
