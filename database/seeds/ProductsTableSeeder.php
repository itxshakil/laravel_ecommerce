<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()->count(25)->create()->each(function ($product) {
            $product->categories()->attach(rand(1, 5));
        });

        Product::factory()->featured()->count(12)->create()->each(function ($product) {
            $product->categories()->attach(rand(1, 5));
        });
    }
}
