<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpotifyPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'spotify_id',
        'title',
        'artist_name',
        'description',
        'album_name',
        'image_url',
        'spotify_url',
        'preview_url',
        'release_date',
        'artists',
        'genres',
        'type',
        'popularity',
        'is_featured'
    ];

    protected $casts = [
        'artists' => 'array',
        'genres' => 'array',
        'release_date' => 'date',
        'is_featured' => 'boolean',
        'popularity' => 'integer'
    ];

    public function getArtistNamesAttribute()
    {
        if (is_array($this->artists)) {
            return implode(', ', array_column($this->artists, 'name'));
        }
        
        return $this->artist_name;
    }

    public function getGenreListAttribute()
    {
        if (is_array($this->genres)) {
            return implode(', ', $this->genres);
        }
        
        return '';
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    public function scopePopular($query, $minPopularity = 50)
    {
        return $query->where('popularity', '>=', $minPopularity);
    }

    public static function getLatest($limit = 10)
    {
        return static::latest('release_date')
                    ->latest('created_at')
                    ->limit($limit)
                    ->get();
    }

    public static function getFeatured($limit = 5)
    {
        return static::featured()
                    ->latest('created_at')
                    ->limit($limit)
                    ->get();
    }

    public function getImageUrlOrDefaultAttribute()
    {
        return $this->image_url ?: asset('images/default-music.jpg');
    }
}
