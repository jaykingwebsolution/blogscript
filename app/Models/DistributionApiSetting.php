<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class DistributionApiSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'environment',
        'public_key',
        'secret_key',
        'configuration',
        'is_active',
    ];

    protected $casts = [
        'configuration' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Set the secret key (encrypted)
     */
    public function setSecretKeyAttribute($value)
    {
        $this->attributes['secret_key'] = $value ? Crypt::encryptString($value) : null;
    }

    /**
     * Get the secret key (decrypted)
     */
    public function getSecretKeyAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    /**
     * Get active settings for a provider
     */
    public static function getActiveForProvider(string $provider, string $environment = 'test')
    {
        return static::where('provider', $provider)
                    ->where('environment', $environment)
                    ->where('is_active', true)
                    ->first();
    }

    /**
     * Get all active payment providers
     */
    public static function getActiveProviders(): array
    {
        return static::where('is_active', true)
                    ->pluck('provider')
                    ->unique()
                    ->toArray();
    }

    /**
     * Check if provider is configured and active
     */
    public static function isProviderActive(string $provider, string $environment = 'test'): bool
    {
        return static::where('provider', $provider)
                    ->where('environment', $environment)
                    ->where('is_active', true)
                    ->exists();
    }

    /**
     * Get provider display name
     */
    public function getProviderDisplayNameAttribute(): string
    {
        return match($this->provider) {
            'paystack' => 'Paystack',
            'flutterwave' => 'Flutterwave',
            default => ucfirst($this->provider)
        };
    }

    /**
     * Get environment display name
     */
    public function getEnvironmentDisplayNameAttribute(): string
    {
        return match($this->environment) {
            'test' => 'Test Mode',
            'live' => 'Live Mode',
            default => ucfirst($this->environment)
        };
    }

    /**
     * Check if this is a test environment
     */
    public function isTestMode(): bool
    {
        return $this->environment === 'test';
    }

    /**
     * Check if this is a live environment
     */
    public function isLiveMode(): bool
    {
        return $this->environment === 'live';
    }

    /**
     * Get masked secret key for display
     */
    public function getMaskedSecretKeyAttribute(): string
    {
        if (!$this->secret_key) {
            return 'Not set';
        }

        $key = $this->secret_key;
        return substr($key, 0, 4) . str_repeat('*', strlen($key) - 8) . substr($key, -4);
    }
}
