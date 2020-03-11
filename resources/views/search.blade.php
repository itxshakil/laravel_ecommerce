@extends('layouts.app')
@section('title','Search')
@section('content')
<section class="container mt-4 mx-auto text-gray-900" id="product-section">
    <form action="/search" method="get" class="w-full text-right">
        <input
            class="w-48 px-3 py-2 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('query') border-red-500 @enderror"
            id="query" type="search" name="query" placeholder="Search product" />
        @error('query')
        <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
        @enderror
    </form>
    <h1 class="px-2 font-semibold text-2xl">Search Result for {{request()->input('query')}}</h1>
    <p class="px-2 text-lg mb-2">{{$products->total()}} results for {{request()->input('query')}}</p>
    @if ($products->count() > 0)
    <table class="overflow-y-auto w-full text-center border-collapse">
        <tr class="bg-blue-300 text-gray-100">
            <th class="p-3">Name</th>
            <th class="p-3">Price</th>
            <th class="p-3">Details</th>
            <th class="p-3">Action</th>
        </tr>
        @foreach ($products as $product)
        <tr class="border-blue-300 border-b">
            <td class="p-3">{{ $product->name }}</td>
            <td class="p-3">{{ $product->price }}</td>
            <td class="p-3">{{ Str::limit($product->details,30) }}</td>
            <td class="p-3"><a href="{{ route('products.view',$product) }}">View</a></td>
        </tr>
        @endforeach
    </table>
    {{$products->appends(request()->input())->links('pagination.tailwind')}}
    @endif
</section>
@endsection