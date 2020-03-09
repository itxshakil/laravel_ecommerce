@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')
<section class="container mt-8 mx-auto text-gray-900 flex md" id="product-section">
    <aside class="w-48">
        <div class="px-2 pt-4 inline-block rounded flex flex-col m-1 md:m-4 mt-8">
            <p class="pt-4 font-semibold ">By Category</p>
            <p>Laptops</p>
            <p>Desktops</p>
            <p>Mobile Phones</p>
            <p>Tablets</p>
            <p>Appliances</p>
            <p class="pt-4 font-semibold ">By Price</p>
            <p>₹0-₹999</p>
            <p>₹999-₹3999</p>
            <p>₹3999+</p>
        </div>
    </aside>
    <div class="w-full">
        <div class="px-2 pb-0 pl-0 m-1 md:m-4 inline border-b-2 border-gray-900 font-semibold text-2xl">Our Products
        </div>
        <div class="flex flex-wrap items-stretch">
            @forelse ($products as $product)
            <div class="card flex-shop m-1 md:m-5 bg-gray-800 text-gray-100 rounded overflow-hidden"
                title="View Details of {{ $product->name }}">
                <img class="object-cover w-full" src="{{$product->image}}" alt="View Details of {{ $product->name }}">
                <div class="text-center p-3">
                    <div class="text-2xl">{{ $product->name }}</div>
                    <div class="text-green-400">₹{{ $product->price }}</div>
                    <a href="{{route('products.view',$product)}}"
                        class="p-2 inline-block bg-green-400 rounded text-white m-1">View Details</a>
                </div>
            </div>
            @empty

            <div class="card flex-product m-5 bg-gray-800 rounded" title="Nothing Here">
                <div class="text-center p-3">
                    <div class="text-2xl">No Products Found</div>
                </div>
            </div>
            @endforelse
        </div>
    </div>


</section>
@endsection