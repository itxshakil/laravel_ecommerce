<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController
{
    public function show(Product $product)
    {
        $product->load('ratings.user');
        return view('products.view', compact('product'));
    }
}
