@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')<div class="container md:mx-auto  max-w-lg p-8 pb-2 m-3">
    @include('includes.message')
    <cart :data="{{json_encode($cartItems)}}" :savedforlater="{{json_encode($savedForLaterItems)}}">
    </cart>
    @endsection