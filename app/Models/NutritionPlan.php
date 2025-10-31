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
     * Ambil total makronutrien dalam satu hari (untuk dashboard harian)
     */
    public static function dailyTotal($userId, $day)
    {
        return self::where('user_id', $userId)
            ->where('day_of_week', $day)
            ->selectRaw('
                SUM(calories) as total_calories,
                SUM(protein) as total_protein,
                SUM(carbs) as total_carbs,
                SUM(fat) as total_fat
            ')
            ->first();
    }
}
