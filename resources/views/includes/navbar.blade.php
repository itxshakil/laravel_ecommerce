<nav class="bg-gray-900 text-gray-100">
    <div class="p-4 flex justify-between">
        <!-- Left Side of Navbar-->
        <div class="flex">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
        </div>
        <!-- Right Side of Navbar-->
        <div class="flex">
            <!-- Authentication Links -->
            @guest
            @if (Route::has('register'))
            <a class="text-blue-500 mr-2 px-2 pb-1 border rounded border-blue-500"
                href="{{ route('register') }}">{{ __('Register') }}</a>
            @endif
            <a class="text-blue-500 mr-2" href="{{ route('login') }}">{{ __('Login') }}</a>
            @else
            <dropdown v-cloak>
                <p slot="toggler" class="mr-12">{{ Auth::user()->name }}</p>
                <span slot="items" class="flex flex-col text-blue-400 bg-gray-900 text-gray-100 p-4 rounded">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </span>
            </dropdown>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </div>
    </div>
</nav>