<?php

namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'notes' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($order) {
            if (!session()->has('cart.' . $order->id)) {
                $order->items->each(function ($item) use ($order) {
                    Cart::instance($order->id)->add($item->model, $item->qty);
                });
            }
        });
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function getItemsAttribute($value)
    {
        return unserialize($value);
    }

    public function getStatusAttribute($value)
    {
        //TODO: Check for refund
        if ($value != 'paid') {
            $value = $this->fetchRecentInfo()->status;
        }
        return $value;
    }

    public function fetchRecentInfo()
    {
        $razorpayApi = resolve('App\Billing\RazorpayApi');

        $orderData = $razorpayApi->fetchOrder($this->id);

        $this->update([
            'amount_paid' => $orderData->amount_paid,
            'amount_due' => $orderData->amount_due,
            'offer_id' => $orderData->offer_id,
            'attempts' => $orderData->attempts,
            'status' => $orderData->status, ]);
        return $orderData;
    }

    public function fetchAllPayments()
    {
        $razorpayApi = resolve('App\Billing\RazorpayApi');

        $payments = $razorpayApi->fetchOrder($this->id)->payments();
        if ($payments->count > $this->payments->count()) {
            for ($i = 0; $i < $payments->count; $i++) {
                if (!Payment::find($payments->items[$i]->id)) {
                    Payment::create($payments->items[$i]->toArray());
                }
            }
        }
    }

    public function decreaseProductQuantity()
    {
        $this->items->map(function ($item) {
            $item->model->decrement('quantity', $item->qty);
        });
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
