<?php

namespace Tests\Unit;

use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function a_product_can_be_added_to_cart()
    {
        $product = factory(Product::class)->create();

        Cart::add($product, 1);

        $this->assertCount(1, Cart::content());
    }
}
