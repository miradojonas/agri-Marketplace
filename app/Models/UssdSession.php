<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id', 'phone', 'farmer_id',
        'current_menu', 'session_data', 'is_active',
        'last_interaction_at',
    ];

    protected function casts(): array
    {
        return [
            'session_data'        => 'array',
            'is_active'           => 'boolean',
            'last_interaction_at' => 'datetime',
        ];
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}