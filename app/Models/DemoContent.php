<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DemoContent extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
        $this->addMediaCollection('hero')->singleFile();
        $this->addMediaCollection('groom_photo')->singleFile();
        $this->addMediaCollection('bride_photo')->singleFile();
        $this->addMediaCollection('groom_qr')->singleFile();
        $this->addMediaCollection('bride_qr')->singleFile();
        $this->addMediaCollection('demo_gallery');
    }

    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        // Conversion for OG Share Image (1200x630) - Only for Cover image
        $this->addMediaConversion('share')
            ->width(1200)
            ->height(630)
            ->sharpen(10)
            ->performOnCollections('cover')
            ->nonQueued();

        // Conversion for Hero/Portrait images (optimized web banner - Vertical 9:16)
        $this->addMediaConversion('optimized')
            ->width(1080)
            ->height(1920)
            ->sharpen(10)
            ->performOnCollections('hero', 'groom_photo', 'bride_photo')
            ->nonQueued();
            
        // Thumbnails for gallery or admin view - Global
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->nonQueued();
    }
}
