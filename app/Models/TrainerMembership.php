<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerMembership extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya (karena model & tabel namanya beda)
    protected $table = 'trainer_memberships';

    protected $fillable = [
        'trainer_id',
        'user_id',
    ];

    /**
     * Relasi untuk mengambil data USER (Member)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi untuk mengambil data TRAINER
     */
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
