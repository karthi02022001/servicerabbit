<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'task_categories';

    protected $fillable = [
        'slug',
        'name',
        'description',
        'short_description',
        'icon',
        'image',
        'color',
        'avg_hourly_rate',
        'commission_percentage',
        'cancellation_fee_percentage',
        'vehicle_required',
        'background_check_required',
        'sort_order',
        'is_featured',
        'status',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'avg_hourly_rate' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'cancellation_fee_percentage' => 'decimal:2',
        'vehicle_required' => 'boolean',
        'background_check_required' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Get the subcategories for this category.
     */
    public function subcategories()
    {
        return $this->hasMany(TaskSubcategory::class, 'category_id');
    }

    /**
     * Get the services for this category.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }

    /**
     * Get the bookings for this category.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'category_id');
    }

    /**
     * Scope a query to only include active categories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured categories.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get tasker count for this category.
     */
    public function getTaskerCountAttribute()
    {
        return $this->services()
            ->whereHas('taskerProfile', function ($query) {
                $query->where('verification_status', 'approved')
                    ->where('is_available', true);
            })
            ->distinct('tasker_profile_id')
            ->count('tasker_profile_id');
    }
}
