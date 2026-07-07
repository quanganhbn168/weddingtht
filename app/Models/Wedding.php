<?php

namespace App\Models;

use App\Enums\FallingEffect;
use App\Enums\LunarDateFormat;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Helpers\LunarHelper;
use App\Observers\WeddingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

#[ObservedBy(WeddingObserver::class)]
class Wedding extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'agent_id',
        'template_id',
        'slug',
        'groom_name',
        'bride_name',
        'groom_father',
        'groom_mother',
        'bride_father',
        'bride_mother',
        'groom_address',
        'bride_address',
        'groom_map_url',
        'groom_map_embed',
        'groom_ceremony_map_url',
        'groom_ceremony_map_embed',
        'bride_map_url',
        'bride_map_embed',
        'bride_ceremony_map_url',
        'bride_ceremony_map_embed',
        'event_date',
        'event_date_lunar',
        'lunar_date_format',
        'album_love_image_position_x',
        'album_love_image_position_y',
        'album_love_focal_point',
        'album_love_media_id',
        'groom_ceremony_date',
        'groom_ceremony_time',
        'groom_ceremony_venue',
        'bride_ceremony_date',
        'bride_ceremony_time',
        'bride_ceremony_venue',
        'groom_reception_date',
        'groom_reception_time',
        'groom_reception_venue',
        'groom_reception_address',
        'bride_reception_date',
        'bride_reception_time',
        'bride_reception_venue',
        'bride_reception_address',
        'content',
        'background_music',
        'shared_music_id',
        'status',
        'tier',
        'falling_effect',
        'is_active',
        'is_auto_approve_wishes',
        'is_demo',
        'show_preload',
        'preload_variant',
        'show_love_story',
        'show_invitation_wrapper',
        'can_share',
        'password',
        'edit_token',
        'preview_token',
        'expires_at',
        'notes',
    ];

    protected $casts = [
        'event_date' => 'date',
        'lunar_date_format' => LunarDateFormat::class,
        'groom_ceremony_date' => 'date',
        'bride_ceremony_date' => 'date',
        'groom_reception_date' => 'date',
        'bride_reception_date' => 'date',
        'groom_reception_time' => 'datetime',
        'bride_reception_time' => 'datetime',
        'groom_ceremony_time' => 'datetime',
        'bride_ceremony_time' => 'datetime',
        'content' => 'array',
        'album_love_focal_point' => 'array',
        'is_active' => 'boolean',
        'is_auto_approve_wishes' => 'boolean',
        'is_demo' => 'boolean',
        'show_preload' => 'boolean',
        'show_love_story' => 'boolean',
        'can_share' => 'boolean',
        'expires_at' => 'date',
        'falling_effect' => FallingEffect::class,
        'status' => WeddingStatus::class,
        'tier' => WeddingTier::class,
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(Template::class);
    }

    public function sharedMusic(): BelongsTo
    {
        return $this->belongsTo(SharedMusic::class);
    }

    public function rsvps(): HasMany
    {
        return $this->hasMany(WeddingRsvp::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(WeddingWish::class);
    }

    public function approvedWishes(): HasMany
    {
        return $this->hasMany(WeddingWish::class)->where('is_approved', true);
    }

    // ==========================================
    // STATUS / TIER HELPERS
    // ==========================================

    public function isPro(): bool
    {
        return $this->tier === WeddingTier::PRO;
    }

    public function isPublished(): bool
    {
        return $this->status === WeddingStatus::PUBLISHED;
    }

    public function isViewable(): bool
    {
        return in_array($this->status, [WeddingStatus::PREVIEW, WeddingStatus::PUBLISHED]);
    }

    public function isDemo(): bool
    {
        return (bool) $this->is_demo;
    }

    public function isExpired(): bool
    {
        if ($this->isPro()) {
            return false;
        }

        return $this->expires_at && $this->expires_at->isPast();
    }

    // ==========================================
    // LABEL HELPERS
    // ==========================================

    public function formattedLunarDate(): ?string
    {
        $format = $this->lunar_date_format ?? LunarDateFormat::SHORT;

        return match ($format) {
            LunarDateFormat::FULL => ($long = LunarHelper::formatLong($this->event_date_lunar))
                ? 'Tức '.$long
                : null,
            LunarDateFormat::SHORT => LunarHelper::formatShort($this->event_date_lunar),
        };
    }

    public function albumLoveImageAlignment(): string
    {
        $horizontal = match ($this->album_love_image_position_x) {
            'left' => 'xMin',
            'right' => 'xMax',
            default => 'xMid',
        };

        $vertical = match ($this->album_love_image_position_y) {
            'center' => 'YMid',
            'bottom' => 'YMax',
            default => 'YMin',
        };

        return "{$horizontal}{$vertical} slice";
    }

    /** @return array{x: int, y: int} */
    public function albumLoveFocalPoint(): array
    {
        $point = $this->album_love_focal_point;

        if (is_array($point)) {
            return [
                'x' => max(0, min(100, (int) ($point['x'] ?? 50))),
                'y' => max(0, min(100, (int) ($point['y'] ?? 20))),
            ];
        }

        $x = match ($this->album_love_image_position_x) {
            'left' => 0,
            'right' => 100,
            default => 50,
        };
        $y = match ($this->album_love_image_position_y) {
            'center' => 50,
            'bottom' => 100,
            default => 20,
        };

        return compact('x', 'y');
    }

    public function albumLoveImageUrl(): ?string
    {
        if ($loveImage = $this->getTemplateMediaUrl('tht16_love')) {
            return $loveImage;
        }

        $images = $this->gallery_images;
        $selected = $this->album_love_media_id
            ? $images->firstWhere('id', (int) $this->album_love_media_id)
            : null;

        return ($selected ?? $images->first())?->getUrl();
    }

    public function getStatusLabel(): string
    {
        return $this->status?->label() ?? 'N/A';
    }

    public function getTierLabel(): string
    {
        return $this->tier?->label() ?? 'Tieu chuan';
    }

    public function getFallingEffectLabel(): string
    {
        return $this->falling_effect?->label() ?? 'Khong';
    }

    // ==========================================
    // MEDIA
    // ==========================================

    public function registerMediaCollections(): void
    {
        $templateCollections = collect(config('wedding-template-media', []))
            ->flatMap(fn (array $template): array => $template['fields'] ?? [])
            ->pluck('collection')
            ->filter()
            ->all();

        $singleCollections = array_unique([
            'cover',
            'hero',
            'groom_photo',
            'bride_photo',
            'groom_qr',
            'bride_qr',
            'demo_thumbnail',
            ...$templateCollections,
        ]);

        foreach ($singleCollections as $collection) {
            $this->addMediaCollection($collection)->singleFile();
        }

        $this->addMediaCollection('gallery');
        $this->addMediaCollection('film_gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $templateCollections = collect(config('wedding-template-media', []))
            ->flatMap(fn (array $template): array => $template['fields'] ?? [])
            ->pluck('collection')
            ->filter()
            ->all();

        $this->addMediaConversion('share')
            ->width(1200)->height(630)->sharpen(10)
            ->format('webp')->quality(85)
            ->performOnCollections('cover')
            ->nonQueued();

        $this->addMediaConversion('optimized')
            ->width(1080)->height(1920)->sharpen(10)
            ->format('webp')->quality(85)
            ->performOnCollections(
                'hero',
                'groom_photo',
                'bride_photo',
                ...$templateCollections,
            )
            ->nonQueued();

        $this->addMediaConversion('gallery_web')
            ->width(1200)
            ->format('webp')->quality(82)
            ->performOnCollections('gallery')
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(400)->height(400)->sharpen(10)
            ->format('webp')->quality(75)
            ->nonQueued();
    }

    // ==========================================
    // MEDIA URL HELPERS
    // ==========================================

    public function getCoverUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('cover')
            ?: $this->getMediaUrlWithDemoFallback('hero')
            ?: asset('images/default-cover.jpg');
    }

    public function getHeroUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('hero')
            ?: asset('images/default-hero.jpg');
    }

    public function getGroomPhotoUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('groom_photo')
            ?: 'https://ui-avatars.com/api/?name=Groom&background=random';
    }

    public function getBridePhotoUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('bride_photo')
            ?: 'https://ui-avatars.com/api/?name=Bride&background=random';
    }

    public function getGroomQrUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('groom_qr')
            ?: asset('images/qr-placeholder.png');
    }

    public function getBrideQrUrl(): string
    {
        return $this->getMediaUrlWithDemoFallback('bride_qr')
            ?: asset('images/qr-placeholder.png');
    }

    public function getTemplateMediaUrl(string $collection): ?string
    {
        return $this->getMediaUrlWithDemoFallback($collection) ?: null;
    }

    // ==========================================
    // ACCESSORS
    // ==========================================

    public function getMusicUrlAttribute(): ?string
    {
        if ($this->is_demo) {
            $demo = DemoContent::first();
            if ($demo?->background_music) {
                return $demo->background_music;
            }
        }

        if ($this->shared_music_id && $this->sharedMusic) {
            return $this->sharedMusic->getUrl();
        }

        if (! $this->background_music) {
            return null;
        }

        if (str_starts_with($this->background_music, 'http')) {
            return $this->background_music;
        }

        return asset('storage/'.$this->background_music);
    }

    public function getGalleryImagesAttribute()
    {
        if ($this->is_demo) {
            $demo = DemoContent::first();
            if ($demo?->hasMedia('demo_gallery')) {
                return $demo->getMedia('demo_gallery');
            }
        }

        return $this->getMedia('gallery');
    }

    // ==========================================
    // CONTENT HELPERS
    // ==========================================

    public function getContentValue(string $key, mixed $default = null): mixed
    {
        return $this->content[$key] ?? $default;
    }

    public function getGuestName(): ?string
    {
        return request()->query('guest');
    }

    // ==========================================
    // ACCESS CONTROL
    // ==========================================

    public function canView(?User $user = null): bool
    {
        if ($this->is_demo) {
            return true;
        }

        if ($this->can_share && $this->isPublished()) {
            return true;
        }

        if (! $user) {
            return false;
        }

        if ($this->user_id === $user->id) {
            return true;
        }

        if ($user->isAgent() && $this->agent_id && $user->agentProfile) {
            if ($this->agent_id === $user->agentProfile->id) {
                return true;
            }
        }

        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }

    public function canBeShared(): bool
    {
        return $this->isPro() && $this->isPublished() && $this->can_share;
    }

    // ==========================================
    // PREVIEW TOKEN
    // ==========================================

    public function generatePreviewToken(): string
    {
        $token = \Illuminate\Support\Str::random(32);
        $this->update(['preview_token' => $token]);

        return $token;
    }

    public function verifyPreviewToken(?string $token): bool
    {
        return $token && $this->preview_token && $this->preview_token === $token;
    }

    // ==========================================
    // PRIVATE HELPERS
    // ==========================================

    private function getMediaUrlWithDemoFallback(string $collection, string $conversion = ''): string
    {
        if ($this->is_demo) {
            $demo = DemoContent::first();
            if ($demo?->hasMedia($collection)) {
                return $demo->getFirstMediaUrl($collection, $conversion);
            }
        }

        return $this->getFirstMediaUrl($collection, $conversion);
    }
}
