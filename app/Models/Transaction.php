<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'transaction_number',
        'booking_id',
        'user_id',
        'tasker_id',
        'type',
        'amount',
        'currency',
        'status',
        'payment_method',
        'stripe_payment_intent_id',
        'stripe_charge_id',
        'stripe_refund_id',
        'stripe_transfer_id',
        'stripe_payout_id',
        'description',
        'metadata',
        'failure_reason',
        'parent_transaction_id',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the booking that this transaction belongs to.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Get the user associated with this transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the tasker associated with this transaction.
     */
    public function tasker()
    {
        return $this->belongsTo(User::class, 'tasker_id');
    }

    /**
     * Get the parent transaction.
     */
    public function parentTransaction()
    {
        return $this->belongsTo(Transaction::class, 'parent_transaction_id');
    }

    /**
     * Get the child transactions.
     */
    public function childTransactions()
    {
        return $this->hasMany(Transaction::class, 'parent_transaction_id');
    }

    /**
     * Get the wallet transactions related to this transaction.
     */
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class, 'transaction_id');
    }

    /**
     * Generate a unique transaction number.
     */
    public static function generateTransactionNumber()
    {
        $prefix = match (true) {
            true => 'TXN',
        };

        do {
            $number = $prefix . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
        } while (self::where('transaction_number', $number)->exists());

        return $number;
    }

    /**
     * Scope a query to filter by type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include completed transactions.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include pending transactions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'processing' => 'bg-info',
            'completed' => 'bg-success',
            'failed' => 'bg-danger',
            'cancelled' => 'bg-secondary',
            'refunded' => 'bg-secondary',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the type badge class.
     */
    public function getTypeBadgeClassAttribute()
    {
        return match ($this->type) {
            'payment' => 'bg-primary',
            'capture' => 'bg-success',
            'refund' => 'bg-warning',
            'payout' => 'bg-info',
            'commission' => 'bg-secondary',
            'cancellation_fee' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
