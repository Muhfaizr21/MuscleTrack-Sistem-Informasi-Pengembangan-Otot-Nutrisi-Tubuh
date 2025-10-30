<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'weight', 'height', 'body_fat', 'muscle_mass', 'photo_progress', 'recorded_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
