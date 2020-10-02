@guest
@if (Route::has('register'))
<a class="hidden sm:block bg-blue-100 active:bg-blue-200 text-blue-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
    href="{{ route('register') }}">{{ __('Register') }}</a>
@endif
<a class="bg-gray-700 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
    href="{{ route('login') }}">{{ __('Login') }}</a>
@else
<dropdown v-cloak>
    <p slot="toggler"
        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-white transition duration-150 ease-in-out text-gray-100">
        {{-- <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" /> --}}
        {{ Auth::guard('web')->user()->name }}
    </p>
    <span slot="items" class="flex flex-col py-1 rounded-md bg-white shadow-xs">
        <a href="{{url('/orders')}}"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">My
            Orders</a>
        <a href="{{ route('logout') }}"
            class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Sign out</a>
    </span>
</dropdown>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endguest