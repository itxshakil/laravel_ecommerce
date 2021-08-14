<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class ProductController
{
    public function index(): Factory|View|Application
    {
        $featuredProducts = Cache::remember('featured-product', 6000, function () {
            return Product::where('featured', true)->take(12)->get();
        });
        return view('welcome', compact('featuredProducts'));
    }

    public function show(Product $product): Factory|View|Application
    {
        $product->load('ratings.user');
        return view('products.view', compact('product'));
    }
}
