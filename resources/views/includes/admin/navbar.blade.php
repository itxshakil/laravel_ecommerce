<nav class="bg-gray-800">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="relative flex items-center justify-between h-16">
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button @click="open = !open"
          class="inline-flex items-center justify-center p-2 rounded text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out"
          aria-label="Hamburger menu">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': !open }" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': !open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
        <div class="flex-shrink-0 mr-8 text-xl text-gray-100">
          <a href="/">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <div class="hidden sm:block sm:ml-6">
          <div class="flex">
            @auth('admin')
            <a href="{{ route('admin.orders.index') }}"
              class="ml-4 px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out  {{url()->current() == route('admin.orders.index') ? 'bg-gray-900' : '' }}">All
              Orders</a>
            <a href="{{ route('admin.products.index') }}"
              class="ml-4 px-3 py-2 rounded-md text-sm font-medium leading-5 text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out  {{url()->current() == route('admin.products.index') ? 'bg-gray-900' : '' }}">All
              Products</a>
            @endauth
          </div>
        </div>
      </div>
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
        @if(Auth::guard('admin')->check())
        <dropdown v-cloak>
          <p slot="toggler"
            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white transition duration-150 ease-in-out text-gray-100">
            {{ Auth::user('admin')->name }}</p>
          <span slot="items" class="flex flex-col py-1 rounded-md bg-white shadow-xs">
            <a href="{{url('/admin')}}"
              class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">Dashboard</a>
            <a href="{{ route('logout') }}"
              class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
              onclick="event.preventDefault();
                                                    document.getElementById('admin-logout-form').submit();">
              {{ __('Logout as Admin') }}
            </a>
          </span>
        </dropdown>
        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
        @endif
      </div>
    </div>
  </div>
  <!-- Mobile Links -->
  <div :class="{'block': open, 'hidden': !open}" class="sm:hidden">
    <div class="px-2 pt-2 pb-3">
      <a href="{{ url('/cart') }}"
        class="block px-3 py-2 rounded text-base font-medium text-white focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out  {{url()->current() == url('/cart') ? 'bg-gray-900' : '' }}"><i
          class="fa fas fa-shopping-cart"></i> Cart</a>
      <a href="{{ url('/shop') }}"
        class="mt-1 block px-3 py-2 rounded text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out {{url()->current() == url('/shop') ? 'bg-gray-900' : '' }}">Shop</a>
      @auth
      <a href="{{route('admin.orders.index')}}"
        class="mt-1 block px-3 py-2 rounded text-base font-medium text-gray-300 hover:text-white hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out {{url()->current() == route('admin.orders.index') ? 'bg-gray-900' : '' }}">My
        Orders</a>
      @endauth
    </div>
  </div>
</nav>