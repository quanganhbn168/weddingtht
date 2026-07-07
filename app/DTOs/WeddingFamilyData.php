<?php

namespace App\DTOs;

final readonly class WeddingFamilyData
{
    public function __construct(
        public string $side,
        public string $label,
        public ?string $father,
        public ?string $mother,
        public ?string $address,
    ) {}
}
