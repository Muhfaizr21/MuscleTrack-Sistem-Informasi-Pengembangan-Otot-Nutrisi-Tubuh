<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Builder;

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
     *
     * @param Builder $query
     * @param int $trainerId
     * @param int $userId
     * @return Builder
     */
    public function scopeBetween(Builder $query, int $trainerId, int $userId): Builder
    {
        return $query->where('trainer_id', $trainerId)
            ->where('user_id', $userId)
            ->orderBy('timestamp', 'asc');
    }

    /**
     * Event boot.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chat) {
            if (Auth::check()) {
                $user = Auth::user();
                $chat->sender_type = $user->role === 'trainer' ? 'trainer' : 'user';
            }
        });
    }

    /**
     * Enkripsi pesan sebelum disimpan.
     */
    public function setMessageAttribute($value): void
    {
        $this->attributes['message'] = Crypt::encryptString($value);
    }

    /**
     * Dekripsi pesan saat diambil.
     */
    public function getMessageAttribute($value): string
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }
}
