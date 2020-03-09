<?php

namespace App\Http\Controllers;

use App\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('shop', compact('products'));
    }
}
