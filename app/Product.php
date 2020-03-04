<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Gloudemans\Shoppingcart\Facades\Cart;

class Product extends Model implements Buyable
{
    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($product) {
            $product->update(['slug' => $product->name]);
        });
    }

    public function setSlugAttribute($value)
    {
        $slug = $this->createSlug($value);
        while (static::where('slug', $slug)->exists()) {
            $slug = "{$slug}-{$this->id}";
        }
        $this->attributes['slug'] = $slug;
    }

    protected function createSlug($value)
    {
        $count = static::where('slug', 'like', Str::slug($value) . '%')->count();
        $value = ($count > 0) ? ($value . '-' . $count) : $value;
        return Str::slug($value);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @return int|string
     */
    public function getBuyableIdentifier($options = null)
    {
        return $this->id;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @return string
     */
    public function getBuyableDescription($options = null)
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @return float
     */
    public function getBuyablePrice($options = null)
    {
        return $this->price;
    }

    public function getCartRowIdAttribute()
    {
        $cart = Cart::content();
        return $cart->firstWhere('id', $this->id)->rowId;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
