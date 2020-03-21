<?php

namespace App\Http\Controllers;

use App\Product;
use App\Helpers\CartHelper;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController
{
    use CartHelper;

    public function index()
    {
        $cartItems = Cart::instance('default')->content();
        $savedForLaterItems = Cart::instance('savedforlater')->content();

        return view('cart.index', compact('cartItems', 'savedForLaterItems'));
    }

    public function store(Product $product)
    {
        if ($product->quantity < 1) {
            return $this->sendErrorResponse('Item is currently not available.');
        }
        if ($this->isDuplicates($product)) {
            return $this->sendErrorResponse('Item is already in cart.');
        }

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is added to cart');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        if ($request->quantity > $product->quantity) {
            return $this->sendErrorResponse(collect(['message' => 'We currently do not have enough item in stock.']));
        }

        Cart::instance('default')->update($product->cartRowId, $request->quantity);
        $this->storeCart();

        return $this->sendSuccessResponse('Item quantity updated successfully.');
    }

    public function destroy(Request $request, Product $product)
    {
        Cart::instance('default')->remove($product->cartRowId);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is removed from cart.');
    }

    public function switchToSaveForLater(Product $product)
    {
        Cart::instance('default');
        Cart::remove($product->cartRowId);
        $this->storeCart();

        if ($this->isDuplicates($product, 'savedforlater')) {
            return $this->sendErrorResponse('Item is already saved for later.');
        }

        Cart::instance('savedforlater')->add($product, 1);
        $this->storeCart('savedforlater');

        return $this->sendSuccessResponse('Item is saved for later.');
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
