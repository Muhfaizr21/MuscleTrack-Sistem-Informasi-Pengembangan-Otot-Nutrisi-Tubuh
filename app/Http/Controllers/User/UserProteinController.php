<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserProteinController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $proteinNeed = $user->weight ? $user->weight * 1.6 : null;
        return view('user.protein.index', compact('user', 'proteinNeed'));
    }

    public function create() { return view('user.protein.create'); }
    public function store() { return redirect()->route('user.protein.index')->with('success', 'Data berhasil disimpan!'); }
    public function edit($id) { return view('user.protein.edit'); }
    public function update() { return redirect()->route('user.protein.index')->with('success', 'Data diperbarui!'); }
    public function destroy() { return redirect()->route('user.protein.index')->with('success', 'Data dihapus!'); }
}
