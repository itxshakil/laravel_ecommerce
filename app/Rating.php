<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $guarded = [];

    protected $casts =[
        'rating' => 'integer'
    ];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->user_id = auth()->id();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
