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
        'falling_effect' => FallingEffect::class,
        'status' => WeddingStatus::class,
        'tier' => WeddingTier::class,
    ];

    // ==========================================
    // ENUM HELPER METHODS
    // ==========================================
    
    public function isPro(): bool
    {
        if ($this->tier instanceof WeddingTier) {
            return $this->tier === WeddingTier::PRO;
        }
        return $this->tier === 'pro' || $this->tier === WeddingTier::PRO->value;
    }
    
    public function isPublished(): bool
    {
        if ($this->status instanceof WeddingStatus) {
            return $this->status === WeddingStatus::PUBLISHED;
        }
        return $this->status === 'published' || $this->status === WeddingStatus::PUBLISHED->value;
    }
    
    public function getStatusLabel(): string
    {
        if ($this->status instanceof WeddingStatus) {
            return $this->status->label();
        }
        return WeddingStatus::tryFrom($this->status)?->label() ?? $this->status ?? 'N/A';
    }
    
    public function getTierLabel(): string
    {
        if ($this->tier instanceof WeddingTier) {
            return $this->tier->label();
        }
        return WeddingTier::tryFrom($this->tier)?->label() ?? $this->tier ?? 'Tiêu chuẩn';
    }
    
    public function getFallingEffectLabel(): string
    {
        if ($this->falling_effect instanceof FallingEffect) {
            return $this->falling_effect->label();
        }
        return FallingEffect::tryFrom($this->falling_effect)?->label() ?? $this->falling_effect ?? 'Không';
    }

    public function getMusicUrlAttribute(): ?string
    {
        // 1. If it's a demo, try to get from Global Config
        if ($this->is_demo) {
            $demo = \App\Models\DemoContent::first();
            if ($demo && $demo->background_music) {
                return $demo->background_music;
            }
        }
        
        // 2. Fallback to local music
        if (!$this->background_music) return null;
        if (Str::startsWith($this->background_music, ['http', 'https'])) return $this->background_music;
        return asset('storage/' . $this->background_music);
    }
    
    public function getGalleryImagesAttribute()
    {
        // 1. If it's a demo, try to get from Global Config first
        if ($this->is_demo) {
            $demo = \App\Models\DemoContent::first();
            if ($demo && $demo->hasMedia('demo_gallery')) {
                return $demo->getMedia('demo_gallery');
            }
        }
        
        // 2. Fallback to local gallery
        return $this->getMedia('gallery');
    }

    // ==========================================
    // CENTRALIZED DEMO ASSETS HELPERS
    // ==========================================

    /**
     * Helper to get URL from DemoContent if is_demo, else fallback to local
     */
    private function getMediaUrlWithDemoFallback(string $collection, string $conversion = ''): string
    {
        // 1. Check Demo
        if ($this->is_demo) {
            $demo = \App\Models\DemoContent::first();
            // Note: We use the SAME collection name in DemoContent for simplicity
            if ($demo && $demo->hasMedia($collection)) {
                return $demo->getFirstMediaUrl($collection, $conversion);
            }
        }
        
        // 2. Fallback to local
        return $this->getFirstMediaUrl($collection, $conversion);
    }

    public function getCoverUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('cover');
        return $url ?: asset('images/default-cover.jpg'); // Fallback placeholder if absolutely nothing
    }

    public function getHeroUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('hero');
        return $url ?: asset('images/default-hero.jpg');
    }

    public function getGroomPhotoUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('groom_photo');
        return $url ?: 'https://ui-avatars.com/api/?name=Groom&background=random';
    }

    public function getBridePhotoUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('bride_photo');
        return $url ?: 'https://ui-avatars.com/api/?name=Bride&background=random';
    }

    public function getGroomQrUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('groom_qr');
        return $url ?: asset('images/qr-placeholder.png');
    }

    public function getBrideQrUrl(): string
    {
        $url = $this->getMediaUrlWithDemoFallback('bride_qr');
        return $url ?: asset('images/qr-placeholder.png');
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
        static::creating(function ($wedding) {
            $wedding->status = $wedding->status ?? WeddingStatus::DRAFT->value;
            $wedding->tier = $wedding->tier ?? WeddingTier::STANDARD->value;
            $wedding->falling_effect = $wedding->falling_effect ?? FallingEffect::HEARTS->value;
        });


        static::saving(function ($wedding) {
            // Auto calculate lunar date
            if ($wedding->event_date) {
                // Check if LunarHelper exists, if not, skip or use fallback
                if (class_exists(\App\Helpers\LunarHelper::class)) {
                    $wedding->event_date_lunar = \App\Helpers\LunarHelper::solarToLunar($wedding->event_date);
                }
            }
            
            // Generate slug if empty
            if (empty($wedding->slug)) {
                $groom = $wedding->groom_name ?? 'groom';
                $bride = $wedding->bride_name ?? 'bride';
                // Use event date year or current year
                $year = $wedding->event_date ? $wedding->event_date->format('d-m-Y') : now()->year;
                
                $baseSlug = Str::slug("$groom-va-$bride-$year");
                $slug = $baseSlug;
                $counter = 1;

                // Ensure uniqueness
                while (static::where('slug', $slug)->where('id', '!=', $wedding->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                
                $wedding->slug = $slug;
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
        if ($this->status instanceof WeddingStatus) {
            return in_array($this->status, [WeddingStatus::PREVIEW, WeddingStatus::PUBLISHED]);
        }
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

