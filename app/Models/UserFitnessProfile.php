<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFitnessProfile extends Model
{
    use HasFactory;

    protected $table = 'user_fitness_profiles';

    protected $fillable = [
        'user_id',
        'goal_id',
        'activity_level',
        'activity_description',
        'preferred_muscle_groups',
        'daily_calorie_target',
    ];

    protected $casts = [
        'preferred_muscle_groups' => 'array', // otomatis ubah JSON ke array PHP
    ];

    /**
     * 🔗 Relasi ke model User
     * Satu profil kebugaran dimiliki oleh satu user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🎯 Relasi ke model Goal
     * Setiap profil bisa punya satu goal (cutting, bulking, maintenance, dll)
     */
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }
}
