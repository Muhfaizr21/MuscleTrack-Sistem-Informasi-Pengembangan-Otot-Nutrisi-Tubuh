<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunityMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_id',
        'user_id',
        'role',
        'joined_at',
        'status',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'approved_at' => 'datetime'
    ];

    // === 👤 RELASI USER ===
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // === 🏘️ RELASI KOMUNITAS ===
    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    // === 👤 RELASI APPROVER ===
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // === 🔍 SCOPES ===

    // Scope untuk role
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeModerators($query)
    {
        return $query->where('role', 'moderator');
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope untuk kombinasi role dan status
    public function scopeActiveAdmins($query)
    {
        return $query->where('role', 'admin')->where('status', 'approved');
    }

    public function scopeActiveModerators($query)
    {
        return $query->where('role', 'moderator')->where('status', 'approved');
    }

    public function scopeActiveMembers($query)
    {
        return $query->where('role', 'member')->where('status', 'approved');
    }

    // === ✅ METHODS BANTUAN ===

    // Cek role
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }

    public function isMember(): bool
    {
        return $this->role === 'member';
    }

    // Cek status
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    // Cek permission
    public function canManage(): bool
    {
        return in_array($this->role, ['admin', 'moderator']) && $this->isApproved();
    }

    public function canManageContent(): bool
    {
        return $this->canManage();
    }

    public function canManageMembers(): bool
    {
        return $this->canManage();
    }

    public function canManageSettings(): bool
    {
        return $this->isAdmin() && $this->isApproved();
    }

    // Methods untuk approval
    public function approve($approvedBy = null): bool
    {
        return $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy ?? auth()->id()
        ]);
    }

    public function reject(): bool
    {
        return $this->delete();
    }

    // Methods untuk role management
    public function promoteToModerator(): bool
    {
        if ($this->isMember() && $this->isApproved()) {
            return $this->update(['role' => 'moderator']);
        }
        return false;
    }

    public function demoteToMember(): bool
    {
        if ($this->isModerator() && $this->isApproved()) {
            return $this->update(['role' => 'member']);
        }
        return false;
    }

    public function promoteToAdmin(): bool
    {
        if ($this->isApproved()) {
            return $this->update(['role' => 'admin']);
        }
        return false;
    }

    // Helper methods
    public function getRoleBadgeClass(): string
    {
        return match ($this->role) {
            'admin' => 'bg-danger',
            'moderator' => 'bg-warning',
            'member' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    public function getStatusBadgeClass(): string
    {
        return match ($this->status) {
            'approved' => 'bg-success',
            'pending' => 'bg-warning',
            default => 'bg-secondary'
        };
    }

    public function getRoleDisplayName(): string
    {
        return match ($this->role) {
            'admin' => 'Admin',
            'moderator' => 'Moderator',
            'member' => 'Member',
            default => 'Member'
        };
    }

    public function getStatusDisplayName(): string
    {
        return match ($this->status) {
            'approved' => 'Approved',
            'pending' => 'Pending',
            default => 'Unknown'
        };
    }

    // Event handlers
    protected static function boot()
    {
        parent::boot();

        // Set default values ketika membuat member baru
        static::creating(function ($communityMember) {
            if (empty($communityMember->joined_at)) {
                $communityMember->joined_at = now();
            }
            if (empty($communityMember->status)) {
                $communityMember->status = 'approved';
            }
        });

        // Update member count ketika member dihapus
        static::deleted(function ($communityMember) {
            $communityMember->community->decrementMemberCount();
        });
    }
}
