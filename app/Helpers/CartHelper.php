<?php

namespace App\Helpers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

trait CartHelper
{
    /**
     * Store cart items to database
     *
     * @param  mixed $instance
     * @return void
     */
    public function storeCart($instance = "default")
    {
        if (Auth::check()) {
            Cart::instance($instance)->store(auth()->id());
        }
    }

    /**
     * Check if Product is already in cart for given instance
     *
     * @param  mixed $product
     * @param  mixed $instance
     * @return bool
     */
    public function isDuplicates(Product $product, $instance = "default")
    {
        $duplicates = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        return $duplicates->isNotEmpty();
    }

    /**
     * send Error Response according to request type
     *
     * @param mixed $message
     * @param integer $status
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function sendErrorResponse($message, $status = 422)
    {
        if (request()->wantsJson()) {
            $message = collect(['message' => $message]);

            return response($message, $status);
        }
        return redirect(route('cart.index'))->with('flash', $message);
    }

    /**
     * Send Success Response according to Request type
     *
     * @param mixed $message
     * @param integer $status
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse($message, $status = 200)
    {
        if (request()->wantsJson()) {
            $message = collect(['message' => $message]);

            return response($message, $status);
        }
        return redirect(route('cart.index'))->with('flash', $message);
    }
}
