<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskerBlockedDate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'tasker_blocked_dates';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tasker_profile_id',
        'blocked_date',
        'start_time',
        'end_time',
        'reason',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'blocked_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the tasker profile that owns this blocked date.
     */
    public function taskerProfile(): BelongsTo
    {
        return $this->belongsTo(TaskerProfile::class, 'tasker_profile_id');
    }

    /**
     * Scope for full day blocks.
     */
    public function scopeFullDay($query)
    {
        return $query->whereNull('start_time')->whereNull('end_time');
    }

    /**
     * Scope for partial day blocks.
     */
    public function scopePartialDay($query)
    {
        return $query->whereNotNull('start_time')->whereNotNull('end_time');
    }

    /**
     * Scope for upcoming blocked dates.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('blocked_date', '>=', now()->toDateString())
            ->orderBy('blocked_date');
    }

    /**
     * Check if this is a full day block.
     */
    public function isFullDay(): bool
    {
        return is_null($this->start_time) && is_null($this->end_time);
    }

    /**
     * Get formatted time range.
     */
    public function getTimeRangeAttribute(): string
    {
        if ($this->isFullDay()) {
            return 'All Day';
        }

        $start = $this->start_time ? date('g:i A', strtotime($this->start_time)) : '';
        $end = $this->end_time ? date('g:i A', strtotime($this->end_time)) : '';

        return "{$start} - {$end}";
    }
}
