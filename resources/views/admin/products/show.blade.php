@extends('layouts.admin.app')
@section('title')
Details of {{ $product->name }}
@endsection
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg shadow-md">
        <a class="pt-4 text-blue-500 float-right text-sm" href="{{route('admin.products.index')}}">All Products</a>
        <h3 class="pt-4 text-2xl text-center">All Products!</h3>
        <div class="md:flex border-2 rounded-lg">
            <div class="md:flex-shrink-0">
                <img class="rounded-lg md:w-56 h-64" src="{{ $product->image }}" alt="Details of {{ $product->name }}">
            </div>
            <div class="pt-4 md:mt-0 md:ml-6">
                <div class="uppercase tracking-wide text-sm text-indigo-600 font-bold">Details of {{ $product->name }}
                </div>
                <a href="#"
                    class="block mt-1 text-lg leading-tight font-semibold text-green hover:underline">₹{{ $product->price }}</a>
                <p class="mt-2 text-gray-600 mb-3">
                    {{ $product->details }}
                </p>

                <div class="flex">
                    <a href="{{ route('admin.products.edit',$product) }}"
                        class="bg-blue-500 active:bg-blue-400 text-gray-100 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs">
                        Edit</a>
                    <form action="{{ route('admin.products.destroy',$product) }}" method="POST"
                        onsubmit="event.preventDefault();if(confirm('Are you sure to Delete?')){event.target.submit();}">
                        <button type="submit"
                            class="bg-red-100 active:bg-red-200 text-red-800 font-normal px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs">Delete</button>
                        @csrf
                        @method('delete')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection