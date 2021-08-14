<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function authenticated_user_can_add_rating()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->assertCount(0, $product->ratings);

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->fresh()->ratings);
    }

    /**
     * @test
     */
    public function user_can_only_add_one_review_per_product()
    {
        $this->actingAs($user = User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

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
        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->json('post', $product->slug . '/ratings', $rating->toArray())->assertStatus(401);

        $this->assertCount(0, $product->ratings);
    }

    /**
     * @test
     */
    public function rating_requires_valid_title()
    {
        $this->createRating(['title' => ''])->assertSessionHasErrors('title');
        $this->createRating(['title' => $this->faker->paragraph(40)])->assertSessionHasErrors('title');
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

    /**
     * @test
     */
    public function user_can_edit_rating()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->post($product->slug . '/ratings', $rating->toArray());
        $updatedRating = Rating::factory()->make();

        $this->patch('/ratings/' . Rating::first()->id, $updatedRating->toArray());

        $this->assertEquals($updatedRating->title, Rating::first()->title);
        $this->assertEquals($updatedRating->description, Rating::first()->description);
        $this->assertEquals($updatedRating->rating, Rating::first()->rating);
    }

    /**
     * @test
     */
    public function unauthorised_user_can_not_edit_rating()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->actingAs(User::factory()->create());
        $updatedRating = Rating::factory()->make();

        $this->patch('/ratings/' . Rating::first()->id, $updatedRating->toArray())->assertStatus(403);

        $this->assertEquals($rating->title, Rating::first()->title);
        $this->assertEquals($rating->description, Rating::first()->description);
        $this->assertEquals($rating->rating, Rating::first()->rating);
    }

    /**
     * @test
     */
    public function authorized_user_can_delete_review()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->fresh()->ratings);

        $this->delete('/ratings/' . Rating::first()->id, $rating->toArray())->assertStatus(200);

        $this->assertCount(0, $product->fresh()->ratings);
    }

    /**
     * @test
     */
    public function unauthorized_user_can_not_delete_review()
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make();

        $this->post($product->slug . '/ratings', $rating->toArray());

        $this->assertCount(1, $product->fresh()->ratings);
        $this->actingAs(User::factory()->create());

        $this->delete('/ratings/' . Rating::first()->id, $rating->toArray())->assertStatus(403);

        $this->assertCount(1, $product->fresh()->ratings);
    }

    public function createRating($overrides = [])
    {
        $this->actingAs(User::factory()->create());

        $product = Product::factory()->create();
        $rating = Rating::factory()->make($overrides);

        return $this->post($product->slug . '/ratings', $rating->toArray());
    }
}
