<?php

namespace App\Helpers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;

trait CartHelper
{
    public function storeCart($instance = 'default')
    {
        if (Auth::check()) {
            Cart::instance($instance)->store(auth()->id());
        }
    }

    public function isDuplicates(Product $product, $instance = 'default')
    {
        $duplicates = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        return $duplicates->isNotEmpty();
    }

    protected function sendErrorResponse($message, $status = 422)
    {
        if (request()->wantsJson()) {
            return response($message, $status);
        }
        return redirect(route('cart.index'))->with('flash', $message);
    }

    protected function sendSuccessResponse($message, $status = 200)
    {
        if (request()->wantsJson()) {
            return response($message, $status);
        }
        return redirect(route('cart.index'))->with('flash', $message);
    }
}
