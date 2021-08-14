<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRating;
use App\Models\Product;
use App\Models\Rating;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class RatingController extends Controller
{
    public function store(Product $product, StoreRating $request): Model|Response|Application|ResponseFactory
    {
        if ($request->user()->hasRated($product)) {
            return response('You have already reviewed the product.', 422);
        }

        return $product->ratings()->create($request->validated())->load('user');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreRating $request
     * @param Rating $rating
     * @return Rating
     * @throws AuthorizationException
     */
    public function update(StoreRating $request, Rating $rating): Rating
    {
        $this->authorize('update', $rating);

        $rating->update($request->validated());

        return $rating->load('user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Rating $rating
     * @return Response|Application|ResponseFactory
     * @throws AuthorizationException
     */
    public function destroy(Rating $rating): Response|Application|ResponseFactory
    {
        $this->authorize('update', $rating);

        try {
            $rating->delete();
        } catch (Exception $e) {
            return response('An Error Occurred, Please try again.', 500);
        }

        return response('Rating deleted Successfully.', 200);
    }
}
