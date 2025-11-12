<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ProgressLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * 🧍 Daftar semua member yang menjadi bimbingan trainer.
     */
    public function index()
    {
        $trainer = Auth::user();

        // Ambil semua member yang dibimbing oleh trainer login
        $members = User::where('trainer_id', $trainer->id)
            ->where('role', 'user')
            ->withCount('progressLogs')
            ->get();

        return view('trainer.members.index', compact('members'));
    }

    /**
     * 📊 Tampilkan detail & log aktivitas satu member
     */
    public function show($id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil log aktivitas terbaru
        $progressLogs = ProgressLog::where('user_id', $member->id)
            ->orderByDesc('log_date')
            ->take(15)
            ->get();

        return view('trainer.members.show', compact('member', 'progressLogs'));
    }

    /**
     * 📝 Tambahkan log aktivitas baru untuk member (progres latihan/nutrisi)
     */
    public function updateProgress(Request $request, $id)
    {
        $trainer = Auth::user();

        $member = User::where('id', $id)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $validated = $request->validate([
            'workout_plan_id' => 'nullable|exists:workout_plans,id',
            'nutrition_plan_id' => 'nullable|exists:nutrition_plans,id',
            'calories_consumed' => 'nullable|numeric|min:0',
            'protein_consumed' => 'nullable|numeric|min:0',
            'carbs_consumed' => 'nullable|numeric|min:0',
            'fat_consumed' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:500',
            'log_date' => 'required|date',
        ]);

        $validated['user_id'] = $member->id;

        ProgressLog::create($validated);

        return redirect()
            ->route('trainer.members.show', $member->id)
            ->with('success', 'Log progres member berhasil ditambahkan!');
    }
}
