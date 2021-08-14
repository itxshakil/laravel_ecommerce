<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    const SEARCH_KEY = 'q';
    private int $perPage = 9;

    public function index(): Factory|View|Application
    {
        $categoryName =  "All Products";
        if (request('category')) {
            $categoryName = Category::firstWhere('slug', request()->category)->name ?? 'Invalid Category';
        }

        $products = $this->getPaginatedProducts();
        return view('shop', compact('products', 'categoryName'));
    }

    protected function getPaginatedProducts(): LengthAwarePaginator
    {
        $products = Product::query();
        if (request('category')) {
            $products->categories(request('category'));
        } else {
            $products->featured();
        }

        $products = $this->SortProducts($products);

        return $products->paginate($this->perPage);
    }

    public function search(Request $request): Factory|View|Application
    {
        $searchQuery = $request->input(self::SEARCH_KEY);
        $products = Product::search($searchQuery)->paginate(20);
        return view('search', compact('products'));
    }

    /**
     * @param Builder $products
     * @return Builder
     */
    protected function SortProducts(Builder $products): Builder
    {
        if (request()->query('sort') == 'low_high') {
            $products = $products->orderBy('price');
        } elseif (request()->query('sort') == 'high_low') {
            $products = $products->orderBy('price', 'desc');
        }
        return $products;
    }
}
