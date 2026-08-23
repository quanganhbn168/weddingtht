<?php

namespace App\DTOs;

use Carbon\Carbon;

final readonly class WeddingEventData
{
    private const DAY_LABELS = [
        0 => 'Chủ Nhật',
        1 => 'Thứ Hai',
        2 => 'Thứ Ba',
        3 => 'Thứ Tư',
        4 => 'Thứ Năm',
        5 => 'Thứ Sáu',
        6 => 'Thứ Bảy',
    ];

    public function __construct(
        public string $side,
        public string $receptionTitle,
        public Carbon $receptionDate,
        public ?string $receptionLunarDisplay,
        public ?string $receptionLunarInWords,
        public ?Carbon $receptionTime,
        public string $receptionVenue,
        public ?string $receptionAddress,
        public ?string $receptionMapUrl,
        public ?string $receptionMapEmbed,
        public string $ceremonyTitle,
        public Carbon $ceremonyDate,
        public ?string $ceremonyLunarDisplay,
        public ?string $ceremonyLunarInWords,
        public ?Carbon $ceremonyTime,
        public string $ceremonyVenue,
        public ?string $ceremonyAddress,
        public ?string $ceremonyMapUrl,
        public ?string $ceremonyMapEmbed,
    ) {}

    public function receptionDayLabel(): string
    {
        return self::DAY_LABELS[$this->receptionDate->dayOfWeek];
    }

    public function ceremonyDayLabel(): string
    {
        return self::DAY_LABELS[$this->ceremonyDate->dayOfWeek];
    }

    public function receptionTimeLabel(): string
    {
        return $this->receptionTime?->format('H:i') ?? '00:00';
    }

    public function receptionTimeVietnameseLabel(): string
    {
        return $this->receptionTime?->format('H\\Hi') ?? '00H00';
    }

    public function ceremonyTimeLabel(): string
    {
        return $this->ceremonyTime?->format('H:i') ?? '00:00';
    }

    public function ceremonyTimeVietnameseLabel(): string
    {
        return $this->ceremonyTime?->format('H\\Hi') ?? '00H00';
    }

    public function receptionMapFrameUrl(): ?string
    {
        if ($embedUrl = trim((string) $this->receptionMapEmbed)) {
            return $embedUrl;
        }

        $address = trim((string) $this->receptionAddress);

        if ($address === '') {
            return null;
        }

        return 'https://www.google.com/maps?'.http_build_query([
            'q' => $address,
            'output' => 'embed',
        ], '', '&', PHP_QUERY_RFC3986);
    }
}
