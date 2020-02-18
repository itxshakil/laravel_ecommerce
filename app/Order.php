<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'notes' => 'array',
    ];
}
