@extends('layouts.app')
@section('title','All products')
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="flex">
        <div class="w-48 flex flex-col">
            <p class="pt-4 font-semibold ">By Category</p>
            @foreach ($categories as $category)
            <a class="capitalize {{request()->category == $category->slug ? 'font-semibold' : '' }}"
                href="{{route('products.index',['category' => $category->slug])}}">{{$category->name}}</a>
            @endforeach

        </div>
        <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg">
            <a class="pt-4 text-blue-500 float-right text-sm" href="{{route('products.create')}}">Add new Products!</a>
            <h3 class="pt-4 text-2xl text-center">All Products!</h3>
            <table class="overflow-y-auto w-full text-center border-collapse">
                <tr class="bg-gray-300">
                    <th class="p-3">Name</th>
                    <th class="p-3">Price</th>
                    <th class="p-3">Details</th>
                    <th class="p-3">Image</th>
                    <th class="p-3">Quantity</th>
                    <th class="p-3">Categories</th>
                    <th class="p-3">Action</th>
                </tr>
                @foreach ($products as $product)
                <tr class="border-gray-300 border-b">
                    <td class="p-3">{{ $product->name }}</td>
                    <td class="p-3">{{ $product->price }}</td>
                    <td class="p-3">{{ Str::limit($product->details,30) }}</td>
                    <td class="p-3">
                        <img src="{{ $product->image }}" alt="Details of {{ $product->image }}" height="auto"
                            width="50">
                    </td>
                    <td class="p-3 text-lg">{{ $product->quantity }}</td>
                    <td class="p-3 text-lg">
                        @foreach ($product->categories as $category)
                        <span
                            class="bg-gray-100 text-gray-800 font-normal px-2 py-1 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs">{{$category->name}}</span>
                        @endforeach
                    </td>
                    <td class="p-3"><a href="{{ route('products.show',$product) }}">View</a></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection