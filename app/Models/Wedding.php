<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\LunarHelper;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Enums\FallingEffect;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;

class Wedding extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = []; // Allow all fields since we use filament form validation

    protected $casts = [
        'event_date' => 'date',
        'groom_ceremony_date' => 'date',
        'bride_ceremony_date' => 'date',
        'groom_reception_time' => 'datetime',
        'bride_reception_time' => 'datetime',
        'groom_ceremony_time' => 'datetime',
        'bride_ceremony_time' => 'datetime',
        'content' => 'array',
        'is_active' => 'boolean',
        'is_auto_approve_wishes' => 'boolean',
        'is_demo' => 'boolean',
        'show_preload' => 'boolean',
        'can_share' => 'boolean',
        'expires_at' => 'date',
        // Note: status, tier, falling_effect are stored as strings, use Enum::options() for dropdowns
    ];

    // ==========================================
    // ENUM HELPER METHODS
    // ==========================================
    
    public function isPro(): bool
    {
        return $this->tier === 'pro' || $this->tier === WeddingTier::PRO->value;
    }
    
    public function isPublished(): bool
    {
        return $this->status === 'published' || $this->status === WeddingStatus::PUBLISHED->value;
    }
    
    public function getStatusLabel(): string
    {
        return WeddingStatus::tryFrom($this->status)?->label() ?? $this->status ?? 'N/A';
    }
    
    public function getTierLabel(): string
    {
        return WeddingTier::tryFrom($this->tier)?->label() ?? $this->tier ?? 'Tiêu chuẩn';
    }
    
    public function getFallingEffectLabel(): string
    {
        return FallingEffect::tryFrom($this->falling_effect)?->label() ?? $this->falling_effect ?? 'Không';
    }

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo

    {
        return $this->belongsTo(Template::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function rsvps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeddingRsvp::class);
    }

    public function wishes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeddingWish::class);
    }

    public function approvedWishes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(WeddingWish::class)->where('is_approved', true);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('hero')->singleFile(); // Hero section image
        $this->addMediaCollection('groom_photo')->singleFile();
        $this->addMediaCollection('bride_photo')->singleFile();
        $this->addMediaCollection('groom_qr')->singleFile();
        $this->addMediaCollection('bride_qr')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Conversion for OG Share Image (1200x630) - Only for Cover image
        $this->addMediaConversion('share')
            ->width(1200)
            ->height(630)
            ->sharpen(10)
            ->performOnCollections('cover')
            ->nonQueued(); // Process immediately for now

        // Conversion for Hero/Portrait images (optimized web banner - Vertical 9:16)
        $this->addMediaConversion('optimized')
            ->width(1080)
            ->height(1920)
            ->sharpen(10)
            ->performOnCollections('hero', 'groom_photo', 'bride_photo')
            ->nonQueued();
            
        // Thumbnails for gallery or admin view - Global or restricted
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();
    }

    protected static function booted()
    {
        static::saving(function ($wedding) {
            // Auto calculate lunar date
            if ($wedding->event_date) {
                $wedding->event_date_lunar = \App\Helpers\LunarHelper::solarToLunar($wedding->event_date);
            }
            
            // Fallback slug generation if empty (though form handles it now)
            if (empty($wedding->slug)) {
                $baseSlug = Str::slug($wedding->groom_name . '-va-' . $wedding->bride_name . '-' . now()->year);
                $wedding->slug = $baseSlug . '-' . rand(1000, 9999);
            }
        });
    }

    public function getContentValue($key, $default = null)
    {
        return $this->content[$key] ?? $default;
    }

    public function isViewable()
    {
        // Allow view if status is preview or published
        return in_array($this->status, ['preview', 'published']);
    }

    /**
     * Check if wedding is Demo
     */
    public function isDemo(): bool
    {
        return $this->is_demo ?? false;
    }

    /**
     * Check if wedding is expired (Standard only)
     */
    public function isExpired(): bool
    {
        if ($this->isPro()) {
            return false; // Pro never expires
        }
        
        if (!$this->expires_at) {
            return false;
        }
        
        return $this->expires_at->isPast();
    }

    /**
     * Get guest name from URL query (?guest=Name)
     */
    public function getGuestName(): ?string
    {
        return request()->query('guest');
    }

    /**
     * Check if current user can view this wedding
     * - Owner always can
     * - Demo weddings: anyone can view
     * - can_share = true: anyone can view (public)
     * - can_share = false: only owner can view (private link, must login)
     */
    public function canView(?User $user = null): bool
    {
        // Demo weddings are always viewable
        if ($this->is_demo) {
            return true;
        }

        // If can_share is true, anyone can view (Pro + published)
        if ($this->can_share && $this->status === 'published') {
            return true;
        }

        // Private link: only owner can view
        if (!$user) {
            return false;
        }

        // Owner can always view
        if ($this->user_id === $user->id) {
            return true;
        }

        // Agent who created can view
        if ($user->isAgent() && $this->agent_id && $user->agentProfile) {
            if ($this->agent_id === $user->agentProfile->id) {
                return true;
            }
        }

        // Admin can view all
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    /**
     * Check if wedding can be shared publicly
     * Only Pro tier weddings that are published can be shared
     */
    public function canBeShared(): bool
    {
        return $this->isPro() && $this->status === 'published' && $this->can_share;
    }

    /**
     * Generate preview token for private viewing
     */
    public function generatePreviewToken(): string
    {
        $token = \Illuminate\Support\Str::random(32);
        $this->update(['preview_token' => $token]);
        return $token;
    }

    /**
     * Verify preview token
     */
    public function verifyPreviewToken(?string $token): bool
    {
        if (!$token || !$this->preview_token) {
            return false;
        }
        return $this->preview_token === $token;
    }
}

