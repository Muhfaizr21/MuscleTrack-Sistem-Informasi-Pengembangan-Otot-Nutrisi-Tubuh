<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UserArticleController extends Controller
{
    /**
     * 📰 Menampilkan daftar artikel edukatif & tips terbaru
     */
    public function index()
    {
        // Ambil semua artikel dengan kategori dan ringkasan
        $articles = NewsArticle::select('id', 'title', 'slug', 'category', 'summary', 'created_at', 'image')
            ->latest()
            ->paginate(9);

        // 🔔 Cek apakah ada artikel baru minggu ini (untuk notifikasi user)
        $newArticlesCount = NewsArticle::where('created_at', '>=', Carbon::now()->subWeek())->count();

        // Cache notifikasi agar tidak muncul terus menerus
        $user = Auth::user();
        $notificationKey = 'article_notification_shown_' . ($user?->id ?? 'guest');
        $showNotification = false;

        if ($newArticlesCount > 0 && !Cache::get($notificationKey)) {
            $showNotification = true;
            Cache::put($notificationKey, true, now()->addDay());
        }

        return view('user.articles.index', compact('articles', 'showNotification', 'newArticlesCount'));
    }

    /**
     * 📖 Menampilkan detail artikel
     */
    public function show($slug)
    {
        // Cari artikel berdasarkan slug
        $article = NewsArticle::where('slug', $slug)->firstOrFail();

        // Ambil artikel lain untuk rekomendasi
        $relatedArticles = NewsArticle::where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest()
            ->take(3)
            ->get();

        // Artikel sebelumnya dan berikutnya
        $previous = NewsArticle::where('id', '<', $article->id)->orderBy('id', 'desc')->first();
        $next = NewsArticle::where('id', '>', $article->id)->orderBy('id', 'asc')->first();

        return view('user.articles.show', compact('article', 'relatedArticles', 'previous', 'next'));
    }
}
