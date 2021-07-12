<?php

namespace Tests\Unit;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_product_can_be_added_to_cart()
    {
        $product = Product::factory()->create();

        Cart::add($product, 1);

        $this->assertCount(1, Cart::content());
    }

    /**
     * @test
     */
    public function a_product_quantity_can_be_added_to_updated()
    {
        $product = Product::factory()->create();

        Cart::add($product, 1);

        Cart::update($product->cartRowId, 2);

        $this->assertEquals(2, Cart::content()->first()->qty);
    }

    /**
    * @test
    */
    public function a_product_can_be_removed_from_cart()
    {
        $product = Product::factory()->create();

        Cart::add($product, 1);

        $this->assertCount(1, Cart::content());

        Cart::remove($product->cartRowId);

        $this->assertCount(0, Cart::content());
    }
}
