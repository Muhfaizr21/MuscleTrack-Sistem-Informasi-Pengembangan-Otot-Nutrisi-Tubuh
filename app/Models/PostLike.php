<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    // Relationship dengan post
    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'post_id');
    }

    // Relationship dengan user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}