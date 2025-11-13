<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $table = 'exercises';

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
        'status',
    ];

    // 🔹 Default attribute
    protected $attributes = [
        'calories_burned' => 0,
        'duration' => 0,
        'status' => 'active',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 🔹 Many-to-Many: Exercise ↔ WorkoutPlan (pivot: exercise_workout_plan)
    public function workoutPlans()
    {
        return $this->belongsToMany(WorkoutPlan::class, 'exercise_workout_plan')
            ->withPivot(['sets', 'reps', 'duration', 'order', 'rest_interval'])
            ->withTimestamps()
            ->orderBy('pivot_order', 'asc'); // Ganti dengan 'order' jika kolom pivot-nya bernama 'order'
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    // 🔹 Scope: hanya yang aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // 🔹 Scope: berdasarkan kelompok otot
    public function scopeByMuscleGroup($query, string $muscleGroup)
    {
        return $query->where('muscle_group', $muscleGroup);
    }

    // 🔹 Scope: berdasarkan tingkat kesulitan
    public function scopeByDifficulty($query, string $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    // 🔹 Getter otomatis untuk video URL (gunakan placeholder jika kosong)
    public function getVideoUrlAttribute($value)
    {
        return $value ?: asset('videos/default-exercise.mp4');
    }

    // 🔹 Getter otomatis untuk image URL (gunakan placeholder jika kosong)
    public function getImageUrlAttribute($value)
    {
        return $value ?: asset('images/default-exercise.jpg');
    }

    // 🔹 Format durasi latihan (contoh: "1 menit 30 detik")
    public function getFormattedDurationAttribute()
    {
        if ($this->duration >= 60) {
            $minutes = floor($this->duration / 60);
            $seconds = $this->duration % 60;
            return $seconds
                ? "{$minutes} menit {$seconds} detik"
                : "{$minutes} menit";
        }
        return "{$this->duration} detik";
    }

    // 🔹 Tampilkan nama latihan dengan kapitalisasi rapi
    public function getDisplayNameAttribute()
    {
        return ucwords(strtolower($this->name));
    }
}
