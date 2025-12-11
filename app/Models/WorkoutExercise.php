<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutExercise extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workout_plan_id',
        'name',
        'description',
        'muscle_group',
        'equipment',
        'difficulty',
        'sets',
        'reps_min',
        'reps_max',
        'rest_seconds',
        'weight_suggestion',
        'video_url',
        'image_url',
        'instructions',
        'tips',
        'common_mistakes',
        'order',
        'day',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'weight_suggestion' => 'decimal:2',
    ];

    /**
     * Get the workout plan that owns the exercise.
     */
    public function workoutPlan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    /**
     * Scope a query to filter by muscle group.
     */
    public function scopeByMuscleGroup($query, $muscleGroup)
    {
        return $query->where('muscle_group', $muscleGroup);
    }

    /**
     * Scope a query to filter by difficulty level.
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        return $query->where('difficulty', $difficulty);
    }

    /**
     * Scope a query to filter by equipment.
     */
    public function scopeByEquipment($query, $equipment)
    {
        return $query->where('equipment', $equipment);
    }

    /**
     * Scope a query to order by day and order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderByRaw("
            CASE day 
                WHEN 'day_1' THEN 1
                WHEN 'day_2' THEN 2
                WHEN 'day_3' THEN 3
                WHEN 'day_4' THEN 4
                WHEN 'day_5' THEN 5
                WHEN 'day_6' THEN 6
                WHEN 'day_7' THEN 7
                ELSE 8
            END, `order`
        ");
    }

    /**
     * Get the recommended rep range.
     */
    public function getRepRangeAttribute(): string
    {
        if ($this->reps_min && $this->reps_max) {
            return "{$this->reps_min}-{$this->reps_max}";
        } elseif ($this->reps_min) {
            return "{$this->reps_min}+";
        }
        
        return 'Custom';
    }

    /**
     * Get rest time in minutes:seconds format.
     */
    public function getRestTimeFormattedAttribute(): string
    {
        if (!$this->rest_seconds) {
            return 'N/A';
        }
        
        $minutes = floor($this->rest_seconds / 60);
        $seconds = $this->rest_seconds % 60;
        
        if ($minutes > 0) {
            return sprintf('%d:%02d min', $minutes, $seconds);
        }
        
        return "{$seconds} sec";
    }

    /**
     * Check if exercise has video.
     */
    public function hasVideo(): bool
    {
        return !empty($this->video_url);
    }

    /**
     * Check if exercise has image.
     */
    public function hasImage(): bool
    {
        return !empty($this->image_url);
    }
}