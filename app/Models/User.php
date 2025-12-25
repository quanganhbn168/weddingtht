<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        // Only allow certain admin emails to access Filament admin
        return str_ends_with($this->email, '@thtmedia.com.vn');
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
