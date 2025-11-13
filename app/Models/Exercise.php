<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'muscle_group',
        'equipment',
        'difficulty',
        'instructions',
        'video_url',
        'image_url',
        'calories_burned',
        'duration',
        'status'
    ];

    // 🔹 Relasi ke workout plans (many-to-many)
    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'exercise_workout_plan')
                    ->withPivot('sets', 'reps', 'duration', 'order', 'rest_interval')
                    ->withTimestamps();
    }

    // 🔹 Scope untuk exercise aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // 🔹 Scope untuk exercise berdasarkan muscle group
    public function scopeByMuscleGroup($query, $muscleGroup)
    {
        return $query->where('muscle_group', $muscleGroup);
    }

    // 🔹 Scope untuk exercise berdasarkan difficulty
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }
}