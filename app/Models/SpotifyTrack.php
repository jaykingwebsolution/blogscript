<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'name',
        'duration_ms',
        'track_number',
        'disc_number',
        'explicit',
        'preview_url',
        'popularity',
        'external_urls',
        'featured_artists',
        'is_imported',
        'is_active',
        'last_synced_at',
        'spotify_artist_id',
        'spotify_album_id',
        'local_music_id'
    ];

    protected $casts = [
        'external_urls' => 'array',
        'featured_artists' => 'array',
        'is_imported' => 'boolean',
        'is_active' => 'boolean',
        'explicit' => 'boolean',
        'last_synced_at' => 'datetime',
        'duration_ms' => 'integer',
        'track_number' => 'integer',
        'disc_number' => 'integer',
        'popularity' => 'integer',
    ];

    // Relationships
    public function artist()
    {
        return $this->belongsTo(SpotifyArtist::class, 'spotify_artist_id');
    }

    public function album()
    {
        return $this->belongsTo(SpotifyAlbum::class, 'spotify_album_id');
    }

    public function localMusic()
    {
        return $this->belongsTo(Music::class, 'local_music_id');
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

    public function scopePopular($query, $threshold = 50)
    {
        return $query->where('popularity', '>=', $threshold);
    }

    public function scopeWithPreview($query)
    {
        return $query->whereNotNull('preview_url');
    }

    public function scopeExplicit($query, $explicit = true)
    {
        return $query->where('explicit', $explicit);
    }

    // Helper methods
    public function getSpotifyUrl()
    {
        return $this->external_urls['spotify'] ?? null;
    }

    public function getDurationInMinutes()
    {
        if (!$this->duration_ms) return null;
        return round($this->duration_ms / 60000, 2);
    }

    public function getDurationFormatted()
    {
        if (!$this->duration_ms) return 'Unknown';
        
        $minutes = floor($this->duration_ms / 60000);
        $seconds = floor(($this->duration_ms % 60000) / 1000);
        
        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function hasFeaturedArtists()
    {
        return !empty($this->featured_artists);
    }

    public function getFeaturedArtistsString()
    {
        if (!$this->hasFeaturedArtists()) return '';
        
        $names = array_map(function($artist) {
            return $artist['name'] ?? 'Unknown';
        }, $this->featured_artists);
        
        return implode(', ', $names);
    }

    public function markAsSynced()
    {
        $this->update(['last_synced_at' => now()]);
    }
}
