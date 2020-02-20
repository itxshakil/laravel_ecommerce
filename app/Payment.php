<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'notes' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function getShippingAddressAttribute()
    {
        $address = json_decode($this->notes);
        return "{$address->shipping_address_local}, {$address->shipping_address_state}, {$address->shipping_address_pincode}";
    }

    public function getCardDetails()
    {
        $razorpayApi = resolve('App\Billing\RazorpayApi');
        return $razorpayApi->fetchCard($this->card_id);
    }
}
