<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'feedbacks';

    protected $fillable = [
        'user_id',
        'trainer_id',
        'rating',
        'comment',
    ];

    // Karena migration hanya menggunakan created_at, kita set timestamps false
    public $timestamps = false;

    // Tentukan kolom created_at
    const CREATED_AT = 'created_at';

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
