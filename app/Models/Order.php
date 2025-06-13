<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'requested_delivery_date',
        'status',
        'notes',
        'delivery_location'
    ];

    protected $casts = [
        'requested_delivery_date' => 'date'
    ];

    // Een bestelling behoort tot een gebruiker
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Een bestelling heeft veel order items
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // Generate unique order number
    public static function generateOrderNumber(): string
    {
        $year = now()->year;
        $lastOrder = self::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $number = $lastOrder ? intval(substr($lastOrder->order_number, -3)) + 1 : 1;
        return 'AQ-' . $year . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }
}