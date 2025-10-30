<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerChat extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'user_id', 'message', 'timestamp', 'read_status'];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
