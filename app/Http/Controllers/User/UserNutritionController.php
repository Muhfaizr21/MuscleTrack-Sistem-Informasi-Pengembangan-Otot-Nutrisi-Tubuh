<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserNutritionController extends Controller
{
    public function index()
    {
        $nutritions = []; // nanti ambil dari tabel nutrition
        return view('user.nutrition.index', compact('nutritions'));
    }

    public function create() { return view('user.nutrition.create'); }
    public function store(Request $request)
    {
        $request->validate(['title' => 'required']);
        return redirect()->route('user.nutrition.index')->with('success', 'Nutrition berhasil ditambahkan!');
    }
    public function edit($id)
    {
        $nutrition = [];
        return view('user.nutrition.edit', compact('nutrition'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(['title' => 'required']);
        return redirect()->route('user.nutrition.index')->with('success', 'Nutrition diperbarui!');
    }
    public function destroy($id)
    {
        return redirect()->route('user.nutrition.index')->with('success', 'Nutrition dihapus!');
    }
}
