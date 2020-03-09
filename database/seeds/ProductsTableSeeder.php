<?php

use App\Product;
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
        factory(Product::class, 12)->create()->each(function($product){
            $product->categories()->attach(rand(1,5));
            return $product;
        });
    }
}
