<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'read_status',
    ];

    protected $casts = [
        'read_status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * 🔗 Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 📬 Scope untuk notifikasi yang belum dibaca
     */
    public function scopeUnread(Builder $query)
    {
        return $query->where('read_status', false);
    }

    /**
     * ✅ Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(): void
    {
        $this->update(['read_status' => true]);
    }

    /**
     * 🕓 Format waktu tampil agar lebih ramah di tampilan
     */
    public function getFormattedTimeAttribute(): string
    {
        return $this->created_at
            ? Carbon::parse($this->created_at)->diffForHumans()
            : '-';
    }

    /**
     * 🔔 Warna label notifikasi (opsional untuk UI)
     */
    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'reminder' => 'text-amber-400',
            'alert' => 'text-red-400',
            'achievement' => 'text-green-400',
            'trainer' => 'text-blue-400',
            'system' => 'text-purple-400',
            default => 'text-gray-300',
        };
    }
}
