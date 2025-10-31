<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certifications',
        'experience_years',
        'specialization',
        'rating',
        'bio',
        'verified',
    ];

    // Trainer Profile dimiliki oleh 1 user (trainer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Trainer punya banyak feedback dari user
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'trainer_id');
    }

    // Trainer menerima banyak pembayaran dari user (premium access)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'trainer_id');
    }
}
