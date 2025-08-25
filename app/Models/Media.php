<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'file_path',
        'external_url',
        'cover_image',
        'original_filename',
        'mime_type',
        'file_size',
        'metadata',
        'tags',
        'status',
        'rejection_reason',
        'category_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'tags' => 'array',
        'file_size' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getFileUrlAttribute()
    {
        if ($this->external_url) {
            return $this->external_url;
        }
        
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        
        return null;
    }

    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return Storage::url($this->cover_image);
        }
        
        return null;
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return 'N/A';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function isExternal()
    {
        return !empty($this->external_url);
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approve()
    {
        $this->update(['status' => 'approved', 'rejection_reason' => null]);
    }

    public function reject($reason = null)
    {
        $this->update(['status' => 'rejected', 'rejection_reason' => $reason]);
    }

    public static function getApproved()
    {
        return static::where('status', 'approved');
    }

    public static function getPending()
    {
        return static::where('status', 'pending');
    }
}
