<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Product $product)
    {
        Cart::add($product, 1);
    }

    public function update(Request $request, Product $product)
    {
        $request->validate(['quantity' => ['required', 'numeric', 'between:1,5']]);

        Cart::update($product->cartRowId, $request->quantity);
    }
}
