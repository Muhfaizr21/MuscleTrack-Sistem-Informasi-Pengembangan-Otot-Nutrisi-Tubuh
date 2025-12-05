<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsArticle::whereNotNull('slug');

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest()->paginate(9);

        // Log untuk debug
        Log::info('Public articles accessed', [
            'count' => $articles->count(),
            'category' => $request->category,
            'first_slug' => $articles->first() ? $articles->first()->slug : 'none'
        ]);

        return view('articles_publik.index', compact('articles'));
    }

    public function show($slug)
    {
        // Log slug yang diminta
        Log::info('Article show requested', ['slug' => $slug]);

        // Cari dengan beberapa cara
        $article = NewsArticle::where('slug', $slug)
                    ->orWhere('slug', 'LIKE', $slug . '-%')
                    ->orWhere('slug', 'LIKE', '%' . $slug . '%')
                    ->first();

        if (!$article) {
            Log::error('Article not found', ['slug' => $slug]);
            abort(404, 'Artikel tidak ditemukan');
        }

        $relatedArticles = NewsArticle::where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->whereNotNull('slug')
            ->latest()
            ->take(2)
            ->get();

        return view('articles_publik.show', compact('article', 'relatedArticles'));
    }
}
