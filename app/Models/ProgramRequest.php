<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id', 'user_id', 'status', 'note',
    ];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    /**
     * Relasi ke model User (trainer)
     */
    
}
