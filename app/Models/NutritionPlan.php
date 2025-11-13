<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'meal_name',
        'calories',
        'protein',
        'carbs',
        'fat',
        'water_intake',
        'hydrogen_level',
        'day_of_week',
        'target_fitness',
        'type',
    ];

    /**
     * Relasi ke user (jika user buat menu sendiri)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ambil total makronutrien & cairan dalam satu hari (untuk dashboard harian)
     */
    public static function dailyTotal($userId, $day)
    {
        return self::where('user_id', $userId)
            ->where('day_of_week', $day)
            ->selectRaw('
                SUM(calories) as total_calories,
                SUM(protein) as total_protein,
                SUM(carbs) as total_carbs,
                SUM(fat) as total_fat,
                SUM(water_intake) as total_water,
                AVG(hydrogen_level) as avg_hydrogen
            ')
            ->first();
    }

    /**
     * Dapatkan total asupan air per minggu
     */
    public static function weeklyWaterIntake($userId)
    {
        return self::where('user_id', $userId)
            ->selectRaw('SUM(water_intake) as total_water')
            ->value('total_water');
    }

    /**
     * Scope untuk rekomendasi berdasarkan target fitness
     */
    public function scopeForTarget($query, $target)
    {
        return $query->where('target_fitness', $target)
            ->orWhereNull('target_fitness');
    }
}
