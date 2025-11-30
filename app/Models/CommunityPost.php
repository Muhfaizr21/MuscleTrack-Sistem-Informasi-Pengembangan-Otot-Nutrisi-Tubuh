<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class CommunityPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'content',
        'image',
        'type',
        'like_count',
        'comment_count'
    ];

    protected $casts = [
        'like_count' => 'integer',
        'comment_count' => 'integer'
    ];

    // === 🏘️ RELASI KOMUNITAS ===
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    // === 👤 RELASI USER ===
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // === 💬 RELASI KOMENTAR ===
    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function parentComments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id')->whereNull('parent_id');
    }

    // === ❤️ RELASI LIKE ===
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    // === 🔍 SCOPES ===
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeDiscussion($query)
    {
        return $query->where('type', 'discussion');
    }

    public function scopeAchievement($query)
    {
        return $query->where('type', 'achievement');
    }

    public function scopeQuestion($query)
    {
        return $query->where('type', 'question');
    }

    public function scopeWorkoutLog($query)
    {
        return $query->where('type', 'workout_log');
    }

    public function scopeProgress($query)
    {
        return $query->where('type', 'progress');
    }

    public function scopePopular($query)
    {
        return $query->orderBy('like_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->latest();
    }

    // === ✅ METHODS BANTUAN ===
    public function isLikedBy($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function incrementLikeCount()
    {
        $this->increment('like_count');
    }

    public function decrementLikeCount()
    {
        $this->decrement('like_count');
    }

    public function incrementCommentCount()
    {
        $this->increment('comment_count');
    }

    public function decrementCommentCount()
    {
        $this->decrement('comment_count');
    }

    // === 🖼️ ACCESSORS ===
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        // Cek jika image sudah full URL
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return asset('storage/' . $this->image);
    }

    public function getExcerptAttribute(): string
    {
        return Str::limit(strip_tags($this->content), 150);
    }
}
