<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_type',
        'delivery_address',
        'preferred_date',
        'time_slot',
        'notes',
        'payment_method',
        'transaction_id',
        'status',
        'subtotal',
        'delivery_fee',
        'discount_amount',
        'coupon_code',
        'total',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    const STATUS_NEW = 'new';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COOKING = 'cooking';
    const STATUS_READY = 'ready';
    const STATUS_OUT_FOR_DELIVERY = 'out_for_delivery';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const STATUSES = [
        self::STATUS_NEW => 'New',
        self::STATUS_CONFIRMED => 'Confirmed',
        self::STATUS_COOKING => 'Cooking',
        self::STATUS_READY => 'Ready',
        self::STATUS_OUT_FOR_DELIVERY => 'Out for Delivery',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    const PAYMENT_METHODS = [
        'cod' => 'Cash on Delivery',
        'bkash' => 'bKash',
        'nagad' => 'Nagad',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber(): string
    {
        $prefix = 'AK';
        $date = now()->format('ymd');
        $random = strtoupper(Str::random(4));
        return "{$prefix}{$date}{$random}";
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('created_at', 'desc');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHODS[$this->payment_method] ?? $this->payment_method;
    }

    public function isDelivery(): bool
    {
        return $this->delivery_type === 'delivery';
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowedTransitions = [
            self::STATUS_NEW => [self::STATUS_CONFIRMED, self::STATUS_CANCELLED],
            self::STATUS_CONFIRMED => [self::STATUS_COOKING, self::STATUS_CANCELLED],
            self::STATUS_COOKING => [self::STATUS_READY, self::STATUS_CANCELLED],
            self::STATUS_READY => [self::STATUS_OUT_FOR_DELIVERY, self::STATUS_COMPLETED, self::STATUS_CANCELLED],
            self::STATUS_OUT_FOR_DELIVERY => [self::STATUS_COMPLETED, self::STATUS_CANCELLED],
            self::STATUS_COMPLETED => [],
            self::STATUS_CANCELLED => [],
        ];

        return in_array($newStatus, $allowedTransitions[$this->status] ?? []);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
