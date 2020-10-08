<?php

namespace Tests\Feature;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_user_can_checkout()
    {

        $this->actingAs(User::factory()->create());
        $response = $this->get('/checkout');

        // $response->assertSeeText('Coming Soon!');

        $product = Product::factory()->create();

        $this->post("/cart/$product->slug");

        $response = $this->get('/checkout');

        $order = Order::all();
        $this->assertCount(1, $order);

        $this->assertEquals($product->id, $order->first()->products->first()->pivot->product_id);

        $response->assertRedirect(route('order.checkout', ['order' => $order->first()->id]));
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_checkout()
    {
        $this->get('/checkout')->assertRedirect('/login');
    }
}
