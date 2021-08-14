<?php

namespace App\Http\Controllers;

use App\Billing\RazorpayApi;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class OrderController extends Controller
{
    public function index(): Factory|View|Application
    {
        $orders = auth()->user()->orders;

        return view('orders.index', compact('orders'));
    }

    public function store(RazorpayApi $razorpayApi): Redirector|Application|RedirectResponse
    {
        $order = $razorpayApi->createOrder(Cart::total());

        $order = $this->createOrder($order);
        $products = [];
        Cart::content()->each(function ($item) use (&$products) {
            $products[$item->model->id] = ['quantity' => $item->qty];
        });

        $order->products()->sync($products);

        session(['order' => $order->id]);

        return redirect(route('order.checkout', ['order' => $order]));
    }

    public function show(Order $order): Factory|View|Application
    {
        return view('orders.show', compact('order'));
    }

    public function checkout(Order $order): Factory|View|Application
    {
        // dd($order);
        return view('checkout', compact('order'));
    }

    /**
     * @param $order
     * @return Order
     */
    protected function createOrder($order):Order
    {
        return auth()->user()->orders()->create([
            'id' => $order->id,
            'entity' => $order->entity,
            'amount' => $order->amount,
            'currency' => $order->currency,
            'receipt' => $order->receipt,
            'status' => $order->status,
            'attempts' => $order->attempts,
            'notes' => $order->notes,
        ]);
    }
}
