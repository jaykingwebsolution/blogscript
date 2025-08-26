<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'amount',
        'currency',
        'type',
        'interval',
        'features',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDistribution($query)
    {
        return $query->where('slug', 'distribution-fee');
    }

    public function getFormattedAmountAttribute()
    {
        $symbol = $this->currency === 'NGN' ? '₦' : '$';
        return $symbol . number_format($this->amount, 2);
    }

    public static function getDistributionFee()
    {
        return self::active()->where('slug', 'distribution-fee')->first();
    }

    public static function getActiveSubscriptions()
    {
        return self::active()->where('type', 'subscription')->get();
    }
}
