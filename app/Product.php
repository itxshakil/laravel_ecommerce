<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;
use Gloudemans\Shoppingcart\Contracts\Buyable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * @method static where(string $string, bool $true)
 */
class Product extends Model implements Buyable
{
    use HasFactory, SearchableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
        * Columns and their priority in search results.
        * Columns with higher values are more important.
        * Columns with equal values have equal importance.
        *
        * @var array
        */
        'columns' => [
            'products.name' => 12,
            'products.details' => 10
        ],
    ];

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

    public function getImageAttribute($value)
    {
        if ($value == "https://source.unsplash.com/collection/307591/400x300") {
            return "https://source.unsplash.com/collection/307591/400x300";
        }
        return '/storage/' . $value;
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

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }

    /**
     * Check if Product is not available
     *
     * @return bool
     */
    public function isNotAvailable()
    {
        return $this->quantity < 1;
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity')->withTimestamps();
    }
}
