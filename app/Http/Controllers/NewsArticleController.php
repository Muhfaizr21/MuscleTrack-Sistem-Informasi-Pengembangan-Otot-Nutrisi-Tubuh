<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;

class NewsArticleController extends Controller
{
    /**
     * Menampilkan halaman daftar semua artikel (dengan paginasi).
     */
    public function index()
    {
        // Ambil semua artikel dengan slug yang tidak null, 9 per halaman
        $articles = NewsArticle::whereNotNull('slug')
            ->latest()
            ->paginate(9);

        return view('articles_publik.index', compact('articles'));
    }

    /**
     * Menampilkan satu artikel secara penuh berdasarkan slug.
     */
    public function show($slug)
    {
        // Cari artikel berdasarkan slug
        $article = NewsArticle::where('slug', $slug)->firstOrFail();

        return view('articles_publik.show', compact('article'));
    }
}
