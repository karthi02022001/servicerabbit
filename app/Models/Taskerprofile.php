<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TaskerProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'tasker_profiles';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'headline',
        'professional_bio',
        'years_of_experience',
        'hourly_rate_min',
        'hourly_rate_max',
        'verification_status',
        'verified_at',
        'rejection_reason',
        'id_document_type',
        'id_document_front',
        'id_document_back',
        'id_verified',
        'id_verified_at',
        'background_check_status',
        'background_check_date',
        'work_radius_km',
        'is_available',
        'instant_booking',
        'has_vehicle',
        'vehicle_type',
        'vehicle_description',
        'stripe_account_id',
        'stripe_account_status',
        'stripe_onboarding_completed',
        'total_reviews',
        'average_rating',
        'total_completed_tasks',
        'completion_rate',
        'response_time_hours',
        'step_profile_completed',
        'step_categories_completed',
        'step_availability_completed',
        'step_payment_completed',
        'is_featured',
        'featured_until',
        'rank_score',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'verified_at' => 'datetime',
            'id_verified_at' => 'datetime',
            'background_check_date' => 'date',
            'is_available' => 'boolean',
            'instant_booking' => 'boolean',
            'has_vehicle' => 'boolean',
            'stripe_onboarding_completed' => 'boolean',
            'step_profile_completed' => 'boolean',
            'step_categories_completed' => 'boolean',
            'step_availability_completed' => 'boolean',
            'step_payment_completed' => 'boolean',
            'is_featured' => 'boolean',
            'id_verified' => 'boolean',
            'featured_until' => 'datetime',
            'hourly_rate_min' => 'decimal:2',
            'hourly_rate_max' => 'decimal:2',
            'average_rating' => 'decimal:2',
            'completion_rate' => 'decimal:2',
            'response_time_hours' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the tasker profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services for the tasker profile.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Get the availabilities for the tasker.
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(TaskerAvailability::class);
    }

    /**
     * Get the blocked dates for the tasker.
     */
    public function blockedDates(): HasMany
    {
        return $this->hasMany(TaskerBlockedDate::class);
    }

    /**
     * Check if tasker registration is complete.
     */
    public function isRegistrationComplete(): bool
    {
        return $this->step_profile_completed
            && $this->step_categories_completed
            && $this->step_availability_completed
            && $this->step_payment_completed;
    }

    /**
     * Get the next incomplete step.
     */
    public function getNextIncompleteStep(): int
    {
        if (!$this->step_profile_completed) return 1;
        if (!$this->step_categories_completed) return 2;
        if (!$this->step_availability_completed) return 3;
        if (!$this->step_payment_completed) return 4;
        return 5; // All complete
    }

    /**
     * Check if tasker is verified.
     */
    public function isVerified(): bool
    {
        return $this->verification_status === 'approved';
    }

    /**
     * Check if tasker is pending verification.
     */
    public function isPendingVerification(): bool
    {
        return $this->verification_status === 'submitted';
    }

    /**
     * Scope for verified taskers.
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'approved');
    }

    /**
     * Scope for available taskers.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for featured taskers.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->where(function ($q) {
                $q->whereNull('featured_until')
                    ->orWhere('featured_until', '>', now());
            });
    }
}
