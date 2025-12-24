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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('groom_photo')->singleFile();
        $this->addMediaCollection('bride_photo')->singleFile();
        $this->addMediaCollection('groom_qr')->singleFile();
        $this->addMediaCollection('bride_qr')->singleFile();
        $this->addMediaCollection('gallery');
    }

    protected static function booted()
    {
        static::saving(function ($wedding) {
            // Auto calculate lunar date
            if ($wedding->event_date) {
                try {
                    $lunar = new \LucNham\LunarCalendar\LunarDateTime($wedding->event_date);
                    $wedding->event_date_lunar = $lunar->day . '/' . $lunar->month . ' ' . $lunar->canChiYear; 
                } catch (\Exception $e) {
                    \Log::error('Lunar date error: ' . $e->getMessage());
                }
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
