<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class UserSummaryController extends Controller
{
    public function index()
    {
        $weekLogs = [];
        $totalCalories = 0;
        $totalProtein = 0;
        $totalCarbs = 0;
        $totalFat = 0;

        return view('user.summary.index', compact('weekLogs', 'totalCalories', 'totalProtein', 'totalCarbs', 'totalFat'));
    }

    public function create() { return view('user.summary.create'); }
    public function store() { return redirect()->route('user.summary.index')->with('success', 'Summary berhasil disimpan!'); }
    public function edit($id) { return view('user.summary.edit'); }
    public function update() { return redirect()->route('user.summary.index')->with('success', 'Summary diperbarui!'); }
    public function destroy() { return redirect()->route('user.summary.index')->with('success', 'Summary dihapus!'); }
}
