<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'post_count',
    ];

    // Relationship dengan user yang membuat komunitas
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship dengan anggota komunitas (melalui pivot table)
    public function members()
    {
        return $this->hasMany(CommunityMember::class);
    }

    // Relationship dengan posts di komunitas
    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    // Relationship many-to-many dengan users
    public function users()
    {
        return $this->belongsToMany(User::class, 'community_members', 'community_id', 'user_id')
            ->withPivot('role')
            ->withTimestamps();
    }

    // Helper untuk mengecek apakah user adalah anggota
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->exists();
    }

    // Helper untuk mengecek role user dalam komunitas
    public function getRole($userId)
    {
        $member = $this->members()->where('user_id', $userId)->first();
        return $member ? $member->role : null;
    }

    // Helper untuk mengecek apakah user adalah admin
    public function isAdmin($userId)
    {
        return $this->members()->where('user_id', $userId)->where('role', 'admin')->exists();
    }
}
