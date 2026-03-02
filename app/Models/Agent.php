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

    // Subscription plans (monthly)
    const PLAN_TRIAL = 'trial';           // Free 14 days
    const PLAN_BASIC = 'basic';           // 199K/month
    const PLAN_STANDARD = 'standard';     // 499K/month
    const PLAN_ENTERPRISE = 'enterprise'; // 999K/month

    // Quota limits per plan (weddings per month)
    const PLAN_LIMITS = [
        self::PLAN_TRIAL => 5,
        self::PLAN_BASIC => 10,
        self::PLAN_STANDARD => 30,
        self::PLAN_ENTERPRISE => -1, // Unlimited
    ];

    // Pricing per plan (VND per month)
    const PLAN_PRICES = [
        self::PLAN_TRIAL => 0,
        self::PLAN_BASIC => 199000,
        self::PLAN_STANDARD => 499000,
        self::PLAN_ENTERPRISE => 999000,
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
     * Check if agent is on trial
     */
    public function isOnTrial(): bool
    {
        return $this->subscription_plan === self::PLAN_TRIAL;
    }

    /**
     * Check if trial is still valid
     */
    public function isTrialValid(): bool
    {
        if (!$this->isOnTrial()) {
            return false;
        }

        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Check if subscription is active
     */
    public function isSubscriptionActive(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->isOnTrial()) {
            return $this->isTrialValid();
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
            return 'Unlimited';
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
            self::PLAN_TRIAL => 'Dùng thử (14 ngày)',
            self::PLAN_BASIC => 'Cơ bản (199K/tháng)',
            self::PLAN_STANDARD => 'Tiêu chuẩn (499K/tháng)',
            self::PLAN_ENTERPRISE => 'Doanh nghiệp (999K/tháng)',
            default => 'Không xác định',
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
     * Start trial period (1 month)
     */
    public function startTrial(): void
    {
        $this->update([
            'subscription_plan' => self::PLAN_TRIAL,
            'trial_ends_at' => now()->addMonth(),
        ]);
    }
}
