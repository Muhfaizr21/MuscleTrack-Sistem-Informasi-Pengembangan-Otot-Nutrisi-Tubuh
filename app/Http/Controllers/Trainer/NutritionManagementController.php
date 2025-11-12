<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan;
use App\Models\Supplement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionManagementController extends Controller
{
    /**
     * 📋 Halaman Index — Menampilkan nutrisi & suplemen member (view only)
     */
    public function index($memberId)
    {
        $trainer = Auth::user();

        // 🚫 Pastikan hanya trainer pemilik member
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->latest()->first();
        $supplements = $nutritionPlan
            ? Supplement::where('nutrition_plan_id', $nutritionPlan->id)->get()
            : collect();

        return view('trainer.nutrition.index', compact('member', 'nutritionPlan', 'supplements'));
    }

    /**
     * ✏️ Halaman Edit Nutrisi & Suplemen
     */
    public function edit($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->latest()->first();
        $supplements = $nutritionPlan
            ? Supplement::where('nutrition_plan_id', $nutritionPlan->id)->get()
            : collect();

        return view('trainer.nutrition.edit', compact('member', 'nutritionPlan', 'supplements'));
    }

    /**
     * 💾 Update atau buat rencana nutrisi baru
     */
    public function update(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $validated = $request->validate([
            'meal_name' => 'required|string|max:255',
            'calories' => 'nullable|integer|min:0',
            'protein' => 'nullable|numeric|min:0',
            'carbs' => 'nullable|numeric|min:0',
            'fat' => 'nullable|numeric|min:0',
            'target_fitness' => 'nullable|string|max:100',
        ]);

        NutritionPlan::updateOrCreate(
            ['user_id' => $member->id],
            $validated
        );

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil diperbarui!');
    }

    /**
     * 💊 Tambah rekomendasi suplemen
     */
    public function storeSupplement(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->latest()->first();

        if (! $nutritionPlan) {
            return back()->with('error', '❌ Buat rencana nutrisi terlebih dahulu sebelum menambah suplemen.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'recommended_dose' => 'nullable|string|max:255',
        ]);

        Supplement::create(array_merge($validated, [
            'nutrition_plan_id' => $nutritionPlan->id,
        ]));

        return back()->with('success', '💊 Suplemen berhasil ditambahkan!');
    }

    /**
     * 🗑️ Hapus rekomendasi suplemen
     */
    public function destroySupplement($memberId, $supplementId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $supplement = Supplement::findOrFail($supplementId);

        // 🚫 Validasi kepemilikan
        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->first();
        if (! $nutritionPlan || $supplement->nutrition_plan_id !== $nutritionPlan->id) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus suplemen ini.');
        }

        $supplement->delete();

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '💊 Suplemen berhasil dihapus!');
    }
}
