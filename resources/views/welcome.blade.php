@extends('layouts.app')
@section('title','Welcome to Acme Shop')
@section('content')
<section class="home relative bg-white overflow-hidden">
  <div class="max-w-screen-xl mx-auto">
    <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
      <div class="mt-10 mx-auto max-w-screen-xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
        <div class="sm:text-center lg:text-left">
          <h2 class="text-4xl tracking-tight leading-10 font-semibold text-gray-900 sm:text-5xl sm:leading-none md:text-6xl">
            Quality laptops in 
            <br class="xl:hidden" />
            <span class="text-indigo-600">reasonable price.</span>
          </h2>
          <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
            Anim aute id magna aliqua ad ad non deserunt sunt. Qui irure qui lorem cupidatat commodo. Elit sunt amet fugiat veniam occaecat fugiat aliqua.
          </p>
          <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
            <div class="rounded-lg shadow">
              <a href="#product-section" class="w-full flex items-center justify-center px-8 py-3 text-xs  border border-transparent text-base leading-6 font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:shadow-outline transition duration-150 ease-in-out md:py-4 md:px-10">
                Featured Products
              </a>
            </div>
            <div class="mt-3 sm:mt-0 sm:ml-3">
              <a href="#" class="w-full flex items-center justify-center px-8 py-3 text-xs  border border-transparent text-base leading-6 font-medium rounded-lg text-indigo-700 bg-indigo-100 hover:text-indigo-600 hover:bg-indigo-50 focus:outline-none focus:shadow-outline focus:border-indigo-300 transition duration-150 ease-in-out md:py-4 md:px-10">
                Shop by category
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
    <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://source.unsplash.com/Xn5FbEM9564/" alt="" />
  </div>
</section>

<section class="container mx-auto text-white" id="product-section">
    <div class="p-2 inline-block bg-indigo-500 rounded m-4">Featured Products</div>
    <div class="flex flex-wrap items-stretch">
        @forelse ($products as $product)
        <div class="card flex-product m-5 bg-gray-800 rounded overflow-hidden" title="View Details of {{ $product->name }}">
            <img class="object-cover w-full" src="{{$product->image}}" alt="View Details of {{ $product->name }}">
            <div class="text-center p-3">
                <div class="text-2xl">{{ $product->name }}</div>
                <div class="text-green-400">₹{{ $product->price }}</div>
                <a href="{{route('products.view',$product)}}"
                    class="p-2 inline-block bg-green-400 rounded text-white m-1">View Details</a>
            </div>
        </div>
        @empty

        <div class="card flex-product m-5 bg-gray-800 rounded" title="Nothing Here">
            <div class="text-center p-3">
                <div class="text-2xl">No Products Found</div>
            </div>
        </div>
        @endforelse
    </div>
</section>
@endsection