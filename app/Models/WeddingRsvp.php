<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeddingRsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'name',
        'phone',
        'attendance',
        'guests',
        'side',
        'note',
        'ip_address',
    ];

    // Attendance constants
    const ATTENDANCE_YES = 'yes';
    const ATTENDANCE_NO = 'no';
    const ATTENDANCE_MAYBE = 'maybe';

    // Side constants
    const SIDE_GROOM = 'groom';
    const SIDE_BRIDE = 'bride';
    const SIDE_BOTH = 'both';

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
    public function scopeAttending($query)
    {
        return $query->where('attendance', self::ATTENDANCE_YES);
    }

    public function scopeGroomSide($query)
    {
        return $query->whereIn('side', [self::SIDE_GROOM, self::SIDE_BOTH]);
    }

    public function scopeBrideSide($query)
    {
        return $query->whereIn('side', [self::SIDE_BRIDE, self::SIDE_BOTH]);
    }

    /**
     * Get display text for attendance
     */
    public function getAttendanceTextAttribute(): string
    {
        return match($this->attendance) {
            self::ATTENDANCE_YES => 'Sẽ tham dự',
            self::ATTENDANCE_NO => 'Không thể đến',
            self::ATTENDANCE_MAYBE => 'Chưa chắc chắn',
            default => 'Không xác định',
        };
    }

    /**
     * Get display text for side
     */
    public function getSideTextAttribute(): string
    {
        return match($this->side) {
            self::SIDE_GROOM => 'Nhà trai',
            self::SIDE_BRIDE => 'Nhà gái',
            self::SIDE_BOTH => 'Cả hai bên',
            default => 'Không xác định',
        };
    }
}
