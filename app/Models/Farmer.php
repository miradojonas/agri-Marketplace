<?php

namespace App\Models;

use Database\Factories\FarmerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected static function newFactory(): FarmerFactory
    {
        return FarmerFactory::new();
    }

    protected $fillable = [
        'user_id', 'farm_name', 'phone', 'region',
        'district', 'description', 'latitude', 'longitude',
        'ussd_enabled', 'ussd_pin',
    ];

    protected function casts(): array
    {
        return [
            'ussd_enabled' => 'boolean',
            'latitude'     => 'decimal:8',
            'longitude'    => 'decimal:8',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function ussdSessions()
    {
        return $this->hasMany(UssdSession::class);
    }
}