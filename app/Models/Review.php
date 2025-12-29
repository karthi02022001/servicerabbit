<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reviews';

    protected $fillable = [
        'booking_id',
        'reviewer_id',
        'reviewee_id',
        'rating',
        'title',
        'comment',
        'quality_rating',
        'punctuality_rating',
        'communication_rating',
        'value_rating',
        'tasker_response',
        'responded_at',
        'status',
        'moderation_notes',
        'is_featured',
        'is_anonymous',
        'helpful_count',
    ];

    protected $casts = [
        'rating' => 'integer',
        'quality_rating' => 'integer',
        'punctuality_rating' => 'integer',
        'communication_rating' => 'integer',
        'value_rating' => 'integer',
        'responded_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_anonymous' => 'boolean',
        'helpful_count' => 'integer',
    ];

    /**
     * Get the booking that this review is for.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Get the user who wrote the review.
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * Get the user who received the review (tasker).
     */
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id');
    }

    /**
     * Get the helpful votes for this review.
     */
    public function helpfulVotes()
    {
        return $this->hasMany(ReviewHelpfulVote::class, 'review_id');
    }

    /**
     * Scope a query to only include approved reviews.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include pending reviews.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include featured reviews.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the average of all sub-ratings.
     */
    public function getAverageSubRatingAttribute()
    {
        $ratings = array_filter([
            $this->quality_rating,
            $this->punctuality_rating,
            $this->communication_rating,
            $this->value_rating,
        ]);

        return count($ratings) > 0 ? round(array_sum($ratings) / count($ratings), 1) : null;
    }

    /**
     * Check if the review has a response.
     */
    public function hasResponse()
    {
        return !empty($this->tasker_response);
    }

    /**
     * Get the display name for the reviewer.
     */
    public function getReviewerDisplayNameAttribute()
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }

        return $this->reviewer->first_name . ' ' . substr($this->reviewer->last_name, 0, 1) . '.';
    }
}
