<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;


class UserArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel untuk user
     */
    public function index()
    {
        // Ambil semua artikel (bisa ditambah pagination)
        $articles = NewsArticle::latest()->paginate(10);

        // Kirim ke view
        return view('user.articles.index', compact('articles'));
    }

    /**
     * Menampilkan detail artikel
     */
    public function show($id)
    {
        // Cari artikel berdasarkan ID
        $article = NewsArticle::findOrFail($id);

        // Kirim ke view
        return view('user.articles.show', compact('article'));
    }
}
