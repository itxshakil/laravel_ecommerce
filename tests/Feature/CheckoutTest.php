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
        $this->actingAs(factory(User::class)->create());

        $product = factory(Product::class)->create();

        $this->post("/cart/$product->slug");

        $response = $this->get('/checkout');

        $order = Order::all();
        $this->assertCount(1, $order);

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
