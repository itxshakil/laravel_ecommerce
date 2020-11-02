@extends('layouts.app')
@section('title','Checkout')
@section('content')

<div class="container mx-auto flex justify-center my-2 md:my-6 overflow-hidden">
    <div class="w-full bg-gray-100 p-3 mx-1 rounded-lg md:mr-2 shadow">
        <h3 class="text-2xl text-primary">Checkout with RazorPay</h3>
        <p class="text-dark">You are going to Pay <strong>₹ {{ $order['amount'] }}</strong> for
            <strong>#{{ $order->id }}</strong>
        </p>
        <details class="sm:hidden border rounded p-2">
            <summary class="text-lg font-semibold" title="Click to see order">See Order</summary>
            <div class="cart">
                @foreach (Cart::instance('default')->content() as $item)
                <div class="flex justify-between border-b-2 p-2">
                    <img src="{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100"
                        height="100">
                    <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>
                    <p class="mx-3 font-semibold items-baseline" title="Quantity">{{ $item->qty  }}</p>
                    <p class="font-semibold" title="Item Price">₹{{ $item->model->price  }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between px-2">
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
        </details>
        @include('includes.message')
        <form method="POST" action="https://api.razorpay.com/v1/checkout/embedded">
            <input type="hidden" name="key_id" value="{{config('services.razorpay.key')}}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="name" value="Acme Corp">
            <input type="hidden" name="description" value="Payment for Order #{{ $order->id }}">
            <fieldset class="border-gray-400 rounded p-1 border-2">
                <legend class="font-semibold mt-4 ml-4 px-1">Personal Details</legend>
                <div class="flex flex-wrap -mx-3 mb-3">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="prefill[name]">
                            Full Name
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="prefill[name]" name="prefill[name]" type="text" placeholder="John Doe"
                            value="{{auth()->user()->name}}" autofocus>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-3">
                    <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="prefill[email]">Email
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="prefill[email]" name="prefill[email]" type="email" placeholder="example@company.com"
                            value="{{auth()->user()->email}}" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-3 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="prefill[contact]">
                            Mobile Number
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="prefill[contact]" name="prefill[contact]" type="tel" placeholder="9123456780"
                            title="Please Enter Valid Contact Number" pattern="[789][0-9]{9}" required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="border-gray-400 rounded p-1 border-2">
                <legend class="font-semibold mt-4 ml-4 px-1">Shipping Address</legend>
                <div class="flex flex-wrap -mx-3 mb-3">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="notes[shipping_address_local]">
                            Street Address
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="notes[shipping_address_local]" name="notes[shipping_address_local]" type="text"
                            placeholder="Flat/House No./Colony/Street/Locality" required>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-3 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="notes[shipping_address_state]">
                            State
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="notes[shipping_address_state]" name="notes[shipping_address_state]" type="text"
                            placeholder="Faridabad" required>
                    </div>
                    {{-- <div class="w-full md:w-1/3 px-3 mb-3 md:mb-0">
                            <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2" for="grid-state">
                            State
                            </label>
                            <div class="relative">
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"   id="grid-state">
                                    <option>Faridabad</option>
                                    <option>Delhi</option>
                                    <option>Noida</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                </div>
                            </div>
                        </div> --}}
                    <div class="w-full md:w-1/3 px-3 mb-3 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-800 text-xs font-bold mb-2"
                            for="notes[shipping_address_pincode]">
                            Zip
                        </label>
                        <input
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="notes[shipping_address_pincode]" name="notes[shipping_address_pincode]" type="text"
                            placeholder="6 digits [0-9] pincode" pattern="[0-9]{6}" required>
                    </div>
                </div>
            </fieldset>
                <input type="hidden" name="callback_url" value="{{ url("payment") }}">
                <small>You will be redirect to payment page.</small>
                <div class="form-group">
                <button
                    class="bg-green-100 active:bg-green-300 text-green-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs">Go
                    to Payment Page</button>
            </div>
            <div class="bg-blue-100 border border-blue-300 text-blue-800 px-4 py-3 my-2  rounded relative" role="alert">
                <strong class="font-bold">Demo!</strong>
                <span class="block sm:inline">Use Demo Debit Card number 4111 1111 1111 1111 for checkout.</span>
            </div>
        </form>
    </div>
    <div class="w-full ml-2 text-sm sm:text-base hidden sm:inline-block">
        <p class="text-lg font-semibold">Your Order</p>
        <div class="cart">
            @foreach (Cart::instance('default')->content() as $item)
            <div class="flex justify-between border-b-2 p-2">
                <img src="{{ $item->model->image }}" alt="Details of {{ $item->model->name }}" width="100" height="100">
                <a href="{{ route('products.view',$item->model->slug) }}" class="mx-2">{{ $item->name }}</a>
                <p class="mx-3 font-semibold items-baseline" title="Quantity">{{ $item->qty  }}</p>
                <p class="font-semibold" title="Item Price">₹{{ $item->model->price  }}</p>
            </div>
            @endforeach
        </div>

        <div class="flex justify-between px-2">
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
@endsection