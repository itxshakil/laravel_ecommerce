@extends('layouts.app')
@section('title')
{{$categoryName  ?? 'Latest Product'}}
{{ (request()->sort) ? (request()->sort == 'low_high')  ? "| Price Low to High" : "| Price High to Low" : NULL }}
{{ (request()->page) ? "| Page ". request()->page  : NULL }}
@endsection
@section('content')
<section class="container mt-4 sm:mt-8 mx-auto text-gray-900" id="product-section">
    <form action="/search" method="get" class="w-full text-center sm:text-right mr-4">
        <input
            class="w-48 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('q')der-red-500 @enderror"
            id="query" type="search" name="q" placeholder="Search products" />
        @error('q')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <div class="flex">
        <aside class="w-48">
            <div class="px-2 pt-4 rounded flex flex-col m-1 md:m-4 mt-8">
                <p class="pt-4 font-semibold text-sm sm:text-base">By Category</p>
                @foreach ($categories as $category)
                <a class="capitalize text-sm sm:text-base {{request()->category == $category->slug ? 'font-semibold' : null }}"
                    href="{{route('shop',['category' => $category->slug])}}">{{$category->name}}</a>
                @endforeach
                <div class="sm:hidden mt-4">
                    <p class="pt-4 font-semibold">Sort Price</p>
                    <a class="capitalize text-sm {{request()->sort == 'low_high' ? 'font-semibold' : null }}"
                        href="{{route('shop',['category'=>request()->category,'sort'=>'low_high'])}}">Low to High</a>
                    <a class="capitalize text-sm {{request()->sort == 'high_low' ? 'font-semibold' : null }}"
                        href="{{route('shop',['category'=>request()->category,'sort'=>'high_low'])}}">High to Low</a>
                </div>

            </div>
        </aside>
        <div class="w-full">
            <div class="flex justify-between items-baseline">
                <div class="px-2 pb-0 pl-0 m-1 md:m-4 inline border-b-2 border-gray-900 font-semibold text-2xl">
                    {{$categoryName}}
                </div>
                <div class="hidden sm:flex">
                    <strong class=" mx-1">Price</strong>
                    <a class="capitalize mx-1 {{request()->sort == 'low_high' ? 'font-semibold' : null }}"
                        href="{{route('shop',['category'=>request()->category,'sort'=>'low_high'])}}">Low to High</a> |
                    <a class="capitalize mx-1 {{request()->sort == 'high_low' ? 'font-semibold' : null }}"
                        href="{{route('shop',['category'=>request()->category,'sort'=>'high_low'])}}">High to Low</a>
                </div>
            </div>
            <div class="flex flex-wrap items-stretch">
                @forelse ($products as $product)
                <div class="card flex-shop mr-2 mb-2 md:m-5 bg-gray-800 text-gray-100 rounded overflow-hidden"
                    title="View Details of {{ $product->name }}">
                    <img class="object-cover w-full" src="{{$product->image}}"
                        alt="View Details of {{ $product->name }}">
                    <div class="text-center p-3">
                        <div class="text-2xl">{{ $product->name }}</div>
                        <div class="text-green-400">₹{{ $product->price }}</div>
                        <a href="{{route('products.view',$product)}}"
                            class="p-2 inline-block bg-green-400 rounded text-white m-1">View Details</a>
                    </div>
                </div>
                @empty

                <div class="text-center p-3">
                    <div class="text-2xl">No Products Found</div>
                </div>
                @endforelse
            </div>
            {{$products->withQueryString()->links()}}
        </div>
    </div>
</section>
@endsection