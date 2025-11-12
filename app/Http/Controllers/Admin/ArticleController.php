<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle; // Gunakan model yang baru kita buat
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Menampilkan daftar artikel di admin.
     */
    public function index()
    {
        $articles = NewsArticle::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news_articles,title',
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // Simpan di 'storage/app/public/articles'
            $path = $request->file('image')->store('articles', 'public');
        }

        NewsArticle::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')) . '-' . uniqid(), // Slug unik
            'category' => $request->input('category'),
            'summary' => $request->input('summary'),
            'content' => $request->input('content'),
            'image' => $path, // Simpan path gambar
            'author' => Auth::user()->name, // Set author ke admin yang login
        ]);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Artikel baru berhasil dipublikasikan.');
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(NewsArticle $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * Update artikel di database.
     */
    public function update(Request $request, NewsArticle $article)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news_articles,title,' . $article->id,
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->input('title')) . '-' . $article->id; // Slug unik

        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama (jika ada)
            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }
            // 2. Upload gambar baru
            $data['image'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Hapus artikel dari database.
     */
    public function destroy(NewsArticle $article)
    {
        // Hapus gambar dari storage
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        // Hapus data dari database
        $article->delete();

        return redirect()->route('admin.articles.index')
                         ->with('success', 'Artikel berhasil dihapus.');
    }
}
