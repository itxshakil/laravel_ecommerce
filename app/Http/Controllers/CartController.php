<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::instance('default')->content();
        $savedForLaterItems = Cart::instance('savedforlater')->content();

        return view('cart.index', compact('cartItems', 'savedForLaterItems'));
    }

    public function store(Request $request, Product $product)
    {
        if ($this->isDuplicates($product)) {
            return redirect(route('cart.index'))->with('success', 'Item is already added in cart');
        }

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        return redirect(route('cart.index'))->with('success', 'Item is added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        Cart::instance('default')->update($product->cartRowId, $request->quantity);
        $this->storeCart();

        if ($request->wantsJson()) {
            return response('Item quantity updated successfully.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item Quantity is updated successfully');
    }

    public function destroy(Request $request, Product $product)
    {
        Cart::instance('default')->remove($product->cartRowId);
        $this->storeCart();

        if ($request->wantsJson()) {
            return response('Item is removed from cart.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item is removed from cart');
    }

    public function switchToSaveForLater(Product $product)
    {
        Cart::instance('default');
        Cart::remove($product->cartRowId);
        $this->storeCart();

        if ($this->isDuplicates($product, 'savedforlater')) {
            if (request()->wantsJson()) {
                return response('Item is already saved for later.', 200);
            }
            return redirect(route('cart.index'))->with('success', 'Item is already saved for later.');
        }

        Cart::instance('savedforlater')->add($product, 1);
        $this->storeCart('savedforlater');

        if (request()->wantsJson()) {
            return response('Item is saved for later.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item is saved for later.');
    }

    public function isDuplicates(Product $product, $instance = 'default')
    {
        $duplicates = Cart::instance($instance)->search(function ($cartItem, $rowId) use ($product) {
            return $cartItem->model->id === $product->id;
        });

        return $duplicates->isNotEmpty();
    }

    public function storeCart($instance = 'default')
    {
        if (Auth::check()) {
            Cart::instance($instance)->store(auth()->id());
        }
    }
}
