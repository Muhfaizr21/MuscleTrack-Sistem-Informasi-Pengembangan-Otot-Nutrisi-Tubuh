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
        'role',
        'age',
        'gender',
        'height',
        'weight',
        'goal_id',
        'trainer_id',
        'verification_status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // === 🏋️‍♂️ Relasi ke Goal ===
    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    // === 📊 Data Latihan & Nutrisi ===
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

    // === 🔔 Notifikasi ===
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // === 👥 Hubungan Trainer ↔ Member ===
    public function trainerMembershipsAsTrainer()
    {
        return $this->hasMany(TrainerMembership::class, 'trainer_id');
    }

    public function trainerMembershipsAsUser()
    {
        return $this->hasMany(TrainerMembership::class, 'user_id');
    }

    // === 💬 Chat antar Trainer & User ===
    public function trainerChatsAsTrainer()
    {
        return $this->hasMany(TrainerChat::class, 'trainer_id');
    }

    public function trainerChatsAsUser()
    {
        return $this->hasMany(TrainerChat::class, 'user_id');
    }

    /**
     * 🔹 Relasi umum untuk semua chat
     * (berguna untuk query campuran user-trainer)
     */
    public function trainerChats()
    {
        return $this->hasMany(TrainerChat::class, 'user_id')
            ->orWhere('trainer_id', $this->id);
    }

    // === 💎 Premium Access ===
    public function premiumAccessLogsAsUser()
    {
        return $this->hasMany(PremiumAccessLog::class, 'user_id');
    }

    public function premiumAccessLogsAsTrainer()
    {
        return $this->hasMany(PremiumAccessLog::class, 'trainer_id');
    }

    // === 🧑‍🏫 Profil & Verifikasi Trainer ===
    public function trainerProfile()
    {
        return $this->hasOne(TrainerProfile::class, 'user_id', 'id');
    }

    public function trainerVerification()
    {
        return $this->hasOne(TrainerVerification::class, 'trainer_id');
    }

    // === 🗣️ Feedback ===
    public function feedbacksGiven()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }

    public function feedbacksReceived()
    {
        return $this->hasMany(Feedback::class, 'trainer_id');
    }

    // === 💰 Pembayaran ===
    public function paymentsMade()
    {
        return $this->hasMany(Payment::class, 'user_id');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'trainer_id');
    }

    // === 🧠 AI & Log Aktivitas ===
    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    public function aiRecommendations()
    {
        return $this->hasMany(AiRecommendation::class, 'user_id');
    }
    public function fitnessProfile()
    {
        return $this->hasOne(UserFitnessProfile::class);
    }
    /**
     * Relasi ke user_devices
     */
    public function devices()
    {
        return $this->hasMany(UserDevice::class);
    }

    /**
     * Scope untuk users yang memiliki devices
     */
    public function scopeHasDevices($query)
    {
        return $query->whereHas('devices');
    }
}
