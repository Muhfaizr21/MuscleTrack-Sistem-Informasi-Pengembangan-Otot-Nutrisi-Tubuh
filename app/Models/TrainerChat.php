<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TrainerChat extends Model
{
    use HasFactory;

    protected $table = 'trainer_chats';

    protected $fillable = [
        'trainer_id',
        'user_id',
        'message',
        'timestamp',
        'read_status',
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'read_status' => 'boolean',
    ];

    /**
     * 🚫 Nonaktifkan timestamps Laravel (karena tabel tidak punya created_at & updated_at)
     */
    public $timestamps = false; // 🧩 Tambahkan baris ini

    // 🧠 Accessor agar selalu punya Carbon instance
    public function getTimestampAttribute($value)
    {
        return $value ? Carbon::parse($value) : now();
    }

    // 🔗 Relasi ke Trainer
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // 🔗 Relasi ke Member/User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🧩 Scope untuk chat antara trainer dan user tertentu
    public function scopeBetween($query, $trainerId, $userId)
    {
        return $query->where('trainer_id', $trainerId)
            ->where('user_id', $userId)
            ->orderBy('timestamp', 'asc');
    }
}
