<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'status',
        'method',
        'payment_details',
        'transaction_reference',
        'notes',
        'requested_at',
        'processed_at',
        'completed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns this payout.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted amount with currency
     */
    public function getFormattedAmountAttribute(): string
    {
        $symbol = match($this->currency) {
            'USD' => '$',
            'NGN' => '₦',
            'EUR' => '€',
            'GBP' => '£',
            default => $this->currency . ' '
        };
        
        return $symbol . number_format($this->amount, 2);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get method display name
     */
    public function getMethodDisplayNameAttribute(): string
    {
        return match($this->method) {
            'bank_transfer' => 'Bank Transfer',
            'paypal' => 'PayPal',
            'mobile_money' => 'Mobile Money',
            default => ucfirst(str_replace('_', ' ', $this->method))
        };
    }

    /**
     * Check if payout can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'processing']);
    }

    /**
     * Check if payout is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if payout is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Scope payouts by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope pending payouts
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope completed payouts
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Mark payout as processing
     */
    public function markAsProcessing(): void
    {
        $this->update([
            'status' => 'processing',
            'processed_at' => now(),
        ]);
    }

    /**
     * Mark payout as completed
     */
    public function markAsCompleted(string $transactionReference = null): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'transaction_reference' => $transactionReference ?? $this->transaction_reference,
        ]);
    }

    /**
     * Mark payout as failed
     */
    public function markAsFailed(string $reason = null): void
    {
        $this->update([
            'status' => 'failed',
            'notes' => $reason ? ($this->notes ? $this->notes . "\n" . $reason : $reason) : $this->notes,
        ]);
    }
}
