<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_plan_id',
        'name',
        'type',
        'sets',
        'reps',
        'rest_seconds',
    ];

    /**
     * 🔗 Relasi ke WorkoutPlan
     * Setiap latihan (exercise) milik satu plan.
     */
    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'workout_plan_id');
    }

    /**
     * ⚙️ Aksesori untuk format tampilan istirahat
     * Contoh output: "60 detik" atau "1 menit"
     */
    public function getRestLabelAttribute()
    {
        if ($this->rest_seconds >= 60) {
            $minutes = floor($this->rest_seconds / 60);

            return $minutes.' menit';
        }

        return $this->rest_seconds.' detik';
    }
}
