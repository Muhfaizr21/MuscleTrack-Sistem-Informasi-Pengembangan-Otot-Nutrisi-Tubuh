<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'level', 'description', 'duration_weeks', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(ProgressLog::class);
    }
}
