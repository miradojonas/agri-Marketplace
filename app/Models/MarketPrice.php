<?php

namespace App\Models;

use Database\Factories\MarketPriceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    use HasFactory;

    protected static function newFactory(): MarketPriceFactory
    {
        return MarketPriceFactory::new();
    }

    protected $fillable = [
        'category_id', 'product_name', 'region',
        'min_price', 'max_price', 'avg_price',
        'unit', 'price_date', 'source',
    ];

    protected function casts(): array
    {
        return [
            'min_price'  => 'decimal:2',
            'max_price'  => 'decimal:2',
            'avg_price'  => 'decimal:2',
            'price_date' => 'date',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}