@extends('layouts.app')
@section('title','Register new Account')
@section('content')
<div class="container mx-auto flex justify-center px-3 md:px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 flex">
        <div class="w-full h-auto bg-gray-400 hidden lg:block lg:w-1/2 bg-cover rounded-l-lg"
            style="background-image: url('https://source.unsplash.com/K4mSJ7kc0As/600x800')">
        </div>
        <div class="w-full lg:w-1/2 bg-gray-100 p-2 md:p-5 rounded-lg lg:rounded-l-none">
            <h3 class="pt-4 text-2xl text-center">Create New account</h3>
            <form class="px-8 pt-6  pb-2 mb-4 bg-white rounded" method="POST" action="{{ route('register') }}">
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="name">
                        Name
                    </label>
                    <input
                        class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none @error('name') border-red-500 @enderror"
                        id="name" type="text" placeholder="John Doe" name="name" value="{{ old('name') }}" required
                        autocomplete="name" autofocus />
                    @error('name')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="email">
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
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="password">
                        Password
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none @error('password') border-red-500 @enderror"
                        id="password" type="password" name="password" placeholder="******************" />
                    @error('password')
                    <p class="text-xs italic text-red-500" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-bold text-gray-700" for="password-confirm">
                        Confirm Password
                    </label>
                    <input
                        class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border  rounded shadow appearance-none focus:outline-none"
                        id="password-confirm" type="password" name="password_confirmation"
                        placeholder="******************" required autocomplete="new-password" />
                </div>
                <div class="mb-6 text-center">
                    <button
                        class="w-full px-4 py-2 font-bold text-white bg-blue-500 rounded-full hover:bg-blue-700 focus:outline-none"
                        type="submit">
                        Register
                    </button>
                </div>
                @csrf
            </form>
            <hr class="mb-6 mx-8 border-t" />
            <div class="text-center">
                <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                    href="{{ route('login') }}">
                    Already have Account? Login!
                </a>
            </div>
            @if (Route::has('password.request'))
            <div class="text-center">
                <a class="inline-block text-sm text-blue-500 align-baseline hover:text-blue-800"
                    href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection