<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'nutrition_plan_id',
        'meal_name',
        'calories',
        'protein',
        'carbs',
        'fat',
        'time_of_day',
    ];

    // MealItem milik satu nutrition plan
    public function nutritionPlan()
    {
        return $this->belongsTo(NutritionPlan::class);
    }
}
