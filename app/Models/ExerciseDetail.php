<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_plan_id',
        'exercise_name',
        'sets',
        'reps',
        'rest_seconds',
        'equipment',
        'notes',
    ];

    // Satu latihan milik satu workout plan
    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class);
    }
}
