<?php

namespace App\Http\Controllers;

use App\Product;

class ProductController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::inRandomOrder()->take(11)->get();
        return view('welcome', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('ratings.user');
        return view('products.view', compact('product'));
    }
}
