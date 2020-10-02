@extends('layouts.admin.app')
@section('title','All products')
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="flex w-full">
        <div class="w-48 flex flex-col">
            <p class="pt-4 pb-1 font-semibold">By Category</p>
            @foreach ($categories as $category)
            <a class="capitalize {{request()->category == $category->slug ? 'font-semibold' : '' }}"
                href="{{route('admin.products.index',['category' => $category->slug])}}">{{$category->name}}</a>
            @endforeach
            <new-category></new-category>
        </div>
        <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg shadow-md">
            <a class="pt-4 text-blue-500 float-right text-sm" href="{{route('admin.products.create')}}">Add new
                Products!</a>
            <h3 class="pt-4 text-2xl text-center">All Products!</h3>
            @if ($products->count() > 0)
            <table class="overflow-y-auto w-full text-center border-collapse">
                <tr class="bg-gray-300">
                    <th class="p-3">Name</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Details</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Action</th>
                </tr>
                @foreach ($products as $product)
                <tr class="border-gray-300 border-b">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->price }}</td>
                    <td class="p-3">{{ Str::limit($product->details,30) }}</td>
                    <td class="p-3">
                        <img src="{{ $product->image }}" alt="Image of {{ $product->name }}" height="auto" width="50">
                    </td>
                    <td class="flex flex-col">
                        <p class="p-3 text-lg">{{ $product->quantity }}</p>
                        @if ($product->featured)
                        <p class="p-1 text-xs rounded-full bg-blue-500 text-gray-100">Featured</p>
                        @endif
                    </td>
                    <td class="p-3"><a href="{{ route('admin.products.show',$product) }}">View</a></td>
                </tr>
                @endforeach
            </table>
            {{$products->withQueryString()->links()}}

            @else
            <p class="text-xl font-semibold text-center -ml-20">No Products found.</p>
            @endif
        </div>
    </div>
</div>
@endsection