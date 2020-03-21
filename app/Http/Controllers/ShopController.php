<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $categoryName = $this->getCategoryTitle();

        $products = $this->getProducts();

        return view('shop', compact('products', 'categoryName'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::search($query)->paginate(20);

        return view('search', compact('products'));
    }

    protected function getProducts()
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

        $perPage = 9;
        return $products->paginate($perPage);
    }

    protected function getCategoryTitle($categoryName = 'Featured')
    {
        if (request()->category) {
            $categoryName = Category::where('slug', request()->category)->first()->name ?? 'Invalid Category';
        }

        return $categoryName;
    }
}
