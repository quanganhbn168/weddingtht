<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'request_id',
        'trans_id',
        'gateway',
        'plan',
        'amount',
        'status',
        'pay_type',
        'response_data',
        'paid_at',
    ];

    protected $casts = [
        'response_data' => 'array',
        'paid_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if payment was successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }

    /**
     * Mark as successful
     */
    public function markAsSuccessful(string $transId, ?string $payType = null, ?array $responseData = null): void
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
            'trans_id' => $transId,
            'pay_type' => $payType,
            'response_data' => $responseData,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed(?array $responseData = null): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'response_data' => $responseData,
        ]);
    }
}
