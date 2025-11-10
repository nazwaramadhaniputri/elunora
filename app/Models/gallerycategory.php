<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryCategory extends Model
{
    protected $fillable = ['name', 'status'];
    
    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get all galleries for this category.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Galeri::class, 'category_id');
    }
    
    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}