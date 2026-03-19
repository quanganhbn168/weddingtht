<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SharedMusic extends Model
{
    protected $table = 'shared_musics';

    protected $fillable = [
        'title',
        'artist',
        'file_path',
        'category',
        'file_size',
        'duration',
        'is_active',
        'usage_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'file_size' => 'integer',
        'usage_count' => 'integer',
    ];

    /**
     * Get public URL of the music file
     */
    public function getUrl(): string
    {
        // Support both local storage and full URLs
        if (str_starts_with($this->file_path, 'http')) {
            return $this->file_path;
        }
        return Storage::disk('public')->url($this->file_path);
    }

    /**
     * Display label: "Title - Artist"
     */
    public function getLabel(): string
    {
        return $this->artist ? "{$this->title} - {$this->artist}" : $this->title;
    }

    /**
     * Format file size for display
     */
    public function getFileSizeLabel(): string
    {
        if (!$this->file_size) return '';
        $mb = round($this->file_size / 1048576, 1);
        return "{$mb} MB";
    }

    /**
     * Increment usage counter
     */
    public function incrementUsage(): void
    {
        $this->increment('usage_count');
    }

    /**
     * Scope: active only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: by category
     */
    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Categories for display
     */
    public static function categories(): array
    {
        return [
            'romantic'     => 'Lãng mạn',
            'traditional'  => 'Truyền thống',
            'modern'       => 'Hiện đại',
            'instrumental' => 'Nhạc không lời',
            'ballad'       => 'Ballad',
        ];
    }
}
