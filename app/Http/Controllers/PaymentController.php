<?php

namespace App\Http\Controllers;

use App\Billing\RazorpayApi;
use App\Order;
use App\Payment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function store(Request $request, RazorpayApi $razorpayApi)
    {
        if ($request->error) {
            #TODO Save to database with error code and error description
            return redirect()->route('order.checkout', ['order' => session('order')])
            ->with('error', $request->error['description']);
        }

        try {
            // Please note that the razorpay order ID must
            // come from a trusted source (fetched from API here, but
            // could be database or something else)
            $payment = $razorpayApi->fetchPayment($request->razorpay_payment_id);
            $attributes = [
                'razorpay_signature' => $request->razorpay_signature,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => session('order')
            ];
            $razorpayApi->verifyPaymentSignature($attributes);
        } catch (SignatureVerificationError $e) {
            // Check if payment really exists
            $error = $e->getMessage();
            return view('payments.failed', compact('error'));
        }
        $payment = Payment::create($payment->toArray());

        $payment->order->decreaseProductQuantity();
        
        Cart::instance('default')->destroy();

        Cart::instance('default')->store(auth()->id());

        return redirect()->route('payment.status', compact('payment'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $payment->order->fetchAllPayments();
        
        return view('payments.success', compact('payment'));
    }
}
