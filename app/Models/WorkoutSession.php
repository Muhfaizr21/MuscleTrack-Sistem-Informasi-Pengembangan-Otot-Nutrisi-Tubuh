<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_plan_id',
        'user_id',
        'session_date',
        'status',
        'notes',
        'rating',
        'completed_at'
    ];

    protected $casts = [
        'session_date' => 'datetime',
        'completed_at' => 'datetime'
    ];

    // 🔹 Relasi ke workout plan
    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    // 🔹 Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🔹 Relasi ke session exercises (many-to-many)
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_session_exercises')
            ->withPivot('completed_sets', 'completed_reps', 'notes', 'rating')
            ->withTimestamps();
    }
}
