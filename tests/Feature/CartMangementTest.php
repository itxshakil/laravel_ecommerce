<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartMangementTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    public function authenticated_user_can_add_products_to_cart()
    {
        $this->actingAs(factory(User::class)->create());
        $product = factory(Product::class)->create();

        $this->post('/cart/' . $product->slug);

        $this->assertCount(1, Cart::content());
        $this->assertEquals($product->fresh(), Cart::content()->first()->model);
    }
}
