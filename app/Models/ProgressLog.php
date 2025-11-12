<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'workout_plan_id', 'nutrition_plan_id',
        'calories_consumed', 'protein_consumed', 'carbs_consumed', 'fat_consumed',
        'notes', 'log_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    public function nutritionPlan()
    {
        return $this->belongsTo(NutritionPlan::class);
    }
}
