<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DistributionAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'distribution_request_id',
        'asset_type',
        'file_path',
        'file_name',
        'file_size',
        'mime_type',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Get the distribution request that owns the asset.
     */
    public function distributionRequest(): BelongsTo
    {
        return $this->belongsTo(DistributionRequest::class);
    }

    /**
     * Get the full file URL
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    /**
     * Check if the asset is an audio file
     */
    public function isAudio(): bool
    {
        return $this->asset_type === 'audio';
    }

    /**
     * Check if the asset is a cover image
     */
    public function isCoverImage(): bool
    {
        return $this->asset_type === 'cover_image';
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute(): string
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $bytes = intval($this->file_size);
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
