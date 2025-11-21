<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\NutritionPlan;
use App\Models\Supplement;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NutritionManagementController extends Controller
{
    /**
     * 📋 Halaman Index — Menampilkan nutrisi & suplemen member
     */
    public function index($memberId)
    {
        $trainer = Auth::user();

        // 🚫 Pastikan hanya trainer pemilik member
        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil semua nutrition plans untuk member ini
        $nutritionPlans = NutritionPlan::where('user_id', $member->id)
            ->orderBy('day_of_week')
            ->get();

        // Group by day untuk tampilan yang lebih terorganisir
        $plansByDay = $nutritionPlans->groupBy('day_of_week');

        // Ambil suplemen yang terkait dengan nutrition plans member ini
        $supplements = Supplement::whereIn('nutrition_plan_id', $nutritionPlans->pluck('id'))->get();

        // Hitung total nutrisi per hari
        $dailyTotals = [];
        foreach ($plansByDay as $day => $plans) {
            $dailyTotals[$day] = [
                'calories' => $plans->sum('calories'),
                'protein' => $plans->sum('protein'),
                'carbs' => $plans->sum('carbs'),
                'fat' => $plans->sum('fat'),
                'meal_count' => $plans->count()
            ];
        }

        return view('trainer.nutrition.index', compact(
            'member',
            'nutritionPlans',
            'plansByDay',
            'supplements',
            'dailyTotals'
        ));
    }

    /**
     * ✏️ Halaman Create/Edit Nutrisi Plan
     */
    public function create($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $types = ['breakfast', 'lunch', 'dinner', 'snack'];
        $targetFitnessOptions = ['Bulking', 'Cutting', 'Maintenance', 'Endurance', 'General'];

        return view('trainer.nutrition.create', compact(
            'member',
            'days',
            'types',
            'targetFitnessOptions'
        ));
    }

    /**
     * ✏️ Halaman Edit Nutrition Plan tertentu
     */
    public function edit($memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $types = ['breakfast', 'lunch', 'dinner', 'snack'];
        $targetFitnessOptions = ['Bulking', 'Cutting', 'Maintenance', 'Endurance', 'General'];

        return view('trainer.nutrition.edit', compact(
            'member',
            'nutritionPlan',
            'days',
            'types',
            'targetFitnessOptions'
        ));
    }

    /**
     * 💾 Simpan Nutrition Plan baru
     */
    public function store(Request $request, $memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $validated = $request->validate([
            'meal_name' => 'required|string|max:255',
            'day_of_week' => 'required|string|max:20',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'water_intake' => 'nullable|numeric|min:0',
            'hydrogen_level' => 'nullable|numeric|min:0',
            'target_fitness' => 'nullable|string|max:100'
        ]);

        $nutritionPlan = NutritionPlan::create(array_merge($validated, [
            'user_id' => $member->id
        ]));

        // Kirim notifikasi ke member
        Notification::create([
            'user_id' => $member->id,
            'title' => 'Rencana Nutrisi Baru 🍽️',
            'message' => "Trainer {$trainer->name} telah membuat rencana nutrisi baru: {$nutritionPlan->meal_name}",
            'type' => 'nutrition_tip',
            'read_status' => false,
        ]);

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil dibuat!');
    }

    /**
     * 💾 Update Nutrition Plan
     */
    public function update(Request $request, $memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        $validated = $request->validate([
            'meal_name' => 'required|string|max:255',
            'day_of_week' => 'required|string|max:20',
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'calories' => 'required|integer|min:0',
            'protein' => 'required|numeric|min:0',
            'carbs' => 'required|numeric|min:0',
            'fat' => 'required|numeric|min:0',
            'water_intake' => 'nullable|numeric|min:0',
            'hydrogen_level' => 'nullable|numeric|min:0',
            'target_fitness' => 'nullable|string|max:100'
        ]);

        $nutritionPlan->update($validated);

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil diperbarui!');
    }

    /**
     * 🗑️ Hapus Nutrition Plan
     */
    public function destroy($memberId, $planId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $nutritionPlan = NutritionPlan::where('user_id', $member->id)
            ->findOrFail($planId);

        $nutritionPlan->delete();

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '✅ Rencana nutrisi berhasil dihapus!');
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

        // Cari nutrition plan terbaru untuk member ini
        $nutritionPlan = NutritionPlan::where('user_id', $member->id)->latest()->first();

        if (!$nutritionPlan) {
            return back()->with('error', '❌ Buat rencana nutrisi terlebih dahulu sebelum menambah suplemen.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'recommended_dose' => 'nullable|string|max:255'
        ]);

        $supplement = Supplement::create(array_merge($validated, [
            'nutrition_plan_id' => $nutritionPlan->id,
        ]));

        // Kirim notifikasi ke member
        Notification::create([
            'user_id' => $member->id,
            'title' => 'Rekomendasi Suplemen Baru 💊',
            'message' => "Trainer {$trainer->name} merekomendasikan suplemen: {$supplement->name}",
            'type' => 'nutrition_tip',
            'read_status' => false,
        ]);

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

        // 🚫 Validasi kepemilikan - pastikan supplement terkait dengan nutrition plan member ini
        $nutritionPlanIds = NutritionPlan::where('user_id', $member->id)->pluck('id');
        if (!$nutritionPlanIds->contains($supplement->nutrition_plan_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus suplemen ini.');
        }

        $supplement->delete();

        return redirect()
            ->route('trainer.programs.nutrition.index', ['memberId' => $member->id])
            ->with('success', '💊 Suplemen berhasil dihapus!');
    }

    /**
     * 📊 Analisis Nutrisi Member
     */
    public function analysis($memberId)
    {
        $trainer = Auth::user();

        $member = User::where('id', $memberId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Ambil data nutrition plans
        $nutritionPlans = NutritionPlan::where('user_id', $member->id)->get();

        // Hitung statistik
        $totalCalories = $nutritionPlans->sum('calories');
        $totalProtein = $nutritionPlans->sum('protein');
        $totalCarbs = $nutritionPlans->sum('carbs');
        $totalFat = $nutritionPlans->sum('fat');
        $mealCount = $nutritionPlans->count();

        // Group by day
        $plansByDay = $nutritionPlans->groupBy('day_of_week');

        // Data untuk chart
        $chartData = [];
        foreach ($plansByDay as $day => $plans) {
            $chartData[$day] = [
                'calories' => $plans->sum('calories'),
                'protein' => $plans->sum('protein'),
                'carbs' => $plans->sum('carbs'),
                'fat' => $plans->sum('fat')
            ];
        }

        return view('trainer.nutrition.analysis', compact(
            'member',
            'nutritionPlans',
            'totalCalories',
            'totalProtein',
            'totalCarbs',
            'totalFat',
            'mealCount',
            'chartData'
        ));
    }
}
