<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id'
    ];

    // === 💬 RELASI KOMENTAR ===
    public function comment(): BelongsTo
    {
        return $this->belongsTo(PostComment::class, 'comment_id');
    }

    // === 👤 RELASI USER ===
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
