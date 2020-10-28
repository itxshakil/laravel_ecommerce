@extends('layouts.app')
@section('title')
Details of {{ $order->id}}
@endsection
@section('content')
<div class="container mx-auto text-sm sm:text-base overflow-hidden">
    <div class="flex justify-between">
        <div class="w-full lg:w-1/2 bg-gray-100 p-5 mt-2 rounded-lg lg:rounded-l-none mx-1">
            <div class="flex justify-between pb-2">
                <p class="text-gray-500 font-semibold">{{ $order->id}}</p>
                <p class="inline-block px-2 pb-1 bg-yellow-200 text-yellow-800 rounded">{{ $order->status}}</p>
            </div>
            <h3 class="text-lg font-semibold">Your Order</h3>
            <div class="cart ">
                @foreach (Cart::instance($order->id)->content() as $item)
                <div class="flex justify-between border-b-2 p-2">
                    <img src="{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100"
                        height="100">
                    <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>
                    <p class="mx-3 font-semibold items-baseline" title="Quantity">{{ $item->qty  }}</p>
                    <p class="font-semibold" title="Item Price">₹{{ $item->model->price  }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between px-2 ">
                <p>Your total includes subtotal and 12% tax.</p>
                <div class="cart-total flex">
                    <div class="cart-total-left px-2">
                        <p>Subtotal</p>
                        <p>Tax</p>
                        <p class="font-semibold">Total</p>
                    </div>
                    <div class="cart-total-right">
                        <p class="font-semibold">₹{{ Cart::subtotal() }}</p>
                        <p class="font-semibold">₹{{ Cart::tax() }}</p>
                        <p class="font-semibold">₹{{ Cart::total() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($order->payments as $payment)
    <div class="w-full lg:w-1/2 bg-gray-100 p-2 md:p-5 rounded-lg lg:rounded-l-none mx-1 mt-4 ">
        <div class="flex justify-between pb-2">
            <p class="text-gray-500 font-semibold">{{ $payment->id}}</p>
            <p class="inline-block px-2 pb-1 bg-yellow-200 text-yellow-800 rounded">{{ $payment->status}}</p>
        </div>
        <div class="flex pb-2 ">
            <p class="text-gray-900 font-semibold ml-4">Payment Method :</p>
            <p class="text-gray-800 font-semibold ml-4">{{ $payment->method}}</p>
        </div>
        <div class="flex pb-2 ">
            <p class="text-gray-900 font-semibold ml-4">Email Address :</p>
            <p class="text-gray-800 font-semibold ml-4">{{ $payment->email}}</p>
        </div>
        <div class="flex pb-2 ">
            <p class="text-gray-900 font-semibold ml-4">Mobile :</p>
            <p class="text-gray-800 font-semibold ml-4">{{ $payment->contact}}</p>
        </div>
        <div class="flex pb-2 ">
            <p class="text-gray-900 font-semibold ml-4">Shipping Address :</p>
            <p class="text-gray-800 font-semibold ml-4">{{ $payment->shipping_address}}</p>
        </div>
    </div>
    @endforeach
</div>
@endsection