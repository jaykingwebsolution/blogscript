<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyArtist extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'name',
        'bio',
        'image_url',
        'genres',
        'popularity',
        'followers',
        'external_urls',
        'is_imported',
        'is_active',
        'last_synced_at',
        'local_artist_id'
    ];

    protected $casts = [
        'genres' => 'array',
        'external_urls' => 'array',
        'is_imported' => 'boolean',
        'is_active' => 'boolean',
        'last_synced_at' => 'datetime',
        'followers' => 'integer',
    ];

    // Relationships
    public function albums()
    {
        return $this->hasMany(SpotifyAlbum::class);
    }

    public function tracks()
    {
        return $this->hasMany(SpotifyTrack::class);
    }

    public function localArtist()
    {
        return $this->belongsTo(Artist::class, 'local_artist_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeImported($query)
    {
        return $query->where('is_imported', true);
    }

    public function scopeNeedsSync($query, $hours = 24)
    {
        return $query->where(function($q) use ($hours) {
            $q->whereNull('last_synced_at')
              ->orWhere('last_synced_at', '<', now()->subHours($hours));
        });
    }

    // Helper methods
    public function getSpotifyUrl()
    {
        return $this->external_urls['spotify'] ?? null;
    }

    public function getGenresString()
    {
        return $this->genres ? implode(', ', $this->genres) : '';
    }

    public function markAsSynced()
    {
        $this->update(['last_synced_at' => now()]);
    }

    /**
     * Get popular imported artists for homepage
     */
    public static function getFeatured($limit = 6)
    {
        return static::active()
            ->with(['albums', 'tracks'])
            ->orderByDesc('followers')
            ->orderByDesc('popularity')
            ->take($limit)
            ->get();
    }

    /**
     * Get recently imported artists
     */
    public static function getRecentlyImported($limit = 6)
    {
        return static::active()
            ->with(['albums', 'tracks'])
            ->latest()
            ->take($limit)
            ->get();
    }
}
