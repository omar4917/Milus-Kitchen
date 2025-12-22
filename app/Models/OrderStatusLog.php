<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusLog extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'old_status',
        'new_status',
        'notes',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getOldStatusLabelAttribute(): ?string
    {
        return $this->old_status ? (Order::STATUSES[$this->old_status] ?? $this->old_status) : null;
    }

    public function getNewStatusLabelAttribute(): string
    {
        return Order::STATUSES[$this->new_status] ?? $this->new_status;
    }
}
