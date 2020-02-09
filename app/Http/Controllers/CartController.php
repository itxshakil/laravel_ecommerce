<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::content();

        return view('cart.index', compact('cartItems'));
    }

    public function store(Request $request, Product $product)
    {
        Cart::add($product, 1);

        return redirect(route('cart.index'))->with('success', 'Item is added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        Cart::update($product->cartRowId, $request->quantity);
        
        if ($request->wantsJson()) {
            return response('Item quantity updated successfully.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item Quantity is updated successfully');
        ;
    }

    public function destroy(Request $request, Product $product)
    {
        Cart::remove($product->cartRowId);

        if ($request->wantsJson()) {
            return response('Item is removed from cart.', 200);
        }
        return redirect(route('cart.index'))->with('success', 'Item is removed from cart');
        ;
    }
}
