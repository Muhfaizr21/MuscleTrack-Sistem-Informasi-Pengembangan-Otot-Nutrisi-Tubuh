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
        'order_id',
        'amount',
        'method',
        'status',
        'payment_type',
        'snap_token',
        'redirect_url',
        'transaction_id',
        'fraud_status',
        'raw_response',
        'paid_at',
    ];

    protected $casts = [
        'raw_response' => 'array',   // JSON dari Midtrans
        'paid_at' => 'datetime',     // tanggal pembayaran selesai
    ];

    /** Relasi ke User (pembeli) */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Relasi ke trainer (jika pembayaran untuk trainer) */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
