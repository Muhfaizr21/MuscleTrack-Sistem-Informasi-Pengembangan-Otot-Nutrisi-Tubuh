<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'cover_image',
        'created_by',
        'is_public',
        'member_count',
        'post_count'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($community) {
            if (empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
        });
    }

    // === 👥 RELASI ANGGOTA ===
    public function members()
    {
        return $this->hasMany(CommunityMember::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'community_members')
                    ->withPivot('role', 'joined_at')
                    ->withTimestamps();
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'community_members')
                    ->wherePivot('role', 'admin')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    public function moderators()
    {
        return $this->belongsToMany(User::class, 'community_members')
                    ->wherePivot('role', 'moderator')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    // === 📝 RELASI POST ===
    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function recentPosts()
    {
        return $this->hasMany(CommunityPost::class)->latest()->limit(10);
    }

    // === 👤 RELASI PENDIRI ===
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // === 🔍 SCOPES ===
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('member_count', 'desc');
    }

    public function scopeActive($query)
    {
        return $query->where('post_count', '>', 0)->orderBy('post_count', 'desc');
    }

    // === ✅ METHODS BANTUAN ===
    public function isMember($userId): bool
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    public function getMemberRole($userId): ?string
    {
        $member = $this->members()->where('user_id', $userId)->first();
        return $member ? $member->role : null;
    }

    public function isAdmin($userId): bool
    {
        return $this->members()
            ->where('user_id', $userId)
            ->whereIn('role', ['admin', 'moderator'])
            ->exists();
    }

    public function incrementMemberCount()
    {
        $this->increment('member_count');
    }

    public function decrementMemberCount()
    {
        $this->decrement('member_count');
    }

    public function incrementPostCount()
    {
        $this->increment('post_count');
    }

    public function decrementPostCount()
    {
        $this->decrement('post_count');
    }

    // === 🖼️ ACCESSORS ===
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/default-community.png');
        }
        
        // Cek jika image sudah full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

    public function getCoverImageUrlAttribute(): string
    {
        if (!$this->cover_image) {
            return asset('images/default-cover.jpg');
        }
        
        // Cek jika cover_image sudah full URL
        if (filter_var($this->cover_image, FILTER_VALIDATE_URL)) {
            return $this->cover_image;
        }
        
        return asset('storage/' . $this->cover_image);
    }
}