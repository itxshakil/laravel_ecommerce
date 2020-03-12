@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')
<section class="home text-center text-white" style="background-image:url(https://source.unsplash.com/daily)">
    <div class="home__content flex flex-col justify-center align-items-center h-screen bg-fixed "
        style="z-index:99;">
        <h2 class="text-4xl md:text-6xl">Welcome to My Shop</h2>
        <p class="text-xl md:text-2xl">We provide quality laptops in reasonable price.</p>
        <div class="mt-3">
            <a href="/shop" class=" p-2 inline-block bg-blue-500 rounded">Our Products</a>
        </div>
    </div>
</section>
<section class="container mx-auto text-white" id="product-section">
    <div class="p-2 inline-block bg-blue-500 rounded m-4">Featured Products</div>
    <div class="flex flex-wrap items-stretch">
        @forelse ($products as $product)
        <div class="card flex-product m-5 bg-gray-800 rounded overflow-hidden" title="View Details of {{ $product->name }}">
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
</section>
@endsection