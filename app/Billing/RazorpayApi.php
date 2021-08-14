<?php

namespace App\Billing;

use Razorpay\Api\Api;

class RazorpayApi
{
    protected Api $api;

    public function __construct()
    {
        $this->api = new Api(config('services.razorpay.key'), config('services.razorpay.private'));
    }

    public function createOrder($amount)
    {
        $orderData = [
            'amount' => str_replace(',', '', $amount) * 100, // 2000 rupees in paise
            'currency' => 'INR',
            'receipt' => 'Receipt #20',
            'payment_capture' => 1 // auto capture
        ];

        return $this->api->order->create($orderData);
    }

    public function fetchOrder($razorpay_order_id)
    {
        return $this->api->order->fetch($razorpay_order_id);
    }

    public function fetchCard($card_id)
    {
        return $this->api->card->fetch($card_id);
    }

    public function verifyPaymentSignature($attributes)
    {
        return $this->api->utility->verifyPaymentSignature($attributes);
    }

    public function fetchPayment($razorpay_payment_id)
    {
        return $this->api->payment->fetch($razorpay_payment_id);
    }
}
