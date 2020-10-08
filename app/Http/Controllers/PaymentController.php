<?php

namespace App\Http\Controllers;

use App\Billing\RazorpayApi;
use App\Payment;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function store(Request $request, RazorpayApi $razorpayApi)
    {
        if ($request->error) {
            return $this->handleErrorPayment($request);
        }

        try {
            // Please note that the razorpay order ID must
            // come from a trusted source (fetched from API here, but
            // could be database or something else)

            $razorpayApi->verifyPaymentSignature([
                'razorpay_signature' => $request->razorpay_signature,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => session('order')
            ]);
        } catch (SignatureVerificationError $e) {
            return $this->handleSignatureVerificationError($e);
        }

        $payment = $razorpayApi->fetchPayment($request->razorpay_payment_id);

        return $this->handleSuccesPayment($payment);
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

    protected function handleSuccesPayment($payment)
    {
        $payment = Payment::create([
            "id" => $payment->id,
            "entity" => $payment->entity,
            "amount" => $payment->amount,
            "currency" => $payment->currency,
            "status" => $payment->status,
            "order_id" => $payment->order_id,
            "invoice_id" => $payment->invoice_id,
            "international" => $payment->international,
            "method" => $payment->method,
            "amount_refunded" => $payment->amount_refunded,
            "refund_status" => $payment->refund_status,
            "captured" => $payment->captured,
            "description" => $payment->description,
            "card_id" => $payment->card_id,
            "bank" => $payment->bank,
            "wallet" => $payment->wallet,
            "vpa" => $payment->vpa,
            "email" => $payment->email,
            "contact" => $payment->contact,
            "notes" => $this->notesToShippingAddress($payment->notes),
            "fee" => $payment->fee,
            "tax" => $payment->tax,
            "error_code" => $payment->error_code,
            "error_description" => $payment->error_description,
            // "error_source" => $payment->error_source,
            // "error_step" => $payment->error_step,
            // "error_reason" => $payment->error_reason,
            // "acquirer_data" => $payment->acquirer_data,
            // "created_at" => $payment->created_at,
        ]);

        $payment->order->decreaseProductQuantity();

        Cart::instance('default')->destroy();

        Cart::instance('default')->store(auth()->id());

        return redirect()->route('payment.status', compact('payment'));
    }

    protected function handleErrorPayment(Request $request)
    {
        //TODO Save to database with error code and error description
        return redirect()->route('order.checkout', ['order' => session('order')])
            ->with('error', $request->error['description']);
    }

    protected function handleSignatureVerificationError(SignatureVerificationError $e)
    {
        // Check if payment really exists
        $error = $e->getMessage();
        return view('payments.failed', compact('error'));
    }

    protected function notesToShippingAddress($notes)
    {
        return "{$notes['shipping_address_local']}, {$notes['shipping_address_state']}, {$notes['shipping_address_pincode']}";
    }
}
