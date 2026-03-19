<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'phone',
        'address',
        'tax_code',
        'subscription_plan',
        'quota_weddings',
        'quota_used',
        'trial_ends_at',
        'subscription_ends_at',
        'is_active',
        'is_verified',
        'notes',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
    ];

    // Business types
    const TYPE_PRINT = 'print';
    const TYPE_PHOTO = 'photo';
    const TYPE_STUDIO = 'studio';
    const TYPE_WEDDING_PLANNER = 'wedding_planner';
    const TYPE_OTHER = 'other';

    // Gói đăng ký
    const PLAN_STANDARD = 'standard';     // Gói cơ bản
    const PLAN_PRO = 'pro';              // Gói nâng cao

    // Giới hạn quota theo gói (số thiệp)
    const PLAN_LIMITS = [
        self::PLAN_STANDARD => 20,
        self::PLAN_PRO => -1, // Không giới hạn
    ];

    // Giá theo gói (VND)
    const PLAN_PRICES = [
        self::PLAN_STANDARD => 0,
        self::PLAN_PRO => 499000,
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customers()
    {
        return $this->hasMany(User::class, 'agent_id');
    }

    public function weddings()
    {
        return $this->hasMany(Wedding::class);
    }

    // ==========================================
    // HELPERS
    // ==========================================

    /**
     * Check if agent is on standard plan
     */
    public function isStandard(): bool
    {
        return $this->subscription_plan === self::PLAN_STANDARD;
    }

    /**
     * Check if agent is on pro plan
     */
    public function isPro(): bool
    {
        return $this->subscription_plan === self::PLAN_PRO;
    }

    /**
     * Check if subscription is active
     */
    public function isSubscriptionActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->subscription_ends_at && $this->subscription_ends_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if agent can create more weddings
     */
    public function canCreateWedding(): bool
    {
        if (!$this->isSubscriptionActive()) {
            return false;
        }

        $limit = self::PLAN_LIMITS[$this->subscription_plan] ?? 0;
        
        if ($limit === -1) {
            return true; // Unlimited
        }

        return $this->quota_used < $limit;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingQuota(): int|string
    {
        $limit = self::PLAN_LIMITS[$this->subscription_plan] ?? 0;
        
        if ($limit === -1) {
            return 'Không giới hạn';
        }

        return max(0, $limit - $this->quota_used);
    }

    /**
     * Increment quota used
     */
    public function incrementQuotaUsed(): void
    {
        $this->increment('quota_used');
    }

    /**
     * Get business type label
     */
    public function getBusinessTypeLabel(): string
    {
        return match($this->business_type) {
            self::TYPE_PRINT => 'Nhà in',
            self::TYPE_PHOTO => 'Chụp ảnh',
            self::TYPE_STUDIO => 'Studio',
            self::TYPE_WEDDING_PLANNER => 'Wedding Planner',
            self::TYPE_OTHER => 'Khác',
            default => 'Không xác định',
        };
    }

    /**
     * Get subscription plan label
     */
    public function getSubscriptionPlanLabel(): string
    {
        return match($this->subscription_plan) {
            self::PLAN_STANDARD => 'Standard',
            self::PLAN_PRO => 'Pro',
            default => 'Chưa xác định',
        };
    }

    /**
     * Get plan price
     */
    public function getPlanPrice(): int
    {
        return self::PLAN_PRICES[$this->subscription_plan] ?? 0;
    }

    /**
     * Upgrade to Pro
     */
    public function upgradeToPro(): void
    {
        $this->update([
            'subscription_plan' => self::PLAN_PRO,
        ]);
    }
}
