<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $fillable = [
        'name',
        'view_path',
        'type',
        'tier',
        'thumbnail_url',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Check if template is Pro tier
     */
    public function isPro(): bool
    {
        return $this->tier === \App\Enums\WeddingTier::PRO->value;
    }

    /**
     * Scope for tier filtering
     */
    public function scopeForTier($query, string $tier)
    {
        return $query->where('tier', $tier);
    }

    /**
     * Scope for basic templates
     */
    public function scopeBasic($query)
    {
        return $query->where('tier', \App\Enums\WeddingTier::STANDARD->value);
    }

    /**
     * Scope for pro templates
     */
    public function scopePro($query)
    {
        return $query->where('tier', \App\Enums\WeddingTier::PRO->value);
    }
}
