<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bookings';

    protected $fillable = [
        'booking_number',
        'user_id',
        'tasker_id',
        'service_id',
        'category_id',
        'subcategory_id',
        'booking_date',
        'start_time',
        'end_time',
        'estimated_hours',
        'actual_hours',
        'task_description',
        'special_instructions',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country_code',
        'latitude',
        'longitude',
        'contact_phone',
        'vehicle_required',
        'vehicle_type',
        'hourly_rate',
        'service_fee_percentage',
        'service_fee_amount',
        'subtotal',
        'tax_amount',
        'total_amount',
        'currency',
        'commission_percentage',
        'commission_amount',
        'tasker_payout',
        'status',
        'status_changed_at',
        'status_reason',
        'cancelled_by',
        'cancelled_at',
        'cancellation_reason',
        'cancellation_fee',
        'is_before_deadline_cancel',
        'started_at',
        'completed_at',
        'stripe_payment_intent_id',
        'stripe_customer_id',
        'metadata',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'vehicle_required' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'service_fee_percentage' => 'decimal:2',
        'service_fee_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'tasker_payout' => 'decimal:2',
        'cancellation_fee' => 'decimal:2',
        'is_before_deadline_cancel' => 'boolean',
        'status_changed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user (customer) that made this booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tasker for this booking.
     */
    public function tasker()
    {
        return $this->belongsTo(User::class, 'tasker_id');
    }

    /**
     * Get the service for this booking.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Get the category for this booking.
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    /**
     * Get the subcategory for this booking.
     */
    public function subcategory()
    {
        return $this->belongsTo(TaskSubcategory::class, 'subcategory_id');
    }

    /**
     * Get the review for this booking.
     */
    public function review()
    {
        return $this->hasOne(Review::class, 'booking_id');
    }

    /**
     * Get the transactions for this booking.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'booking_id');
    }

    /**
     * Get the status history for this booking.
     */
    public function statusHistory()
    {
        return $this->hasMany(BookingStatusHistory::class, 'booking_id');
    }

    /**
     * Get the conversation for this booking.
     */
    public function conversation()
    {
        return $this->hasOne(Conversation::class, 'booking_id');
    }

    /**
     * Generate a unique booking number.
     */
    public static function generateBookingNumber()
    {
        do {
            $number = 'SR' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
        } while (self::where('booking_number', $number)->exists());

        return $number;
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include accepted bookings.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    /**
     * Scope a query to only include paid bookings.
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled bookings.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query for upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->whereIn('status', ['accepted', 'paid'])
            ->where('booking_date', '>=', now()->toDateString())
            ->orderBy('booking_date')
            ->orderBy('start_time');
    }

    /**
     * Check if the booking can be cancelled.
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'accepted', 'paid']);
    }

    /**
     * Check if the booking can be reviewed.
     */
    public function canBeReviewed()
    {
        return $this->status === 'completed' && !$this->review;
    }

    /**
     * Get the full address.
     */
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'accepted' => 'bg-info',
            'declined' => 'bg-danger',
            'paid' => 'bg-success',
            'in_progress' => 'bg-primary',
            'completed' => 'bg-success',
            'cancelled' => 'bg-secondary',
            'disputed' => 'bg-danger',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }
}
