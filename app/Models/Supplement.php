<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'recommended_dose', 'nutrition_plan_id'];

    public function nutritionPlan()
    {
        return $this->belongsTo(NutritionPlan::class);
    }
}
