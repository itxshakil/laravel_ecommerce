<?php

namespace App\Http\Controllers;

use App\CartHelper;
use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController
{
    use CartHelper;

    public function index()
    {
        $cartItems = Cart::instance('default')->content();
        $savedForLaterItems = Cart::instance('savedforlater')->content();

        return view('cart.index', compact('cartItems', 'savedForLaterItems'));
    }

    public function store(Request $request, Product $product)
    {
        if ($product->quantity < 1) {
            if ($request->wantsJson()) {
                return response('Item is not available.', 422);
            }
            return redirect(route('cart.index'))->with('flash', 'Item is not available.');
        }
        if ($this->isDuplicates($product)) {
            if ($request->wantsJson()) {
                return response('Item is already in cart.', 422);
            }
            return redirect(route('cart.index'))->with('flash', 'Item is already added in cart');
        }

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        if ($request->wantsJson()) {
            return response('Item is added to cart', 200);
        }
        return redirect(route('cart.index'))->with('flash', 'Item is added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        if ($request->quantity > $product->quantity) {
            return response(collect(['message' => 'We currently do not have enough item in stock.']), 422);
        }

        Cart::instance('default')->update($product->cartRowId, $request->quantity);
        $this->storeCart();

        if ($request->wantsJson()) {
            return response('Item quantity updated successfully.', 200);
        }
        return redirect(route('cart.index'))->with('flash', 'Item Quantity is updated flashfully');
    }

    public function destroy(Request $request, Product $product)
    {
        Cart::instance('default')->remove($product->cartRowId);
        $this->storeCart();

        if ($request->wantsJson()) {
            return response('Item is removed from cart.', 200);
        }
        return redirect(route('cart.index'))->with('flash', 'Item is removed from cart');
    }

    public function switchToSaveForLater(Product $product)
    {
        Cart::instance('default');
        Cart::remove($product->cartRowId);
        $this->storeCart();

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
}
