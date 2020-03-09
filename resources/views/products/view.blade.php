@extends('layouts.app')
@section('title')
{{ $product->name }}
@endsection
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
<product-view :data="{{json_encode($product)}}"></product-view>
</div>
@endsection