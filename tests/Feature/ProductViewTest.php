<?php

namespace Tests\Feature;

use App\Models\Product;
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
        $product = Product::factory()->create();

        $this->get(route('products.view', $product))
            ->assertSee($product->name)
            ->assertSee($product->details)
            ->assertSee($product->price);
    }
}
