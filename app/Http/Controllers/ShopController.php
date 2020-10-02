<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $perPage = 9;

    public function index()
    {
        $categoryName =  "All Products";
        if (request()->category) {
            $categoryName = Category::where('slug', request()->category)->first()->name ?? 'Invalid Category';
        }

        $products = $this->getPaginatedProducts();

        return view('shop', compact('products', 'categoryName'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::search($query)->paginate(20);

        return view('search', compact('products'));
    }

    protected function getPaginatedProducts()
    {
        if (request()->category) {
            $products = Product::with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
        } else {
            $products = Product::where('featured', true);
        }
        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price');
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc');
        }

        return $products->paginate($this->perPage);
    }
}
