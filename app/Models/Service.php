<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'tasker_profile_id',
        'category_id',
        'subcategory_id',
        'title',
        'description',
        'pricing_type',
        'hourly_rate',
        'fixed_price',
        'minimum_hours',
        'experience_years',
        'experience_description',
        'is_active',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'fixed_price' => 'decimal:2',
        'minimum_hours' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the tasker profile that owns this service.
     */
    public function taskerProfile()
    {
        return $this->belongsTo(TaskerProfile::class, 'tasker_profile_id');
    }

    /**
     * Get the tasker (user) that provides this service.
     */
    public function tasker()
    {
        return $this->hasOneThrough(User::class, TaskerProfile::class, 'id', 'id', 'tasker_profile_id', 'user_id');
    }

    /**
     * Get the category for this service.
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    /**
     * Get the subcategory for this service.
     */
    public function subcategory()
    {
        return $this->belongsTo(TaskSubcategory::class, 'subcategory_id');
    }

    /**
     * Get the bookings for this service.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'service_id');
    }

    /**
     * Get the images for this service.
     */
    public function images()
    {
        return $this->hasMany(ServiceImage::class, 'service_id');
    }

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include hourly services.
     */
    public function scopeHourly($query)
    {
        return $query->where('pricing_type', 'hourly');
    }

    /**
     * Get the display price for this service.
     */
    public function getDisplayPriceAttribute()
    {
        if ($this->pricing_type === 'hourly') {
            return '$' . number_format($this->hourly_rate, 2) . '/hr';
        } elseif ($this->pricing_type === 'fixed') {
            return '$' . number_format($this->fixed_price, 2);
        }
        return 'Quote';
    }
}
