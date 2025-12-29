<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    protected $fillable = [
        'user_id',
        'available_balance',
        'pending_balance',
        'total_earned',
        'total_withdrawn',
        'currency',
        'is_active',
        'last_transaction_at',
    ];

    protected $casts = [
        'available_balance' => 'decimal:2',
        'pending_balance' => 'decimal:2',
        'total_earned' => 'decimal:2',
        'total_withdrawn' => 'decimal:2',
        'is_active' => 'boolean',
        'last_transaction_at' => 'datetime',
    ];

    /**
     * Get the user that owns this wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the wallet transactions.
     */
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id');
    }

    /**
     * Credit amount to the wallet.
     */
    public function credit(float $amount, string $category, ?int $bookingId = null, ?int $transactionId = null, ?string $description = null)
    {
        $balanceBefore = $this->available_balance;
        $this->available_balance += $amount;
        $this->total_earned += $amount;
        $this->last_transaction_at = now();
        $this->save();

        return WalletTransaction::create([
            'wallet_id' => $this->id,
            'transaction_id' => $transactionId,
            'booking_id' => $bookingId,
            'type' => 'credit',
            'category' => $category,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->available_balance,
            'description' => $description,
        ]);
    }

    /**
     * Debit amount from the wallet.
     */
    public function debit(float $amount, string $category, ?int $bookingId = null, ?int $transactionId = null, ?string $description = null)
    {
        if ($this->available_balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        $balanceBefore = $this->available_balance;
        $this->available_balance -= $amount;
        $this->total_withdrawn += $amount;
        $this->last_transaction_at = now();
        $this->save();

        return WalletTransaction::create([
            'wallet_id' => $this->id,
            'transaction_id' => $transactionId,
            'booking_id' => $bookingId,
            'type' => 'debit',
            'category' => $category,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->available_balance,
            'description' => $description,
        ]);
    }

    /**
     * Add to pending balance.
     */
    public function addPending(float $amount)
    {
        $this->pending_balance += $amount;
        $this->save();
    }

    /**
     * Release pending to available.
     */
    public function releasePending(float $amount)
    {
        if ($this->pending_balance < $amount) {
            $amount = $this->pending_balance;
        }

        $this->pending_balance -= $amount;
        $this->available_balance += $amount;
        $this->save();
    }

    /**
     * Get total balance (available + pending).
     */
    public function getTotalBalanceAttribute()
    {
        return $this->available_balance + $this->pending_balance;
    }

    /**
     * Check if wallet has sufficient balance.
     */
    public function hasSufficientBalance(float $amount)
    {
        return $this->available_balance >= $amount;
    }
}