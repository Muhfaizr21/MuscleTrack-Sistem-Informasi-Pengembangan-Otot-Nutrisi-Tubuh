<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
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

    /**
     * 🚫 Nonaktifkan timestamps Laravel bawaan
     */
    public $timestamps = false;

    /**
     * 🕒 Accessor untuk format waktu otomatis Carbon
     */
    public function getTimestampAttribute($value)
    {
        return $value ? Carbon::parse($value) : now();
    }

    /**
     * 🔗 Relasi ke Trainer
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * 🔗 Relasi ke Member/User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🧩 Scope untuk ambil chat antara trainer dan user tertentu
     */
    public function scopeBetween($query, $trainerId, $userId)
    {
        return $query->where('trainer_id', $trainerId)
                     ->where('user_id', $userId)
                     ->orderBy('timestamp', 'asc');
    }

    /**
     * 🧠 Event boot — otomatis isi sender_type
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chat) {
            if (Auth::check()) {
                $user = Auth::user();
                // Isi sender_type berdasarkan role yang login
                $chat->sender_type = $user->role === 'trainer' ? 'trainer' : 'user';
            }
        });
    }
}
