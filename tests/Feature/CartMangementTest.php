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

    /**
    * @test
    */
    public function cart_items_quantity_could_be_updated()
    {
        $this->actingAs(factory(User::class)->create());
        $product = factory(Product::class)->create();

        $this->post('/cart/' . $product->slug);
        $this->assertEquals(1, Cart::content()->first()->qty);

        $this->patch('/cart/' . $product->slug, ['quantity' => 2]);
        $this->assertEquals(2, Cart::content()->first()->qty);
    }

    /**
    * @test
    */
    public function it_requires_numeric_quantity_to_update_cart()
    {
        $this->actingAs(factory(User::class)->create());
        $product = factory(Product::class)->create();

        $this->post('/cart/' . $product->slug);
        $this->assertEquals(1, Cart::content()->first()->qty);

        $this->patch('/cart/' . $product->slug, ['quantity' => ''])->assertSessionHasErrors('quantity');
        $this->patch('/cart/' . $product->slug, ['quantity' => 'not numeric'])->assertSessionHasErrors('quantity');
        $this->assertEquals(1, Cart::content()->first()->qty);
    }

    /**
    * @test
    */
    public function user_can_remove_product_from_cart()
    {
        $this->actingAs(factory(User::class)->create());
        $product = factory(Product::class)->create();

        $this->post('/cart/' . $product->slug);
        $this->assertCount(1, Cart::content());

        $this->delete('/cart/' . $product->slug);
        $this->assertCount(0, Cart::content());
    }
}