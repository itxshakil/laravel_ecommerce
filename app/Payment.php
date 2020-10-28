<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function getCardAttribute($value)
    {
        return resolve('App\Billing\RazorpayApi')->fetchCard($this->card_id)->toArray();
    }

    public function getShippingAddressAttribute()
    {
        return $this->notes;
    }

    public function getCardDetails()
    {
        $razorpayApi = resolve('App\Billing\RazorpayApi');
        return $razorpayApi->fetchCard($this->card_id);
    }
}
