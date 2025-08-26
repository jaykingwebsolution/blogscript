<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'name',
        'description',
        'album_type',
        'image_url',
        'release_date',
        'release_date_precision',
        'total_tracks',
        'genres',
        'external_urls',
        'is_imported',
        'is_active',
        'last_synced_at',
        'spotify_artist_id'
    ];

    protected $casts = [
        'genres' => 'array',
        'external_urls' => 'array',
        'is_imported' => 'boolean',
        'is_active' => 'boolean',
        'last_synced_at' => 'datetime',
        'release_date' => 'date',
        'total_tracks' => 'integer',
    ];

    // Relationships
    public function artist()
    {
        return $this->belongsTo(SpotifyArtist::class, 'spotify_artist_id');
    }

    public function tracks()
    {
        return $this->hasMany(SpotifyTrack::class);
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

    public function scopeByType($query, $type)
    {
        return $query->where('album_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('release_date', '>=', now()->subDays($days));
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

    public function isAlbum()
    {
        return $this->album_type === 'album';
    }

    public function isSingle()
    {
        return $this->album_type === 'single';
    }

    public function isCompilation()
    {
        return $this->album_type === 'compilation';
    }

    public function markAsSynced()
    {
        $this->update(['last_synced_at' => now()]);
    }
}
