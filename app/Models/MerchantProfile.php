<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'user_id',
    'company_name',
    'address',
    'phone',
    'food_type',
    'description',
])]
class MerchantProfile extends Model
{
    use HasFactory, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeWithUser(Builder $query): Builder
    {
        return $query->with('user');
    }

    public function scopeWithCounts(Builder $query): Builder
    {
        return $query->withCount('menus', 'orders');
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('company_name', 'like', "%{$keyword}%")
                ->orWhere('address', 'like', "%{$keyword}%")
                ->orWhere('food_type', 'like', "%{$keyword}%");
        });
    }

    public function scopeFoodType(Builder $query, ?string $type): Builder
    {
        if (blank($type)) {
            return $query;
        }

        return $query->where('food_type', $type);
    }

    public function scopeLocation(Builder $query, ?string $location): Builder
    {
        if (blank($location)) {
            return $query;
        }

        return $query->where('address', 'like', "%{$location}%");
    }

    public function scopeFoodTypes(Builder $query): Builder
    {
        return $query->whereNotNull('food_type')
            ->where('food_type', '!=', '')
            ->distinct()
            ->orderBy('food_type');
    }
}
