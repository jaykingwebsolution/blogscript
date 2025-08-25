<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value'
    ];

    protected $casts = [
        'value' => 'json'
    ];

    /**
     * Get a setting value by key
     */
    public static function getValue(string $key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function setValue(string $key, $value): void
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        // Clear cache
        Cache::forget("site_setting_{$key}");
    }

    /**
     * Get multiple settings
     */
    public static function getSettings(array $keys): array
    {
        $settings = self::whereIn('key', $keys)->pluck('value', 'key')->toArray();
        
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $settings[$key] ?? null;
        }
        
        return $result;
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAllSettings(): array
    {
        return Cache::remember('all_site_settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all setting caches
     */
    public static function clearCache(): void
    {
        Cache::flush();
    }
}