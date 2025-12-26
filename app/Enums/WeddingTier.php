<?php

namespace App\Enums;

enum WeddingTier: string
{
    case STANDARD = 'standard';
    case PRO = 'pro';
    
    public function label(): string
    {
        return match($this) {
            self::STANDARD => 'Tiêu chuẩn',
            self::PRO => 'Pro',
        };
    }
    
    public function badgeClass(): string
    {
        return match($this) {
            self::STANDARD => 'bg-gray-100 text-gray-600',
            self::PRO => 'bg-yellow-100 text-yellow-800',
        };
    }
    
    public function icon(): string
    {
        return match($this) {
            self::STANDARD => '',
            self::PRO => '⭐',
        };
    }
    
    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])->toArray();
    }
}
