<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'role',
        'age',
        'gender',
        'height',
        'weight',
        'goal_id',
        'trainer_id',
        'verification_status'
    ];

    protected $hidden = ['password'];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function workoutPlans()
    {
        return $this->hasMany(WorkoutPlan::class);
    }

    public function nutritionPlans()
    {
        return $this->hasMany(NutritionPlan::class);
    }

    public function bodyMetrics()
    {
        return $this->hasMany(BodyMetric::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function trainerMembershipsAsTrainer()
    {
        return $this->hasMany(TrainerMembership::class, 'trainer_id');
    }

    public function trainerMembershipsAsUser()
    {
        return $this->hasMany(TrainerMembership::class, 'user_id');
    }

    public function trainerChatsAsTrainer()
    {
        return $this->hasMany(TrainerChat::class, 'trainer_id');
    }

    public function trainerChatsAsUser()
    {
        return $this->hasMany(TrainerChat::class, 'user_id');
    }

    public function premiumAccessLogsAsUser()
    {
        return $this->hasMany(PremiumAccessLog::class, 'user_id');
    }

    public function premiumAccessLogsAsTrainer()
    {
        return $this->hasMany(PremiumAccessLog::class, 'trainer_id');
    }

    // === Relasi ke fitur tambahan MuscleXpert ===

    public function trainerProfile()
    {
        return $this->hasOne(TrainerProfile::class);
    }

    public function feedbacksGiven()
    {
        return $this->hasMany(Feedback::class);
    }

    public function feedbacksReceived()
    {
        return $this->hasMany(Feedback::class, 'trainer_id');
    }

    public function paymentsMade()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'trainer_id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function aiRecommendations()
    {
        return $this->hasMany(AiRecommendation::class);
    }
}
