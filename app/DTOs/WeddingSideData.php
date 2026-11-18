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

    /** Vietnamese given name = last word of the display name ("Khánh Ly" → "Ly"). */
    public function firstGivenName(): string
    {
        return self::givenName($this->firstName);
    }

    public function secondGivenName(): string
    {
        return self::givenName($this->secondName);
    }

    private static function givenName(string $name): string
    {
        $parts = preg_split('/\s+/u', trim($name), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return $parts === [] ? $name : end($parts);
    }
}
