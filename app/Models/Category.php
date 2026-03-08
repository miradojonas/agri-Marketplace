<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    protected $fillable = [
        'name', 'name_mg', 'slug', 'description', 'icon', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function marketPrices()
    {
        return $this->hasMany(MarketPrice::class);
    }
}