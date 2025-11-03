<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BodyMetric extends Model
{
    use HasFactory;

    // Tentukan nama tabelnya
    protected $table = 'body_metrics';

    protected $fillable = [
        'user_id',
        'weight',
        'height',
        'body_fat',
        'muscle_mass',
        'waist',
        'chest',
        'arm',
        'photo_progress',
        'recorded_at',
    ];

    /**
     * Ubah recorded_at menjadi objek Carbon
     */
    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor "ciamik" untuk mengambil URL foto progress
     */
    // public function getPhotoProgressUrlAttribute()
    // {
    //     if ($this->photo_progress) {
    //         // 'progress_photos' adalah folder di 'storage/app/public'
    //         return Storage::disk('public')->url($this->photo_progress);
    //     }

    //     // Gambar fallback jika tidak ada foto
    //     return asset('images/default-progress.png'); // Pastikan Anda punya gambar default ini
    // }
}
