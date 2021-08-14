<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class CartController
{
    use CartHelper;

    public function index(): Factory|View|Application
    {
        $cartItems = Cart::instance('default')->content();
        $savedForLaterItems = Cart::instance('savedforlater')->content();

        return view('cart.index', compact('cartItems', 'savedForLaterItems'));
    }

    public function store(Product $product): Response|Redirector|RedirectResponse|Application|ResponseFactory
    {
        if ($product->isNotAvailable()) {
            return $this->sendErrorResponse('Item is currently not available.');
        }
        if ($this->isDuplicates($product)) {
            return $this->sendErrorResponse('Item is already in cart.');
        }

        Cart::instance('default')->add($product, 1);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is added to cart');
    }

    public function update(Request $request, Product $product): Response|Redirector|RedirectResponse|Application|ResponseFactory
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        if ($request->quantity > $product->quantity) {
            return $this->sendErrorResponse('We currently do not have enough item in stock.');
        }

        Cart::instance('default')->update($product->cartRowId, $request->quantity);
        $this->storeCart();

        return $this->sendSuccessResponse('Item quantity updated successfully.');
    }

    public function destroy(Product $product): Response|Redirector|Application|RedirectResponse|ResponseFactory
    {
        Cart::instance('default')->remove($product->cartRowId);
        $this->storeCart();

        return $this->sendSuccessResponse('Item is removed from cart.');
    }

    public function switchToSaveForLater(Product $product): Response|Redirector|RedirectResponse|Application|ResponseFactory
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
}
