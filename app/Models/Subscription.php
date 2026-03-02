<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan',
        'status',
        'started_at',
        'expires_at',
        'payment_method',
        'transaction_id',
        'features',
    ];

    protected $casts = [
        'features' => 'array',
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    // Plan constants
    const PLAN_FREE = 'free';
    const PLAN_PRO = 'pro';
    const PLAN_ENTERPRISE = 'enterprise';

    // Status constants
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_EXPIRED = 'expired';

    /**
     * Get plan limits
     */
    public static function getPlanLimits(string $plan): array
    {
        return match($plan) {
            self::PLAN_FREE => [
                'max_weddings' => 1,
                'max_business_cards' => 1,
                'premium_templates' => false,
                'custom_domain' => false,
                'analytics' => false,
            ],
            self::PLAN_PRO => [
                'max_weddings' => 10,
                'max_business_cards' => 10,
                'premium_templates' => true,
                'custom_domain' => true,
                'analytics' => true,
            ],
            self::PLAN_ENTERPRISE => [
                'max_weddings' => -1, // Unlimited
                'max_business_cards' => -1,
                'premium_templates' => true,
                'custom_domain' => true,
                'analytics' => true,
                'white_label' => true,
            ],
            default => self::getPlanLimits(self::PLAN_FREE),
        };
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if subscription is active
     */
    public function isActive(): bool
    {
        if ($this->status !== self::STATUS_ACTIVE) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if subscription has access to feature
     */
    public function hasFeature(string $feature): bool
    {
        $limits = self::getPlanLimits($this->plan);
        return $limits[$feature] ?? false;
    }

    /**
     * Get limit for a specific resource
     */
    public function getLimit(string $resource): int
    {
        $limits = self::getPlanLimits($this->plan);
        return $limits[$resource] ?? 0;
    }
}
