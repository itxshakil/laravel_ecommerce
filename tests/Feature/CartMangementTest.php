<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartMangementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_add_products_to_cart()
    {
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create();

        $this->post('/cart/' . $product->slug);

        $this->assertCount(1, Cart::content());
        $this->assertEquals($product->fresh(), Cart::content()->first()->model);
    }

    /**
     * @test
     */
    public function item_does_not_added_to_cart_if_stock_is_not_available()
    {
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create(['quantity' => 0]);

        $this->assertCount(0, Cart::content());

        $this->post('/cart/' . $product->slug);

        $this->assertCount(0, Cart::content());
    }

    /**
     * @test
     */
    public function message_is_flashed_if_dupliactes_is_added()
    {
        $product = Product::factory()->create();

        $this->post('/cart/' . $product->slug);

        $this->assertCount(1, Cart::content());

        $this->json('POST', '/cart/' . $product->slug)->assertStatus(422);

        $this->assertCount(1, Cart::content());
    }

    /**
     * @test
     */
    public function cart_items_quantity_could_be_updated()
    {
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create();

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
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create();

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
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create();

        $this->post('/cart/' . $product->slug);
        $this->assertCount(1, Cart::content());

        $this->delete('/cart/' . $product->slug);
        $this->assertCount(0, Cart::content());
    }
}
