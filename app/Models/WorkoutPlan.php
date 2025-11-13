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

    // 🔹 Relasi ke exercises (many-to-many melalui tabel pivot)
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_workout_plan')
                    ->withPivot('sets', 'reps', 'duration', 'order', 'rest_interval')
                    ->withTimestamps()
                    ->orderBy('order');
    }

    // 🔹 Relasi ke workout sessions (one-to-many)
    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSession::class);
    }

    // 🔹 Scope untuk plan yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // 🔹 Scope untuk plan berdasarkan level kesulitan
    public function scopeByDifficulty($query, $level)
    {
        return $query->where('difficulty_level', $level);
    }

    // 🔹 Accessor untuk durasi total
    public function getTotalDurationAttribute()
    {
        return $this->duration_weeks . ' minggu (' . $this->duration_minutes . ' menit/hari)';
    }

    // 🔹 Method untuk mengecek apakah plan milik user tertentu
    public function isOwnedBy($userId)
    {
        return $this->user_id == $userId;
    }

    // 🔹 Method untuk menambah exercise ke plan
    public function addExercise($exerciseId, $data = [])
    {
        return $this->exercises()->attach($exerciseId, [
            'sets' => $data['sets'] ?? 3,
            'reps' => $data['reps'] ?? 10,
            'duration' => $data['duration'] ?? null,
            'order' => $data['order'] ?? 0,
            'rest_interval' => $data['rest_interval'] ?? 60,
        ]);
    }
}