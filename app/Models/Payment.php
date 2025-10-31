<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'trainer_id',
        'amount',
        'method',
        'status',
        'transaction_id',
    ];

    // User yang melakukan pembayaran
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Trainer yang menerima pembayaran
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
