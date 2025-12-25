<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Helpers\LunarHelper;
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
        'groom_reception_time' => 'datetime', // Cast to Carbon instance for format()
        'bride_reception_time' => 'datetime',
        'groom_ceremony_time' => 'datetime',
        'bride_ceremony_time' => 'datetime',
        'content' => 'array',
        'is_active' => 'boolean',
    ];

    public function template(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Template::class);
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
}
