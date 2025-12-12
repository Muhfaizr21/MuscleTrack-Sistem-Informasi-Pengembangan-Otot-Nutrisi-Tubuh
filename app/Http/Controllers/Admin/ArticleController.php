<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news_articles,title',
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // Simpan dengan nama asli file
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($originalName) . '-' . time() . '.' . $extension;

            $path = $file->storeAs('articles', $filename, 'public');
            \Log::info("Store - Image saved: {$path}");
        }

        $article = NewsArticle::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.uniqid(),
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => $path, // articles/filename.jpg
            'author' => Auth::user()->name,
        ]);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel baru berhasil dipublikasikan.');
    }

    public function edit(NewsArticle $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, NewsArticle $article)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:news_articles,title,'.$article->id,
            'category' => 'nullable|string|max:100',
            'summary' => 'nullable|string|max:300',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Update text data
        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.$article->id,
            'category' => $request->category,
            'summary' => $request->summary,
            'content' => $request->content,
        ]);

        // Update image if exists
        if ($request->hasFile('image')) {
            // Generate nama file yang baik
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug($originalName) . '-' . time() . '.' . $extension;

            $newPath = $file->storeAs('articles', $filename, 'public');

            // Delete old image if exists
            if ($article->image && Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }

            // Update database
            $article->update(['image' => $newPath]);
        }

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(NewsArticle $article)
    {
        if ($article->image && Storage::disk('public')->exists($article->image)) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    public function removeImage(NewsArticle $article)
    {
        if ($article->image) {
            if (Storage::disk('public')->exists($article->image)) {
                Storage::disk('public')->delete($article->image);
            }
            $article->update(['image' => null]);

            return back()->with('success', 'Gambar dihapus.');
        }

        return back()->with('error', 'Gambar tidak ditemukan.');
    }
}
