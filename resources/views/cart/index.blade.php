@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')<div class="container md:mx-auto  max-w-lg p-8 pb-2 m-3">
    @include('includes.message')
    @if (Cart::instance('default')->count() > 0)
    <div class="mb-8">
        <p class="text-xl mb-2">{{ Cart::instance('default')->count() }} item(s) in Shopping Cart</p>
        <div class="cart">
            @foreach ($cartItems as $item)
            <div class="flex justify-between border-b-2 p-2">
                <img src="/storage/{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100"
                    height="100">
                <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>

                <div class="mx-2 flex flex-col">
                    <form action="{{ route('cart.destroy',$item->model) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit">Remove</button>
                    </form>
                </div>
                <select class="block uppercase tracking-wide text-gray-700 text-xs font-bold p-1 mr-2 w-12 quantity"
                    data-id="{{ $item->rowId }}" for="grid-state">
                    <option {{ $item->qty == 1 ? 'selected' : ''}}>1</option>
                    <option {{ $item->qty == 2 ? 'selected' : ''}}>2</option>
                    <option {{ $item->qty == 3 ? 'selected' : ''}}>3</option>
                    <option {{ $item->qty == 4 ? 'selected' : ''}}>4</option>
                </select>
                <p class="font-semibold">${{ $item->subtotal()  }}</p>
            </div>
            @endforeach
        </div>

        <div class="flex justify-between px-2">
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis blanditiis voluptates commodi vero.
                Impedit odio unde animi aliquam reprehenderit modi.</p>
            <div class="cart-total flex">
                <div class="cart-total-left px-2">
                    <p>Subtotal</p>
                    <p>Tax</p>
                    <p class="font-semibold">Total</p>
                </div>
                <div class="cart-total-right">
                    <p class="font-semibold">{{ Cart::subtotal() }}</p>
                    <p class="font-semibold">{{ Cart::tax() }}</p>
                    <p class="font-semibold">{{ Cart::total() }}</p>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center mb-8">
        <p class="text-lg">No Items is Saved for later. </p>
        <a href="/" class="btn bg-gray-200 text-gray-800 rounded">Continue Shopping</a>
    </div>
    @endif
    @endsection