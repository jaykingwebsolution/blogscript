<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'artist_name',
        'song_title',
        'genre',
        'isrc',
        'upc',
        'contributors',
        'explicit_content',
        'territories',
        'record_label',
        'lyrics',
        'release_date',
        'cover_image',
        'audio_file',
        'description',
        'status',
        'notes',
        'dsp_delivery_status',
        'dsp_platforms',
        'delivered_at',
        'distribution_fee',
        'aggregator_provider',
        'aggregator_release_id',
        'aggregator_response',
    ];

    protected $casts = [
        'release_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'contributors' => 'array',
        'territories' => 'array',
        'explicit_content' => 'boolean',
        'dsp_platforms' => 'array',
        'delivered_at' => 'datetime',
        'distribution_fee' => 'decimal:2',
        'aggregator_response' => 'array',
    ];

    /**
     * Get the user that owns the distribution request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assets associated with this distribution request.
     */
    public function assets()
    {
        return $this->hasMany(DistributionAsset::class);
    }

    /**
     * Get the earnings associated with this distribution request.
     */
    public function earnings()
    {
        return $this->hasMany(DistributionEarning::class);
    }

    /**
     * Get the audio asset
     */
    public function audioAsset()
    {
        return $this->assets()->where('asset_type', 'audio')->first();
    }

    /**
     * Get the cover image asset
     */
    public function coverImageAsset()
    {
        return $this->assets()->where('asset_type', 'cover_image')->first();
    }

    /**
     * Scope a query to only include pending requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved requests.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include declined requests.
     */
    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    /**
     * Check if the request is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the request is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if the request is declined.
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Get the status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'declined' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the available genres for distribution.
     */
    public static function getGenres(): array
    {
        return [
            'Afrobeats' => 'Afrobeats',
            'Hip Hop' => 'Hip Hop',
            'R&B' => 'R&B',
            'Pop' => 'Pop',
            'Reggae' => 'Reggae',
            'Dancehall' => 'Dancehall',
            'Gospel' => 'Gospel',
            'Highlife' => 'Highlife',
            'Fuji' => 'Fuji',
            'Juju' => 'Juju',
            'Apala' => 'Apala',
            'Afro-pop' => 'Afro-pop',
            'Amapiano' => 'Amapiano',
            'Afro-house' => 'Afro-house',
            'Alternative' => 'Alternative',
            'Electronic' => 'Electronic',
            'Jazz' => 'Jazz',
            'Blues' => 'Blues',
            'Country' => 'Country',
            'Folk' => 'Folk',
            'Other' => 'Other',
        ];
    }

    /**
     * Check if DSP delivery is pending
     */
    public function isDspDeliveryPending(): bool
    {
        return $this->dsp_delivery_status === 'pending';
    }

    /**
     * Check if DSP delivery is delivered
     */
    public function isDspDelivered(): bool
    {
        return $this->dsp_delivery_status === 'delivered';
    }

    /**
     * Get DSP delivery status color
     */
    public function getDspDeliveryStatusColorAttribute(): string
    {
        return match ($this->dsp_delivery_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'delivered' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get total earnings for this release
     */
    public function getTotalEarningsAttribute(): float
    {
        return $this->earnings()->where('status', 'confirmed')->sum('amount');
    }

    /**
     * Get formatted total earnings
     */
    public function getFormattedTotalEarningsAttribute(): string
    {
        $total = $this->total_earnings;
        return '$' . number_format($total, 2);
    }

    /**
     * Get contributors as formatted string
     */
    public function getFormattedContributorsAttribute(): string
    {
        if (!$this->contributors) {
            return '';
        }

        $contributors = collect($this->contributors);
        return $contributors->pluck('name')->implode(', ');
    }

    /**
     * Get territories as formatted string
     */
    public function getFormattedTerritoriesAttribute(): string
    {
        if (!$this->territories) {
            return 'Worldwide';
        }

        $territories = collect($this->territories);
        return $territories->implode(', ');
    }

    /**
     * Check if explicit content
     */
    public function isExplicit(): bool
    {
        return $this->explicit_content === true;
    }
}
