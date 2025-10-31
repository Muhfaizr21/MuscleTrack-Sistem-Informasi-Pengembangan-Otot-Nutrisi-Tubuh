<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'workout_plan_id',
        'scheduled_date',
        'scheduled_time',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'workout_plan_id');
    }
}
