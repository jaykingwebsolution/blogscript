<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'bio',
        'image_url',
        'genre',
        'country',
        'is_trending',
        'status',
        'created_by'
    ];

    protected $casts = [
        'is_trending' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function music()
    {
        return $this->hasMany(Music::class);
    }
}