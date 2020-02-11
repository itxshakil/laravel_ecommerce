<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    public function destroy(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        return response(['Item is removed from saved for later.', 200]);
    }

    public function switchToSaveToCart(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            if (request()->wantsJson()) {
                return response('Item is already saved in cart.', 200);
            }
            return redirect(route('cart.index'))->with('success', 'Item is already saved in cart.');
        };

        Cart::instance('default')->add($product, 1);

        if (request()->wantsJson()) {
            return response('Item is saved to cart.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item is saved to cart.');
    }
}
