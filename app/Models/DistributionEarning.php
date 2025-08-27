<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionEarning extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_request_id',
        'user_id',
        'platform',
        'territory',
        'amount',
        'currency',
        'streams',
        'downloads',
        'period_start',
        'period_end',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'period_start' => 'date',
        'period_end' => 'date',
        'streams' => 'integer',
        'downloads' => 'integer',
    ];

    /**
     * Get the distribution request that generated this earning.
     */
    public function distributionRequest(): BelongsTo
    {
        return $this->belongsTo(DistributionRequest::class);
    }

    /**
     * Get the user that owns this earning.
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
     * Get the period description
     */
    public function getPeriodDescriptionAttribute(): string
    {
        return $this->period_start->format('M Y');
    }

    /**
     * Scope earnings by platform
     */
    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    /**
     * Scope earnings by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope earnings for a specific period
     */
    public function scopeForPeriod($query, $startDate, $endDate = null)
    {
        if ($endDate) {
            return $query->whereBetween('period_start', [$startDate, $endDate]);
        }
        
        return $query->where('period_start', '>=', $startDate);
    }

    /**
     * Get platform display name
     */
    public function getPlatformDisplayNameAttribute(): string
    {
        return match($this->platform) {
            'spotify' => 'Spotify',
            'apple_music' => 'Apple Music',
            'youtube_music' => 'YouTube Music',
            'amazon_music' => 'Amazon Music',
            'boomplay' => 'Boomplay',
            'audiomack' => 'Audiomack',
            'deezer' => 'Deezer',
            default => ucfirst(str_replace('_', ' ', $this->platform))
        };
    }
}
