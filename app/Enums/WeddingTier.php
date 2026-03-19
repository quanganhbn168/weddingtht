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

    public function color(): string
    {
        return match($this) {
            self::STANDARD => 'info',
            self::PRO => 'warning',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::STANDARD => 'fa-solid fa-check',
            self::PRO => 'fa-solid fa-star',
        };
    }

    public function maxPhotos(): int
    {
        return match($this) {
            self::STANDARD => 20,
            self::PRO => -1, // Không giới hạn
        };
    }

    public function expiresInMonths(): ?int
    {
        return match($this) {
            self::STANDARD => 6,
            self::PRO => null, // Vĩnh viễn
        };
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

    public function priceLabel(): string
    {
        $price = \App\Models\Setting::getTierPrice($this->value);
        return \App\Models\Setting::formatPrice($price);
    }
}
