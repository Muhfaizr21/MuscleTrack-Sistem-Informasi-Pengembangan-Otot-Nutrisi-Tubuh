<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    // Relasi baliknya (opsional tapi bagus)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
