<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'material_id',
        'quantity',
        'unit',
        'unit_price',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2'
    ];

    // Een order item behoort tot een bestelling
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Een order item behoort tot een materiaal
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }
}