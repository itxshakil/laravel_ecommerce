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

    public function setNotesAttribute($value)
    {
        $this->attributes['notes'] = json_encode($value);
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
        return "{$this->notes['shipping_address_local']}, {$this->notes['shipping_address_state']}, {$this->notes['shipping_address_pincode']}";
    }

    public function getCardDetails()
    {
        $razorpayApi = resolve('App\Billing\RazorpayApi');
        return $razorpayApi->fetchCard($this->card_id);
    }
}
