<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRating;
use App\Product;
use App\Rating;

class RatingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRating  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Product $product, StoreRating $request)
    {
        if ($request->user()->isRated($product)) {
            return response('You have already added your review', 422);
        }

        return $product->ratings()->create($request->only('title', 'description', 'rating'))->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRating $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $rating->update($request->only('title', 'description', 'rating'));

        return $rating->load('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        $this->authorize('update', $rating);

        $rating->delete();

        return response('Deleted Successfully', 200);
    }
}
