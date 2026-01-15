<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\WeddingTier;

class Template extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'type',
        'required_tier',
        'thumbnail_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Check if template requires Pro tier
     */
    public function isPro(): bool
    {
        return $this->required_tier === WeddingTier::PRO->value;
    }

    /**
     * Check if a user with given tier can access this template
     */
    public function isAccessibleBy(string $userTier): bool
    {
        $tierOrder = [
            WeddingTier::BASIC->value => 1,
            WeddingTier::STANDARD->value => 2,
            WeddingTier::PRO->value => 3,
        ];
        
        $requiredLevel = $tierOrder[$this->required_tier] ?? 1;
        $userLevel = $tierOrder[$userTier] ?? 1;
        
        return $userLevel >= $requiredLevel;
    }

    /**
     * Get the required tier enum
     */
    public function getRequiredTierEnum(): WeddingTier
    {
        return WeddingTier::tryFrom($this->required_tier) ?? WeddingTier::BASIC;
    }

    /**
     * Scope for templates accessible by a specific tier
     */
    public function scopeAccessibleBy($query, string $tier)
    {
        $tierOrder = [
            WeddingTier::BASIC->value => 1,
            WeddingTier::STANDARD->value => 2,
            WeddingTier::PRO->value => 3,
        ];
        
        $userLevel = $tierOrder[$tier] ?? 1;
        
        $accessibleTiers = array_filter($tierOrder, fn($level) => $level <= $userLevel);
        
        return $query->whereIn('required_tier', array_keys($accessibleTiers));
    }

    /**
     * Scope for tier filtering
     */
    public function scopeForTier($query, string $tier)
    {
        return $query->where('required_tier', $tier);
    }

    /**
     * Scope for basic templates only
     */
    public function scopeBasic($query)
    {
        return $query->where('required_tier', WeddingTier::BASIC->value);
    }

    /**
     * Scope for pro templates only
     */
    public function scopePro($query)
    {
        return $query->where('required_tier', WeddingTier::PRO->value);
    }
}

