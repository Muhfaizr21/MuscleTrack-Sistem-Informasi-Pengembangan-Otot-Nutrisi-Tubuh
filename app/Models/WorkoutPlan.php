<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $table = 'workout_plans';

    protected $fillable = [
        'title',
        'level',
        'description',
        'target_fitness',
        'focus_area',
        'bmi_category',
        'status',
        'difficulty_level',
        'duration_weeks',
        'duration_minutes',
        'user_id',
        'trainer_id',
        'recommended_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (Auth::check()) {
                $plan->user_id = Auth::id();
                $plan->recommended_by = Auth::user()->role;
            }
        });
    }

    // 🔹 Relasi ke pembuat plan (admin/trainer)
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Relasi ke pelatih yang ditugaskan
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // 🔹 Jika ada member (peserta plan)
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }
}
