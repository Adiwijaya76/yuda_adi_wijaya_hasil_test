<?php

namespace App\Models;

use App\Exceptions\OrderStatusTransitionException;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'order_number',
    'customer_id',
    'merchant_profile_id',
    'delivery_date',
    'delivery_address',
    'total',
    'status',
])]
class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_PREPARING = 'preparing';

    public const STATUS_READY = 'ready';

    public const STATUS_DELIVERED = 'delivered';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_CONFIRMED,
        self::STATUS_PREPARING,
        self::STATUS_READY,
        self::STATUS_DELIVERED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED,
    ];

    /**
     * Transisi status yang diizinkan (BR-12).
     */
    public const TRANSITIONS = [
        self::STATUS_PENDING => [
            self::STATUS_CONFIRMED,
            self::STATUS_REJECTED,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_CONFIRMED => [
            self::STATUS_PREPARING,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_PREPARING => [
            self::STATUS_READY,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_READY => [
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED,
        ],
        self::STATUS_DELIVERED => [],
        self::STATUS_REJECTED => [],
        self::STATUS_CANCELLED => [],
    ];

    protected function casts(): array
    {
        return [
            'delivery_date' => 'date',
            'total' => 'decimal:2',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function merchantProfile(): BelongsTo
    {
        return $this->belongsTo(MerchantProfile::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array($status, self::TRANSITIONS[$this->status] ?? [], true);
    }

    /**
     * @throws OrderStatusTransitionException
     */
    public function transitionTo(string $status): self
    {
        if (! $this->canTransitionTo($status)) {
            throw new OrderStatusTransitionException(
                $this->status,
                $status
            );
        }

        $this->status = $status;
        $this->save();

        return $this;
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where('order_number', 'like', "%{$keyword}%");
    }

    public function scopeOfStatus(Builder $query, ?string $status): Builder
    {
        if (blank($status)) {
            return $query;
        }

        return $query->where('status', $status);
    }

    public function scopeWithList(Builder $query): Builder
    {
        return $query->with('customer', 'merchantProfile', 'invoice');
    }

    public function scopeRecent(Builder $query, int $limit = 5): Builder
    {
        return $query->latest()->limit($limit);
    }
}
