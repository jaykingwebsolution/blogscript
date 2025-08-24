<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships - Many to Many
    public function music()
    {
        return $this->belongsToMany(Music::class, 'music_tags');
    }

    public function posts()
    {
        return $this->belongsToMany(News::class, 'post_tags');
    }

    public function videos()
    {
        return $this->belongsToMany(Video::class, 'video_tags');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}