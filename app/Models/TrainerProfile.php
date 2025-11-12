<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'avatar',            // 🖼️ Foto profil pelatih
        'certifications',
        'experience_years',
        'specialization',
        'rating',
        'bio',
        'verified',
        'price',             // 💰 Harga jasa pelatih
    ];

    /**
     * Relasi: TrainerProfile dimiliki oleh 1 user (trainer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Trainer punya banyak feedback dari user
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'trainer_id');
    }

    /**
     * Relasi: Trainer menerima banyak pembayaran dari user (premium access)
     */
    public function payments()
    {
        return $this->hasMany(Payment::class, 'trainer_id');
    }

    /**
     * Accessor: Dapatkan URL lengkap avatar
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-trainer.png');
    }
}
