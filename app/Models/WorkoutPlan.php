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

    protected $attributes = [
        'status' => 'active',
    ];

    /*
    |--------------------------------------------------------------------------
    | BOOT EVENTS
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($plan) {
            if (Auth::check()) {
                $plan->user_id = Auth::id();
                $plan->recommended_by = Auth::user()->role ?? 'system';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔹 Pembuat plan (Admin/Trainer)
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 🔹 Trainer yang ditugaskan
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    // 🔹 Exercise (Many-to-Many Pivot)
    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'exercise_workout_plan')
            ->withPivot(['sets', 'reps', 'duration', 'order', 'rest_interval'])
            ->withTimestamps()
            ->orderBy('pivot_order', 'asc');
    }

    // 🔹 Workout Sessions (One-to-Many)
    public function workoutSessions()
    {
        return $this->hasMany(WorkoutSession::class, 'workout_plan_id');
    }

    // 🔹 Workout Exercise (One-to-Many alternatif pivot eksplisit)
    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_plan_id');
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

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // 🔹 Format durasi: “6 minggu (45 menit/hari)”
    public function getTotalDurationAttribute()
    {
        $weeks = $this->duration_weeks ? "{$this->duration_weeks} minggu" : "-";
        $minutes = $this->duration_minutes ? "{$this->duration_minutes} menit/hari" : "-";
        return "{$weeks} ({$minutes})";
    }

    // 🔹 Warna status label di UI
    public function getStatusLabelAttribute()
    {
        return $this->status === 'active' ? '🟢 Active' : '⚪ Inactive';
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    // 🔹 Cek kepemilikan user
    public function isOwnedBy(int $userId): bool
    {
        return $this->user_id === $userId;
    }

    // 🔹 Tambahkan Exercise ke Plan (Pivot)
    public function addExercise($exerciseId, array $data = [])
    {
        return $this->exercises()->attach($exerciseId, [
            'sets' => $data['sets'] ?? 3,
            'reps' => $data['reps'] ?? 10,
            'duration' => $data['duration'] ?? null,
            'order' => $data['order'] ?? 0,
            'rest_interval' => $data['rest_interval'] ?? 60,
        ]);
    }

    // 🔹 Hapus Exercise dari Plan
    public function removeExercise($exerciseId)
    {
        return $this->exercises()->detach($exerciseId);
    }

    // 🔹 Sinkronisasi list exercise (replace semua pivot)
    public function syncExercises(array $exercises)
    {
        $syncData = [];
        foreach ($exercises as $exerciseId => $data) {
            $syncData[$exerciseId] = [
                'sets' => $data['sets'] ?? 3,
                'reps' => $data['reps'] ?? 10,
                'duration' => $data['duration'] ?? null,
                'order' => $data['order'] ?? 0,
                'rest_interval' => $data['rest_interval'] ?? 60,
            ];
        }
        $this->exercises()->sync($syncData);
    }
}
