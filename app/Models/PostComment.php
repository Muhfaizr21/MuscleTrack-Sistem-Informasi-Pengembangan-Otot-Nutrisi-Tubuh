<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id', // PASTIKAN INI post_id BUKAN community_post_id
        'user_id',
        'parent_id',
        'content',
        'like_count'
    ];

    protected $casts = [
        'like_count' => 'integer'
    ];

    // === 📝 RELASI POST ===
    public function post(): BelongsTo
    {
        return $this->belongsTo(CommunityPost::class, 'post_id'); // PASTIKAN foreignKey-nya post_id
    }

    // === 👤 RELASI USER ===
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // === 🔄 RELASI PARENT/CHILD ===
    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    // === ❤️ RELASI LIKE ===
    public function likes(): HasMany
    {
        return $this->hasMany(CommentLike::class, 'comment_id');
    }

    // === 🔍 SCOPES ===
    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithReplies($query)
    {
        return $query->with(['replies.user', 'replies.likes']);
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

    public function hasReplies(): bool
    {
        return $this->replies()->count() > 0;
    }
}
