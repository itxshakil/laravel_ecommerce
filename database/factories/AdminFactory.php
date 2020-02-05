<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => 'admin@acme.com',
        'job_title' => $faker->jobTitle,
        'password' => Hash::make('Admin123'),
    ];
});
