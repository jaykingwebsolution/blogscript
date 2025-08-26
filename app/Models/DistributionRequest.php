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
        'release_date',
        'cover_image',
        'audio_file',
        'description',
        'status',
        'notes',
    ];

    protected $casts = [
        'release_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the distribution request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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
}
