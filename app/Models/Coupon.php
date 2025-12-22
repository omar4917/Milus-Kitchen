<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isValid($orderTotal = 0): bool
    {
        if (!$this->is_active) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->max_uses && $this->used_count >= $this->max_uses) return false;
        if ($orderTotal < $this->min_order) return false;
        return true;
    }

    public function calculateDiscount($orderTotal): float
    {
        if (!$this->isValid($orderTotal)) return 0;

        if ($this->type === 'percentage') {
            return round($orderTotal * ($this->value / 100), 2);
        }
        
        return min($this->value, $orderTotal);
    }

    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }
}
