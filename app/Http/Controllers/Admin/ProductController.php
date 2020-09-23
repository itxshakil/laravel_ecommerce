<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();
        if (request()->category) {
            $products = $products->with('categories')->whereHas('categories', function ($query) {
                $query->where('slug', request()->category);
            });
        } else {
            $products = $products->where('featured', true);
        }
        if (request()->sort == 'low_high') {
            $products = $products->orderBy('price');
        } elseif (request()->sort == 'high_low') {
            $products = $products->orderBy('price', 'desc');
        }

        $products = $products->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'details' => ['required'],
            'price' => ['required', 'numeric'],
            'image' => ['required']
        ]);

        $data['image'] = $this->uploadImage($request);

        return Product::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required'],
            'details' => ['required'],
            'price' => ['required', 'numeric'],
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
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
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
    public function uploadImage(Request $request)
    {
        $name = time() . '_' . preg_replace('/\s+/', '_', $request->image->getClientOriginalName());
        return $request->image->storeAs('products/images', $name, 'public');
    }
}
