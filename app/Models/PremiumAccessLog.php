<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumAccessLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'trainer_id', 'start_date', 'end_date', 'payment_status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
