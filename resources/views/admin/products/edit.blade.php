@extends('layouts.admin.app')
@section('title')
Edit {{$product->name}}
@endsection
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg shadow-md">
        <h3 class="pt-4 text-2xl text-center">Edit {{$product->name}}</h3>
        <a class="pt-4 text-blue-500 float-right text-sm" href="{{route('admin.products.index')}}">All Products</a>
        <form class="px-8 pt-6 pb-2 mb-4 bg-white rounded" method="POST"
            action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                    Product name
                </label>
                <input
                    class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('name') border-red-500 @enderror"
                    id="name" type="text" required placeholder="New Product" name="name"
                    value="{{ $product->name ?? old('name') }}" required autocomplete="name" autofocus />
                @error('name')
                <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex flex-col md:flex-row">
                <div class="mb-4 md:mr-2 w-full">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="price">
                        Price
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('price') border-red-500 @enderror"
                        id="price" type="text" pattern="[0-9].+" name="price"
                        value="{{ $product->price ?? old('price') }}" required placeholder="199.99" />
                    @error('price')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 md:ml-2 w-full">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="quantity">
                        Quantity
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('price') border-red-500 @enderror"
                        id="quantity" type="number" pattern="[0-9].+" name="quantity"
                        value="{{ $product->quantity ?? old('quantity') }}" required placeholder="199" />
                    @error('quantity')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="image">
                    Image
                </label>
                <input
                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('image') border-red-500 @enderror"
                    id="image" type="file" name="image" accept="image/*" />
                @error('image')
                <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-gray-700" for="details">
                    Details
                </label>
                <textarea
                    class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('details') border-red-500 @enderror"
                    id="details" name="details" required placeholder="Enter product details here">{{ $product->details ?? old('details') }}
                </textarea>
                @error('details')
                <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <input class="mr-2 leading-tight" type="checkbox" name="featured" id="featured"
                    {{ $product->featured ? 'checked' : '' }} />
                <label class="text-sm" for="featured">
                    Featured Product
                </label>
            </div>
            <div class="mb-6 text-center">
                <button
                    class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                    type="submit">
                    Update {{$product->name}}
                </button>
            </div>
            @csrf
            @method('PATCH')
        </form>
    </div>
</div>
@endsection