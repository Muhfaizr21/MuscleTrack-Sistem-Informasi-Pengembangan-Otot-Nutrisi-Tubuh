<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsArticleController extends Controller
{
    /**
     * Menampilkan halaman daftar semua artikel (dengan paginasi).
     */
    public function index()
    {
        // Ambil semua artikel, 9 per halaman
        $articles = NewsArticle::latest()->paginate(9);

        return view('articles.index', compact('articles'));
    }

    /**
     * Menampilkan satu artikel secara penuh.
     */
    public function show(NewsArticle $article)
    {
        // Laravel akan otomatis mencari artikel berdasarkan ID/slug
        return view('articles.show', compact('article'));
    }
}
