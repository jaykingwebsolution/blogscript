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
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2'
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
        return self::count() > 0;
    }
}
