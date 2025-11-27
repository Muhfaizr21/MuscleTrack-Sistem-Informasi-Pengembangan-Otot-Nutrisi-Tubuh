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

    // === 🆕 SUPPLEMENTS RELATIONSHIPS ===

    /**
     * Relationship dengan supplements melalui nutrition plans
     */
    public function supplements()
    {
        return $this->hasManyThrough(
            Supplement::class,
            NutritionPlan::class,
            'user_id', // Foreign key on nutrition_plans table
            'nutrition_plan_id', // Foreign key on supplements table
            'id', // Local key on users table
            'id' // Local key on nutrition_plans table
        );
    }

    /**
     * Relationship untuk mendapatkan jumlah supplements
     */
    public function supplementsCount()
    {
        return $this->hasManyThrough(
            Supplement::class,
            NutritionPlan::class,
            'user_id',
            'nutrition_plan_id',
            'id',
            'id'
        )->count();
    }

    /**
     * Relationship untuk mendapatkan supplements dengan eager loading
     */
    public function supplementsWithDetails()
    {
        return $this->hasManyThrough(
            Supplement::class,
            NutritionPlan::class,
            'user_id',
            'nutrition_plan_id',
            'id',
            'id'
        )->with('nutritionPlan');
    }

    // === 🆕 RELASI BARU UNTUK FITUR HISTORY MEMBER ===

    /**
     * Relasi untuk mendapatkan premium access log terbaru untuk trainer tertentu
     */
    public function latestPremiumAccessForTrainer($trainerId)
    {
        return $this->hasOne(PremiumAccessLog::class, 'user_id')
            ->where('trainer_id', $trainerId)
            ->latestOfMany();
    }

    /**
     * Relasi untuk mendapatkan semua premium access log untuk trainer tertentu
     */
    public function premiumAccessHistoryForTrainer($trainerId)
    {
        return $this->hasMany(PremiumAccessLog::class, 'user_id')
            ->where('trainer_id', $trainerId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi untuk mendapatkan pembayaran terbaru untuk trainer tertentu
     */
    public function latestPaymentForTrainer($trainerId)
    {
        return $this->hasOne(Payment::class, 'user_id')
            ->where('trainer_id', $trainerId)
            ->where('status', 'paid')
            ->latestOfMany();
    }

    /**
     * Relasi untuk mendapatkan semua pembayaran untuk trainer tertentu
     */
    public function paymentHistoryForTrainer($trainerId)
    {
        return $this->hasMany(Payment::class, 'user_id')
            ->where('trainer_id', $trainerId)
            ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi untuk mendapatkan trainer yang membimbing user ini
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    /**
     * Relasi untuk mendapatkan semua member yang dibimbing oleh trainer ini
     */
    public function members()
    {
        return $this->hasMany(User::class, 'trainer_id')
            ->where('role', 'user');
    }

    public function workoutSchedules()
    {
        return $this->hasMany(WorkoutSchedule::class);
    }

    // === 👥 COMMUNITY RELATIONSHIPS ===
    // app/Models/User.php

    // Community relationships
    public function communityMembers()
    {
        return $this->hasMany(CommunityMember::class);
    }

    public function communityPosts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    public function postComments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Accessor untuk cek apakah user aktif sebagai member trainer tertentu
     */
    public function getIsActiveForTrainerAttribute($trainerId = null)
    {
        if (!$trainerId && $this->trainer_id) {
            $trainerId = $this->trainer_id;
        }

        if (!$trainerId) {
            return false;
        }

        $premiumAccess = $this->latestPremiumAccessForTrainer($trainerId)->first();

        if (!$premiumAccess) {
            return false;
        }

        return \Carbon\Carbon::parse($premiumAccess->end_date)->isFuture();
    }

    /**
     * Accessor untuk mendapatkan sisa hari masa aktif untuk trainer tertentu
     */
    public function getRemainingDaysForTrainerAttribute($trainerId = null)
    {
        if (!$trainerId && $this->trainer_id) {
            $trainerId = $this->trainer_id;
        }

        if (!$trainerId) {
            return 0;
        }

        $premiumAccess = $this->latestPremiumAccessForTrainer($trainerId)->first();

        if (!$premiumAccess) {
            return 0;
        }

        $endDate = \Carbon\Carbon::parse($premiumAccess->end_date);
        $today = \Carbon\Carbon::today();

        return $today->diffInDays($endDate, false);
    }

    /**
     * Scope untuk mendapatkan member yang aktif untuk trainer tertentu
     */
    public function scopeActiveForTrainer($query, $trainerId)
    {
        return $query->whereHas('premiumAccessLogsAsUser', function ($q) use ($trainerId) {
            $q->where('trainer_id', $trainerId)
                ->where('end_date', '>=', now())
                ->where('payment_status', 'paid');
        });
    }

    /**
     * Scope untuk mendapatkan member yang akan berakhir masa aktifnya (kurang dari 7 hari)
     */
    public function scopeExpiringForTrainer($query, $trainerId)
    {
        return $query->whereHas('premiumAccessLogsAsUser', function ($q) use ($trainerId) {
            $q->where('trainer_id', $trainerId)
                ->where('end_date', '>=', now())
                ->where('end_date', '<=', now()->addDays(7))
                ->where('payment_status', 'paid');
        });
    }

    /**
     * Scope untuk mendapatkan member yang sudah kadaluarsa untuk trainer tertentu
     */
    public function scopeExpiredForTrainer($query, $trainerId)
    {
        return $query->whereHas('premiumAccessLogsAsUser', function ($q) use ($trainerId) {
            $q->where('trainer_id', $trainerId)
                ->where('end_date', '<', now())
                ->where('payment_status', 'paid');
        });
    }
}
