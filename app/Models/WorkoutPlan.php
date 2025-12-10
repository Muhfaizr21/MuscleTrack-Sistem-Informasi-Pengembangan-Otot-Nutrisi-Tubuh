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
        'sessions_per_week',
        'equipment_needed',
        'detailed_description',
        'notes',
        'is_premium',
        'user_id',
        'trainer_id',
        'recommended_by',
        'created_by',
        'updated_by',
    ];

    protected $attributes = [
        'status' => 'active',
        'is_premium' => false,
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'duration_weeks' => 'integer',
        'duration_minutes' => 'integer',
        'sessions_per_week' => 'integer',
    ];

    // BOOT
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (Auth::check()) {
                $plan->created_by = Auth::id();
                $plan->user_id = Auth::id();
                $plan->recommended_by = Auth::user()->role ?? 'system';
            }
        });

        static::updating(function ($plan) {
            if (Auth::check()) {
                $plan->updated_by = Auth::id();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS - PERBAIKAN
    |--------------------------------------------------------------------------
    */

    // ✅ Relasi utama ke workout_exercises
    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_plan_id')
                    ->orderBy('order', 'asc');
    }

    // ✅ Alias untuk compatibility (jika controller masih pakai exercises())
    public function exercises()
    {
        return $this->workoutExercises();
    }

    // ✅ Relasi ke exercise_workout_plan (jika ingin menggunakan tabel exercises nanti)
    public function pivotExercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_workout_plan', 'workout_plan_id', 'exercise_id')
            ->withPivot(['sets', 'reps', 'duration', 'order', 'rest_interval'])
            ->withTimestamps()
            ->orderBy('pivot_order', 'asc');
    }

    // ✅ User yang ditugaskan
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ✅ Trainer yang ditugaskan
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // ✅ Pembuat plan
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ✅ Workout Sessions
    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSchedule::class, 'workout_plan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    // ✅ Method untuk menambahkan exercise ke workout_exercises
    public function addWorkoutExercise(array $data)
    {
        // Hitung order otomatis jika tidak disediakan
        if (!isset($data['order'])) {
            $data['order'] = $this->workoutExercises()->count() + 1;
        }

        return $this->workoutExercises()->create([
            'name' => $data['name'],
            'type' => $data['type'] ?? 'strength',
            'description' => $data['description'] ?? null,
            'sets' => $data['sets'] ?? 3,
            'reps' => $data['reps'] ?? '10-12',
            'duration_minutes' => $data['duration_minutes'] ?? null,
            'rest_seconds' => $data['rest_seconds'] ?? 60,
            'video_url' => $data['video_url'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'muscle_group' => $data['muscle_group'] ?? null,
            'equipment' => $data['equipment'] ?? null,
            'notes' => $data['notes'] ?? null,
            'order' => $data['order'],
        ]);
    }

    // ✅ Method untuk menghapus exercise
    public function removeWorkoutExercise($exerciseId)
    {
        $exercise = $this->workoutExercises()->find($exerciseId);

        if ($exercise) {
            // Update order untuk exercise lain
            $this->workoutExercises()
                ->where('order', '>', $exercise->order)
                ->decrement('order');

            return $exercise->delete();
        }

        return false;
    }

    // ✅ Update order exercises
    public function updateExerciseOrder(array $orderList)
    {
        foreach ($orderList as $order => $exerciseId) {
            $this->workoutExercises()
                ->where('id', $exerciseId)
                ->update(['order' => $order + 1]);
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByDifficulty($query, string $level)
    {
        return $query->where('difficulty_level', $level);
    }

    public function scopeForBMI($query, string $bmiCategory)
    {
        return $query->where('bmi_category', $bmiCategory);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeStandard($query)
    {
        return $query->where('is_premium', false);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getTotalDurationAttribute()
    {
        $weeks = $this->duration_weeks ? "{$this->duration_weeks} minggu" : "-";
        $minutes = $this->duration_minutes ? "{$this->duration_minutes} menit/sesi" : "-";
        return "{$weeks} ({$minutes})";
    }

    public function getStatusLabelAttribute()
    {
        return $this->status === 'active'
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-secondary">Inactive</span>';
    }

    public function getPremiumLabelAttribute()
    {
        return $this->is_premium
            ? '<span class="badge bg-warning">⭐ Premium</span>'
            : '<span class="badge bg-info">📋 Standard</span>';
    }

    public function getTotalExercisesAttribute()
    {
        return $this->workoutExercises()->count();
    }

    public function getWeeklyTimeAttribute()
    {
        if ($this->duration_minutes && $this->sessions_per_week) {
            $totalMinutes = $this->duration_minutes * $this->sessions_per_week;
            $hours = floor($totalMinutes / 60);
            $minutes = $totalMinutes % 60;

            if ($hours > 0) {
                return "{$hours} jam {$minutes} menit/minggu";
            }
            return "{$totalMinutes} menit/minggu";
        }
        return '-';
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    public function isOwnedBy(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    public function isCreatedBy(int $userId): bool
    {
        return $this->created_by === $userId;
    }

    public function duplicate(string $newTitle = null)
    {
        $newPlan = $this->replicate();
        $newPlan->title = $newTitle ?? $this->title . ' (Copy)';
        $newPlan->status = 'inactive';
        $newPlan->created_by = Auth::id();
        $newPlan->created_at = now();
        $newPlan->updated_at = now();
        $newPlan->save();

        // Duplicate workout exercises
        foreach ($this->workoutExercises as $exercise) {
            $newExercise = $exercise->replicate();
            $newExercise->workout_plan_id = $newPlan->id;
            $newExercise->created_at = now();
            $newExercise->updated_at = now();
            $newExercise->save();
        }

        return $newPlan;
    }

    public function toggleStatus()
    {
        $this->status = $this->status === 'active' ? 'inactive' : 'active';
        $this->updated_by = Auth::id();
        $this->updated_at = now();
        return $this->save();
    }

    public function togglePremium()
    {
        $this->is_premium = !$this->is_premium;
        $this->updated_by = Auth::id();
        $this->updated_at = now();
        return $this->save();
    }

    // ✅ Check if plan is assigned to specific trainer
    public function isAssignedToTrainer(int $trainerId): bool
    {
        return $this->trainer_id === $trainerId;
    }

    // ✅ Get all completed sessions
    public function getCompletedSessions()
    {
        return $this->workoutSessions()
                    ->where('status', 'completed')
                    ->count();
    }

    // ✅ Get completion percentage
    public function getCompletionPercentage()
    {
        $totalSessions = $this->workoutSessions()->count();
        $completedSessions = $this->getCompletedSessions();

        if ($totalSessions === 0) {
            return 0;
        }

        return round(($completedSessions / $totalSessions) * 100, 2);
    }
}
