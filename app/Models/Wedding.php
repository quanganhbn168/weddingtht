<?php

namespace App\Models;

use App\Enums\FallingEffect;
use App\Enums\LunarDateFormat;
use App\Enums\WeddingStatus;
use App\Enums\WeddingTier;
use App\Helpers\LunarHelper;
use App\Observers\WeddingObserver;
use App\Services\VietQrService;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
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
        'groom_qr_info',
        'groom_qr_bank_id',
        'groom_qr_account_number',
        'groom_qr_account_name',
        'groom_qr_amount',
        'groom_qr_add_info',
        'bride_qr_info',
        'bride_qr_bank_id',
        'bride_qr_account_number',
        'bride_qr_account_name',
        'bride_qr_amount',
        'bride_qr_add_info',
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
        return $this->formatLunarDate($this->event_date_lunar);
    }

    public function formattedLunarDateFor(mixed $solarDate): ?string
    {
        return $this->formatLunarDate(LunarHelper::solarToLunar($solarDate));
    }

    public function eventDayLabel(): string
    {
        return match ($this->event_date->dayOfWeek) {
            0 => 'Chủ Nhật',
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
        };
    }

    private function formatLunarDate(?string $lunarDate): ?string
    {
        $format = $this->lunar_date_format ?? LunarDateFormat::SHORT;

        return match ($format) {
            LunarDateFormat::FULL => ($long = LunarHelper::formatLong($lunarDate))
                ? 'Tức '.$long
                : null,
            LunarDateFormat::SHORT => LunarHelper::formatShort($lunarDate),
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

        if (! $this->album_love_media_id) {
            return null;
        }

        return $this->gallery_images
            ->firstWhere('id', (int) $this->album_love_media_id)
            ?->getUrl();
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
        $templateMediaFields = collect(config('wedding-template-media', []))
            ->flatMap(fn (array $template): array => $template['fields'] ?? [])
            ->filter(fn (array $field): bool => ! empty($field['collection']));

        $templateSingleCollections = $templateMediaFields
            ->reject(fn (array $field): bool => ! empty($field['multiple']))
            ->pluck('collection')
            ->all();

        $templateMultipleCollections = $templateMediaFields
            ->filter(fn (array $field): bool => ! empty($field['multiple']))
            ->pluck('collection')
            ->all();

        $singleCollections = array_unique([
            'cover',
            'hero',
            'thank_you',
            'groom_photo',
            'bride_photo',
            'groom_qr',
            'bride_qr',
            'demo_thumbnail',
            ...$templateSingleCollections,
        ]);

        foreach ($singleCollections as $collection) {
            $this->addMediaCollection($collection)->singleFile();
        }

        foreach (array_unique(['gallery', 'film_gallery', ...$templateMultipleCollections]) as $collection) {
            $this->addMediaCollection($collection);
        }
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $templateMediaFields = collect(config('wedding-template-media', []))
            ->flatMap(fn (array $template): array => $template['fields'] ?? [])
            ->filter(fn (array $field): bool => ! empty($field['collection']));

        $templateCollections = $templateMediaFields
            ->pluck('collection')
            ->all();

        $templateMultipleCollections = $templateMediaFields
            ->filter(fn (array $field): bool => ! empty($field['multiple']))
            ->pluck('collection')
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
                'thank_you',
                'groom_photo',
                'bride_photo',
                ...$templateCollections,
            )
            ->nonQueued();

        $this->addMediaConversion('gallery_web')
            ->width(1200)
            ->format('webp')->quality(82)
            ->performOnCollections('gallery', ...$templateMultipleCollections)
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

    public function getThankYouUrl(): ?string
    {
        return $this->getMediaUrlWithDemoFallback('thank_you') ?: null;
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
        return $this->getGeneratedQrUrl('groom')
            ?: $this->getMediaUrlWithDemoFallback('groom_qr')
            ?: asset('images/qr-placeholder.png');
    }

    public function getBrideQrUrl(): string
    {
        return $this->getGeneratedQrUrl('bride')
            ?: $this->getMediaUrlWithDemoFallback('bride_qr')
            ?: asset('images/qr-placeholder.png');
    }

    public function getGeneratedQrUrl(string $side): ?string
    {
        $prefix = $side === 'groom' ? 'groom' : 'bride';

        return VietQrService::quickLink(
            $this->getAttribute("{$prefix}_qr_bank_id"),
            $this->getAttribute("{$prefix}_qr_account_number"),
            $this->getAttribute("{$prefix}_qr_account_name"),
            $this->getAttribute("{$prefix}_qr_amount"),
            $this->getAttribute("{$prefix}_qr_add_info"),
        );
    }

    public function getQrPaymentInfo(string $side): ?string
    {
        $prefix = $side === 'groom' ? 'groom' : 'bride';

        return VietQrService::accountInfo(
            $this->getAttribute("{$prefix}_qr_bank_id"),
            $this->getAttribute("{$prefix}_qr_account_number"),
            $this->getAttribute("{$prefix}_qr_account_name"),
        ) ?: $this->getAttribute("{$prefix}_qr_info");
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

    public static function normalizeGuestCode(?string $code): ?string
    {
        $normalized = Str::of((string) $code)
            ->trim()
            ->lower()
            ->replaceMatches('/[^a-z0-9_-]+/', '-')
            ->trim('-_')
            ->toString();

        return $normalized !== '' ? $normalized : null;
    }

    public static function nextGuestCode(iterable $guests, string $prefix = 'km'): string
    {
        $prefix = Str::of($prefix)
            ->trim()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', '')
            ->toString() ?: 'km';

        $highestNumber = 0;
        $padding = 3;
        $usedCodes = [];

        foreach ($guests as $guest) {
            if (! is_array($guest)) {
                continue;
            }

            $code = self::normalizeGuestCode($guest['code'] ?? null);

            if (! $code) {
                continue;
            }

            $usedCodes[$code] = true;

            if (! preg_match('/^'.preg_quote($prefix, '/').'(\d+)$/', $code, $matches)) {
                continue;
            }

            $highestNumber = max($highestNumber, (int) $matches[1]);
            $padding = max($padding, strlen($matches[1]));
        }

        do {
            $highestNumber++;
            $nextCode = $prefix.str_pad((string) $highestNumber, $padding, '0', STR_PAD_LEFT);
        } while (isset($usedCodes[$nextCode]));

        return $nextCode;
    }

    public static function appendGuestNames(array $existingGuests, string $guestNames): array
    {
        $guests = array_values($existingGuests);
        $knownNames = [];

        foreach ($guests as $guest) {
            if (! is_array($guest)) {
                continue;
            }

            $nameKey = self::guestNameKey($guest['name'] ?? null);

            if ($nameKey !== '') {
                $knownNames[$nameKey] = true;
            }
        }

        foreach (preg_split('/\R/u', $guestNames) ?: [] as $line) {
            $name = preg_replace('/^\s*(?:(?:[-*•▪◦]+)|(?:\d+[.)]))\s*/u', '', $line);
            $name = trim(strip_tags((string) $name));
            $nameKey = self::guestNameKey($name);

            if ($nameKey === '' || isset($knownNames[$nameKey])) {
                continue;
            }

            $guests[] = [
                'code' => self::nextGuestCode($guests),
                'name' => $name,
            ];
            $knownNames[$nameKey] = true;
        }

        return $guests;
    }

    public function guestInvites(): array
    {
        $guests = $this->getContentValue('invited_guests', []);

        return is_array($guests) ? $guests : [];
    }

    public function hasGuestInvites(): bool
    {
        return collect($this->guestInvites())->contains(
            fn (mixed $guest): bool => is_array($guest)
                && filled($guest['code'] ?? null)
                && filled($guest['name'] ?? null)
        );
    }

    public function guestNameForCode(?string $code): ?string
    {
        $normalizedCode = self::normalizeGuestCode($code);

        if (! $normalizedCode) {
            return null;
        }

        foreach ($this->guestInvites() as $guest) {
            if (! is_array($guest)) {
                continue;
            }

            if (self::normalizeGuestCode($guest['code'] ?? null) !== $normalizedCode) {
                continue;
            }

            $name = trim(strip_tags((string) ($guest['name'] ?? '')));

            return $name !== '' ? $name : null;
        }

        return null;
    }

    public function guestInvitationUrl(string $code): string
    {
        return route('wedding.short.guest', [
            'slug' => $this->slug,
            'guestCode' => self::normalizeGuestCode($code) ?: $code,
        ]);
    }

    /**
     * URL thiệp theo thứ tự tên: cô dâu trước là thiệp nhà gái,
     * chú rể trước là thiệp nhà trai.
     */
    public function brideInvitationSlug(): string
    {
        return Str::slug(($this->bride_name ?? 'bride') . '-va-' . ($this->groom_name ?? 'groom'))
            . $this->invitationSlugSuffix();
    }

    public function groomInvitationSlug(): string
    {
        return Str::slug(($this->groom_name ?? 'groom') . '-va-' . ($this->bride_name ?? 'bride'))
            . $this->invitationSlugSuffix();
    }

    public function matchesInvitationSlug(string $slug): bool
    {
        $slug = Str::lower($slug);

        return in_array($slug, [
            Str::lower((string) $this->slug),
            $this->brideInvitationSlug(),
            $this->groomInvitationSlug(),
        ], true);
    }

    public function invitationSideForSlug(string $slug): string
    {
        $slug = Str::lower($slug);

        return match ($slug) {
            $this->brideInvitationSlug() => 'bride',
            $this->groomInvitationSlug() => 'groom',
            default => 'both',
        };
    }

    private function invitationSlugSuffix(): string
    {
        foreach ([$this->groomInvitationSlugBase(), $this->brideInvitationSlugBase()] as $baseSlug) {
            if (Str::startsWith((string) $this->slug, $baseSlug)) {
                return Str::after((string) $this->slug, $baseSlug);
            }
        }

        return '';
    }

    private function brideInvitationSlugBase(): string
    {
        return Str::slug(($this->bride_name ?? 'bride') . '-va-' . ($this->groom_name ?? 'groom'));
    }

    private function groomInvitationSlugBase(): string
    {
        return Str::slug(($this->groom_name ?? 'groom') . '-va-' . ($this->bride_name ?? 'bride'));
    }

    public function getGuestName(): ?string
    {
        $requestedGuest = $this->requestedGuestValue();

        if (! $requestedGuest) {
            return null;
        }

        if ($name = $this->guestNameForCode($requestedGuest)) {
            return $name;
        }

        if ($this->hasGuestInvites()) {
            return null;
        }

        return trim(strip_tags($requestedGuest)) ?: null;
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

    private function requestedGuestValue(): ?string
    {
        $guest = request()->route('guestCode')
            ?? request()->query('guest_code')
            ?? request()->query('guest');

        if (! is_string($guest)) {
            return null;
        }

        $guest = trim(urldecode($guest));

        return $guest !== '' ? $guest : null;
    }

    private static function guestNameKey(mixed $name): string
    {
        return Str::of(strip_tags((string) $name))
            ->squish()
            ->lower()
            ->toString();
    }
}
