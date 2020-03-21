@extends('layouts.app')
@section('title','My Shopping Cart')
@section('content')
<div class="container md:mx-auto  max-w-lg p-2 sm:p-8 pb-2 sm:m-3 overflow-hidden">
    @include('includes.message')
    <cart :data="{{json_encode($cartItems)}}" :savedforlater="{{json_encode($savedForLaterItems)}}">
    </cart>
</div>
@endsection