<?php

namespace App\Helpers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

trait CartHelper
{
    /**
     * Store cart items to database
     *
     * @param string $instance
     * @return void
     */
    public function storeCart(string $instance = "default")
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
    public function isDuplicates(Product $product, string $instance = "default"): bool
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
     * @return Application|ResponseFactory|Response|RedirectResponse|Redirector
     */
    protected function sendErrorResponse(mixed $message, int $status = 422): Application|ResponseFactory|Response|RedirectResponse|Redirector
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
     * @return Application|ResponseFactory|Response|Redirector|RedirectResponse
     */
    protected function sendSuccessResponse(mixed $message, int $status = 200): Application|ResponseFactory|Response|Redirector|RedirectResponse
    {
        if (request()->wantsJson()) {
            $message = collect(['message' => $message]);

            return response($message, $status);
        }
        return redirect(route('cart.index'))->with('flash', $message);
    }
}
