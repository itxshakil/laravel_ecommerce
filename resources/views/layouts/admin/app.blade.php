<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Laravel Ecommerce is demo app where user can browse, add to cart and order products.This also includes site management system for admin. Razorpay is used as Payment Gateway.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title',config('app.name'))</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        window.auth_user = @json(auth()->user());
    </script>
    @stack('scripts')
</head>

<body>
    <div id="app">
        @include('includes.admin.navbar')

        <main>
            @yield('content')
            <flash message="{{session('flash')}}"></flash>
        </main>
    </div>
</body>

</html>