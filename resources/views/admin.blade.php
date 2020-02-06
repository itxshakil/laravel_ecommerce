@extends('layouts.app')

@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full lg:w-1/2 bg-gray-100 p-5 rounded-lg lg:rounded-l-none">
        <h3 class="pt-4 text-2xl text-center">Dashboard!</h3>
        <a class="text-blue-500 mr-2" href="{{ route('products.index') }}">{{ __('All Product') }}</a>
        <div class="card-body">
            @if (session('status'))
            <div class="bg-yellow-100 text-yellow-700 border-yellow-400 border px-4 py-3 my-2 rounded" role="alert">
                {{ session('status') }}
            </div>
            @endif
            @component('components.who')
            @endcomponent
        </div>
    </div>
</div>
@endsection