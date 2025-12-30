<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskerAvailability extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'tasker_availabilities';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tasker_profile_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_available',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'day_of_week' => 'integer',
            'is_available' => 'boolean',
        ];
    }

    /**
     * Get the tasker profile that owns this availability.
     */
    public function taskerProfile(): BelongsTo
    {
        return $this->belongsTo(TaskerProfile::class);
    }

    /**
     * Get the day name.
     */
    public function getDayNameAttribute(): string
    {
        $days = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];

        return $days[$this->day_of_week] ?? 'Unknown';
    }

    /**
     * Get formatted time range.
     */
    public function getTimeRangeAttribute(): string
    {
        $start = date('g:i A', strtotime($this->start_time));
        $end = date('g:i A', strtotime($this->end_time));
        return "{$start} - {$end}";
    }

    /**
     * Scope for available slots.
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for a specific day.
     */
    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }
}
