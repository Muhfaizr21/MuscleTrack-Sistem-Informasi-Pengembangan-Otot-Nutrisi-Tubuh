<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainerVerification extends Model
{
    use HasFactory;

    protected $fillable = ['trainer_id', 'certificate', 'bio', 'status'];

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
