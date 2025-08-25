<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'is_global',
        'target_roles',
        'target_users',
        'action_url',
        'icon',
        'is_active',
        'expires_at'
    ];

    protected $casts = [
        'target_roles' => 'array',
        'target_users' => 'array',
        'is_global' => 'boolean',
        'is_active' => 'boolean',
        'expires_at' => 'datetime'
    ];

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    public function scopeForUser($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('is_global', true)
              ->orWhereJsonContains('target_roles', $user->role)
              ->orWhereJsonContains('target_users', $user->id);
        });
    }

    public function getTypeDisplayAttribute()
    {
        return ucwords(str_replace('_', ' ', $this->type));
    }

    public function getIconClassAttribute()
    {
        $icons = [
            'feature' => 'fas fa-star text-yellow-500',
            'trending_song' => 'fas fa-music text-purple-500',
            'trending_artist' => 'fas fa-user-music text-blue-500',
            'general' => 'fas fa-bell text-gray-500',
        ];
        
        return $icons[$this->type] ?? $icons['general'];
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isForUser(User $user)
    {
        if ($this->is_global) {
            return true;
        }
        
        if (is_array($this->target_roles) && in_array($user->role, $this->target_roles)) {
            return true;
        }
        
        if (is_array($this->target_users) && in_array($user->id, $this->target_users)) {
            return true;
        }
        
        return false;
    }

    public static function createForAllUsers($data)
    {
        return static::create(array_merge($data, ['is_global' => true]));
    }

    public static function createForRoles($data, $roles)
    {
        return static::create(array_merge($data, [
            'is_global' => false,
            'target_roles' => is_array($roles) ? $roles : [$roles]
        ]));
    }

    public static function getActiveForUser(User $user)
    {
        return static::active()
                    ->forUser($user)
                    ->whereDoesntHave('userNotifications', function ($q) use ($user) {
                        $q->where('user_id', $user->id)->where('is_read', true);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
    }
}
