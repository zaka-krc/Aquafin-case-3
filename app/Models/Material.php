<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'unit',
        'price',
        'supplier',
        'article_number',
        'minimum_stock',
        'current_stock', 
        'is_available'
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'price' => 'decimal:2',
        'minimum_stock' => 'integer',
        'current_stock' => 'integer'  
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('article_number', 'like', "%{$search}%");
        });
    }

    public function getFullNameAttribute(): string
    {
        return $this->name . ($this->description ? " - {$this->description}" : '');
    }
    
    // NIEUWE METHODS VOOR VOORRAAD BEHEER
    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->minimum_stock;
    }
    
    public function isOutOfStock(): bool
    {
        return $this->current_stock <= 0;
    }
    
    public function decreaseStock(int $amount): void
    {
        $this->current_stock = max(0, $this->current_stock - $amount);
        $this->save();
    }
    
    public function increaseStock(int $amount): void
    {
        $this->current_stock += $amount;
        $this->save();
    }
}