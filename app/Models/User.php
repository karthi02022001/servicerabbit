<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'avatar',
        'date_of_birth',
        'gender',
        'bio',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country_code',
        'latitude',
        'longitude',
        'is_tasker',
        'is_active',
        'google_id',
        'facebook_id',
        'apple_id',
        'stripe_customer_id',
        'device_type',
        'device_token',
        'notification_preferences',
        'locale',
        'timezone',
        'last_login_at',
        'last_login_ip',
        'otp',
        'otp_expires_at',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'is_tasker' => 'boolean',
            'is_active' => 'boolean',
            'notification_preferences' => 'array',
            'last_login_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'password' => 'hashed',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's initials.
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    /**
     * Get the avatar URL with fallback to default.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->full_name) . '&background=FF6B35&color=fff&size=150';
    }

    /**
     * Check if the user is a tasker.
     */
    public function isTasker(): bool
    {
        return $this->is_tasker && $this->taskerProfile()->exists();
    }

    /**
     * Check if the tasker is verified.
     */
    public function isVerifiedTasker(): bool
    {
        if (!$this->is_tasker) {
            return false;
        }

        $profile = $this->taskerProfile;
        return $profile && $profile->verification_status === 'approved';
    }

    /**
     * Get the tasker profile.
     */
    public function taskerProfile(): HasOne
    {
        return $this->hasOne(TaskerProfile::class);
    }

    /**
     * Get bookings as a customer.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Get bookings as a tasker.
     */
    public function taskerBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'tasker_id');
    }

    /**
     * Get reviews written by the user.
     */
    public function reviewsWritten(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /**
     * Get reviews received (as tasker).
     */
    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    /**
     * Get user's wallet.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get user's payment methods.
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(PaymentMethod::class);
    }

    /**
     * Get conversations where user is the customer.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }

    /**
     * Get conversations where user is the tasker.
     */
    public function taskerConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'tasker_id');
    }

    /**
     * Update last login info.
     */
    public function updateLastLogin(string $ipAddress): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ipAddress,
        ]);
    }

    /**
     * Scope for active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for taskers.
     */
    public function scopeTaskers($query)
    {
        return $query->where('is_tasker', true);
    }

    /**
     * Scope for regular users (not taskers).
     */
    public function scopeRegularUsers($query)
    {
        return $query->where('is_tasker', false);
    }
}
