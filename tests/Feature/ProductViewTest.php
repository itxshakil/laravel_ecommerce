<?php

namespace Tests\Feature;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductViewTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_user_can_view_product()
    {
        $product = factory(Product::class)->create();

        $this->get(route('products.view', $product))
        ->assertSee($product->name)
        ->assertSee($product->details)
        ->assertSee($product->price);
    }
}
