<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'audio_url',
        'duration',
        'genre',
        'is_featured',
        'status',
        'created_by'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
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
}