@extends('layouts.app')
@section('title','Reset Admin Password')
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-white p-5 rounded-lg lg:rounded-l-none">
            <h3 class="py-4 text-2xl text-center">{{ __('Reset Admin Password') }}</h3>
            <form class="px-8 py-6 mb-4 bg-gray-100 rounded" method="POST" action="{{ route('admin.password.email') }}">
                @if (session('status'))
                <div class="text-xs italic text-green-500" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-semibold text-gray-700" for="email">
                        Email Address
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
                        id="email" type="email" placeholder="email@example.com" name="email" value="{{ old('email') }}"
                        required autocomplete="email" />
                    @error('email')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
                @csrf
                <div class="text-center">
                    <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                        href="{{ route('admin.login') }}">
                        Already have Account? Login!
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection