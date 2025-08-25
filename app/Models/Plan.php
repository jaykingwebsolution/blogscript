<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'duration_days',
        'features',
        'type',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function getPriceFormattedAttribute()
    {
        return $this->currency . ' ' . number_format($this->price, 2);
    }

    public function getTypeDisplayAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }

    public function isFree()
    {
        return $this->price == 0 || $this->type === 'free';
    }

    public static function getActivePlans()
    {
        return static::where('is_active', true)->orderBy('sort_order')->orderBy('price')->get();
    }

    public static function getFreePlan()
    {
        return static::where('type', 'free')->where('is_active', true)->first();
    }
}
