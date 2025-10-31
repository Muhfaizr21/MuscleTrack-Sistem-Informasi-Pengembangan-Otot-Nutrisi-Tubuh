<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'rating',
        'comment',
    ];

    public $timestamps = false; // karena kita hanya pakai created_at

    // Feedback diberikan oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Feedback ditujukan kepada trainer
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
