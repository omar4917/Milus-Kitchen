<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'photo_path',
        'is_available',
        'is_special',
        'discount_price',
        'sort_order',
        'stock_quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_available' => 'boolean',
        'is_special' => 'boolean',
        'stock_quantity' => 'integer',
    ];

    protected $appends = ['photo_url', 'discount_percentage'];

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

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->discount_price || $this->price <= 0) {
            return 0;
        }
        
        $savings = $this->price - $this->discount_price;
        return (int) round(($savings / $this->price) * 100);
    }
}
