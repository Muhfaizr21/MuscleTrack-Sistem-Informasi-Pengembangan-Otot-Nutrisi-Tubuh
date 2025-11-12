<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'summary',
        'content',
        'image',
        'author',
    ];

    /**
     * Boot untuk handle slug otomatis dari title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    /**
     * Format tanggal rapi (misal: 31 Okt 2025)
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at
            ? $this->created_at->translatedFormat('d M Y')
            : '-';
    }

    /**
     * Ringkasan pendek otomatis (jika summary kosong)
     */
    public function getShortSummaryAttribute()
    {
        if (! empty($this->summary)) {
            return $this->summary;
        }

        return Str::limit(strip_tags($this->content), 120);
    }

    /**
     * Dapatkan URL gambar (fallback default)
     */
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/articles/'.$this->image)
            : asset('images/default-article.jpg');
    }
}
