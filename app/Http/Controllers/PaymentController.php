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
            return view('payment.failed', compact('error'));
        }
        #TODO Notes should be used without so many toarray json encode
        $notes = $payment->notes->toArray();
        $order = Order::find($payment->order_id);
        $payment = $order->payments()->create([
            'id' => $payment->id,
            'entity' => $payment->entity,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'status' => $payment->status,
            'invoice_id' => $payment->invoice_id,
            'international' => $payment->international,
            'method' => $payment->method,
            'amount_refunded' => $payment->amount_refunded,
            'refund_status' => 'null',
            'captured' => $payment->captured,
            'description' => $payment->description,
            'card_id' => $payment->card_id,
            'bank' => $payment->bank,
            'wallet' => $payment->wallet,
            'vpa' => $payment->vpa,
            'email' => $payment->email,
            'contact' => $payment->contact,
            'fee' => $payment->fee,
            'tax' => $payment->tax,
            'error_code' => $payment->error_code,
            'error_description' => $payment->error_description,
            'notes' => json_encode($notes),
        ]);
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
        // Check if already exists
        if (!session()->has('cart.' . $payment->order->id)) {
            $payment->order->items->each(function ($item) use ($payment) {
                Cart::instance($payment->order->id)->add($item->model, $item->qty);
            });
        }

        return view('payments.success', compact('payment'));
    }
}
