<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkoutPlan extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya (jika nama file model beda)
    protected $table = 'workout_plans';

    /**
     * Kolom yang boleh diisi (sesuai migrasi BARU Anda)
     */
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
        'user_id', // pembuat (admin)
        'trainer_id',
        'recommended_by',
    ];

    /**
     * Boot "ciamik" untuk otomatis mengisi user_id (pembuat)
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            // Otomatis set pembuatnya adalah admin/trainer yang sedang login
            if (Auth::check()) {
                $plan->user_id = Auth::id();
                $plan->recommended_by = Auth::user()->role; // misal 'admin' atau 'trainer'
            }
        });
    }
}
