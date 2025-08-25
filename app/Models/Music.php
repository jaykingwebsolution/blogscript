<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Music extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'artist_id',
        'artist_name',
        'category_id',
        'image_url',
        'cover_image',
        'audio_url',
        'audio_file',
        'duration',
        'genre',
        'is_featured',
        'status',
        'created_by',
        'release_date'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'release_date' => 'date',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'draft');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'music_tags');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($music) {
            if (empty($music->slug)) {
                $music->slug = static::generateUniqueSlug($music->title);
            }
        });

        static::updating(function ($music) {
            if (empty($music->slug) || $music->isDirty('title')) {
                $music->slug = static::generateUniqueSlug($music->title, $music->id);
            }
        });
    }

    /**
     * Generate a unique slug from the title.
     */
    protected static function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->when($ignoreId, function ($query, $ignoreId) {
            return $query->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
    
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'music_id', 'user_id')
                    ->withTimestamps();
    }
}