<?php

namespace App\Http\Controllers;

use App\Product;
use App\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
    public function store(Product $product, Request $request)
    {
        if (auth()->user()->fresh()->isRated($product)->isNotEmpty()) {
            return response('You have already added your review', 422);
        }

        $data = $request->validate([
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'rating' => ['required', 'numeric', 'between:1,5'],
        ]);

        return $product->ratings()->create($data)->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $data = $request->validate([
            'title' => ['required', 'max:100'],
            'description' => ['required'],
            'rating' => ['required', 'numeric', 'between:1,5'],
        ]);

        $rating->update($data);

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
