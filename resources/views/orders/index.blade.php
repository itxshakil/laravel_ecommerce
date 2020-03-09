@extends('layouts.app')
@section('title','My Orders')
@section('content')
<div class="container mx-auto flex justify-center px-6 my-12">
    <div class="w-full xl:w-3/4 lg:w-11/12 bg-gray-100 p-5 rounded-lg">
        <h3 class="pt-4 text-2xl text-center">My Orders!</h3>
        <table class="overflow-y-auto w-full text-center border-collapse">
            <tr class="bg-gray-300">
                <th class="p-3">OrderId </th>
                <th class="p-3">Amount</th>
                <th class="p-3">Status</th>
                <th class="p-3">Date</th>
                <th class="p-3">View Details</th>
            </tr>
            @foreach ($orders as $order)
            <tr class="border-gray-300 border-b">
                <td class="p-3">{{ $order->id }}</td>
                <td class="p-3">{{ $order->amount }}</td>
                <td class="p-3">{{ $order->status }}</td>
                <td class="p-3">{{ $order->updated_at->diffForHumans() }}</td>
                <td class="p-3"><a href="{{ route('orders.view',$order) }}">View</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection