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
        'content_schema',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'content_schema' => 'array',
    ];

    /**
     * Scope for active templates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for wedding templates
     */
    public function scopeWedding($query)
    {
        return $query->where('type', 'wedding');
    }
}
