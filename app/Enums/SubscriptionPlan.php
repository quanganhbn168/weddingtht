<?php

namespace App\Enums;

enum SubscriptionPlan: string
{
    case FREE = 'free';
    case PRO = 'pro';
    case ENTERPRISE = 'enterprise';
    
    public function label(): string
    {
        return match($this) {
            self::FREE => 'Miễn phí',
            self::PRO => 'Pro',
            self::ENTERPRISE => 'Doanh nghiệp',
        };
    }
    
    public function badgeClass(): string
    {
        return match($this) {
            self::FREE => 'bg-gray-100 text-gray-600',
            self::PRO => 'bg-purple-100 text-purple-800',
            self::ENTERPRISE => 'bg-indigo-100 text-indigo-800',
        };
    }
    
    public function maxWeddings(): int
    {
        return match($this) {
            self::FREE => 1,
            self::PRO => 10,
            self::ENTERPRISE => -1, // Unlimited
        };
    }
    
    public function maxCards(): int
    {
        return match($this) {
            self::FREE => 1,
            self::PRO => 10,
            self::ENTERPRISE => -1,
        };
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
}
