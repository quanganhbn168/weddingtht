<?php

namespace App\DTOs;

use Illuminate\Support\Collection;

final readonly class WeddingSideData
{
    /**
     * @param Collection<int, WeddingFamilyData> $families
     * @param Collection<int, WeddingEventData> $events
     */
    public function __construct(
        public string $side,
        public string $firstName,
        public string $secondName,
        public string $firstPhoto,
        public string $secondPhoto,
        public Collection $families,
        public Collection $events,
        public bool $showGroomEvents,
        public bool $showBrideEvents,
    ) {}

    public function isBride(): bool
    {
        return $this->side === 'bride';
    }

    public function isGroom(): bool
    {
        return $this->side === 'groom';
    }

    public function isBoth(): bool
    {
        return $this->side === 'both';
    }

    /**
     * Get first initial (for monograms)
     */
    public function firstInitial(): string
    {
        return mb_substr($this->firstName, 0, 1);
    }

    /**
     * Get second initial (for monograms)
     */
    public function secondInitial(): string
    {
        return mb_substr($this->secondName, 0, 1);
    }
}
