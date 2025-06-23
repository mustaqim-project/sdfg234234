<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'nickname',
        'email',
        'password',
        'photo',
        'status',
        'profile_status',
        'lastActive',
        'timezone',
        'friends',
        'followers',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'lastActive' => 'datetime',
        'friends' => 'array',
        'followers' => 'array',
        'password' => 'hashed',
    ];

    // =====================================
    // OPTIMASI UNTUK USERNAME UUID
    // =====================================

    /**
     * Cache key prefix untuk user data
     */
    const CACHE_PREFIX = 'user_';
    const CACHE_TTL = 3600; // 1 hour

    /**
     * Get user ID by username dengan caching
     */
    public static function getIdByUsername(string $username): ?int
    {
        $cacheKey = self::CACHE_PREFIX . 'id_' . $username;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($username) {
            return self::where('username', $username)->value('id');
        });
    }

    /**
     * Find user by username dengan caching
     */
    public static function findByUsername(string $username)
    {
        $cacheKey = self::CACHE_PREFIX . 'data_' . $username;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($username) {
            return self::where('username', $username)->first();
        });
    }

    /**
     * Find user by username dengan relations
     */
    public static function findByUsernameWithProfile(string $username)
    {
        $cacheKey = self::CACHE_PREFIX . 'profile_' . $username;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($username) {
            return self::with('userProfile')
                      ->where('username', $username)
                      ->first();
        });
    }

    /**
     * Route model binding menggunakan username
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * Resolve route binding menggunakan optimized query
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->findByUsername($value);
    }

    // =====================================
    // QUERY SCOPES YANG DIOPTIMASI
    // =====================================

    /**
     * Scope untuk query berdasarkan username
     */
    public function scopeByUsername($query, string $username)
    {
        return $query->where('username', $username);
    }

    /**
     * Scope untuk active users
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk users dengan profile complete
     */
    public function scopeProfileComplete($query)
    {
        return $query->where('profile_status', 'complete');
    }

    /**
     * Scope untuk recently active users
     */
    public function scopeRecentlyActive($query, int $hours = 24)
    {
        return $query->where('lastActive', '>=', now()->subHours($hours));
    }

    // =====================================
    // OPTIMASI JSON FIELDS
    // =====================================

    /**
     * Get friends count efficiently
     */
    public function getFriendsCountAttribute()
    {
        // Jika menggunakan virtual column
        if (isset($this->attributes['friends_count'])) {
            return $this->attributes['friends_count'];
        }

        // Fallback untuk hitung manual
        return $this->friends ? count($this->friends) : 0;
    }

    /**
     * Get followers count efficiently
     */
    public function getFollowersCountAttribute()
    {
        // Jika menggunakan virtual column
        if (isset($this->attributes['followers_count'])) {
            return $this->attributes['followers_count'];
        }

        // Fallback untuk hitung manual
        return $this->followers ? count($this->followers) : 0;
    }

    /**
     * Add friend efficiently
     */
    public function addFriend(int $friendId)
    {
        $friends = $this->friends ?? [];

        if (!in_array($friendId, $friends)) {
            $friends[] = $friendId;
            $this->friends = $friends;
            $this->save();

            // Clear cache
            $this->clearCache();
        }
    }

    /**
     * Remove friend efficiently
     */
    public function removeFriend(int $friendId)
    {
        $friends = $this->friends ?? [];

        if (($key = array_search($friendId, $friends)) !== false) {
            unset($friends[$key]);
            $this->friends = array_values($friends);
            $this->save();

            // Clear cache
            $this->clearCache();
        }
    }

    // =====================================
    // RELASI YANG DIOPTIMASI
    // =====================================

    /**
     * Relasi ke user profile dengan caching
     */
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    /**
     * Get profile dengan caching
     */
    public function getCachedProfile()
    {
        $cacheKey = self::CACHE_PREFIX . 'full_profile_' . $this->username;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () {
            return $this->load('userProfile');
        });
    }

    // =====================================
    // CACHE MANAGEMENT
    // =====================================

    /**
     * Clear all cache untuk user ini
     */
    public function clearCache()
    {
        $keys = [
            self::CACHE_PREFIX . 'id_' . $this->username,
            self::CACHE_PREFIX . 'data_' . $this->username,
            self::CACHE_PREFIX . 'profile_' . $this->username,
            self::CACHE_PREFIX . 'full_profile_' . $this->username,
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }

    // =====================================
    // EVENT HOOKS
    // =====================================

    public static function boot()
    {
        parent::boot();

        // Prevent ID and username modification
        static::updating(function ($model) {
            if ($model->isDirty('id')) {
                throw new \Exception("ID cannot be modified.");
            }

            if ($model->isDirty('username')) {
                throw new \Exception("Username cannot be modified.");
            }
        });

        // Clear cache on update
        static::updated(function ($model) {
            $model->clearCache();
        });

        // Clear cache on delete
        static::deleted(function ($model) {
            $model->clearCache();
        });
    }

    // =====================================
    // UTILITY METHODS
    // =====================================

    /**
     * Check if user is online (active in last 15 minutes)
     */
    public function isOnline(): bool
    {
        return $this->lastActive &&
               $this->lastActive->gt(now()->subMinutes(15));
    }

    /**
     * Update last active timestamp
     */
    public function updateLastActive()
    {
        $this->lastActive = now();
        $this->saveQuietly(); // Tidak trigger events
    }
}
