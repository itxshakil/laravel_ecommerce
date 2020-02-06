<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use illuminate\Support\Str;

class Product extends Model
{
    /**
      * The attributes that are mass assignable.
      *
      * @var array
      */
    protected $fillable = ['slug'];

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
}
