<?php

namespace Tests\Feature;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaveForLaterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_save_item_to_Saved_for_later()
    {
        $product = Product::factory()->create();

        $this->post("/saveForLater/$product->slug");

        $this->assertCount(1, Cart::instance('savedforlater')->content());
        $this->assertEquals($product->fresh(), Cart::instance('savedforlater')->content()->first()->model);
    }

    /**
     * @test
     */
    public function user_can_switch_product_to_saved_for_later()
    {
        $product = Product::factory()->create();

        Cart::add($product, 1);
        $this->post('/cart/switchToSaveForLater/' . $product->slug);

        $this->assertCount(0, Cart::instance('default')->content());
        $this->assertCount(1, Cart::instance('savedforlater')->content());
        $this->assertEquals($product->fresh(), Cart::instance('savedforlater')->content()->first()->model);
    }

    /**
     * @test
     */
    public function user_can_remove_product_from_save_for_later()
    {
        $product = Product::factory()->create();

        Cart::instance('savedforlater')->add($product, 1);
        $this->assertCount(1, Cart::instance('savedforlater')->content());
        $this->delete('/saveForLater/' . $product->slug);

        $this->assertCount(0, Cart::instance('savedforlater')->content());
    }

    /**
     * @test
     */
    public function user_can_switch_product_to_cart()
    {
        $product = Product::factory()->create();

        Cart::instance('savedforlater')->add($product, 1);
        $this->post('/saveForLater/switchToSaveToCart/' . $product->slug);

        $this->assertCount(1, Cart::instance('default')->content());
        $this->assertCount(0, Cart::instance('savedforlater')->content());
        $this->assertEquals($product->fresh(), Cart::instance('default')->content()->first()->model);
    }
}
