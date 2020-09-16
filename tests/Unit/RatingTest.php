<?php

namespace Tests\Unit;

use App\Product;
use App\Rating;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function rating_belongs_to_product()
    {
        $this->actingAs(User::factory()->create());
        $product = Product::factory()->create();
        $rating = Rating::factory()->make();
        $rating = $product->ratings()->create([
            'title' => $rating->title,
            'description' => $rating->description,
            'rating' => $rating->rating,
            'user_id' => auth()->id()
        ]);

        $this->assertEquals($rating->fresh(), $product->ratings->first());
    }
}
