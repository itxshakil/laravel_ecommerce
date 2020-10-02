@extends('layouts.app')
@section('title')
Search result for {{request()->query('q')}}
@endsection
@section('content')
<section class="container mt-4 mx-auto text-gray-900" id="product-section">
    <form action="/search" method="get" class="w-full text-right mr-4">
        <input
            class="w-48 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('q') border-red-500 @enderror"
            id="query" type="search" name="q" value="{{request()->query('q')}}" placeholder="Search products" />
        @error('q')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <h1 class="pr-2 font-semibold text-2xl">Search Result for {{request()->query('q')}}</h1>
    @forelse ($products as $product)
    <div class="bg-gray-300 p-5 rounded-lg shadow block sm:flex mb-2 mx-2">
        <img src="{{$product->image}}" alt="Image of {{$product->name}}" title="Image of {{$product->name}}"
            height="150px" width="200px" class="w-full sm:w-48">
        <div class="ml-4">
            <h3 class="text-xl" title="Product name">{{ $product->name }}</h3>
            <p class="text-lg text-green-400 mb-2" title="Product price">₹{{ $product->price }}</p>
            <p class="" title="Product short description">{{ Str::limit($product->details,80) }}</p>
            <a href="{{route('products.view',$product)}}"
                class="p-2 inline-block bg-green-300 rounded text-green-900 m-1" title="Go to product page">View
                Details</a>
        </div>
    </div>
    @empty
    <p title="No Result">No results found.</p>
    @endforelse
    {{$products->withQueryString()->links()}}
</section>
@endsection