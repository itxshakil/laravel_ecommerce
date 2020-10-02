@extends('layouts.app')
@section('title','Admin Login')
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-100 p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 mb-2 text-2xl text-center">Welcome Back!</h3>
            <form class="px-8 pt-6 pb-2 mb-4 bg-white rounded" method="POST" action="{{ route('admin.login.submit') }}">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
                        Email Address
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('email') border-red-500 @enderror"
                        id="email" type="email" placeholder="email@example.com" name="email" value="{{ old('email') }}"
                        required autocomplete="email" autofocus />
                    @error('email')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                            Password
                        </label>
                        @if (Route::has('admin.password.request'))
                        <a class="inline-block text-xs text-blue-500 align-baseline hover:text-blue-800"
                            href="{{ route('admin.password.request') }}">
                            Forgot Password?
                        </a>
                    </div>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password') border-red-500 @enderror"
                        id="password" type="password" name="password" placeholder="******************" />
                    @error('password')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                    @endif
                </div>
                <div class="mb-4">
                    <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }} />
                    <label class="text-sm" for="remember">
                        Remember Me
                    </label>
                </div>
                <div class="mb-6 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Sign In
                    </button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
@endsection