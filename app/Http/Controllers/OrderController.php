<?php

namespace App\Http\Controllers;

use App\Billing\RazorpayApi;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{
    public function store(RazorpayApi $razorpayApi)
    {
        $order = $razorpayApi->createOrder();

        $order = auth()->user()->orders()->create([
            'id' => $order->id,
            'entity' => $order->entity,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'receipt' => $order->receipt,
            'status' => $order->status,
            'attempts' => $order->attempts,
            'items' => serialize(Cart::content()),
            'notes' => serialize($order->notes),
        ]);

        session(['order' => $order->id]);

        return redirect(route('order.checkout', ['order' => $order]));
    }

    public function checkout(Order $order)
    {
        return view('checkout', compact('order'));
    }
}
