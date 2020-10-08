<?php

namespace App;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
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
                $order->products->each(function ($item) use ($order) {
                    Cart::instance($order->id)->add($item, $item->pivot->quantity);
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

    public function setItemsAttribute($value)
    {
        $this->attributes['items'] = serialize($value);
    }

    public function setNotesAttribute($value)
    {
        $this->attributes['notes'] = serialize($value);
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
            'status' => $orderData->status,
        ]);
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
        $this->products->map(function ($product) {
            $product->decrement('quantity', $product->pivot->quantity);
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

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity')->withTimestamps();
    }
}
