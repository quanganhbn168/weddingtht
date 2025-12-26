<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    // Role constants
    const ROLE_SUPER_ADMIN = 'super_admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_AGENT = 'agent';
    const ROLE_CUSTOMER = 'customer';
    
    // Super admin email (hidden everywhere)
    const SUPER_ADMIN_EMAIL = 'quanganhadmin@thtmedia.com.vn';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'agent_id',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    /**
     * Filament access control - Only admins can access Filament panel
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Allow admin role OR legacy email check
        return $this->isSuperAdmin() || $this->isAdmin() || str_ends_with($this->email, '@thtmedia.com.vn');
    }

    // ==========================================
    // ROLE CHECKS
    // ==========================================

    public function isSuperAdmin(): bool
    {
        return $this->email === self::SUPER_ADMIN_EMAIL || $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->hasRole(self::ROLE_ADMIN);
    }

    public function isAgent(): bool
    {
        return $this->role === self::ROLE_AGENT || $this->hasRole(self::ROLE_AGENT);
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER || $this->hasRole(self::ROLE_CUSTOMER);
    }

    public function getRoleLabel(): string
    {
        if ($this->isSuperAdmin()) return 'Super Admin';
        
        return match($this->role) {
            self::ROLE_ADMIN => 'Quản trị viên',
            self::ROLE_AGENT => 'Đại lý',
            self::ROLE_CUSTOMER => 'Khách hàng',
            default => 'Không xác định',
        };
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function weddings()
    {
        return $this->hasMany(Wedding::class);
    }

    public function businessCards()
    {
        return $this->hasMany(BusinessCard::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    /**
     * Agent profile (if user is an agent)
     */
    public function agentProfile()
    {
        return $this->hasOne(Agent::class);
    }

    /**
     * Agent who created this customer account
     */
    public function managingAgent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Customers managed by this agent
     */
    public function managedCustomers()
    {
        return $this->hasMany(User::class, 'agent_id');
    }

    /**
     * User who created this account
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ==========================================
    // SUBSCRIPTION HELPERS
    // ==========================================

    /**
     * Get active subscription or create free one
     */
    public function getActiveSubscription(): Subscription
    {
        $subscription = $this->subscription;

        if (!$subscription || !$subscription->isActive()) {
            // Create free subscription if none exists
            $subscription = $this->subscription()->create([
                'plan' => Subscription::PLAN_FREE,
                'status' => Subscription::STATUS_ACTIVE,
                'started_at' => now(),
            ]);
        }

        return $subscription;
    }

    /**
     * Get current plan
     */
    public function getPlan(): string
    {
        return $this->getActiveSubscription()->plan;
    }

    /**
     * Check if user is on Pro or higher plan
     */
    public function isPro(): bool
    {
        return in_array($this->getPlan(), [Subscription::PLAN_PRO, Subscription::PLAN_ENTERPRISE]);
    }

    /**
     * Check if user can create more weddings
     */
    public function canCreateWedding(): bool
    {
        $subscription = $this->getActiveSubscription();
        $limit = $subscription->getLimit('max_weddings');
        
        if ($limit === -1) return true; // Unlimited
        
        return $this->weddings()->count() < $limit;
    }

    /**
     * Check if user can create more business cards
     */
    public function canCreateBusinessCard(): bool
    {
        $subscription = $this->getActiveSubscription();
        $limit = $subscription->getLimit('max_business_cards');
        
        if ($limit === -1) return true; // Unlimited
        
        return $this->businessCards()->count() < $limit;
    }

    /**
     * Get remaining quota
     */
    public function getRemainingWeddings(): int|string
    {
        $subscription = $this->getActiveSubscription();
        $limit = $subscription->getLimit('max_weddings');
        
        if ($limit === -1) return 'Unlimited';
        
        return max(0, $limit - $this->weddings()->count());
    }

    public function getRemainingBusinessCards(): int|string
    {
        $subscription = $this->getActiveSubscription();
        $limit = $subscription->getLimit('max_business_cards');
        
        if ($limit === -1) return 'Unlimited';
        
        return max(0, $limit - $this->businessCards()->count());
    }
}
