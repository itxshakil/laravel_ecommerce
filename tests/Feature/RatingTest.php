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

        $this->assertCount(0, $product->ratings);

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->fresh()->ratings);
    }

    /**
     * @test
     */
    public function user_can_only_add_one_review_per_product()
    {
        $this->actingAs($user = factory(User::class)->create());

        $product = factory(Product::class)->create();
        $rating = factory(Rating::class)->make();

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->fresh()->ratings);

        $this->post($product->slug . '/ratings', $rating->toArray())->assertStatus(422);

        $this->assertCount(1, $product->fresh()->ratings);
        $this->assertCount(1, $user->fresh()->ratings);
    }

    /**
     * @test
     */
    public function unauthenticated_user_can_not_add_rating()
    {
        $product = factory(Product::class)->create();
        $rating = factory(Rating::class)->make();

        $this->json('post', $product->slug . '/ratings', $rating->toArray())->assertStatus(401);

        $this->assertCount(0, $product->ratings);
    }

    /**
    * @test
    */
    public function rating_requires_valid_title()
    {
        $this->createRating(['title' => ''])->assertSessionHasErrors('title');
        $this->createRating(['title' => $this->faker->paragraph()])->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function rating_requires_description()
    {
        $this->createRating(['description' => ''])->assertSessionHasErrors('description');
    }

    /**
    * @test
    */
    public function rating_requires_valid_rating()
    {
        $this->createRating(['rating' => ''])->assertSessionHasErrors('rating');
        $this->createRating(['rating' => 8])->assertSessionHasErrors('rating');
        $this->createRating(['rating' => 0])->assertSessionHasErrors('rating');
    }

    public function createRating($overrides = [])
    {
        $this->actingAs(factory(User::class)->create());

        $product = factory(Product::class)->create();
        $rating = factory(Rating::class)->make($overrides);

        return $this->post($product->slug . '/ratings', $rating->toArray());
    }
}
