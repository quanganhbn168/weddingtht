<?php

namespace App\Enums;

enum WeddingTier: string
{
    case BASIC = 'basic';
    case STANDARD = 'standard';
    case PRO = 'pro';
    
    public function label(): string
    {
        return match($this) {
            self::BASIC => 'Cơ bản',
            self::STANDARD => 'Tiêu chuẩn',
            self::PRO => 'Pro',
        };
    }
    
    public function price(): int
    {
        return match($this) {
            self::BASIC => 198000,
            self::STANDARD => 299000,
            self::PRO => 499000,
        };
    }
    
    public function priceLabel(): string
    {
        return match($this) {
            self::BASIC => '198K',
            self::STANDARD => '299K',
            self::PRO => '499K',
        };
    }
    
    public function badgeClass(): string
    {
        return match($this) {
            self::BASIC => 'bg-slate-100 text-slate-600',
            self::STANDARD => 'bg-blue-100 text-blue-600',
            self::PRO => 'bg-yellow-100 text-yellow-800',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
            self::BASIC => '',
            self::STANDARD => '✓',
            self::PRO => '⭐',
        };
    }
    
    public function maxPhotos(): int
    {
        return match($this) {
            self::BASIC => 20,
            self::STANDARD => 40,
            self::PRO => -1, // Unlimited
        };
    }
    
    public function expiresInMonths(): ?int
    {
        return match($this) {
            self::BASIC => 6,
            self::STANDARD => 12,
            self::PRO => null, // Vĩnh viễn
        };
    }
    
    public function hasEffects(): bool
    {
        return match($this) {
            self::BASIC => false,
            self::STANDARD => true,
            self::PRO => true,
        };
    }
    
    public function hasPreload(): bool
    {
        return $this === self::PRO;
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
    
    public static function optionsWithPrice(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label() . ' (' . $case->priceLabel() . ')'
        ])->toArray();
    }
}

