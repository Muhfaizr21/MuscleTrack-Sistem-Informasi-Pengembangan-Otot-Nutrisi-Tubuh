<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'comment_count',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship dengan komunitas
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    // Relationship dengan user yang membuat post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship dengan komentar
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    // Relationship dengan likes
    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    // Helper untuk mengecek apakah user sudah like post ini
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? \Storage::url($this->image) : null;
    }
}
