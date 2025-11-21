<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'user_id',
    ];

    // Relationship dengan komentar
    public function comment()
    {
        return $this->belongsTo(PostComment::class, 'comment_id');
    }

    // Relationship dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}