@extends('layouts.app')
@section('title')
{{ $product->name }}
@endsection
@section('description')
    View details of  {{$product->name}} such as price, reviews and more. You can even search products here.
@endsection
@section('content')
<div class="container mx-auto px-6 my-4">
    <form action="{{route('search')}}" method="GET" class="w-full mb-4 text-right mr-4">
        <input
            class="w-48 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('q')border-red-500 @enderror"
            id="query" type="search" name="q" placeholder="Search products" />
        @error('q')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <div class="flex justify-center">
        <product-view :data="{{json_encode($product)}}"></product-view>
    </div>
</div>
@endsection
