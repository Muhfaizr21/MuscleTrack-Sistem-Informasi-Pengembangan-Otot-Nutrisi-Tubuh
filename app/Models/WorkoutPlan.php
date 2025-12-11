<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkoutPlan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'workout_plans';

    protected $fillable = [
        'title',
        'slug',
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
        'cover_image',
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
                if (!isset($plan->user_id)) {
                    $plan->user_id = Auth::id();
                }
                if (!isset($plan->recommended_by)) {
                    $plan->recommended_by = Auth::user()->role ?? 'system';
                }
            }

            // Generate slug jika belum ada
            if (empty($plan->slug)) {
                $plan->slug = \Str::slug($plan->title) . '-' . \Str::random(6);
            }
        });

        static::updating(function ($plan) {
            if (Auth::check()) {
                $plan->updated_by = Auth::id();
            }
        });

        static::deleting(function ($plan) {
            // Soft delete related exercises
            $plan->workoutExercises()->delete();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_plan_id')
            ->orderByRaw("
                CASE day 
                    WHEN 'day_1' THEN 1
                    WHEN 'day_2' THEN 2
                    WHEN 'day_3' THEN 3
                    WHEN 'day_4' THEN 4
                    WHEN 'day_5' THEN 5
                    WHEN 'day_6' THEN 6
                    WHEN 'day_7' THEN 7
                    ELSE 8
                END
            ")
            ->orderBy('order', 'asc');
    }

    public function exercises()
    {
        return $this->workoutExercises();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSchedule::class, 'workout_plan_id');
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

    public function scopeSearch($query, string $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('detailed_description', 'like', "%{$search}%");
        });
    }

    public function scopeWithExercises($query)
    {
        return $query->with(['workoutExercises' => function ($q) {
            $q->ordered();
        }]);
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

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-workout-cover.jpg');
    }

    public function getExercisesByDayAttribute()
    {
        return $this->workoutExercises()
            ->get()
            ->groupBy('day');
    }

    public function getMuscleGroupsAttribute()
    {
        return $this->workoutExercises()
            ->select('muscle_group')
            ->distinct()
            ->pluck('muscle_group')
            ->filter()
            ->values();
    }

    public function getEquipmentListAttribute()
    {
        $equipmentFromPlan = $this->equipment_needed ? explode(',', $this->equipment_needed) : [];
        $equipmentFromExercises = $this->workoutExercises()
            ->select('equipment')
            ->distinct()
            ->pluck('equipment')
            ->filter()
            ->values()
            ->toArray();

        return array_unique(array_merge($equipmentFromPlan, $equipmentFromExercises));
    }

    public function getTotalSetsAttribute()
    {
        return $this->workoutExercises()->sum('sets');
    }

    public function getEstimatedTotalTimeAttribute()
    {
        $exerciseTime = $this->duration_minutes * 60; // Convert to seconds
        $totalRestTime = $this->workoutExercises()->sum('rest_seconds') * $this->sessions_per_week;

        return ceil(($exerciseTime + $totalRestTime) / 60); // Return in minutes
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

    public function isTrainerPlan(): bool
    {
        return !is_null($this->trainer_id);
    }

    public function isSystemPlan(): bool
    {
        return $this->recommended_by === 'system';
    }

    public function duplicate(string $newTitle = null)
    {
        $newPlan = $this->replicate();
        $newPlan->title = $newTitle ?? $this->title . ' (Copy)';
        $newPlan->slug = \Str::slug($newPlan->title) . '-' . \Str::random(6);
        $newPlan->status = 'inactive';
        $newPlan->created_by = Auth::id();
        $newPlan->created_at = now();
        $newPlan->updated_at = now();
        $newPlan->save();

        // Duplicate workout exercises dengan field yang sesuai
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
        return $this->save();
    }

    public function togglePremium()
    {
        $this->is_premium = !$this->is_premium;
        $this->updated_by = Auth::id();
        return $this->save();
    }

    public function getCompletionPercentage()
    {
        $totalSessions = $this->workoutSessions()->count();
        $completedSessions = $this->workoutSessions()->where('status', 'completed')->count();

        if ($totalSessions === 0) {
            return 0;
        }

        return round(($completedSessions / $totalSessions) * 100, 2);
    }

    public function addExercise(array $data)
    {
        $order = $this->workoutExercises()
            ->where('day', $data['day'] ?? 'day_1')
            ->max('order') ?? 0;

        return $this->workoutExercises()->create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'muscle_group' => $data['muscle_group'] ?? null,
            'equipment' => $data['equipment'] ?? null,
            'difficulty' => $data['difficulty'] ?? 'beginner',
            'sets' => $data['sets'] ?? 3,
            'reps_min' => $data['reps_min'] ?? null,
            'reps_max' => $data['reps_max'] ?? null,
            'rest_seconds' => $data['rest_seconds'] ?? 60,
            'weight_suggestion' => $data['weight_suggestion'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'tips' => $data['tips'] ?? null,
            'common_mistakes' => $data['common_mistakes'] ?? null,
            'day' => $data['day'] ?? 'day_1',
            'order' => $order + 1,
        ]);
    }

    public function updateExercise($exerciseId, array $data)
    {
        $exercise = $this->workoutExercises()->find($exerciseId);

        if ($exercise) {
            return $exercise->update($data);
        }

        return false;
    }

    public function removeExercise($exerciseId)
    {
        $exercise = $this->workoutExercises()->find($exerciseId);

        if ($exercise) {
            $exercise->delete();
            $this->reorderExercises($exercise->day);
            return true;
        }

        return false;
    }

    private function reorderExercises($day = null)
    {
        $query = $this->workoutExercises();

        if ($day) {
            $query->where('day', $day);
        }

        $exercises = $query->orderBy('order')->get();

        foreach ($exercises as $index => $exercise) {
            $exercise->update(['order' => $index + 1]);
        }
    }

    public function reorderExercisesByDay($day, array $exerciseIds)
    {
        foreach ($exerciseIds as $index => $exerciseId) {
            $exercise = $this->workoutExercises()
                ->where('id', $exerciseId)
                ->where('day', $day)
                ->first();

            if ($exercise) {
                $exercise->update(['order' => $index + 1]);
            }
        }
    }

    public function getExercisesForDay($day)
    {
        return $this->workoutExercises()
            ->where('day', $day)
            ->orderBy('order')
            ->get();
    }

    public function getExerciseStats()
    {
        return [
            'total_exercises' => $this->total_exercises,
            'total_sets' => $this->total_sets,
            'muscle_groups' => $this->muscle_groups,
            'equipment_list' => $this->equipment_list,
            'estimated_time' => $this->estimated_total_time,
        ];
    }

    public function canUserAccess($userId)
    {
        // Premium plans require premium access
        if ($this->is_premium) {
            $user = User::find($userId);
            return $user && $user->hasPremiumAccess();
        }

        // Standard plans are accessible to all
        return true;
    }
}
