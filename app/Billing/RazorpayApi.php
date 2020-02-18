<?php

namespace App\Billing;

use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Razorpay\Api\Api;

class RazorpayApi
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(config('app.razorpay_key'), config('app.razorpay_private'));
    }

    public function createOrder()
    {
        $orderData = [
            'amount' => str_replace(',', '', Cart::total()) * 100, // 2000 rupees in paise
            'currency' => 'INR',
            'receipt' => 'Receipt #20',
            'payment_capture' => 1 // auto capture
        ];

        return $this->api->order->create($orderData);
    }

}
