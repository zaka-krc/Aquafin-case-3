<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'unit',
        'price',
        'supplier',
        'article_number',
        'minimum_stock',
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
        'minimum_stock' => 'integer'
    ];

    // Een materiaal behoort tot een categorie
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Een materiaal kan in veel order items zitten
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}