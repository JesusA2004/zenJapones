<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model {

    protected $fillable = [
        'menu_category_id',
        'name',
        'slug',
        'short_description',
        'description',
        'price',
        'promo_price',
        'sku',
        'image_path',
        'is_featured',
        'is_available',
        'is_spicy',
        'is_vegetarian',
        'is_vegan',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'promo_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_available' => 'boolean',
        'is_spicy' => 'boolean',
        'is_vegetarian' => 'boolean',
        'is_vegan' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    public function images(): HasMany {
        return $this->hasMany(MenuItemImage::class);
    }

}
