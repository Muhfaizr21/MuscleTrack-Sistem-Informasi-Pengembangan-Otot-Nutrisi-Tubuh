<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

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

    /**
     * 🧍 Relasi ke pembuat (admin/trainer)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🧑‍🏫 Relasi ke trainer (jika direkomendasikan oleh trainer)
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * 📊 Relasi ke log progres latihan
     */
    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }

    /**
     * 🗓️ Relasi ke jadwal workout user
     */
    public function schedules()
    {
        return $this->hasMany(WorkoutSchedule::class, 'workout_plan_id');
    }

    /**
     * 🔍 Scope: hanya ambil workout aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * 🔍 Scope: filter berdasarkan focus area
     */
    public function scopeFocus($query, $focus)
    {
        return $query->where('focus_area', $focus);
    }
    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_plan_id');
    }
}
