@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container mt-4 mx-auto text-gray-900" id="product-section">
    <form action="/search" method="get" class="w-full text-right mr-4">
        <input
            class="w-48 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('query') border-red-500 @enderror"
            id="query" type="search" name="query" placeholder="Search product" />
        @error('query')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <h1 class="pr-2 font-semibold text-2xl">Search Result for {{request()->input('query')}}</h1>
    @forelse ($products as $product)
    <div class="w-full bg-gray-200 p-5 rounded-lg shadow flex mb-2">
        <img src="{{$product->image}}" alt="Image of {{$product->name}}" height="150px" width="150px">
        <div>
            <h3 class="text-xl">{{ $product->name }}</h3>
            <p class="text-sm text-green-400 mb-2">₹{{ $product->price }}</p>
            <p class="">{{ Str::limit($product->details,60) }}</p>
            <a href="{{route('products.view',$product)}}"
                class="p-2 inline-block bg-green-300 rounded text-green-900 m-1">View
                Details</a>
        </div>
    </div>
    @empty
    <p>No results found.</p>
    @endforelse
    {{$products->withQueryString()->links()}}
</section>
@endsection