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
        'artist_genre',
        'distribution_paid',
        'distribution_paid_at',
        'distribution_payment_reference',
        'distribution_amount_paid',
        'subscription_status',
        'subscription_plan_id',
        'subscription_paid_at',
        'subscription_expires_at'
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
        'social_links' => 'array',
        'distribution_paid' => 'boolean',
        'distribution_paid_at' => 'datetime',
        'subscription_paid_at' => 'datetime',
        'subscription_expires_at' => 'datetime'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
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

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
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

    public function getUnreadNotificationsCount()
    {
        return AdminNotification::getActiveForUser($this)->count();
    }

    public function hasDistributionAccess()
    {
        return $this->distribution_paid || $this->isAdmin();
    }

    public function canSubmitDistribution()
    {
        return ($this->isArtist() || $this->isRecordLabel()) && $this->hasDistributionAccess();
    }

    public function markDistributionAsPaid($amount, $reference = null)
    {
        $this->update([
            'distribution_paid' => true,
            'distribution_paid_at' => now(),
            'distribution_payment_reference' => $reference,
            'distribution_amount_paid' => $amount
        ]);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function publicPlaylists()
    {
        return $this->hasMany(Playlist::class)->where('visibility', 'public');
    }

    public function distributionRequests()
    {
        return $this->hasMany(DistributionRequest::class);
    }
    
    public function likedSongs()
    {
        return $this->belongsToMany(Music::class, 'likes', 'user_id', 'music_id')
                    ->withTimestamps();
    }

    public function manualPayments()
    {
        return $this->hasMany(ManualPayment::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(PricingPlan::class, 'subscription_plan_id');
    }

    public function hasActiveSubscription()
    {
        return $this->subscription_status === 'active' && 
               $this->subscription_expires_at && 
               $this->subscription_expires_at->isFuture();
    }

    public function isSubscriptionExpired()
    {
        return $this->subscription_expires_at && $this->subscription_expires_at->isPast();
    }

    public function likeSong($musicId)
    {
        if (!$this->likedSongs()->where('music_id', $musicId)->exists()) {
            $this->likedSongs()->attach($musicId);
            return true;
        }
        return false;
    }

    public function unlikeSong($musicId)
    {
        return $this->likedSongs()->detach($musicId) > 0;
    }

    public function hasLikedSong($musicId)
    {
        return $this->likedSongs()->where('music_id', $musicId)->exists();
    }
}