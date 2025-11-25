<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrainerChat extends Model
{
    use HasFactory;

    protected $table = 'trainer_chats';

    protected $fillable = [
        'trainer_id',
        'user_id',
        'message',
        'sender_type',
        'timestamp',
        'read_status',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'read_status' => 'boolean',
    ];

    public $timestamps = false;

    /**
     * Format timestamp otomatis.
     */
    public function getTimestampAttribute($value)
    {
        return $value ? Carbon::parse($value) : now();
    }

    /**
     * Set timestamp attribute dengan format yang benar
     */
    public function setTimestampAttribute($value)
    {
        $this->attributes['timestamp'] = $value ? Carbon::parse($value) : now();
    }

    /**
     * Relasi ke trainer.
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Relasi ke user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: ambil chat antara trainer dan user tertentu.
     */
    public function scopeBetween(Builder $query, int $trainerId, int $userId): Builder
    {
        return $query->where('trainer_id', $trainerId)
            ->where('user_id', $userId)
            ->orderBy('timestamp', 'asc');
    }

    /**
     * Scope: pesan yang belum dibaca
     */
    public function scopeUnread(Builder $query): Builder
    {
        return $query->where('read_status', false);
    }

    /**
     * Scope: pesan dari user
     */
    public function scopeFromUser(Builder $query): Builder
    {
        return $query->where('sender_type', 'user');
    }

    /**
     * Scope: pesan dari trainer
     */
    public function scopeFromTrainer(Builder $query): Builder
    {
        return $query->where('sender_type', 'trainer');
    }

    /**
     * Event boot.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chat) {
            // Set timestamp jika tidak diset
            if (empty($chat->timestamp)) {
                $chat->timestamp = now();
            }

            // Set read_status berdasarkan sender_type
            if (empty($chat->read_status)) {
                // Pesan dari trainer otomatis terbaca, pesan dari user belum terbaca
                $chat->read_status = $chat->sender_type === 'trainer';
            }
        });
    }

    /**
     * Cek apakah pesan sudah dibaca
     */
    public function isRead(): bool
    {
        return (bool) $this->read_status;
    }

    /**
     * Tandai pesan sebagai sudah dibaca
     */
    public function markAsRead(): bool
    {
        return $this->update(['read_status' => true]);
    }

    /**
     * Tandai pesan sebagai belum dibaca
     */
    public function markAsUnread(): bool
    {
        return $this->update(['read_status' => false]);
    }
}
