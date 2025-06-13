<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
        'color',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Een categorie heeft veel materialen
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    // Alleen beschikbare materialen
    public function availableMaterials(): HasMany
    {
        return $this->hasMany(Material::class)->where('is_available', true);
    }
}