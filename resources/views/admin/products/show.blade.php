@extends('layouts.app')

@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg">
        <a class="pt-4 text-blue-500 float-right text-sm" href="{{route('products.index')}}">All Products</a>
        <h3 class="pt-4 text-2xl text-center">All Products!</h3>
        <div class="md:flex border-2 rounded-lg">
            <div class="md:flex-shrink-0">
                <img class="rounded-lg md:w-56 h-64" src="/storage/{{ $product->image }}" alt="Details of {{ $product->name }}">
            </div>
            <div class="pt-4 md:mt-0 md:ml-6">
                <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">Details of {{ $product->name }}</div>
                <a href="#" class="block mt-1 text-lg leading-tight font-semibold text-green hover:underline">₹{{ $product->price }}</a>
                <p class="mt-2 text-gray-600 mb-3">
                    {{ $product->details }}
                </p>
                
                <a href="{{ route('products.edit',$product) }}" class="inline-block px-2 bg-blue-500 text-white rounded mb-2">Edit</a>
                <form action="{{ route('products.destroy',$product) }}" method="POST" onsubmit="event.preventDefault();if(confirm('Are you sure to Delete?')){event.target.submit();}">
                    <button type="submit" class="inline-block px-2 bg-blue-500 text-white rounded">Delete</button>
                    @csrf
                    @method('delete')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection