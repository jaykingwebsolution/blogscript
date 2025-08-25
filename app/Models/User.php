<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'approved_at',
        'approved_by',
        'bio',
        'profile_picture',
        'social_links',
        'artist_stage_name',
        'artist_genre'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'social_links' => 'array'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEditor()
    {
        return $this->role === 'editor';
    }

    public function isArtist()
    {
        return $this->role === 'artist';
    }

    public function isListener()
    {
        return $this->role === 'listener';
    }

    public function isRecordLabel()
    {
        return $this->role === 'record_label';
    }

    public function isApproved()
    {
        return $this->status === 'approved' && !is_null($this->approved_at);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function createdMusic()
    {
        return $this->hasMany(Music::class, 'created_by');
    }

    public function createdArtists()
    {
        return $this->hasMany(Artist::class, 'created_by');
    }

    public function createdVideos()
    {
        return $this->hasMany(Video::class, 'created_by');
    }

    public function createdNews()
    {
        return $this->hasMany(News::class, 'created_by');
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function verificationRequests()
    {
        return $this->hasMany(VerificationRequest::class);
    }

    public function trendingRequests()
    {
        return $this->hasMany(TrendingRequest::class);
    }

    public function hasActiveSubscription()
    {
        return $this->subscription && $this->subscription->isActive();
    }

    public function isVerified()
    {
        return $this->verification_status === 'verified';
    }

    public function getDisplayName()
    {
        return $this->artist_stage_name ?? $this->name;
    }
}
}