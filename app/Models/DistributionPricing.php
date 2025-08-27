<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionPricing extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration', 
        'price',
        'description',
        'features',
        'is_active',
        'type'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'features' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get all distribution pricing plans ordered logically
     */
    public static function getOrderedPlans()
    {
        return self::orderByRaw("
            CASE 
                WHEN duration LIKE '%6 month%' THEN 1
                WHEN duration LIKE '%12 month%' OR duration LIKE '%1 year%' THEN 2
                WHEN duration LIKE '%lifetime%' THEN 3
                ELSE 4
            END
        ")->get();
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return '₦' . number_format($this->price, 2);
    }

    /**
     * Check if there are any distribution pricing plans configured
     */
    public static function hasPlans()
    {
        return self::where('is_active', true)->count() > 0;
    }

    /**
     * Get active plans ordered by price
     */
    public static function getActivePlans()
    {
        return self::where('is_active', true)
                  ->orderBy('price', 'asc')
                  ->get();
    }

    /**
     * Get plan type display name
     */
    public function getTypeDisplayNameAttribute(): string
    {
        return match($this->type) {
            'standard' => 'Musician',
            'premium' => 'Musician Plus', 
            'ultimate' => 'Ultimate',
            default => ucfirst($this->type)
        };
    }

    /**
     * Check if this is the most popular plan
     */
    public function isPopular(): bool
    {
        return $this->type === 'premium';
    }

    /**
     * Get features as formatted list
     */
    public function getFormattedFeaturesAttribute(): array
    {
        return $this->features ?? [];
    }
}
