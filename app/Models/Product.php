<?php

namespace App\Models;

use Gloudemans\Shoppingcart\Contracts\Buyable;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use illuminate\Support\Str;
use Nicolaslopezj\Searchable\SearchableTrait;

/**
 * @method static where(string $string, bool $true)
 * @method static search(mixed $query)
 * @method static create(array $data)
 * @property integer quantity
 * @property mixed price
 * @property mixed id
 * @property mixed name
 * @property mixed cartRowId
 */
class Product extends Model implements Buyable
{
    use HasFactory;
    use SearchableTrait;

    protected $guarded = [];

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

    protected function createSlug($value): string
    {
        $count = static::where('slug', 'like', Str::slug($value) . '%')->count();
        $value = ($count > 0) ? ($value . '-' . $count) : $value;
        return Str::slug($value);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageAttribute($value): string
    {
        if ($value == "https://source.unsplash.com/collection/307591/400x300") {
            return $value;
        }
        return '/storage/' . $value;
    }

    /**
     * Get the identifier of the Buyable item.
     *
     * @param null $options
     * @return int|string
     */
    public function getBuyableIdentifier($options = null): int|string
    {
        return $this->id;
    }

    /**
     * Get the description or title of the Buyable item.
     *
     * @param null $options
     * @return string
     */
    public function getBuyableDescription($options = null): string
    {
        return $this->name;
    }

    /**
     * Get the price of the Buyable item.
     *
     * @param null $options
     * @return float
     */
    public function getBuyablePrice($options = null): float
    {
        return $this->price;
    }

    public function getCartRowIdAttribute()
    {
        $cart = Cart::content();
        return $cart->firstWhere('id', $this->id)->rowId;
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class)
            ->withTimestamps();
    }

    /**
     * Check if Product is not available
     *
     * @return bool
     */
    public function isNotAvailable(): bool
    {
        return $this->quantity < 1;
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function scopeCategories($query, string $slug){
        return $query->whereHas('categories', function ($query) use ($slug) {
            $query->where('slug',$slug);
        });
    }

    public function scopeFeatured($query){
        return $query->where('featured', true);
    }
}
