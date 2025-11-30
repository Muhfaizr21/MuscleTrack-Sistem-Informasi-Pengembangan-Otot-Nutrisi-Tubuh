<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'parent_id',
        'content',
        'like_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan post
    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    // Relationship dengan user yang membuat komentar
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan parent komentar (jika ada)
    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    // Relationship dengan replies (child comments)
    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    // Relationship dengan likes pada komentar - FIXED
    public function likes()
    {
        return $this->hasMany(CommentLike::class, 'comment_id');
    }

    // Helper untuk mengecek apakah user sudah like komentar ini
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Update like count
    public function updateLikeCount()
    {
        $this->update(['like_count' => $this->likes()->count()]);
    }

    // Scope untuk komentar utama (bukan reply)
    public function scopeMainComments($query)
    {
        return $query->whereNull('parent_id');
    }
}
