<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    protected $fillable = [
        'farmer_id', 'category_id', 'name', 'name_mg',
        'description', 'price', 'unit', 'quantity_available',
        'image', 'status', 'harvest_date',
    ];

    protected function casts(): array
    {
        return [
            'price'              => 'decimal:2',
            'quantity_available' => 'decimal:2',
            'harvest_date'       => 'date',
        ];
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->quantity_available > 0;
    }
}