<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    // Izinkan kolom-kolom ini untuk diisi
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];
}
