<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiRecommendation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'type',
        'recommendation',
        'created_at',
    ];

    // Rekomendasi milik satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
