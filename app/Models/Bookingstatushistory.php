<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'booking_status_history';

    public $timestamps = false;

    protected $fillable = [
        'booking_id',
        'from_status',
        'to_status',
        'changed_by_type',
        'changed_by_id',
        'reason',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the booking that this history belongs to.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Record a status change for a booking.
     */
    public static function recordChange(Booking $booking, string $toStatus, string $changedByType, ?int $changedById = null, ?string $reason = null, ?array $metadata = null)
    {
        return self::create([
            'booking_id' => $booking->id,
            'from_status' => $booking->status,
            'to_status' => $toStatus,
            'changed_by_type' => $changedByType,
            'changed_by_id' => $changedById,
            'reason' => $reason,
            'metadata' => $metadata,
            'created_at' => now(),
        ]);
    }
}
