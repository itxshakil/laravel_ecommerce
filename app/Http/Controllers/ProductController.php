<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        $product->load('ratings.user');
        return view('products.view', compact('product'));
    }
}
