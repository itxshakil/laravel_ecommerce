<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $products = Product::query();
        if (request()->category) {
            $products->categories(request()->category);
        } else {
            $products = $products->latest();
        }
        $products = $this->handleSorting($products);

        $products = $products->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return
     */
    public function store(Request $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required'],
            'details' => ['required'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'image' => ['required']
        ]);

        $data['image'] = $this->uploadImage($request);

        Product::create($data);
        return redirect(route('admin.products.index'))->with('flash', 'Product is Added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Factory|View|Application
     */
    public function show(Product $product): Factory|View|Application
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @return Factory|View|Application
     */
    public function edit(Product $product): Factory|View|Application
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required'],
            'details' => ['required'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'image' => ['sometimes', 'required']
        ]);

        if ($request->hasFile('image')) {
            $imgArr = ['image' => $this->uploadImage($request)];
        }

        $product->update(array_merge($data, $imgArr ?? []));

        return redirect()->route('admin.products.show', ['product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Redirector|Application|RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): Redirector|Application|RedirectResponse
    {
        $product->delete();

        return redirect(route('admin.products.index'));
    }

    /**
     * Return Unique Image name in snake_case
     *
     * @param Request $request
     * @return string
     */
    public function uploadImage(Request $request): string
    {
        $name = time() . '_' . preg_replace('/\s+/', '_', $request->image->getClientOriginalName());
        return $request->image->storeAs('products/images', $name, 'public');
    }

    /**
     * @param Builder $products
     * @return Builder
     */
    protected function handleSorting(Builder $products): Builder
    {
        if (request()->query('sort') == 'low_high') {
            $products = $products->orderBy('price');
        } elseif (request()->query('sort') == 'high_low') {
            $products = $products->orderBy('price', 'desc');
        }
        return $products;
    }
}
