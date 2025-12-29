<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskSubcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'task_subcategories';

    protected $fillable = [
        'category_id',
        'slug',
        'name',
        'description',
        'image',
        'sort_order',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    /**
     * Get the category that this subcategory belongs to.
     */
    public function category()
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    /**
     * Get the services for this subcategory.
     */
    public function services()
    {
        return $this->hasMany(Service::class, 'subcategory_id');
    }

    /**
     * Get the bookings for this subcategory.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'subcategory_id');
    }

    /**
     * Scope a query to only include active subcategories.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured subcategories.
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
}
