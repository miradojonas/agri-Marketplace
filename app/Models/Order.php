<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'buyer_id', 'status', 'total_amount',
        'payment_method', 'payment_status', 'delivery_address',
        'delivery_region', 'notes',
    ];

    protected function casts(): array
    {
        return ['total_amount' => 'decimal:2'];
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $order->order_number = 'ORD-' . strtoupper(Str::random(8));
        });
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }
}