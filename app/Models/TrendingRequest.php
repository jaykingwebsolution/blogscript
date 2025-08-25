<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // 'week', 'month', 'all-time'
        'status',
        'message',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
        'expires_at'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function isActive()
    {
        return $this->status === 'approved' && $this->expires_at && $this->expires_at->isFuture();
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved')->where('expires_at', '>', now());
    }
}