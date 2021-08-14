<?php

namespace Tests\Unit;

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
    public function product_can_be_switched_to_saved_for_later()
    {
        $product = Product::factory()->create();

        Cart::add($product, 1);

        Cart::remove($product->cartRowId);
        Cart::instance('savedforlater')->add($product, 1);

        $this->assertCount(0, Cart::instance('default')->content());
        $this->assertCount(1, Cart::instance('savedforlater')->content());
    }

    /**
     * @test
     */
    public function product_can_be_removed_from_saved_for_later()
    {
        $product = Product::factory()->create();

        Cart::instance('savedforlater')->add($product, 1);

        $this->assertCount(1, Cart::instance('savedforlater')->content());
        Cart::remove($product->cartRowId);
        $this->assertCount(0, Cart::instance('savedforlater')->content());
    }

    /**
     * @test
     */
    public function product_can_be_switched_to_save_for_cart()
    {
        $product = Product::factory()->create();

        Cart::instance('savedforlater')->add($product, 1);

        Cart::instance('savedforlater')->remove($product->cartRowId);
        Cart::instance('default')->add($product, 1);

        $this->assertCount(0, Cart::instance('savedforlater')->content());
        $this->assertCount(1, Cart::instance('default')->content());
    }
}
