@extends('layouts.admin.app')
@section('title')
Details of {{ $order->id }}
@endsection
@section('content')
<div class="container mx-auto">
    <div class="flex justify-between">
        <div class="w-full lg:w-1/2 bg-white shadow-md p-5 mt-4 rounded-lg lg:rounded-l-none mx-1">
            <div class="flex justify-between pb-2">
                <p class="text-gray-500 font-semibold">{{ $order->id}}</p>
                <p class="inline-block px-2 pb-1 bg-yellow-200 text-yellow-800 rounded">{{ $order->status}}</p>
            </div>
            <h3 class="text-lg font-semibold">Your Order</h3>
            <div class="cart">
                @foreach (Cart::instance($order->id)->content() as $item)
                <div class="flex justify-between border-b-2 pb-4 p-2">
                    <img src="{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100"
                        height="100">
                    <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>
                    <p>{{ $item->qty  }}</p>
                    <p class="font-semibold">${{ $item->model->price  }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between px-2 mt-4">
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
    <div class="flex flex-col md:flex-row flex-wrap items-stretch">
        @foreach ($order->payments as $payment)
        <div class="w-full lg:w-1/3 bg-white shadow-md p-5 rounded-lg lg:rounded-l-none mx-1 mt-4 flex-grow">
            <div class="flex justify-between pb-2">
                <p class="text-gray-500 font-semibold">{{ $payment->id}}</p>
                <p class="inline-block px-2 pb-1 bg-yellow-200 text-yellow-800 rounded">{{ $payment->status}}</p>
            </div>
            <div class="flex pb-2 ">
                <p class="text-gray-900 font-semibold ml-4">Payment Method :</p>
                <p class="text-gray-800 ml-4">{{ $payment->method}}</p>
            </div>
            @if ($payment->method == 'card')
            <div class="w-full border rounded-lg p-4">
                <div class="flex justify-between">
                    <span class="text-sm text-grey-900 p-1">{{$payment->card['type'].'Card'}}</span>
                    <span class="text-sm text-grey-900 p-1">{{$payment->card['network']}}</span>
                </div>
                <div class="flex justify-between mt-4">
                    <span class="text-sm text-grey-900 p-1">{{$payment->card['name']}}</span>
                    <span class="text-sm text-grey-900 p-1">{{'XXXXXX'.$payment->card['last4']}}</span>
                    <span class="text-sm text-grey-900 p-1">{{'Issued by' .$payment->card['issuer']}}</span>
                </div>

            </div>
            @endif
            <div class="flex pb-2 ">
                <p class="text-gray-900 font-semibold ml-4">Email Address :</p>
                <p class="text-gray-800 ml-4">{{ $payment->email}}</p>
            </div>
            <div class="flex pb-2 ">
                <p class="text-gray-900 font-semibold ml-4">Mobile :</p>
                <p class="text-gray-800 ml-4">{{ $payment->contact}}</p>
            </div>
            <div class="flex pb-2 ">
                <p class="text-gray-900 font-semibold ml-4">Shipping Address :</p>
                <p class="text-gray-800 ml-4">{{ $payment->shipping_address}}</p>
            </div>
            @if ($payment->status == "failed")
            <div class="flex pb-2 ">
                <p class="text-gray-900 font-semibold ml-4">Error :</p>
                <p class="text-red-800 ml-4">{{ $payment->error_description}}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection