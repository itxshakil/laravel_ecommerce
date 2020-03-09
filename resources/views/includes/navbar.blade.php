<nav class="bg-gray-900 text-gray-100">
    <div class="p-4 flex justify-between">
        <!-- Left Side of Navbar-->
        <div class="flex items-end">
            <a class="mr-8 text-xl" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <a class="mx-2" href="{{ url('/cart') }}"><i class="fa fas fa-shopping-cart"></i> Cart</a>
            <a class="mx-2" href="{{ url('/shop') }}"> Shop</a>
            @auth
            <a class="mx-2" href="{{ url('/orders') }}">My Order</a>
            @endauth
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
            @if(Auth::guard('admin')->check() && Auth::guard('web')->check())
            <dropdown v-cloak>
                <p slot="toggler" class="mr-12">{{ Auth::guard('admin')->user()->name }}</p>
                <span slot="items" class="flex flex-col text-blue-400 bg-gray-900 text-gray-100 p-4 rounded">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </span>
            </dropdown>
            <dropdown v-cloak>
                <p slot="toggler" class="mr-12">{{ Auth::user()->name }}</p>
                <span slot="items" class="flex flex-col text-blue-400 bg-gray-900 text-gray-100 p-4 rounded">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('admin-logout-form').submit();">
                        {{ __('Logout as Admin') }}
                    </a>
                </span>
            </dropdown>
            @elseif(Auth::guard('admin')->check())
            <dropdown v-cloak>
                <p slot="toggler" class="mr-12">{{ Auth::guard('admin')->user()->name }}</p>
                <span slot="items" class="flex flex-col text-blue-400 bg-gray-900 text-gray-100 p-4 rounded">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('admin-logout-form').submit();">
                        {{ __('Logout as Admin') }}
                    </a>
                </span>
            </dropdown>
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
            @endif
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            </dropdown>
            <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </div>
    </div>
</nav>