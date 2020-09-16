<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'rating' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rating) {
            $rating->user_id = auth()->id();
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
