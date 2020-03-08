<?php

namespace App\Http\Controllers;

use App\CartHelper;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    use CartHelper;

    public function store(Product $product)
    {
        if ($this->isDuplicates($product, 'savedforlater')) {
            if (request()->wantsJson()) {
                return response('Item is already saved for later.', 422);
            }
            return redirect(route('cart.index'))->with('flash', 'Item is already saved for later.');
        }

        Cart::instance('savedforlater')->add($product, 1);
        $this->storeCart('savedforlater');

        if (request()->wantsJson()) {
            return response('Item is saved for later.', 200);
        }
        return redirect(route('cart.index'))->with('flash', 'Item is saved for later.');
    }

    public function destroy(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        $this->storeCart('savedforlater');

        return response(['Item is removed from saved for later.', 200]);
    }

    public function switchToSaveToCart(Product $product)
    {
        Cart::instance('savedforlater');
        Cart::remove($product->cartRowId);
        $this->storeCart('savedforlater');

        $duplicates = Cart::instance('default')->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        if ($duplicates->isNotEmpty()) {
            if (request()->wantsJson()) {
                return response('Item is already saved in cart.', 200);
            }
            return redirect(route('cart.index'))->with('flash', 'Item is already saved in cart.');
        };

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        if (request()->wantsJson()) {
            return response('Item is saved to cart.', 200);
        }
        return redirect(route('cart.index'))->with('flash', 'Item is saved to cart.');
    }
}
