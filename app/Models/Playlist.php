<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'visibility',
        'user_id',
        'slug',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($playlist) {
            if (empty($playlist->slug)) {
                $playlist->slug = Str::slug($playlist->title);
                
                // Ensure slug is unique
                $originalSlug = $playlist->slug;
                $counter = 1;
                while (static::where('slug', $playlist->slug)->exists()) {
                    $playlist->slug = $originalSlug . '-' . $counter++;
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function music()
    {
        return $this->belongsToMany(Music::class, 'playlist_music')
                    ->withPivot('order_in_playlist')
                    ->withTimestamps()
                    ->orderBy('playlist_music.order_in_playlist');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function isUnlisted()
    {
        return $this->visibility === 'unlisted';
    }

    public function canBeViewedBy($user = null)
    {
        if ($this->isPublic()) {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($this->user_id === $user->id) {
            return true;
        }

        return false;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        return asset('images/default-playlist.svg');
    }

    public function getMusicCountAttribute()
    {
        return $this->music()->count();
    }

    public function getTotalDurationAttribute()
    {
        return $this->music()->sum('duration') ?? 0;
    }

    public function getFormattedDurationAttribute()
    {
        $totalSeconds = $this->total_duration;
        $hours = intval($totalSeconds / 3600);
        $minutes = intval(($totalSeconds % 3600) / 60);
        
        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }
        
        return "{$minutes} min";
    }
}
