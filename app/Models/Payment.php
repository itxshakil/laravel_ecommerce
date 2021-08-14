<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property mixed order
 * @property string|null card_id
 * @property mixed notes
 * @method static create(array $array)
 * @method static find($id)
 */
class Payment extends Model
{
    public $incrementing = false;
    protected $guarded = [];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getAmountAttribute($value): float|int
    {
        return $value / 100;
    }

    public function getCardAttribute($value)
    {
        return resolve('App\Billing\RazorpayApi')
            ->fetchCard($this->card_id)
            ->toArray();
    }

    public function getShippingAddressAttribute()
    {
        return $this->notes;
    }

    public function getCardDetails()
    {
        return resolve('App\Billing\RazorpayApi')->fetchCard($this->card_id);
    }
}
