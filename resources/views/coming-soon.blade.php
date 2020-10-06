@extends('layouts.app')

@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full lg:w-1/2 bg-gray-100 p-5 rounded-lg lg:rounded-l-none">
        <h3 class="pt-4 text-2xl text-center">Coming Soon!</h3>
        <div class="card-body flex flex-col justify-center items-center">
            @if (session('status'))
            <div class="bg-yellow-100 text-yellow-700 border-yellow-400 border px-4 py-3 my-2 rounded" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <h4 class="text-lg text-center text-gray-800 mt-6">This page is locked to stop spamming!</h4>
            <a
          href="/"
          class="bg-green-700 text-green-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs text-center inline-block mt-4"
          >Go Home</a
        >
        </div>
    </div>
</div>
@endsection