<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeddingWish extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'name',
        'message',
        'is_approved',
        'ip_address',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function wedding()
    {
        return $this->belongsTo(Wedding::class);
    }

    /**
     * Scopes
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Approve this wish
     */
    public function approve(): void
    {
        $this->update(['is_approved' => true]);
    }

    /**
     * Reject/delete this wish
     */
    public function reject(): void
    {
        $this->delete();
    }
}
