<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_MERCHANT = 'merchant';

    public const ROLE_CUSTOMER = 'customer';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_MERCHANT,
        self::ROLE_CUSTOMER,
    ];

    public const REGISTRABLE_ROLES = [
        self::ROLE_MERCHANT,
        self::ROLE_CUSTOMER,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMerchant(): bool
    {
        return $this->role === self::ROLE_MERCHANT;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function merchantProfile(): HasOne
    {
        return $this->hasOne(MerchantProfile::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
                ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    public function scopeOfRole(Builder $query, ?string $role): Builder
    {
        if (blank($role)) {
            return $query;
        }

        return $query->where('role', $role);
    }
}
