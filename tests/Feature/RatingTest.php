<?php

namespace Tests\Feature;

use App\Product;
use App\Rating;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /**
    * @test
    */
    public function authenticated_user_can_add_rating()
    {
        $this->actingAs(factory(User::class)->create());

        $product = factory(Product::class)->create();
        $rating = factory(Rating::class)->make();

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->ratings);
    }
}
