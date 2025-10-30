<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'calories', 'protein', 'carbs', 'fat', 'meals', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function supplements()
    {
        return $this->hasMany(Supplement::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }
}
