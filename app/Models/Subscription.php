<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_name',
        'amount',
        'status',
        'expires_at',
        'paystack_reference',
        'paystack_access_code',
        'started_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'started_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at->isFuture();
    }

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function daysRemaining()
    {
        return $this->expires_at->diffInDays(now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('expires_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', now());
    }

    public static function getPlanDetails($planName)
    {
        $plans = [
            'free' => [
                'name' => 'Free Plan',
                'amount' => 0,
                'duration' => 0, // unlimited
                'features' => ['Basic access', 'Limited uploads']
            ],
            'artist' => [
                'name' => 'Artist Plan',
                'amount' => 5000, // ₦50 in kobo
                'duration' => 30, // days
                'features' => ['Unlimited uploads', 'Analytics', 'Priority support']
            ],
            'record_label' => [
                'name' => 'Record Label Plan',
                'amount' => 20000, // ₦200 in kobo
                'duration' => 30, // days
                'features' => ['Manage multiple artists', 'Advanced analytics', 'Custom branding']
            ],
            'premium' => [
                'name' => 'Premium Plan',
                'amount' => 3000, // ₦30 in kobo
                'duration' => 30, // days
                'features' => ['Ad-free experience', 'HD streaming', 'Offline downloads']
            ]
        ];

        return $plans[$planName] ?? null;
    }
}