@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')
<section class="container mt-8 mx-auto text-gray-900 flex md" id="product-section">
    <aside class="w-48">
        <div class="px-2 pt-4 inline-block rounded flex flex-col m-1 md:m-4 mt-8">
            <p class="pt-4 font-semibold ">By Category</p>
            @foreach ($categories as $category)
            <a class="capitalize {{request()->category == $category->slug ? 'font-semibold' : '' }}"
                href="{{route('shop',['category' => $category->slug])}}">{{$category->name}}</a>
            @endforeach
        </div>
    </aside>
    <div class="w-full">
        <div class="flex justify-between items-baseline">
            <div class="px-2 pb-0 pl-0 m-1 md:m-4 inline border-b-2 border-gray-900 font-semibold text-2xl">
                {{$categoryName}}
            </div>
            <div class="flex">
                <strong class=" mx-1">Price</strong>
                <a class="capitalize mx-1"
                    href="{{route('shop',['category'=>request()->category,'sort'=>'low_high'])}}">Low to High</a> |
                <a class="capitalize mx-1"
                    href="{{route('shop',['category'=>request()->category,'sort'=>'high_low'])}}">High to Low</a>
            </div>
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

            <div class="text-center p-3">
                <div class="text-2xl">No Products Found</div>
            </div>
            @endforelse
        </div>
        {{$products->appends(request()->input())->links('pagination.tailwind')}}
    </div>


</section>
@endsection