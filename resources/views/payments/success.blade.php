@extends('layouts.app')
@section('title','Payment Successfull')
@section('content')
<div class="container mx-auto">
    <div class="flex justify-between">
        <div class="md:mx-auto card max-w-lg p-8 pb-2 m-3 flex-1">
            <p class="text-success font-semibold float-right">{{ $payment->amount." " .$payment->currency }}</p>
            <h1 class="text-blue-500 text-xl pb-2">Payment Successfull.</h1>
            <hr>
            <p class="text-gray-600 mt-2">Transaction Id</p>
            <p class="font-semibold text-gray-900">{{ $payment->id }}</p>
            <p class="text-gray-600 mt-2">Order Id</p>
            <p class="font-semibold text-gray-900">{{ $payment->order_id }}</p>
            <p class="text-gray-600 mt-2">Shipping Address</p>
            <p class="font-semibold text-gray-900">{{ $payment->shipping_address }}</p>
            <p class="text-gray-500 text-xs float-right pt-3">
                {{ $payment->created_at->setTimezone('Asia/Kolkata')->toDateTimeString() }}</p>
        </div>

        <div class="cart flex-1 px-4">
            <p class="text-lg font-semibold">Your Order</p>
            <div class="cart">
                @foreach (Cart::instance($payment->order->id)->content() as $item)
                <div class="flex justify-between border-b-2 p-2">
                    <img src="{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100"
                        height="100">
                    <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>
                    <p>{{ $item->qty  }}</p>
                    <p class="font-semibold">${{ $item->model->price  }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between px-2">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perferendis blanditiis voluptates commodi
                    vero.
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
    </div>
</div>
@endsection